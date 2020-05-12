<?php

/** @var Factory $factory */

use App\Models\Call;
use App\Enums\CallStatus;
use App\Enums\CallPriority;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Call::class, function (Faker $faker) {
    return [
        'phone_number' => $faker->phoneNumber,
        'priority' => CallPriority::NORMAL,
        'status' => CallStatus::WAITING,
    ];
});
