<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\Transaksi;
use App\Models\SetupKec;
use App\Models\SetupKel;

try {
    $user = User::where('name', 'like', '%CECEP SYAFEI%')->first();
    if ($user) {
        $kecUser = SetupKec::find($user->id_kec);
        $kelUser = SetupKel::where('kode_desa', $user->kode_desa)->first();
        
        $trx = Transaksi::where('id_user', $user->id)->latest()->first();
        if ($trx) {
            $kecTrx = SetupKec::find($trx->id_kec);
            $kelTrx = SetupKel::where('kode_desa', $trx->id_kel)->first();
            
            echo json_encode([
                'user' => [
                    'name' => $user->name,
                    'id_kec' => $user->id_kec,
                    'kode_desa' => $user->kode_desa,
                    'kec_name' => $kecUser ? $kecUser->nama : null,
                    'kel_name' => $kelUser ? $kelUser->nama : null,
                ],
                'transaksi' => [
                    'id_trx' => $trx->id_trx,
                    'id_kec' => $trx->id_kec,
                    'id_kel' => $trx->id_kel,
                    'kec_name' => $kecTrx ? $kecTrx->nama : null,
                    'kel_name' => $kelTrx ? $kelTrx->nama : null,
                ]
            ]);
        } else {
            echo json_encode(['error' => 'No transaction found for user']);
        }
    } else {
        echo json_encode(['error' => 'User not found']);
    }
} catch (\Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
