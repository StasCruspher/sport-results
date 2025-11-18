//
//  2025_15_10_000010_create_result_table.php
//  
//
//  Created by St Life on 15.10.2025.
//

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultsTable extends Migration
{
    public function up()
    {
        Schema::create('result', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('score_id')->unsigned();
            $table->integer('participant_id')->unsigned();
            $table->integer('point_sum')->nullable();
            $table->integer('phys_fitness_point')->nullable();

            $table->foreign('score_id')->references('id')->on('score');
            $table->foreign('participant_id')->references('id')->on('participant');
        });
    }

    public function down()
    {
        Schema::table('result', function (Blueprint $table) {
            $table->dropForeign(['score_id']);
            $table->dropForeign(['participant_id']);
        });
        Schema::dropIfExists('result');
    }
}
