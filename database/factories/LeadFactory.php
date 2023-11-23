<?php

namespace Agenciafmd\Leads\Database\Factories;

use Agenciafmd\Leads\Models\Lead;
use Agenciafmd\Postal\Models\Postal;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeadFactory extends Factory
{
    protected $model = Lead::class;

    public function definition(): array
    {
        $sources = Postal::query()
            ->pluck('slug')
            ->toArray();

        return [
            'is_active' => $this->faker->optional(0.3, 1)
                ->randomElement([0]),
            'source' => $this->faker->randomElement($sources),
            'name' => $this->faker->sentence(3),
            'email' => $this->faker->freeEmail,
            'phone' => $this->faker->phoneNumber,
            'description' => $this->faker->paragraphs(3, true),
        ];
    }
}
