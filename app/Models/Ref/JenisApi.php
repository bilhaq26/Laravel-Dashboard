<?php

namespace App\Models\Ref;

use App\Models\DaftarApi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JenisApi extends Model
{
    use HasFactory;

    protected $table = 'jenis_apis';
    protected $fillable = [
        'nama',
        'slug',
    ];

    public function daftarApis()
    {
        return $this->hasMany(DaftarApi::class);
    }
}
