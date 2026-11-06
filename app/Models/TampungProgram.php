<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TampungProgram extends Model
{
    use HasFactory;

    protected $table = 'tampung_programs';

    protected $fillable = [
        'nama_program',
        'kategori',
        'versi',
        'deskripsi',
        'tipe_sumber',
        'file_name',
        'file_path',
        'file_size',
        'file_extension',
        'external_link',
        'download_count',
        'uploader',
        'catatan',
    ];

    /**
     * Human-readable file size format
     */
    public function getFormattedSizeAttribute(): string
    {
        if ($this->tipe_sumber === 'link' && $this->file_size <= 0) {
            return 'External Link';
        }

        $bytes = (float) $this->file_size;
        if ($bytes <= 0) {
            return '0 B';
        }

        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $i = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * File extension uppercase or fallback
     */
    public function getExtUpperAttribute(): string
    {
        if ($this->tipe_sumber === 'link') {
            return 'LINK';
        }

        return strtoupper($this->file_extension ?: 'FILE');
    }

    /**
     * Style badge colors based on file extension
     */
    public function getBadgeColorAttribute(): string
    {
        if ($this->tipe_sumber === 'link') {
            return 'badge-link';
        }

        $ext = strtolower($this->file_extension ?: '');

        return match ($ext) {
            'exe', 'msi' => 'badge-exe',
            'zip', 'rar', '7z', 'tar', 'gz' => 'badge-zip',
            'iso', 'img' => 'badge-iso',
            'bat', 'cmd', 'ps1', 'sh' => 'badge-script',
            'apk' => 'badge-apk',
            'pdf', 'doc', 'docx', 'xls', 'xlsx' => 'badge-doc',
            default => 'badge-default',
        };
    }
}
