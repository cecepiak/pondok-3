<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusLog extends Model
{
    protected $table = 'status_logs';
    protected $fillable = ['transaksi_id', 'status_sebelumnya', 'status_baru'];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }
}