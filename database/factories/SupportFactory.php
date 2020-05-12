<?php

/** @var Factory $factory */

use App\Models\Support;
use Faker\Generator as Faker;
use App\Enums\SupportStatus;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Support::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'priority' => 1,
        'status' => SupportStatus::IN_CALL,
    ];
});
