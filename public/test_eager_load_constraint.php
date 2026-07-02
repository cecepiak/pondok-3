<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Transaksi;

try {
    // We modify the relation on the fly or just use query builder/Eloquent constraints
    $trx = Transaksi::with(['desa' => function($query) {
        // Here we can't easily reference the parent's table column 'transaksi.id_kec' unless we join
    }])->where('id_trx', 'PDK-280626-004')->first();
    
    echo json_encode(['status' => 'success', 'data' => $trx ? $trx->desa : null]);
} catch (\Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
