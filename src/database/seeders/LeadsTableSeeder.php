<?php

namespace Agenciafmd\Leads\Database\Seeders;

use Agenciafmd\Leads\Models\Lead;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeadsTableSeeder extends Seeder
{
    protected $total = 150000;

    public function run()
    {
//        Lead::withTrashed()
//            ->get()->each->forceDelete();

        DB::table('leads')
            ->truncate();

        $this->command->getOutput()
            ->progressStart($this->total);

        Lead::factory($this->total)
            ->create();

        $this->command->getOutput()
            ->progressFinish();
    }
}
