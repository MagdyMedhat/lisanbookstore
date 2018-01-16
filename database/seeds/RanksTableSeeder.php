<?php

use Illuminate\Database\Seeder;

class RanksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Ranks')->insert([
            'name' => 'Bronze'
        ]);

        DB::table('Ranks')->insert([
            'name' => 'Silver'
        ]);

        DB::table('Ranks')->insert([
            'name' => 'Gold'
        ]);
    }
}
