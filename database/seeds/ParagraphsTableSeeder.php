<?php

use Illuminate\Database\Seeder;

class ParagraphsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Reading\Paragraph::class,30)->create();
    }
}
