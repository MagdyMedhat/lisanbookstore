<?php

use Illuminate\Database\Seeder;

class WritersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Writers')->insert([
            'name' => 'Mark Twain',
            'birth_date' => Carbon\Carbon::createFromFormat('Y-m-d', '1891-3-22')->toDateString(),
            'nationality' => 'American'
        ]);
        DB::table('Writers')->insert([
            'name' => 'Lowis Lowry',
            'birth_date' => Carbon\Carbon::createFromFormat('Y-m-d', '1945-5-11')->toDateString(),
            'nationality' => 'American'
        ]);
    }
}
