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
            'title'=>'Admin'
        ]);
        \App\Role::create([
            'title'=>'Student'
        ]);
        \App\Role::create([
            'title'=>'Manage Exams Panel'
        ]);
        \App\Role::create([
            'title'=>'Manage Reading Section'
        ]);
        \App\Role::create([
            'title'=>'Manage Grammar Section'
        ]);
        \App\Role::create([
            'title'=>'Manage Listening Section'
        ]);
        \App\Role::create([
            'title'=>'Edit Failed Students Marks'
        ]);
        \App\Role::create([
            'title'=>'Print Certificates'
        ]);
        \App\Role::create([
            'title'=>'Manage Students Panel'
        ]);
        \App\Role::create([
            'title'=>'Manage Reservations Panel'
        ]);
        \App\Role::create([
            'title' => 'Super Admin'
        ]);

    }
}
