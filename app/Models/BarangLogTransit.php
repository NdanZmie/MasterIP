<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangLogTransit extends Model
{
    use HasFactory;

    protected $table = 'barang_log_transit';

    protected $fillable = [
        'barang_id',
        'kode_plu',
        'nama_barang',
        'divisi',
        'satuan',
        'tipe',
        'kategori',
        'qty',
        'stok_awal',
        'stok_akhir',
        'tujuan_sumber',
        'referensi_id',
        'pic',
        'keterangan',
        'tanggal_transaksi',
    ];

    protected $casts = [
        'tanggal_transaksi' => 'date',
    ];

    /**
     * Relasi ke master barang
     */
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

    /**
     * Helper badge styling untuk tipe transaksi IN / OUT / EDIT
     */
    public function getTipeBadgeAttribute()
    {
        if ($this->tipe === 'IN') {
            return [
                'label' => 'MASUK (IN)',
                'class' => 'badge-in',
                'prefix' => '+',
            ];
        } elseif ($this->tipe === 'OUT') {
            return [
                'label' => 'KELUAR (OUT)',
                'class' => 'badge-out',
                'prefix' => '-',
            ];
        }

        return [
            'label' => 'EDIT / KOREKSI',
            'class' => 'badge-edit',
            'prefix' => '',
        ];
    }
}
