<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;
use App\Question;

$factory->define(Question::class, function (Faker $faker) {
    return [
        // 末尾のピリオド削除
        'title' => rtrim($faker->sentence(rand(5, 10)), "."),
        // paragraphsの第二引数trueで文字列、falseで配列で返す
        'body' => $faker->paragraphs(rand(3, 7), true),
        'views' => rand(0, 10),
        // 'answers_count' => rand(0, 10),
        // 'votes_count' => rand(-3, 10)
    ];
});
