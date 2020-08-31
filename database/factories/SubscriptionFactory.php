<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Subscription;
use Faker\Generator as Faker;

$factory->define(Subscription::class, static function (Faker $faker) {
    return [
        'active' => $faker->boolean(50),
        'activeRenewal' => $faker->boolean(50),
        'expiresAt' => $faker->dateTime,
    ];
});
