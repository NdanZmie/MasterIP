<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Spekpc extends Model
{
    protected $table = 'spekpc';
    public $timestamps = false; 

    protected $fillable = [
        'ip',
        'nama',
        'dept',
        'dat',
        'sn',
        'merk',
        'processor',
        'ram',
        'storage',
        'lisensi_windows',
        'lisensi_office',
        'windows',
        'status',
        'keterangan'
    ];
public function getStatusColorAttribute()
{
    $status = strtoupper(trim((string) $this->status));

    if ($status === 'UNDER') {
        return 'bg-red-100 text-red-700';
    }

    if ($status === 'AMAN') {
        return 'bg-yellow-100 text-yellow-700';
    }

    if ($status === 'BAGUS') {
        return 'bg-green-100 text-green-700';
    }

    return 'bg-gray-100 text-gray-500';
}}

