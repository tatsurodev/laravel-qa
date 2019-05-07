<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Answer::class, function (Faker $faker) {
    return [
        'body' => $faker->paragraphs(rand(3, 7), true),
        // App\User::pluck('id')はcollectionを返し、randomメソッドで１つ選択
        'user_id' => App\User::pluck('id')->random(),
        // 'votes_count' => rand(0, 5)
    ];
});
