<?php

namespace Database\Factories;

use Agenciafmd\Leads\Models\Lead;
use Agenciafmd\Postal\Models\Postal;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeadFactory extends Factory
{
    protected $model = Lead::class;

    public function definition()
    {
        $sources = Postal::pluck('slug')
            ->toArray();

        return [
            'is_active' => $this->faker->optional(0.3, 1)
                ->randomElement([0]),
            'source' => $this->faker->randomElement($sources),
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'description' => $this->faker->text,
        ];
    }
}
