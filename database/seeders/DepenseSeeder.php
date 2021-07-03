<?php

namespace Database\Seeders;

use App\Models\Depense;
use Illuminate\Database\Seeder;

class DepenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Depense::factory()->count(5)->create();
    }
}
