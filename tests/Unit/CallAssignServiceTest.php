<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Call;
use App\Models\Support;
use App\Enums\CallStatus;
use App\Enums\CallPriority;
use App\Enums\SupportStatus;
use App\Services\CallAssignService;
use App\Services\ImmediateCallService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CallAssignServiceTest extends TestCase
{
    use RefreshDatabase;

    private Support $support;
    private Call $immediateCall;
    private Call $normalCall;

    protected function setUp(): void
    {
        parent::setUp();

        $this->support = factory(Support::class)->create([
            'status' => SupportStatus::WAITING
        ]);

        $this->immediateCall = factory(Call::class)->create([
            'priority' => CallPriority::IMMEDIATE
        ]);

        $this->normalCall = factory(Call::class)->create([
            'priority' => CallPriority::NORMAL
        ]);
    }

    public function testWhenTheCallIsImmediateAndThereIsFreeSupportThenShouldAssignIt()
    {
        (new CallAssignService($this->support))->handle();

        $this->assertDatabaseHas('calls', [
            'id' => $this->immediateCall->id,
            'support_id' => $this->support->id,
            'status' => CallStatus::IN_CALL,
        ]);

        $this->assertDatabaseHas('calls', [
            'id' => $this->normalCall->id,
            'support_id' => null,
        ]);
    }

    public function testWhenTheCallIsImmediateAndThereIsNoFreeSupportThenShouldNotAssignSupport()
    {
        $this->immediateCall->update([
            'status' => CallStatus::FINISHED
        ]);

        (new CallAssignService($this->support))->handle();

        $this->assertDatabaseHas('calls', [
            'id' => $this->normalCall->id,
            'support_id' => $this->support->id,
            'status' => CallStatus::IN_CALL,
        ]);
    }
}
