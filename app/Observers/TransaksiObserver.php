<?php

namespace App\Observers;

use App\Models\Transaksi;
use App\Models\StatusLog;

class TransaksiObserver
{
    public function creating(Transaksi $transaksi)
    {
        if (empty($transaksi->id_trx)) {
            $transaksi->id_trx = $transaksi->generateIdTrx();
        }
    }

    public function saving(Transaksi $transaksi)
    {
        // Hanya untuk update (bukan create)
        if ($transaksi->exists) {
            $originalStatus = $transaksi->getOriginal('status');
            $newStatus = $transaksi->status;

            if ($originalStatus != $newStatus) {
                StatusLog::create([
                    'transaksi_id' => $transaksi->id_trx,
                    'status_sebelumnya' => $originalStatus,
                    'status_baru' => $newStatus,
                ]);
            }
        }
        // ❌ JANGAN simpan log untuk transaksi baru di sini
    }

    // ✅ Simpan log awal di sini — setelah id_trx tersedia
    public function created(Transaksi $transaksi)
    {
        StatusLog::create([
            'transaksi_id' => $transaksi->id_trx,
            'status_sebelumnya' => null,
            'status_baru' => $transaksi->status ?? 1,
        ]);
    }
}

    // Untuk transaksi baru, ID belum ada saat `saving`, jadi kita simpan log di `created`
    // public function created(Transaksi $transaksi)
    // {
        // Update transaksi_id di log pertama
    //     $transaksi->statusLogs()->latest()->first()?->update(['transaksi_id' => $transaksi->id]);
    // }
