<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Student;
use Faker\Generator as Faker;

$factory->define(Student::class, function (Faker $faker) {
   $user = factory(\App\User::class)->create();
   $user->update([
       'role_id'=>2,
       'email'=>$faker->unique()->email
   ]);
    return [

        ];
});
