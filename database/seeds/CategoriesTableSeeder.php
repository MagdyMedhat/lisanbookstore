<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Categories')->insert([
            'name' => 'Sale'
        ]);

        DB::table('Categories')->insert([
            'name' => 'Rent'
        ]);
    }
}
