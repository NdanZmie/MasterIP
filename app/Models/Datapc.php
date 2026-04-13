<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Datapc extends Model
{
    protected $table = 'datapc';

    public $timestamps = false;

    protected $fillable = [
        'no',
        'ip',
        'computer_name',
        'nama',
        'nik',
        'departemen',
        'os',
        'merk_cpu',
        'tmav_tipe',
        'os_build',
        'status',
        'keterangan'
    ];
}