<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Transaksi;
use App\Models\SetupKel;

class TestTransaksi extends Transaksi {
    public function getDesaAttribute() {
        return SetupKel::where('kode_desa', $this->id_kel)
                       ->where('kecamatan_id', $this->id_kec)
                       ->first();
    }
}

try {
    $trx = TestTransaksi::where('id_trx', 'PDK-280626-004')->first();
    if ($trx) {
        $desa = $trx->desa;
        echo json_encode([
            'id_trx' => $trx->id_trx,
            'desa' => $desa
        ]);
    } else {
        echo json_encode(['error' => 'Trx not found']);
    }
} catch (\Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
