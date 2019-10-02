<?php

use Agenciafmd\Leads\Lead;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeadsTableSeeder extends Seeder
{
    protected $total = 150;

    public function run()
    {
        Lead::withTrashed()
            ->get()->each->forceDelete();

        DB::table('media')
            ->where('model_type', 'Agenciafmd\\Leads\\Lead')
            ->delete();

        $this->command->getOutput()
            ->progressStart($this->total);
        factory(Lead::class, $this->total)
            ->create();
        $this->command->getOutput()
            ->progressFinish();
    }
}
