<?php

namespace App\Events;

use App\Models\Call;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CallEndedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $callId;
    private $call;

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
