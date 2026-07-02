<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    // 1. Get the current column details for transaksi table
    $columns = DB::select("SHOW FULL COLUMNS FROM transaksi");
    
    echo "COLUMNS BEFORE ALTER:\n";
    foreach ($columns as $c) {
        if (in_array($c->Field, ['pesan', 'keterangan', 'alasan', 'komentar_rating'])) {
            echo "- {$c->Field}: type={$c->Type}, collation={$c->Collation}\n";
        }
    }
    
    // 2. Perform the ALTER queries
    DB::statement("ALTER TABLE transaksi MODIFY pesan TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL");
    DB::statement("ALTER TABLE transaksi MODIFY keterangan TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL");
    DB::statement("ALTER TABLE transaksi MODIFY alasan TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL");
    DB::statement("ALTER TABLE transaksi MODIFY komentar_rating TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL");
    
    // 3. Get column details again
    $columnsAfter = DB::select("SHOW FULL COLUMNS FROM transaksi");
    echo "\nCOLUMNS AFTER ALTER:\n";
    foreach ($columnsAfter as $c) {
        if (in_array($c->Field, ['pesan', 'keterangan', 'alasan', 'komentar_rating'])) {
            echo "- {$c->Field}: type={$c->Type}, collation={$c->Collation}\n";
        }
    }
    
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
