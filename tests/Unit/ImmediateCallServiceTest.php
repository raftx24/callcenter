<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Call;
use App\Models\Support;
use App\Enums\CallStatus;
use App\Enums\CallPriority;
use App\Enums\SupportStatus;
use App\Services\ImmediateCallService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ImmediateCallServiceTest extends TestCase
{
    use RefreshDatabase;

    private Call $call;

    protected function setUp(): void
    {
        parent::setUp();

        $this->call = factory(Call::class)->create([
            'priority' => CallPriority::IMMEDIATE
        ]);
    }

    public function testWhenTheCallIsImmediateAndThereIsFreeSupportThenShouldAssignIt()
    {
        $support = factory(Support::class)->create([
            'status' => SupportStatus::WAITING
        ]);

        (new ImmediateCallService())
            ->setCall($this->call)
            ->handle();

        $this->assertEquals($support->id, $this->call->fresh()->support_id);
        $this->assertEquals(CallStatus::IN_CALL, $this->call->fresh()->status);
        $this->assertEquals(SupportStatus::IN_CALL, $support->fresh()->status);
    }

    public function testWhenTheCallIsImmediateAndThereIsNoFreeSupportThenShouldNotAssignSupport()
    {
        factory(Support::class)->create([
            'status' => SupportStatus::IN_CALL
        ]);


        (new ImmediateCallService())
            ->setCall($this->call)
            ->handle();

        $this->assertNull($this->call->fresh()->support_id);
        $this->assertEquals(CallStatus::WAITING, $this->call->fresh()->status);
    }

    public function testWhenTheSupportIsFreeAndThereIsWaitingImmediateCallThenShouldAssignSupport()
    {
        $support = factory(Support::class)->create([
            'status' => SupportStatus::WAITING
        ]);

        (new ImmediateCallService())
            ->setSupport($support)
            ->handle();

        $this->assertEquals($support->id, $this->call->fresh()->support_id);
        $this->assertEquals(CallStatus::IN_CALL, $this->call->fresh()->status);
        $this->assertEquals(SupportStatus::IN_CALL, $support->fresh()->status);
    }
}
