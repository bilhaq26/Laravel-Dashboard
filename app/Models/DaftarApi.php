<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarApi extends Model
{
    use HasFactory;

    protected $table = 'daftar_apis';
    protected $with = ['JenisAPI', 'PerangkatDaerah'];

    protected $fillable = [
        'id_jenis_api',
        'id_perangkat_daerah',
        'endpoint',
    ];

    public function JenisAPI()
    {
        return $this->belongsTo('App\Models\Ref\JenisApi', 'id_jenis_api', 'id');
    }

    public function PerangkatDaerah()
    {
        return $this->belongsTo('App\Models\Ref\PerangkatDaerah', 'id_perangkat_daerah', 'id');
    }

}
