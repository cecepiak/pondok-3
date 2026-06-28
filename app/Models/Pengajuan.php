<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;

    protected $table = 'jenis_pelayanan';

    // Menonaktifkan timestamps karena tabel tidak memiliki created_at dan updated_at
    public $timestamps = false;

    // Laravel tidak akan mengelola primary key secara otomatis, karena bukan integer
    public $incrementing = false;

    // Primary key adalah string
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'nama',
        'keterangan',
        'persyaratan',
        'placeholder',
    ];
}