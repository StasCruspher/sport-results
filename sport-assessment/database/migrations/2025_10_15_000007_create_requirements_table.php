<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequirementsTable extends Migration
{
    public function up()
    {
        Schema::create('requirement', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('exercise_id');
            $table->decimal('result', 7, 2);
            $table->integer('point');
            $table->enum('gender', ['чоловік', 'жінка']);

            $table->foreign('exercise_id')
                  ->references('id')->on('exercise')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('requirement', function (Blueprint $table) {
            $table->dropForeign(['exercise_id']);
        });
        Schema::dropIfExists('requirement');
    }
}
