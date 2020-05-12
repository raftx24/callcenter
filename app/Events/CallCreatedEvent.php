<?php

namespace App\Events;

use App\Models\Call;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CallCreatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private int $callId;
    private Call $call;

    public function __construct($callId)
    {
        $this->callId = $callId;
    }

    public function getCall()
    {
        return $this->call
            ??= Call::find($this->callId);
    }
}
