<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceBarang extends Model
{
    use HasFactory;

    protected $table = 'service_barang';

    protected $fillable = [
        'no_dat',
        'sn',
        'nama_barang',
        'kode_toko',
        'kerusakan',
        'tindakan',
        'tanggal_masuk',
        'tanggal_selesai',
        'status',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
        'tanggal_selesai' => 'date',
    ];

    protected $appends = [
        'durasi_text',
    ];

    /**
     * Relasi ke part keluar yang digunakan pada service ini
     */
    public function partKeluars()
    {
        return $this->hasMany(ServicePartKeluar::class, 'service_barang_id');
    }

    /**
     * Relasi ke data toko jika kode toko cocok
     */
    public function toko()
    {
        return $this->belongsTo(Toko::class, 'kode_toko', 'kode_toko');
    }

    /**
     * Hitung durasi pengerjaan service
     */
    public function getDurasiTextAttribute()
    {
        if (!$this->tanggal_masuk) {
            return '-';
        }

        if ($this->tanggal_selesai) {
            $days = (int) $this->tanggal_masuk->diffInDays($this->tanggal_selesai);
            if ($days === 0) {
                return 'Hari yang sama (< 24 Jam)';
            }
            return $days . ' Hari';
        }

        $days = (int) $this->tanggal_masuk->diffInDays(now()->startOfDay());
        if ($days === 0) {
            return 'Hari ini (Baru Masuk)';
        }
        return $days . ' Hari Berjalan';
    }

    /**
     * Helper badge styling untuk status service
     */
    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {
            'Belum Cek' => [
                'bg' => 'bg-amber-500/10 text-amber-600 border-amber-500/20 dark:bg-amber-500/20 dark:text-amber-400',
                'dot' => 'bg-amber-500',
                'label' => 'Belum Cek'
            ],
            'Sudah Cek' => [
                'bg' => 'bg-blue-500/10 text-blue-600 border-blue-500/20 dark:bg-blue-500/20 dark:text-blue-400',
                'dot' => 'bg-blue-500',
                'label' => 'Sudah Cek'
            ],
            'Service Suplier' => [
                'bg' => 'bg-purple-500/10 text-purple-600 border-purple-500/20 dark:bg-purple-500/20 dark:text-purple-400',
                'dot' => 'bg-purple-500',
                'label' => 'Service Suplier'
            ],
            'Selesai Service' => [
                'bg' => 'bg-emerald-500/10 text-emerald-600 border-emerald-500/20 dark:bg-emerald-500/20 dark:text-emerald-400',
                'dot' => 'bg-emerald-500',
                'label' => 'Selesai Service'
            ],
            default => [
                'bg' => 'bg-slate-500/10 text-slate-600 border-slate-500/20',
                'dot' => 'bg-slate-500',
                'label' => $this->status
            ]
        };
    }
}
