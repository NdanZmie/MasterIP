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
}