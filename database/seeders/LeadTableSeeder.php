<?php

namespace Agenciafmd\Leads\Database\Seeders;

use Agenciafmd\Leads\Models\Lead;
use Illuminate\Database\Seeder;

class LeadTableSeeder extends Seeder
{
    protected int $total = 100;

    public function run(): void
    {
        Lead::query()
            ->truncate();

        $this->command->getOutput()
            ->progressStart($this->total);

        collect(range(1, $this->total))
            ->each(function () {
                Lead::factory()
                    ->create();

                $this->command->getOutput()
                    ->progressAdvance();
            });

        $this->command->getOutput()
            ->progressFinish();
    }
}
