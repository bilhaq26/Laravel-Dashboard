<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'username' => $this->username,
            // make photo url if space in name give %20 in url
            'photo' => $this->photo ? url('/storage/user/'.$this->photo) : null,

            // get role from spatie permission
            'role' => $this->getRoleNames(),
            'name' => $this->name,
            'email' => $this->email,
            'address' => $this->address,
            'phone' => $this->phone,
            'status' => $this->status,
        ];
    }
}
