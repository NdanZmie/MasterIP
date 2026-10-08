<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMutasiBulanan extends Model
{
    use HasFactory;

    protected $table = 'barang_mutasi_bulanan';

    protected $fillable = [
        'barang_id',
        'kode_plu',
        'periode_key',
        'nama_bulan',
        'urutan',
        'qty_in',
        'qty_out',
        'saldo_akhir',
    ];

    /**
     * Relasi ke master barang
     */
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }
}
