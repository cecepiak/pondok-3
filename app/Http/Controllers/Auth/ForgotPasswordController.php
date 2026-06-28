<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\User;

class ForgotPasswordController extends Controller
{
    /**
     * Menampilkan form input NIK (Lupa Password)
     */
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Mengirim link reset password via WhatsApp
     */
    public function sendResetLink(Request $request)
    {
        // 1. Validasi input NIK
        $request->validate([
            'nik' => 'required|numeric',
        ], [
            'nik.required' => 'NIK wajib diisi.',
            'nik.numeric' => 'NIK harus berupa angka.',
        ]);

        // 2. Cari user berdasarkan NIK
        $user = User::where('nik', $request->nik)->first();

        if (!$user) {
            return back()->with('swal', [
                'title' => 'Data Tidak Ditemukan',
                'text' => 'NIK yang Anda masukkan tidak terdaftar di sistem kami.',
                'icon' => 'error'
            ]);
        }

        if (!$user->phone) {
            return back()->with('swal', [
                'title' => 'Nomor WA Kosong',
                'text' => 'Nomor WhatsApp tidak ditemukan di profil Anda. Silakan hubungi admin.',
                'icon' => 'warning'
            ]);
        }

        // 3. Buat Token Reset & Simpan ke database
        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email], // Gunakan email sebagai key sesuai struktur tabel default
            [
                'token' => $token,
                'created_at' => now()
            ]
        );

        // 4. Susun Link Reset
        $resetUrl = url("/password/reset/{$token}?nik=" . $user->nik);

        // Format nomor telepon ke format internasional (62)
        $phone = preg_replace('/[^0-9]/', '', $user->phone);
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }

        try {
            // Jika Anda menggunakan provider lain, sesuaikan bagian post() ini
            $response = Http::withHeaders([
                'x-api-key' => config('services.whatsapp.token'),
            ])->post(config('services.whatsapp.url'), [
                'number'  => $phone,
                'message' => "Halo *{$user->name}*,\n\nKami menerima permintaan reset password untuk akun Anda.\n\nKlik link di bawah ini untuk mengatur ulang password Anda:\n{$resetUrl}\n\n*Catatan:* Tautan reset password ini hanya berlaku selama 15 menit.",
                'referal' => config('services.whatsapp.referal'),
            ]);

            // Log request payload for debugging
            \Illuminate\Support\Facades\Log::info('Mencoba mengirim WA ke: ' . $phone . ' URL: ' . config('services.whatsapp.url'));

            if ($response->successful()) {
                \Illuminate\Support\Facades\Log::info('Respon WhatsApp Sukses (200): ' . $response->body());
                return back()->with('swal', [
                    'title' => 'Berhasil!',
                    'text' => 'Link reset password telah dikirim ke nomor WhatsApp Anda.',
                    'icon' => 'success'
                ]);
            } else {
                \Illuminate\Support\Facades\Log::error('Respon WhatsApp Gagal (' . $response->status() . '): ' . $response->body());
                return back()->with('swal', [
                    'title' => 'Gagal Mengirim',
                    'text' => 'Gagal mengirim pesan reset password (HTTP ' . $response->status() . ').',
                    'icon' => 'error'
                ]);
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Gagal mengirim WhatsApp reset password (Exception): ' . $e->getMessage());
            return back()->with('swal', [
                'title' => 'Koneksi Gagal',
                'text' => 'Gagal terhubung ke WhatsApp Gateway (Timeout). Silakan coba beberapa saat lagi.',
                'icon' => 'error'
            ]);
        }
    }

    /**
     * Menampilkan halaman form password baru
     */
    public function showResetForm(Request $request, $token)
    {
        $user = User::where('nik', $request->nik)->first();

        if (!$user) {
            return redirect()->route('password.request')->with('swal', [
                'title' => 'Link Tidak Valid',
                'text' => 'Pengguna tidak ditemukan.',
                'icon' => 'error'
            ]);
        }

        $resetData = DB::table('password_reset_tokens')
            ->where('email', $user->email)
            ->where('token', $token)
            ->first();

        // Cek apakah token ada dan belum kadaluarsa (berlaku 15 menit)
        if (!$resetData || \Carbon\Carbon::parse($resetData->created_at)->addMinutes(15)->isPast()) {
            if ($resetData) {
                DB::table('password_reset_tokens')->where('email', $user->email)->delete();
            }
            return redirect()->route('password.request')->with('swal', [
                'title' => 'Link Kadaluarsa',
                'text' => 'Tautan reset password sudah tidak berlaku atau sudah kadaluwarsa (berlaku 15 menit). Silakan minta tautan baru.',
                'icon' => 'error'
            ]);
        }

        return view('auth.reset-password', [
            'token' => $token,
            'nik' => $request->nik
        ]);
    }

    /**
     * Proses update password ke database
     */
    public function updatePassword(Request $request)
    {
        // 1. Validasi input password baru
        $request->validate([
            'token' => 'required',
            'nik' => 'required',
            'password' => 'required|confirmed|min:8',
        ], [
            'password.required' => 'Password baru wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal terdiri dari 8 karakter.',
        ]);

        // 2. Cari user berdasarkan NIK
        $user = User::where('nik', $request->nik)->first();

        if (!$user) {
            return redirect()->route('login')->with('swal', [
                'title' => 'Eror!',
                'text' => 'User tidak valid.',
                'icon' => 'error'
            ]);
        }

        // 3. Verifikasi token di tabel password_reset_tokens
        $resetData = DB::table('password_reset_tokens')
            ->where('email', $user->email)
            ->where('token', $request->token)
            ->first();

        // Cek apakah token ada dan belum kadaluarsa (berlaku 15 menit)
        if (!$resetData || \Carbon\Carbon::parse($resetData->created_at)->addMinutes(15)->isPast()) {
            if ($resetData) {
                DB::table('password_reset_tokens')->where('email', $user->email)->delete();
            }
            return redirect()->route('password.request')->with('swal', [
                'title' => 'Link Kadaluarsa',
                'text' => 'Tautan reset password sudah tidak berlaku atau sudah kadaluwarsa (berlaku 15 menit). Silakan minta tautan baru.',
                'icon' => 'error'
            ]);
        }

        // 4. Update password user
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        // 5. Hapus token dari database agar tidak bisa dipakai lagi
        DB::table('password_reset_tokens')->where('email', $user->email)->delete();

        return redirect('/login')->with('swal', [
            'title' => 'Sukses!',
            'text' => 'Password Anda berhasil diperbarui. Silakan login menggunakan password baru.',
            'icon' => 'success'
        ]);
    }
}