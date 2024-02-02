<?php

namespace App\Models\Ref;

use App\Models\DaftarApi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PerangkatDaerah extends Model
{
    use HasFactory;

    protected $table = 'perangkat_daerahs';
    protected $fillable = [
        'nama',
        'slug',
        'url',
        'api_key'
    ];

    public function daftarApis()
    {
        return $this->hasMany(DaftarApi::class);
    }

}
