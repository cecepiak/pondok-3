<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Transaksi;

try {
    $trx = Transaksi::where('id_trx', 'PDK-280626-004')->first();
    if ($trx) {
        $desaLazy = $trx->desa;
        echo json_encode([
            'id_trx' => $trx->id_trx,
            'id_kel' => $trx->id_kel,
            'desa_lazy' => $desaLazy
        ]);
    } else {
        echo json_encode(['error' => 'Transaction not found']);
    }
} catch (\Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
