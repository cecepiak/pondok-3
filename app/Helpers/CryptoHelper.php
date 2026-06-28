<?php

if (!function_exists('decrypt_legacy_field')) {
    /**
     * Mendekripsi string menggunakan logika enkripsi dari project lama.
     *
     * @param string $value
     * @return string
     */
    function decrypt_legacy_field($value)
    {
        // Konfigurasi kunci dan IV dari project lama
        $secret_key = 'zulhari31 ';
        $secret_iv = '230990';
        $key = hash('sha256', $secret_key);
        $initialize_vector = substr(hash('sha256', $secret_iv), 0, 16);

        // Cek jika data kosong atau null
        if (empty($value)) {
            return '';
        }

        // Dekode Base64 dan kemudian dekripsi
        $output = base64_decode($value);
        $output = openssl_decrypt($output, 'AES-256-CBC', $key, 0, $initialize_vector);

        return $output;
    }
}