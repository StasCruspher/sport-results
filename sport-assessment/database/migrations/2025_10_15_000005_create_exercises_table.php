//
//  2025_15_10_000005_create_exercise_table.php
//  
//
//  Created by St Life on 15.10.2025.
//

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExercisesTable extends Migration
{
    public function up()
    {
        Schema::create('exercise', function (Blueprint $table) {
            $table->increments('id');
            $table->string('exercise_name', 6);
            $table->text('exercise_desc');
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('exercise');
    }
}
