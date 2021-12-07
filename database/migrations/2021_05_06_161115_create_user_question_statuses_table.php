<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserQuestionStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_question_statuses', function (Blueprint $table) {
            $table->id('question_id');
            $table->integer('user_id');
            $table->integer('ques_id');
            $table->integer('select_ans');
            $table->integer('corrected_ans');
            $table->integer('question_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_question_statuses');
    }
}
