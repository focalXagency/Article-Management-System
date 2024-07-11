<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BeAythorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $request_data = $this->request_data;
        return [
            'request_id' => $this->id,
            'request_data_id' => $request_data->id,
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'status' => $this->status,
            'country' => $request_data->country,
            'address' => $request_data->address,
        ];
    }
}
