<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicePartKeluar extends Model
{
    use HasFactory;

    protected $table = 'service_part_keluar';

    protected $fillable = [
        'service_barang_id',
        'barang_id',
        'kode_plu',
        'nama_barang',
        'qty',
        'tanggal_keluar',
    ];

    protected $casts = [
        'qty' => 'integer',
        'tanggal_keluar' => 'date',
    ];

    public function serviceBarang()
    {
        return $this->belongsTo(ServiceBarang::class, 'service_barang_id');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }
}
