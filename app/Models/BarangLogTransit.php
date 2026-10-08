<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangLogTransit extends Model
{
    use HasFactory;

    protected $table = 'barang_log_transit';

    protected $fillable = [
        'no_urut',
        'barang_id',
        'kode_plu',
        'nama_barang',
        'divisi',
        'satuan',
        'periode',
        'tgl_datang',
        'tgl_btb',
        'no_btb',
        'tgl_keluar',
        'tgl_bkb',
        'no_bkb',
        'kdtk',
        'nama_toko',
        'aktiva',
        'tipe',
        'kategori',
        'qty',
        'harga_satuan',
        'total_harga',
        'stok_awal',
        'stok_akhir',
        'tujuan_sumber',
        'referensi_id',
        'pic',
        'keterangan',
        'tanggal_transaksi',
        'google_sheet_name',
        'google_sheet_row',
    ];

    protected $casts = [
        'no_urut'           => 'integer',
        'qty'               => 'integer',
        'harga_satuan'      => 'decimal:2',
        'total_harga'       => 'decimal:2',
        'stok_awal'         => 'integer',
        'stok_akhir'        => 'integer',
        'google_sheet_row'  => 'integer',
        'tanggal_transaksi' => 'date',
        'tgl_datang'        => 'date',
        'tgl_btb'           => 'date',
        'tgl_keluar'        => 'date',
        'tgl_bkb'           => 'date',
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
