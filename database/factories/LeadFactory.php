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
            'is_active' => fake()->optional(0.3, 1)
                ->randomElement([0]),
            'source' => fake()->randomElement($sources),
            'name' => fake()->sentence(3),
            'email' => fake()->freeEmail,
            'phone' => fake()->phoneNumber,
            'description' => fake()->paragraphs(3, true),
        ];
    }
}
