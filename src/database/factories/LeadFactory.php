<?php

use Agenciafmd\Leads\Lead;
use Agenciafmd\Postal\Postal;

$factory->define(Lead::class, function (\Faker\Generator $faker) {

    $sources = Postal::pluck('slug')
        ->toArray();

    return [
        'is_active' => $faker->optional(0.3, 1)
            ->randomElement([0]),
        'source' => $faker->randomElement($sources),
        'name' => $faker->name,
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
        'description' => $faker->text,
    ];
});
