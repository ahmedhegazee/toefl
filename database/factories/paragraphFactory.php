<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Reading\Paragraph;
use Faker\Generator as Faker;

$factory->define(Paragraph::class, function (Faker $faker) {
    return [
        'title'=>$faker->text(30),
        'content'=>$faker->paragraph,
    ];
});
