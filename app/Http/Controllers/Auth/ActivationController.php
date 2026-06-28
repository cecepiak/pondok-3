<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ActivationController extends Controller
{
    /**
     * Tampilkan form aktivasi OTP
     */
    public function showForm(Request $request)
    {
        $nik = $request->query('nik', session('activation_nik'));
        return view('auth.activate', compact('nik'));
    }

    /**
     * Proses aktivasi dengan kode OTP manual
     */
    public function activate(Request $request)
    {
        $request->validate([
            'nik' => 'required|numeric|digits:16|exists:users,nik',
            'otp' => 'required|numeric|digits:6',
        ], [
            'nik.required' => 'NIK wajib diisi.',
            'nik.digits' => 'NIK harus 16 digit.',
            'nik.exists' => 'NIK tidak terdaftar.',
            'otp.required' => 'Kode OTP wajib diisi.',
            'otp.digits' => 'Kode OTP harus 6 digit.',
        ]);

        $user = User::where('nik', $request->nik)->firstOrFail();

        if ($user->active == 1) {
            return redirect()->route('login')->with('swal', [
                'title' => 'Akun Sudah Aktif',
                'text' => 'Akun Anda sudah aktif sebelumnya. Silakan login.',
                'icon' => 'info'
            ]);
        }

        $expiresAt = $user->activation_code_expires_at ? Carbon::parse($user->activation_code_expires_at) : null;

        if ($user->activation_code !== $request->otp || !$expiresAt || $expiresAt->isPast()) {
            return back()->withInput()->with('swal', [
                'title' => 'Aktivasi Gagal',
                'text' => 'Kode OTP salah atau sudah kedaluwarsa. Silakan kirim ulang OTP.',
                'icon' => 'error'
            ]);
        }

        // Aktifkan user
        $user->update([
            'active' => 1,
            'activation_code' => null,
            'activation_code_expires_at' => null,
        ]);

        return redirect()->route('login')->with('swal', [
            'title' => 'Aktivasi Berhasil!',
            'text' => 'Akun Anda berhasil diaktifkan. Silakan login.',
            'icon' => 'success'
        ]);
    }

    /**
     * Kirim ulang kode OTP
     */
    public function resend(Request $request)
    {
        $request->validate([
            'nik' => 'required|numeric|digits:16|exists:users,nik',
        ], [
            'nik.required' => 'NIK wajib diisi untuk kirim ulang OTP.',
            'nik.exists' => 'NIK tidak terdaftar.',
        ]);

        $user = User::where('nik', $request->nik)->firstOrFail();

        if ($user->active == 1) {
            return redirect()->route('login')->with('swal', [
                'title' => 'Akun Sudah Aktif',
                'text' => 'Akun Anda sudah aktif. Silakan login.',
                'icon' => 'info'
            ]);
        }

        // Generate OTP Baru
        $otp = rand(100000, 999999);
        $user->update([
            'activation_code' => $otp,
            'activation_code_expires_at' => now()->addMinutes(15),
        ]);

        // Kirim WhatsApp
        $this->sendActivationWhatsapp($user, $otp);

        return back()->with('swal', [
            'title' => 'OTP Terkirim!',
            'text' => 'Kode OTP baru telah dikirimkan ke nomor WhatsApp Anda.',
            'icon' => 'success'
        ])->with('activation_nik', $user->nik);
    }

    /**
     * Aktivasi akun langsung melalui link URL WhatsApp
     */
    public function directActivate($nik, $otp)
    {
        $user = User::where('nik', $nik)->first();

        if (!$user) {
            return redirect()->route('login')->with('swal', [
                'title' => 'Error',
                'text' => 'Pengguna tidak ditemukan.',
                'icon' => 'error'
            ]);
        }

        if ($user->active == 1) {
            return redirect()->route('login')->with('swal', [
                'title' => 'Akun Sudah Aktif',
                'text' => 'Akun Anda sudah aktif. Silakan login.',
                'icon' => 'info'
            ]);
        }

        $expiresAt = $user->activation_code_expires_at ? Carbon::parse($user->activation_code_expires_at) : null;

        if ($user->activation_code !== $otp || !$expiresAt || $expiresAt->isPast()) {
            return redirect()->route('activate.form', ['nik' => $user->nik])->with('swal', [
                'title' => 'Link Kadaluarsa',
                'text' => 'Link aktivasi salah atau sudah kedaluwarsa. Silakan masukkan NIK Anda dan kirim ulang OTP.',
                'icon' => 'error'
            ]);
        }

        // Aktifkan user
        $user->update([
            'active' => 1,
            'activation_code' => null,
            'activation_code_expires_at' => null,
        ]);

        return redirect()->route('login')->with('swal', [
            'title' => 'Aktivasi Berhasil!',
            'text' => 'Akun Anda telah diaktifkan secara otomatis. Silakan login.',
            'icon' => 'success'
        ]);
    }

    /**
     * Helper untuk kirim WhatsApp
     */
    protected function sendActivationWhatsapp($user, $otp)
    {
        $activationUrl = route('activate.link', ['nik' => $user->nik, 'otp' => $otp]);
        
        $message = "Halo *{$user->name}*,\n\nIni adalah kode OTP aktivasi baru untuk akun Anda di Pondok App.\n\nKode OTP Anda:\n*{$otp}*\n\nAtau klik tautan berikut untuk aktivasi otomatis:\n{$activationUrl}\n\n*Catatan:* Kode OTP ini berlaku selama 15 menit.";

        try {
            // Format nomor telepon ke format internasional (62)
            $phone = preg_replace('/[^0-9]/', '', $user->phone);
            if (str_starts_with($phone, '0')) {
                $phone = '62' . substr($phone, 1);
            }

            Log::info('Mencoba mengirim ulang WA OTP ke: ' . $phone);
            $response = Http::withHeaders([
                'x-api-key' => config('services.whatsapp.token'),
            ])->post(config('services.whatsapp.url'), [
                'number'  => $phone,
                'message' => $message,
                'referal' => config('services.whatsapp.referal'),
            ]);

            if ($response->successful()) {
                Log::info('WhatsApp OTP kirim ulang sukses (200): ' . $response->body());
            } else {
                Log::error('Gagal kirim ulang WhatsApp OTP. Status: ' . $response->status() . ' Respon: ' . $response->body());
            }
        } catch (\Exception $e) {
            Log::error('Gagal mengirim ulang WhatsApp OTP (Exception): ' . $e->getMessage());
        }
    }
}
