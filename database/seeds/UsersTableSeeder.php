<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //factory(\App\User::class,4)->create();

        User::create([
          'name'=>'Admin',
          'email'=>'admin@admin.com',
          'password'=>'$2y$10$aVsbF321xGmFj/JSO8OeTe80REpDa.sJD.0roGzqG9OxwfDDfYB1a', //password
            'role_id'=>1
        ]);


    }
}
