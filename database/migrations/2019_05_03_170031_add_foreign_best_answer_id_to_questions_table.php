<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignBestAnswerIdToQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('questions', function (Blueprint $table) {
            // questions.best_answer_idのデータ型をanswers.idのbigIncrementsに揃える
            $table->unsignedBigInteger('best_answer_id')->change();
            // 外部キー設定
            $table->foreign('best_answer_id')
                ->references('id')
                ->on('answers')
                // 参照先のanswers.idが削除更新された時、questions.best_answer_idをnullにする
                ->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->unsignedBigInteger('best_answer_id')->change();
            $table->dropForeign(['best_answer_id']);
        });
    }
}
