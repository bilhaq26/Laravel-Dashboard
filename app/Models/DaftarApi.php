<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarApi extends Model
{
    use HasFactory;

    protected $table = 'daftar_apis';
    protected $fillable = [
        'nama',
        'slug',
        'url',
        'jenis_api_id',
        'perangkat_daerah_id',
    ];

    public function jenisApi()
    {
        return $this->belongsTo(Ref\JenisApi::class, 'jenis_api_id');
    }

    public function perangkatDaerah()
    {
        return $this->belongsTo(Ref\PerangkatDaerah::class, 'perangkat_daerah_id');
    }
}
