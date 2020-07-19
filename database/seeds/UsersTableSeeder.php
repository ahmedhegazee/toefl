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


        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => '$2y$10$aVsbF321xGmFj/JSO8OeTe80REpDa.sJD.0roGzqG9OxwfDDfYB1a', //password
        ]);
        $user->roles()->attach([1, 2, 4, 5, 6, 7, 8, 9, 10, 11, 12]);

        //Mr.Hatem
        $user = User::create([
            'name' => 'Hatem',
            'email' => 'hatem@admin.com',

            'password' => '$2y$10$aVsbF321xGmFj/JSO8OeTe80REpDa.sJD.0roGzqG9OxwfDDfYB1a', //password
        ]);
        $user->roles()->attach([1, 4, 9, 10, 11]);

        //Prof.Ayman
        $user = User::create([
            'name' => 'Ayman',
            'email' => 'ayman@admin.com',

            'password' => '$2y$10$aVsbF321xGmFj/JSO8OeTe80REpDa.sJD.0roGzqG9OxwfDDfYB1a', //password
        ]);
        $user->roles()->attach([2, 5, 8]);
        //Prof.Khaled
        $user = User::create([
            'name' => 'Khaled',
            'email' => 'khaled@admin.com',

            'password' => '$2y$10$aVsbF321xGmFj/JSO8OeTe80REpDa.sJD.0roGzqG9OxwfDDfYB1a', //password
        ]);
        $user->roles()->attach([2, 6, 8]);
        //Prof.Ahmed
        $user = User::create([
            'name' => 'Ahmed',
            'email' => 'ahmed@admin.com',

            'password' => '$2y$10$aVsbF321xGmFj/JSO8OeTe80REpDa.sJD.0roGzqG9OxwfDDfYB1a', //password
        ]);
        $user->roles()->attach([2, 7, 8]);
        $user = User::create([
            'name' => 'Technical Support',
            'email' => 'support@admin.com',

            'password' => '$2y$10$aVsbF321xGmFj/JSO8OeTe80REpDa.sJD.0roGzqG9OxwfDDfYB1a', //password
        ]);
        $user->roles()->attach([1, 12]);
    }
}
