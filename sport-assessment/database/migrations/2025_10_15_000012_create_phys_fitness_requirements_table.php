<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhysFitnessRequirementsTable extends Migration
{
    public function up()
    {
        Schema::create('phys_fitness_requirement', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('age_group_id');
            $table->unsignedInteger('category_id');
            $table->enum('gender', ['чоловік', 'жінка']);
            $table->integer('exercise_threshold');
            $table->integer('exercise_count');
            $table->integer('total_points');
            $table->integer('result');

            $table->foreign('age_group_id')
                  ->references('id')->on('age_group')
                  ->onDelete('cascade');

            $table->foreign('category_id')
                  ->references('id')->on('category')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('phys_fitness_requirement', function (Blueprint $table) {
            $table->dropForeign(['age_group_id']);
            $table->dropForeign(['category_id']);
        });
        Schema::dropIfExists('phys_fitness_requirement');
    }
}
