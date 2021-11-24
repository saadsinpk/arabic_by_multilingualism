<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessionPlusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lession_pluses', function (Blueprint $table) {
            $table->id('lesson_id');
            $table->text('lesson_title');
            $table->text('lesson_sub_title');
            $table->text('lesson_json_data');
            $table->integer('lesson_unit');
            $table->integer('lesson_level');
            $table->text('lesson_content');
            $table->text('lesson_audio');
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
        Schema::dropIfExists('lession_pluses');
    }
}
