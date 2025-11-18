//
//  2025_15_10_000009_create_score_exercise_table.php
//  
//
//  Created by St Life on 15.10.2025.
//

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScoreExercisesTable extends Migration
{
    public function up()
    {
        Schema::create('score_exercise', function (Blueprint $table) {
            $table->increments('id'); 
            $table->integer('score_id')->unsigned();
            $table->integer('exercise_id')->unsigned();

            $table->foreign('score_id')->references('id')->on('score');
            $table->foreign('exercise_id')->references('id')->on('exercise');
        });
    }

    public function down()
    {
        Schema::table('score_exercise', function (Blueprint $table) {
            $table->dropForeign(['score_id']);
            $table->dropForeign(['exercise_id']);
        });
        Schema::dropIfExists('score_exercise');
    }
}
