<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use App\Models\SetupKec; // Menggunakan model untuk mengambil data kecamatan
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Tampilkan formulir registrasi.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        // 1. Jadikan id_kec nullable
        try {
            \Illuminate\Support\Facades\DB::statement("ALTER TABLE users MODIFY id_kec varchar(4) NULL");
        } catch (\Exception $e) {}

        // 2. Jadikan kode_desa nullable
        try {
            \Illuminate\Support\Facades\DB::statement("ALTER TABLE users MODIFY kode_desa varchar(4) NULL");
        } catch (\Exception $e) {}

        // 3. Jadikan photos nullable
        try {
            \Illuminate\Support\Facades\DB::statement("ALTER TABLE users MODIFY photos varchar(30) NULL");
        } catch (\Exception $e) {}

        // 4. Tambahkan kolom activation_code_expires_at jika belum ada
        try {
            \Illuminate\Support\Facades\DB::statement("ALTER TABLE users ADD COLUMN activation_code_expires_at timestamp NULL DEFAULT NULL AFTER activation_code");
        } catch (\Exception $e) {}

        // 5. Jadikan id_kec di transaksi nullable
        try {
            \Illuminate\Support\Facades\DB::statement("ALTER TABLE transaksi MODIFY id_kec varchar(4) NULL");
        } catch (\Exception $e) {}

        // 6. Jadikan id_kel di transaksi nullable
        try {
            \Illuminate\Support\Facades\DB::statement("ALTER TABLE transaksi MODIFY id_kel varchar(4) NULL");
        } catch (\Exception $e) {}

        return view('auth.register');
    }

    /**
     * Tangani permintaan registrasi.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        try {
            // Validasi data yang masuk
            $this->validator($request->all())->validate();

            // Buat instance user baru
            $user = $this->create($request->all());

            // Generate OTP
            $otp = rand(100000, 999999);
            $user->update([
                'activation_code' => $otp,
                'activation_code_expires_at' => now()->addMinutes(15),
            ]);

            // Kirim event Registered
            event(new Registered($user));

            // Kirim WhatsApp OTP
            $this->sendActivationWhatsapp($user, $otp);

            return redirect()->route('activate.form', ['nik' => $user->nik])->with('swal', [
                'title' => 'Registrasi Berhasil!',
                'text' => 'Kode OTP aktivasi akun telah dikirim ke nomor WhatsApp Anda. Silakan masukkan kode OTP untuk mengaktifkan akun.',
                'icon' => 'success'
            ]);
        } catch (ValidationException $e) {
            // Tangani error validasi
            return back()->withErrors($e->validator)->withInput();
        }
    }

    /**
     * Kirim pesan aktivasi WhatsApp dengan kode OTP & link langsung
     */
    protected function sendActivationWhatsapp($user, $otp)
    {
        $activationUrl = route('activate.link', ['nik' => $user->nik, 'otp' => $otp]);
        
        $message = "Halo *{$user->name}*,\n\nPendaftaran akun Anda berhasil di Pondok App.\n\nMasukkan kode OTP berikut untuk mengaktifkan akun Anda:\n*{$otp}*\n\nAtau klik tautan berikut untuk aktivasi otomatis:\n{$activationUrl}\n\n*Catatan:* Kode OTP ini berlaku selama 15 menit.";

        try {
            // Format nomor telepon ke format internasional (62)
            $phone = preg_replace('/[^0-9]/', '', $user->phone);
            if (str_starts_with($phone, '0')) {
                $phone = '62' . substr($phone, 1);
            }

            \Illuminate\Support\Facades\Log::info('Mencoba mengirim WA OTP ke: ' . $phone);
            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'x-api-key' => config('services.whatsapp.token'),
            ])->post(config('services.whatsapp.url'), [
                'number'  => $phone,
                'message' => $message,
                'referal' => config('services.whatsapp.referal'),
            ]);

            if ($response->successful()) {
                \Illuminate\Support\Facades\Log::info('WhatsApp OTP terkirim sukses (200): ' . $response->body());
            } else {
                \Illuminate\Support\Facades\Log::error('Gagal kirim WhatsApp OTP. Status: ' . $response->status() . ' Respon: ' . $response->body());
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Gagal mengirim WhatsApp OTP (Exception): ' . $e->getMessage());
        }
    }

    /**
     * Dapatkan validator untuk permintaan registrasi yang masuk.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'nik' => ['required', 'string', 'digits:16', 'unique:users,nik'],
            'kk' => ['required', 'string', 'digits:16'],
            'phone' => ['required', 'string', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10', 'max:15'],
            'kecamatan' => ['nullable', 'integer', 'exists:kecamatan,id'],
            'desa_kelurahan' => ['nullable', 'integer', 'exists:desa,kode_desa'],
        ]);
    }

    /**
     * Buat instance pengguna baru setelah registrasi yang valid.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'nik' => $data['nik'],
            'kk' => $data['kk'],
            'phone' => $data['phone'],
            'role_id' => 2,
            'id_kec' => $data['kecamatan'] ?? null,
            'kode_desa' => $data['desa_kelurahan'] ?? null,
            'active' => 0,
            'photos' => null,
        ]);
    }
}
