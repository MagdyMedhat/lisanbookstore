<?php

use Illuminate\Database\Seeder;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Books')->insert([
           'name' => 'The Adventures of Tom Sawyer',
            'writer_id' => '1',
            'code' => '0100',
            'stock_count' => 100,
            'sold_count' => 0,
            'page_count' => 50,
            'description' => '',
            'artist_id' => 1,
            'notes' => '',
            'published_date' => Carbon\Carbon::now()
        ]);
        DB::table('Books')->insert([
            'name' => 'The Adventures of Huckleberry Fin',
            'code' => '0101',
            'writer_id' => '1',
            'stock_count' => 100,
            'sold_count' => 0,
            'page_count' => 100,
            'description' => '',
            'artist_id' => 1,
            'notes' => '',
            'published_date' => Carbon\Carbon::now()
        ]);
    }
}
