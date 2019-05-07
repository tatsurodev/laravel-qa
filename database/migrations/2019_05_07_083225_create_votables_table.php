<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVotablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // ポリモーフィックリレーション用のテーブル作成
        Schema::create('votables', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            // question_id、もしくは、answer_idを格納
            $table->unsignedInteger('votable_id');
            // 格納するidのクラス名
            $table->string('votable_type');
            $table->tinyInteger('vote')->comment('-1: down vote, 1: up vote');
            $table->timestamps();
            $table->unique(['user_id', 'votable_id', 'votable_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('votables');
    }
}
