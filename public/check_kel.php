<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\SetupKel;

try {
    $kelList = SetupKel::where('kecamatan_id', 1)->get();
    $kel2008 = SetupKel::where('kode_desa', 2008)->first();
    $kelBagak = SetupKel::where('nama', 'like', '%BAGAK%')->first();
    
    echo json_encode([
        'kel_2008' => $kel2008,
        'kel_bagak' => $kelBagak,
        'all_in_binuang' => $kelList
    ]);
} catch (\Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
