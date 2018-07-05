<?php

use Faker\Generator as Faker;
use App\Player;

$factory->define(Player::class, function (Faker $faker) {
    return [
        'first_name' => $faker->name,
        'first_name' => $faker->name,
        'last_name' => $faker->name,
    ];
});
