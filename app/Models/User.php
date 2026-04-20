<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user';
    public $timestamps = false; // ← tambahkan baris ini

    protected $fillable = [
        'id',
        'NIK',
        'Nama',
        'Password',
    ];
}