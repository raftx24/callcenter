<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Call;
use App\Models\Support;
use App\Enums\CallStatus;
use App\Enums\SupportStatus;
use App\Services\CallEndService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CallEndServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testWhenCallEndedThenShouldChangeStatusOfCallAndSupport()
    {
        $support = factory(Support::class)->create([
            'status' => SupportStatus::IN_CALL
        ]);

        $call = factory(Call::class)->create([
            'support_id' => $support->id,
            'status' => CallStatus::IN_CALL,
        ]);

        (new CallEndService($call))->handle();

        $call->fresh();

        $this->assertEquals($support->id, $call->support_id);
        $this->assertEquals(CallStatus::FINISHED, $call->fresh()->status);
    }
}
