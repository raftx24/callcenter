<?php

namespace App\Services;

use App\Models\Call;
use App\Models\Support;
use App\Enums\CallStatus;
use App\Enums\SupportStatus;
use App\Events\CallEndedEvent;
use Illuminate\Support\Facades\DB;
use App\Jobs\ImmediateCallAssignerJob;

class CallEndService
{
    private Call $call;

    public function __construct(Call $call)
    {
        $this->call = $call;
    }

    public function handle()
    {
        DB::transaction(function () {
            $this->call->update([
                'status' => CallStatus::FINISHED
            ]);

            Support::whereId($this->call->support_id)->update([
                'status' => SupportStatus::WAITING
            ]);
        });

        event(new CallEndedEvent($this->call->id));
    }
}
