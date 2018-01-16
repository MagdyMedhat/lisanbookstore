<?php

use Illuminate\Database\Seeder;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Clients')->insert([
            'name' => 'Awel Zboon',
            'address' => '18 18 st. Area 18',
            'email' => 'awelzboon@lisan.com',
            'rank_id' => '1',
            'telephone' => '1111111'
        ]);
    }
}
