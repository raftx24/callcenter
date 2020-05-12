<?php

namespace Tests\Feature;

use App\Models\Support;
use App\Enums\CallPriority;
use App\Enums\SupportStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CallStartTest extends TestCase
{
    use RefreshDatabase;

    public function testWhenRequestIsNotValidThenRequestShouldNotValidate()
    {
        $resp = $this->json('post' ,route('calls.start'), []);

        $resp->assertStatus(422);
        $resp->assertJson([
            'message' => 'The given data was invalid.'
        ]);
    }

    public function testWhenRequestDoesNotHaveValidPriorityThenShouldThrowException()
    {
        $resp = $this->json('post' ,route('calls.start'), [
            'phone_number' => '09158585179',
            'priority' => 2
        ]);

        $resp->assertStatus(422);
        $resp->assertJson([
            'message' => 'The given data was invalid.'
        ]);
    }

    public function testCreateNormalCall()
    {
        $resp = $this->json('post' ,route('calls.start'), [
            'phone_number' => '09158585179',
            'priority' => CallPriority::NORMAL
        ]);

        $resp->assertJson([
            'data' => [
                'phone_number' => "09158585179"
            ]
        ]);

        $this->assertDatabaseHas('calls', [
            'phone_number' => '09158585179',
            'priority' => CallPriority::NORMAL,
            'support_id' => null
        ]);
    }
}
