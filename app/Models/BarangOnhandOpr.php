<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangOnhandOpr extends Model
{
    use HasFactory;

    protected $table = 'barang_onhand_opr';

    /**
     * Daftar 17 Sparepart Standar ONHAND OPR
     */
    public const STANDARD_PARTS = [
        ['kode_plu' => '22062', 'nama_barang' => 'SPAREPART KOMPUTER MEMORY DDR3 4GB', 'divisi' => 'CPU', 'satuan' => 'PCS'],
        ['kode_plu' => '32411', 'nama_barang' => 'SPAREPARTS KOMPUTER KABEL USB PRINTER 1.5 M', 'divisi' => 'CPU', 'satuan' => 'PCS'],
        ['kode_plu' => '63288', 'nama_barang' => 'ADAPTOR ADAPTOR 12V 2A', 'divisi' => 'STB', 'satuan' => 'PCS'],
        ['kode_plu' => '63711', 'nama_barang' => 'FAN PROSESOR LGA 1150', 'divisi' => 'CPU', 'satuan' => 'PCS'],
        ['kode_plu' => '63712', 'nama_barang' => 'FLASHDISK 64 GB(C)', 'divisi' => 'STB', 'satuan' => 'PCS'],
        ['kode_plu' => '63716', 'nama_barang' => 'KABEL VGA 1.5MM', 'divisi' => 'CPU', 'satuan' => 'PCS'],
        ['kode_plu' => '63741', 'nama_barang' => 'CONNECTOR PANDUIT -', 'divisi' => 'CPU', 'satuan' => 'PCS'],
        ['kode_plu' => '63806', 'nama_barang' => 'KABEL POWER CPU', 'divisi' => 'CPU', 'satuan' => 'PCS'],
        ['kode_plu' => '63808', 'nama_barang' => 'KABEL POWER MONITOR', 'divisi' => 'CPU', 'satuan' => 'PCS'],
        ['kode_plu' => '63833', 'nama_barang' => 'POWER SUPPLY SIMBADA', 'divisi' => 'CPU', 'satuan' => 'PCS'],
        ['kode_plu' => '63848', 'nama_barang' => 'USB HUB 4 PORT', 'divisi' => 'CPU', 'satuan' => 'PCS'],
        ['kode_plu' => '63943', 'nama_barang' => 'KABEL HDMI 1,5 MTR(C) -', 'divisi' => 'CPU', 'satuan' => 'PCS'],
        ['kode_plu' => '69840', 'nama_barang' => 'ADAPTOR 24 V 0.8 A UNTUK RB951 -', 'divisi' => 'KONEKSI', 'satuan' => 'PCS'],
        ['kode_plu' => '69889', 'nama_barang' => 'SSD 512GB -', 'divisi' => 'CPU', 'satuan' => 'PCS'],
        ['kode_plu' => '63955', 'nama_barang' => 'MEMORY DDR4 8GB -', 'divisi' => 'CPU', 'satuan' => 'PCS'],
        ['kode_plu' => 'EDC1',  'nama_barang' => 'KABEL EDC BCA', 'divisi' => 'EDC', 'satuan' => 'PCS'],
        ['kode_plu' => 'EDC2',  'nama_barang' => 'KABEL EDC MANDIRI', 'divisi' => 'EDC', 'satuan' => 'PCS'],
    ];

    protected $fillable = [
        'barang_id',
        'no_urut',
        'kode_plu',
        'nama_barang',
        'tanggal_ambil',
        'tanggal_keluar',
        'divisi',
        'satuan',
        'teknisi',
        'qty_ambil',
        'qty_out',
        'qty_sisa',
        'status',
        'keterangan',
        'tujuan_pemakaian',
        'serial_number',
        'out_method',
        'approved_at',
        'approved_by',
        'google_sheet_row',
        'last_synced_at',
    ];

    protected $casts = [
        'tanggal_ambil'  => 'date',
        'tanggal_keluar' => 'date',
        'qty_ambil'      => 'integer',
        'qty_out'        => 'integer',
        'qty_sisa'       => 'integer',
        'no_urut'        => 'integer',
        'google_sheet_row' => 'integer',
        'approved_at'    => 'datetime',
        'last_synced_at' => 'datetime',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

    /**
     * Scope untuk transaksi yang masih memegang sisa part onhand
     */
    public function scopeActive($query)
    {
        return $query->where('qty_sisa', '>', 0);
    }

    /**
     * Scope untuk transaksi yang sudah selesai/out lunas
     */
    public function scopeCompleted($query)
    {
        return $query->where('qty_sisa', '<=', 0);
    }

    /**
     * Scope untuk pengajuan OUT dari Telegram yang menunggu persetujuan
     */
    public function scopePendingApproval($query)
    {
        return $query->where('status', 'PENDING_APPROVAL');
    }

    /**
     * Scope filter per teknisi
     */
    public function scopeByTeknisi($query, string $teknisi)
    {
        return $query->where('teknisi', strtoupper($teknisi));
    }
}
