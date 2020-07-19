<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Role::create([
            'title' => 'Admin' //1
        ]);
        \App\Role::create([
            'title' => 'Professor' //2
        ]);
        \App\Role::create([
            'title' => 'Student' //3
        ]);
        \App\Role::create([
            'title' => 'Manage Exams Panel' //4
        ]);
        \App\Role::create([
            'title' => 'Manage Reading Section' //5
        ]);
        \App\Role::create([
            'title' => 'Manage Grammar Section' //6
        ]);
        \App\Role::create([
            'title' => 'Manage Listening Section' //7
        ]);
        \App\Role::create([
            'title' => 'Edit Failed Students Marks' //8
        ]);
        \App\Role::create([
            'title' => 'Print Certificates' //9
        ]);
        \App\Role::create([
            'title' => 'Manage Students Panel' //10
        ]);
        \App\Role::create([
            'title' => 'Manage Reservations Panel' //11
        ]);
        \App\Role::create([
            'title' => 'Super Admin' //12
        ]);
    }
}
