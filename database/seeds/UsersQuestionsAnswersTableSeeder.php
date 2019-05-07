<?php

use Illuminate\Database\Seeder;

class UsersQuestionsAnswersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 外部参照されている親テーブルのレコードからから削除するとエラーが発生するのでレコードの削除を参照されていない元から削除していく
        \DB::table('answers')->delete();
        \DB::table('questions')->delete();
        \DB::table('users')->delete();
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
