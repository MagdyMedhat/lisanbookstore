<?php

use Illuminate\Database\Seeder;

class ArtistsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Artists')->insert([
            'name' => 'James Green',
            'birth_date' => Carbon\Carbon::createFromFormat('Y-m-d', '1981-12-21')->toDateString(),
            'nationality' => 'American'
        ]);
    }
}
