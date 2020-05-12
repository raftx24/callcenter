<?php

namespace App\Http\Resources;

use App\Enums\CallStatus;
use Illuminate\Http\Resources\Json\JsonResource;

class CallResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'phone_number' => $this->phone_number,
            'priority' => $this->priority,
            'status' => CallStatus::toString($this->status)
        ];
    }
}
