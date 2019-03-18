<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class IssueResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'client'=> $this->client,
            'commercial_name'=> $this->commercial->full_name,
            'commercial_phone'=> $this->commercial->phone,
            'diagnostic'=> $this->diagnostic,
            'id'=> $this->id,
            'imei'=> $this->imei,
            'delivered_at'=> $this->delivered_at,
            'stage'=> $this->stage,
            'user_name'=> $this->user->name ?? 'Not Assigned',
            'user_super'=> auth()->user()->isAdmin,
        ];
    }
}
