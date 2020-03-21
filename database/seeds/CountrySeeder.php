<?php

use App\Http\Controllers\CountryController;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CountryController::importCSV();
    }
}
