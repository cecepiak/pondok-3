<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;

try {
    $user = User::where('name', 'like', '%CECEP SYAFEI%')->first();
    if ($user) {
        $desa = $user->desa;
        echo json_encode([
            'user_name' => $user->name,
            'kode_desa' => $user->kode_desa,
            'desa_relation' => $desa
        ]);
    } else {
        echo json_encode(['error' => 'User not found']);
    }
} catch (\Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
