<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('slug')->uqnique();
            $table->text('body');
            // unsignedIntegerは、符号なしのINT
            $table->unsignedInteger('views')->default(0);
            $table->unsignedInteger('answers')->default(0);
            // unsignedIntegerは、符号なしのINT
            $table->integer('votes')->default(0);
            $table->unsignedInteger('best_answer_id')->nullable();
            // 子の外部キーと親の主キーは同じ型でないといけない！unsignedIntegerだと
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            // 親テーブルusersの主キーidと子テーブルquestionsの外部キーuser_idを関連付け
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
