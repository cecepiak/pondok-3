<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    echo "Converting 'transaksi' table to utf8mb4...\n";
    DB::statement("ALTER TABLE transaksi CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "Success! Checking column collations now:\n";
    
    $columns = DB::select("SHOW FULL COLUMNS FROM transaksi");
    foreach ($columns as $c) {
        if ($c->Collation) {
            echo "- {$c->Field}: collation={$c->Collation}\n";
        }
    }
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
