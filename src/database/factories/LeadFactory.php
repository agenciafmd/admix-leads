<?php

use Agenciafmd\Leads\Lead;

$factory->define(Lead::class, function (\Faker\Generator $faker) {

    return [
        'is_active' => $faker->optional(0.3, 1)
            ->randomElement([0]),
        'name' => $faker->name,
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
        'description' => $faker->text,
    ];
});
