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
        'no_urut',
        'kode_plu',
        'nama_barang',
        'divisi',
        'satuan',
        'moving',
        'pkm',
        'keb_per_toko',
        'total_toko',
        'kriteria_buffer',
        'saldo_awal',
        'qty_stock',
        'avg_l3m_out',
        'dsi',
        'lead_time',
        'minor',
        'reorder',
        'qty_pp',
        'buffer',
        'keterangan_khusus',
        'harga_satuan',
        'total_harga',
        'qty_pp_belum_realisasi',
        'keterangan',
        'google_sheet_row',
        'last_synced_at',
    ];

    protected $casts = [
        'no_urut'                => 'integer',
        'pkm'                    => 'integer',
        'keb_per_toko'           => 'decimal:2',
        'total_toko'             => 'integer',
        'saldo_awal'             => 'integer',
        'qty_stock'              => 'integer',
        'avg_l3m_out'            => 'decimal:2',
        'dsi'                    => 'integer',
        'lead_time'              => 'integer',
        'minor'                  => 'integer',
        'reorder'                => 'integer',
        'qty_pp'                 => 'integer',
        'buffer'                 => 'integer',
        'harga_satuan'           => 'decimal:2',
        'total_harga'            => 'decimal:2',
        'qty_pp_belum_realisasi' => 'integer',
        'google_sheet_row'       => 'integer',
        'last_synced_at'         => 'datetime',
    ];

    /**
     * Relasi ke riwayat mutasi bulanan (LPP)
     */
    public function mutasiBulanan()
    {
        return $this->hasMany(BarangMutasiBulanan::class, 'barang_id')->orderBy('urutan', 'asc');
    }

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

    /**
     * Helper badge kategori perputaran barang (Moving)
     */
    public function getMovingBadgeAttribute()
    {
        $m = strtoupper(trim((string)$this->moving));
        switch ($m) {
            case 'FAST MOVING':
                return ['label' => 'Fast Moving', 'bg' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20'];
            case 'SLOW MOVING':
                return ['label' => 'Slow Moving', 'bg' => 'bg-amber-500/10 text-amber-400 border-amber-500/20'];
            case 'NOT MOVING':
                return ['label' => 'Not Moving', 'bg' => 'bg-rose-500/10 text-rose-400 border-rose-500/20'];
            case 'SPECIAL':
                return ['label' => 'Special', 'bg' => 'bg-cyan-500/10 text-cyan-400 border-cyan-500/20'];
            case 'KIRIM HO':
                return ['label' => 'Kirim HO', 'bg' => 'bg-purple-500/10 text-purple-400 border-purple-500/20'];
            default:
                return ['label' => $this->moving ?: '-', 'bg' => 'bg-slate-500/10 text-slate-400 border-slate-500/20'];
        }
    }

    /**
     * Helper format rupiah
     */
    public function getHargaSatuanFormatAttribute()
    {
        return 'Rp ' . number_format((float)$this->harga_satuan, 0, ',', '.');
    }

    public function getTotalHargaFormatAttribute()
    {
        return 'Rp ' . number_format((float)$this->total_harga, 0, ',', '.');
    }
}
