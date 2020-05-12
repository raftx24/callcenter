<?php

namespace App\Services;

use App\Models\Call;
use App\Models\Support;
use App\Enums\CallStatus;
use App\Enums\SupportStatus;
use Illuminate\Support\Facades\DB;
use App\Exceptions\CallIsNotImmediateException;

class ImmediateCallService
{
    private ?Call $call;
    private ?Support $support;

    public function __construct()
    {
        $this->call = null;
        $this->support = null;
    }

    public function setCall(Call $call): self
    {
        $this->call = $call;

        return $this;
    }

    public function setSupport(Support $support): self
    {
        $this->support = $support;

        return $this;
    }

    public function handle()
    {
        if (! $this->getCall() || ! $this->getSupport()) {
            return;
        }

        if (! $this->call->isImmediate()) {
            throw new CallIsNotImmediateException($this->call);
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
    }

    private function getSupport()
    {
        return $this->support
            ??= Support::free()->first();
    }

    private function getCall()
    {
        return $this->call
            ??= Call::waiting()->immediate()->ordered()->first();
    }
}
