<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barang extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'barang';

    protected $fillable = [
        'kode_plu',
        'nama_barang',
        'divisi',
        'satuan',
        'qty_stock',
        'keterangan',
    ];

    /**
     * Relasi ke part keluar pada service barang
     */
    public function servicePartKeluars()
    {
        return $this->hasMany(ServicePartKeluar::class, 'barang_id');
    }

    /**
     * Relasi ke riwayat log transit keluar / masuk
     */
    public function logTransits()
    {
        return $this->hasMany(BarangLogTransit::class, 'barang_id');
    }

    /**
     * Helper status stok: Aman, Menipis, Habis
     */
    public function getStockStatusAttribute()
    {
        if ($this->qty_stock <= 0) {
            return [
                'label' => 'Habis',
                'color' => 'red',
                'badge' => 'danger',
            ];
        } elseif ($this->qty_stock <= 5) {
            return [
                'label' => 'Menipis',
                'color' => 'yellow',
                'badge' => 'warning',
            ];
        } else {
            return [
                'label' => 'Aman',
                'color' => 'green',
                'badge' => 'success',
            ];
        }
    }
}
