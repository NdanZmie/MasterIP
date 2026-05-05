<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Toko extends Model
{
    use HasFactory;

    protected $connection = 'masterip';
    protected $table = 'toko';
    protected $primaryKey = 'id_toko';
    public $timestamps = false;

    protected $fillable = [
        'kode_toko',
        'nama_toko',
        'ip_cctv',
        'ip_station_1',
        'ip_station_2',
        'ip_station_3',
        'ip_station_4',
        'ip_station_5',
        'ip_stb',
    ];
}