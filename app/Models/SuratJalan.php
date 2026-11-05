<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratJalan extends Model
{
    use HasFactory;

    protected $table = 'surat_jalan';

    protected $fillable = [
        'no_sj',
        'tipe_sj',
        'tanggal',
        'kepada',
        'perihal',
        'kode_toko',
        'nama_toko',
        'items',
        'signatures',
        'catatan',
        'created_by',
    ];

    protected $casts = [
        'tanggal'    => 'date',
        'items'      => 'array',
        'signatures' => 'array',
    ];

    /**
     * Generate auto-sequenced No SJ based on type and date
     */
    public static function generateNoSj(string $tipe): string
    {
        $prefix = strtoupper($tipe) === 'GO' ? 'SJ-GO' : 'SJ-NRM';
        $dateCode = date('Ymd');
        $pattern = "{$prefix}-{$dateCode}-%";

        $lastSj = self::where('no_sj', 'like', $pattern)
            ->orderBy('id', 'desc')
            ->first();

        $seq = 1;
        if ($lastSj && preg_match('/-(\d+)$/', $lastSj->no_sj, $matches)) {
            $seq = intval($matches[1]) + 1;
        }

        return sprintf('%s-%s-%03d', $prefix, $dateCode, $seq);
    }
}
