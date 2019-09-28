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
            'title'=>'Verifier'
        ]);
    }
}
