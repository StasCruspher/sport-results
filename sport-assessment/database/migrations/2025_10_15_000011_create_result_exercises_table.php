//
//  2025_15_10_000011_create_result_exercise_table.php
//  
//
//  Created by St Life on 15.10.2025.
//

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultExercisesTable extends Migration
{
    public function up()
    {
        Schema::create('result_exercise', function (Blueprint $table) {
            $table->increments('id'); 
            $table->integer('result_id')->unsigned();
            $table->integer('exercise_id')->unsigned();
            $table->decimal('result', 5, 2)->nullable();
            $table->integer('point')->nullable();

            $table->foreign('result_id')->references('id')->on('result');
            $table->foreign('exercise_id')->references('id')->on('exercise');
        });
    }

    public function down()
    {
        Schema::table('result_exercise', function (Blueprint $table) {
            $table->dropForeign(['result_id']);
            $table->dropForeign(['exercise_id']);
        });
        Schema::dropIfExists('result_exercise');
    }
}
