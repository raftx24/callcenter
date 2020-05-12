<?php

namespace App\Services;

use App\Models\Call;
use App\Models\Support;
use App\Enums\CallStatus;
use App\Enums\SupportStatus;
use Illuminate\Support\Facades\DB;
use App\Exceptions\SupportIsBusyException;

class CallAssignService
{
    private ?Call $call;

    public function __construct(Support $support)
    {
        $this->support = $support;
    }

    public function handle()
    {
        if (! $this->support->isFree()) {
            throw new SupportIsBusyException($this->support);
        }

        if (! $this->getCall()) {
            return;
        }

        DB::transaction(function () {
            $this->call->update([
                'support_id' => $this->support->id,
                'status' => CallStatus::IN_CALL,
            ]);

            $this->support->update([
                'status' => SupportStatus::IN_CALL
            ]);
        });

        return $this->getCall();
    }

    private function getCall()
    {
        return $this->call
            ??= Call::waiting()->ordered()->first();
    }
}
