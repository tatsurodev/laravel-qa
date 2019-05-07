<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Question;

class VotablesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 元からあるQuestionのvoteレコードを削除
        \DB::table('votables')->where('votable_type', 'App\Question')->delete();

        $users = User::all();
        $numberOfUsers = $users->count();
        $votes = [-1, 1];

        // 全questionがユーザーからランダムにvoteを受ける
        foreach (Question::all() as $question) {
            for ($i = 0; $i < rand(0, $numberOfUsers); $i++) {
                $user = $users[$i];
                $user->voteQuestion($question, $votes[rand(0, 1)]);
            }
        }
    }
}
