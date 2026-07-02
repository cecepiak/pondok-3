<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\JenisPelayanan; // ⬅️ DITAMBAH: Pastikan Model JenisPelayanan di-import
use Illuminate\Http\Request;
use Carbon\Carbon; // ⬅️ DITAMBAH: Gunakan alias untuk Carbon
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

// class DashboardController extends Controller
class DashboardController extends \App\Http\Controllers\Controller
{
    /**
     * Menampilkan Dashboard Utama (Ringkasan/Statistik).
     * Logika filtering yang lama dipindahkan ke transaksiIndex.
     */
    public function index(Request $request)
    {

        // Jumlah transaksi baru (status = 1) — seperti sebelumnya
        $transaksiBaruCount = Transaksi::where('status', 1)->count();

        $transaksiVerifikasi = Transaksi::where('status', 2)->count();

        // 🔥 Jumlah transaksi hari ini (new orders) menggunakan kolom tgl lokal
        $newOrdersToday = Transaksi::whereDate('tgl', now()->toDateString())->count();

        // Jumlah transaksi proses (status = 3) — seperti sebelumnya
        $transaksiProses = Transaksi::where('status', 3)->count();

        // Jumlah transaksi selesai (status = 4) — seperti sebelumnya
        $transaksiSelesai = Transaksi::where('status', 4)->count();

        // Jumlah transaksi ditolak (status = 5) — seperti sebelumnya
        $transaksiTolak = Transaksi::where('status', 5)->count();

        // Jumlah transaksi ulang (status = 6) — seperti sebelumnya
        $transaksiUlang = Transaksi::where('status', 6)->count();

        // Jumlah transaksi komplain (status = 7) — seperti sebelumnya
        $transaksiKomplain = Transaksi::where('status', 7)->count();

        // Jumlah transaksi dibatalkan (status = 8) — seperti sebelumnya
        $transaksiDibatalkan = Transaksi::where('status', 8)->count();

        // Jumlah user (aktif) — seperti sebelumnya
        $pengguna = User::where('active', 1)->count();

        $data = DB::table('transaksi')
            ->join('jenis_pelayanan', 'transaksi.id_dokumen', '=', 'jenis_pelayanan.id')
            ->select('jenis_pelayanan.keterangan', DB::raw('COUNT(*) as total'))
            ->groupBy('jenis_pelayanan.keterangan')
            ->get();

        // Ambil 8 anggota terbaru untuk widget Latest Members
        $latestMembers = User::orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        // Hitung jumlah pendaftar baru dalam 7 hari terakhir
        $newMembersCount = User::where('created_at', '>=', now()->subDays(7))->count();

        // Cukup tampilkan view Dashboard standar AdminLTE
        return view('admin.dashboard', compact('transaksiBaruCount', 'transaksiVerifikasi', 'newOrdersToday', 'transaksiProses', 'transaksiSelesai', 'transaksiTolak', 'transaksiUlang', 'transaksiKomplain', 'transaksiDibatalkan', 'pengguna', 'data', 'latestMembers', 'newMembersCount'));

    }
    
    // --- 🚨 START PERBAIKAN UTAMA UNTUK MENU TRANSAKSI (BadMethodCallException) ---
    
    /**
     * Menampilkan Daftar Transaksi dengan Filtering (Dipanggil oleh route admin/transaksi).
     */
    public function transaksiIndex(Request $request)
    {
        // 1. Ambil data pendukung
        $jenisPelayanans = JenisPelayanan::all(); // Menggunakan alias yang sudah di-import
        $filterGroups = $this->getFilterGroups();
        
        // 2. Inisialisasi query dengan eager loading
        $query = Transaksi::with('jenisPelayanan', 'pengambilan');

        // 3. Aplikasikan Filter
        
        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan id trasaksi
        if ($request->filled('id_trx')) {
            $query->where('id_trx', $request->id_trx);
        }

        if ($request->filled('nama')) {
            $query->where('nama', $request->nama);
        }

        // Filter berdasarkan jenis dokumen (ID Dokumen)
        if ($request->filled('id_dokumen')) {
             // Pastikan id_dokumen adalah kolom yang benar untuk filtering
            $query->where('id_dokumen', $request->id_dokumen);
        }

        // Filter berdasarkan grup (misal: KIA → cari semua yang nama-nya mengandung KIA)
        if ($request->filled('filter_jenis')) {
            $selectedGroup = $request->filter_jenis;
            if (isset($filterGroups[$selectedGroup])) {
                $keyword = $filterGroups[$selectedGroup];
                $query->whereHas('jenisPelayanan', function ($q) use ($keyword) {
                    $q->where('nama', 'like', "%{$keyword}%");
                });
            }
        }
        
        // Filter berdasarkan rentang tanggal
        if ($request->filled('tgl_dari')) {
            // Menggunakan whereDate untuk membandingkan hanya tanggal, menghindari masalah waktu
            $query->whereDate('tgl', '>=', $request->tgl_dari);
        }
        if ($request->filled('tgl_sampai')) {
            $query->whereDate('tgl', '<=', $request->tgl_sampai);
        }
        
        // 4. Eksekusi query
        $transaksis = $query->orderBy('created_at', 'desc')->paginate(10);

        // 5. Return view transaksi
        return view('admin.transaksi', compact('transaksis', 'jenisPelayanans', 'filterGroups'));
    }

    // --- 🚨 END PERBAIKAN UTAMA UNTUK MENU TRANSAKSI ---

    /**
     * Menampilkan Detail Transaksi dan Timeline.
     */
    public function show($idTrx)
    {
        $transaksi = Transaksi::with([
            'user', 'jenisPelayanan', 'pengambilan', 'files', 'userDokumen', 'kecamatan', 'desa'
        ])->where('id_trx', $idTrx)->firstOrFail();

        $timeline = [];
        $prevDatetime = null;

        // Gunakan Carbon::parse() untuk semua tanggal agar lebih konsisten

        // 1. Status "Baru"
        if ($transaksi->tgl) {
            $timeline[] = [
                'label' => 'Baru',
                'icon' => 'clipboard-list',
                'color' => 'warning',
                'status_text' => 'Dibuat',
                'datetime' => $transaksi->tgl,
                'duration' => null,
            ];
            $prevDatetime = Carbon::parse($transaksi->tgl);
        }

        // 2. Status "Verifikasi"
        if ($transaksi->tgl_respon) {
            $currentDatetime = Carbon::parse($transaksi->tgl_respon);
            $timeline[] = [
                'label' => 'Verifikasi Dokumen', // ⬅️ Diperjelas
                'icon' => 'search',
                'color' => 'secondary',
                'status_text' => 'Selesai',
                'datetime' => $transaksi->tgl_respon,
                'duration' => $prevDatetime ? $prevDatetime->diffInMinutes($currentDatetime) : null,
            ];
            $prevDatetime = $currentDatetime;
        }

        // 3. Status "Proses"
        if ($transaksi->tgl_proses) {
            $currentDatetime = Carbon::parse($transaksi->tgl_proses);
            $timeline[] = [
                'label' => 'Proses Cetak/Pembuatan', // ⬅️ Diperjelas
                'icon' => 'cog',
                'color' => 'primary',
                'status_text' => 'Selesai',
                'datetime' => $transaksi->tgl_proses,
                'duration' => $prevDatetime ? $prevDatetime->diffInMinutes($currentDatetime) : null,
            ];
            $prevDatetime = $currentDatetime;
        }

        // 4. Status "Selesai" (Siap Diambil)
        if ($transaksi->tgl_selesai) {
            $currentDatetime = Carbon::parse($transaksi->tgl_selesai);
            $timeline[] = [
                'label' => 'Selesai (Siap Diambil)', // ⬅️ Diperjelas
                'icon' => 'check',
                'color' => 'success',
                'status_text' => 'Selesai',
                'datetime' => $transaksi->tgl_selesai,
                'duration' => $prevDatetime ? $prevDatetime->diffInMinutes($currentDatetime) : null,
            ];
            // Tidak perlu update $prevDatetime, proses selesai di sini
        }

        // 5. Status Non-Lurus (Ditolak / Pengajuan Ulang / Komplain)
        $currentStatus = $transaksi->status;
        $statusDates = [
            Transaksi::STATUS_DITOLAK => 'updated_at', // ⬅️ Asumsi ada kolom ini
            Transaksi::STATUS_AJUKAN_ULANG => 'updated_at', // ⬅️ Asumsi ada kolom ini
            Transaksi::STATUS_KOMPLAIN => 'updated_at', // ⬅️ Asumsi ada kolom ini
            Transaksi::STATUS_DIBATALKAN => 'updated_at', // ⬅️ Asumsi ada kolom ini untuk pembatalan
        ];
        
        $statusKey = array_search($currentStatus, array_keys($statusDates));

        if ($statusKey !== false) {
             $statusColumn = $statusDates[$currentStatus];
             // Pastikan kolom tanggal terkait terisi dan status ini belum Selesai
             if ($transaksi->$statusColumn && $transaksi->status !== Transaksi::STATUS_SELESAI) {
                
                $labelMap = [
                    Transaksi::STATUS_DITOLAK => 'Ditolak',
                    Transaksi::STATUS_AJUKAN_ULANG => 'Pengajuan Ulang',
                    Transaksi::STATUS_KOMPLAIN => 'Komplain',
                    transaksi::STATUS_DIBATALKAN => 'Dibatalkan',
                ];
                $iconMap = [
                    Transaksi::STATUS_DITOLAK => 'times',
                    Transaksi::STATUS_AJUKAN_ULANG => 'undo',
                    Transaksi::STATUS_KOMPLAIN => 'exclamation-triangle',
                    Transaksi::STATUS_DIBATALKAN => 'ban',
                ];
                $colorMap = [
                    Transaksi::STATUS_DITOLAK => 'danger',
                    Transaksi::STATUS_AJUKAN_ULANG => 'danger',
                    Transaksi::STATUS_KOMPLAIN => 'danger',
                    Transaksi::STATUS_DIBATALKAN => 'danger',
                ];
                
                $currentDatetime = Carbon::parse($transaksi->$statusColumn);
                $duration = $prevDatetime ? $prevDatetime->diffInMinutes($currentDatetime) : null;
                
                $timeline[] = [
                    'label' => $labelMap[$currentStatus],
                    'icon' => $iconMap[$currentStatus],
                    'color' => $colorMap[$currentStatus],
                    'status_text' => 'Dilakukan',
                    'datetime' => $currentDatetime,
                    'duration' => $duration,
                ];
            }
        }


        return view('admin.detail', compact('transaksi', 'timeline'));
    }

    /**
     * Memperbarui Status Transaksi.
     */
    public function updateStatus(Request $request, $idTrx)
    {
        $rules = [
            'status' => 'required|integer|in:1,2,3,4,5,6,7,8',
        ];
        
        // Hanya validasi pesan_penolakan untuk status 5 (Ditolak)
        if ($request->status == 5) {
            $rules['pesan_penolakan'] = 'required|string|max:1000';
        }
        if ($request->status == 8) {
            $rules['pesan_batal'] = 'required|string|max:1000';
        }
        if ($request->status == 4) {
            $rules['pesan_selesai'] = 'nullable|string|max:1000';
        }

        $request->validate($rules);

        $transaksi = Transaksi::where('id_trx', $idTrx)->firstOrFail();

        $oldStatus = $transaksi->status;
        $newStatus = $request->status;

        $transaksi->status = $newStatus;

        // Atur tanggal berdasarkan status
        if ($newStatus == 2) { // Verifikasi
            $transaksi->tgl_respon = now();
        } elseif ($newStatus == 3) { // Proses
            $transaksi->tgl_proses = now();
        } elseif ($newStatus == 4) { // Selesai
            $transaksi->tgl_selesai = now();
            $transaksi->pesan = $request->pesan_selesai;
        } elseif ($newStatus == 5) { // Ditolak
            $transaksi->updated_at = now();
            $transaksi->pesan = $request->pesan_penolakan;
        } elseif ($newStatus == 8) { // Dibatalkan
            $transaksi->updated_at = now();
            $transaksi->pesan = $request->pesan_batal;
        }

        $transaksi->save();

        // Kirim Notifikasi WA jika status adalah Proses (3), Selesai (4), Ditolak (5), atau Dibatalkan (8)
        if (in_array($newStatus, [3, 4, 5, 8])) {
            $reason = null;
            if ($newStatus == 4) {
                $reason = $request->pesan_selesai;
            } elseif ($newStatus == 5) {
                $reason = $request->pesan_penolakan;
            } elseif ($newStatus == 8) {
                $reason = $request->pesan_batal;
            }
            $this->sendStatusNotification($transaksi, $newStatus, $reason);
        }

        return redirect()->back()->with('success', 'Status berhasil diperbarui.');
    }

    /**
     * Mengirim notifikasi perubahan status transaksi via WhatsApp
     */
    protected function sendStatusNotification($transaksi, $status, $reason = null)
    {
        $transaksi->load('user', 'dokumen');
        $user = $transaksi->user;
        
        if (!$user || !$user->phone) {
            return;
        }

        $phone = preg_replace('/[^0-9]/', '', $user->phone);
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }

        $namaDokumen = $transaksi->dokumen ? $transaksi->dokumen->nama : 'Dokumen';
        $idTrx = $transaksi->id_trx;

        $message = '';
        if ($status == 3) {
            $message = "Halo *{$transaksi->nama}*,\n\nPermohonan layanan *{$namaDokumen}* Anda dengan ID Transaksi *{$idTrx}* saat ini sedang **DIPROSES** oleh petugas.\n\nSilakan pantau secara berkala status permohonan Anda melalui aplikasi.\nStatus **DIPROSES** dilakukan sesuai jam kerja Aktif, diluar jam kerja akan dikerjakan hari selanjutnya.\n\nTerima kasih.";
        } elseif ($status == 4) {
            $message = "Halo *{$transaksi->nama}*,\n\nPermohonan layanan *{$namaDokumen}* Anda dengan ID Transaksi *{$idTrx}* telah **SELESAI**.\n\nDokumen Anda sudah siap diambil/diterima.\nSilakan cek menu lacak, cek berkas di aplikasi.";
            if (!empty($reason)) {
                $message .= "\n\n*Pesan Petugas:*\n{$reason}";
            }
            $message .= "\n\nTerima kasih.";
        } elseif ($status == 5) {
            $message = "Halo *{$transaksi->nama}*,\n\nMohon maaf, permohonan layanan *{$namaDokumen}* Anda dengan ID Transaksi *{$idTrx}* statusnya **DITOLAK**.\n\n*Alasan Penolakan:*\n{$reason}\n\nSilakan lakukan perbaikan data dan lakukan pengajuan ulang dengan nomor transaksi *{$idTrx}* melalui aplikasi.\n\nTerima kasih.";
        } elseif ($status == 8) {
            $message = "Halo *{$transaksi->nama}*,\n\nMohon maaf, permohonan layanan *{$namaDokumen}* Anda dengan ID Transaksi *{$idTrx}* telah **DIBATALKAN**.\n\n*Alasan Pembatalan:*\n{$reason}\n\nTerima kasih.";
        }

        if (empty($message)) {
            return;
        }

        try {
            Log::info('Mengirim notifikasi status WA ke: ' . $phone . ' Status: ' . $status);
            $response = Http::withHeaders([
                'x-api-key' => config('services.whatsapp.token'),
            ])->post(config('services.whatsapp.url'), [
                'number'  => $phone,
                'message' => $message,
                'referal' => config('services.whatsapp.referal'),
            ]);

            if ($response->successful()) {
                Log::info('Notifikasi status WA terkirim sukses (200): ' . $response->body());
            } else {
                Log::error('Gagal kirim notifikasi status WA. Status: ' . $response->status() . ' Respon: ' . $response->body());
            }
        } catch (\Exception $e) {
            Log::error('Gagal mengirim notifikasi status WA (Exception): ' . $e->getMessage());
        }
    }

    /**
     * Helper: Menentukan grup filter.
     */
    private function getFilterGroups()
    {
        return [
            'KIA' => 'KIA',
            'KTP' => 'KTP',
            // 'KK'  => 'KK',
            'Kartu Keluarga' => 'Perubahan Data KK',
            'Pindah' => 'Pindah',
            'Datang' => 'Datang',
            'Akta Kelahiran' => 'Akta Kelahiran',
            'Akta Kematian' => 'Akta Kematian',
            'Akta Perkawinan' => 'Akta Perkawinan',
            'Akta Perceraian' => 'Akta Perceraian',
            // tambahkan grup lain jika perlu
        ];
    }
}

