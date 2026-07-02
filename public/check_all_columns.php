<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    $columns = DB::select("SHOW FULL COLUMNS FROM transaksi");
    foreach ($columns as $c) {
        echo "- {$c->Field}: type={$c->Type}, collation={$c->Collation}\n";
    }
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
