<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Userが作成される度、それに関連するQestionを作成
        // factory(App\Question::class, 10)->create()だとUserとのリレーションが設定されていないためエラーとなる
        factory(App\User::class, 3)->create()->each(function ($u) {
            // saveManyで複数の関連したモデルを保存
            $u->questions()
                ->saveMany(
                    // createでレコードの挿入、makeでメモリ上にオブジェクトの作成
                    factory(App\Question::class, rand(1, 5))->make()
                )
                // questionが持つ複数のanswerを作成
                ->each(function ($q) {
                    $q->answers()->saveMany(
                        factory(App\Answer::class, rand(1, 5))->make()
                    );
                });
        });
    }
}
