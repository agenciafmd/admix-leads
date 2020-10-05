<?php

namespace Database\Seeders;

use Agenciafmd\Leads\Models\Lead;
use Illuminate\Database\Seeder;

class LeadsTableSeeder extends Seeder
{
    protected int $total = 150;

    public function run()
    {
        Lead::withTrashed()
            ->get()->each->forceDelete();

        $this->command->getOutput()
            ->progressStart($this->total);

        Lead::factory($this->total)
            ->create();

        $this->command->getOutput()
            ->progressFinish();
    }
}
