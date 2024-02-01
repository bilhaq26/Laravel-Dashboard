<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DaftarApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'id_jenis_api' => $this->id_jenis_api,
            'jenis_api' => $this->JenisAPI->nama,
            'id_perangkat_daerah' => $this->id_perangkat_daerah,
            'perangkat_daerah' => $this->PerangkatDaerah->nama,
            'url' => $this->PerangkatDaerah->url,
            'endpoint' => $this->endpoint,
            // 'jenis_api' => $this->JenisAPI,
        ];
    }
}
