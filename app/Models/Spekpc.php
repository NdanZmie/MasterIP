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
    return match(strtoupper(trim($this->status))) {
        'UNDER' => 'bg-red-100 text-red-700',
        'AMAN' => 'bg-yellow-100 text-yellow-700',
        'BAGUS' => 'bg-green-100 text-green-700',
        default => 'bg-gray-100 text-gray-500'
    };
}}

