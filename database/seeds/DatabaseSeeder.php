<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
//        $this->call(ReservationsTableSeeder::class);
        $this->call(GrammarQuestionTypesTableSeeder::class);
        $this->call(GrammarQuestionsTableSeeder::class);
        $this->call(ConfigTableSeeder::class);

//        $this->call(QuestionTypesTableSeeder::class);
//        $this->call(AttachmentsTableSeeder::class);
    }
}
