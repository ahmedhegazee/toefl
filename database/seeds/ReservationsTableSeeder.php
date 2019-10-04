<?php

use App\User;
use Illuminate\Database\Seeder;

class ReservationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Reservation::create([
            'start'=>now()->toDateString(),
            'end'=>now()->addDays(10)->toDateString(),
            'max_students'=>50
        ]);
        $group=\App\Group::create(['name'=>'Group 1']);
        $st= User::create([
            'name'=>'Student',
            'email'=>'student@admin.com',
            'password'=>'$2y$10$aVsbF321xGmFj/JSO8OeTe80REpDa.sJD.0roGzqG9OxwfDDfYB1a', //password
            'role_id'=>2,

        ]);
        \App\Student::create([
            'uid'=>$st->id,
            'phone'=>'01113353945',
            'personalimage'=>'personalimages/f7B7s5p4kEeDM41TFKk1BYl9bazOmO1n56aa4R8a.jpeg',
            'nidimage'=>'nidimages/ST7pLVogHynp4zNVXmW2rhm5O0rKCJ2zDZXhffVN.jpeg',
            'certificateimage'=>'certificateimages/Y5dWwrSLy0E0ViPLD7NK91mVleoKb5LAgeGxci6u.jpeg',
            'messageimage'=>'messageimages/IfxWoF1FzlHzXEoKy6OTehYZmoF9JpWLNLv92KGB.jpeg',
            'res_id'=>\App\Reservation::first()->id,
            'group_id'=>$group->id,
        ]);
    }
}
