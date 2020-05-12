<?php

namespace App\Http\Controllers;

use App\Models\Call;
use App\Models\Support;
use App\Enums\CallStatus;
use App\Services\CallEndService;
use App\Events\CallCreatedEvent;
use App\Services\CallAssignService;
use App\Http\Resources\CallResource;
use App\Jobs\ImmediateCallAssignerJob;
use App\Http\Requests\CallStartRequest;

class CallController extends Controller
{
    public function start(CallStartRequest $callPriority)
    {
        $call = Call::create($callPriority->validated() + [
            'status' => CallStatus::WAITING,
        ]);

        event(new CallCreatedEvent($call->id));

        return new CallResource($call->fresh());
    }

    public function end(Call $call)
    {
        (new CallEndService($call))
            ->handle();

        return new CallResource($call);
    }

    public function answer(Support $support)
    {
        $call = (new CallAssignService($support))
            ->handle();

        return $call
            ? new CallResource($call)
            : [
                'message' => 'there is no calls'
            ];
    }
}
