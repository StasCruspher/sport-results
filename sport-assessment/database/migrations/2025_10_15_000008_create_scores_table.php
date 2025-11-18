//
//  2025_15_10_000007_create_scores_table.php
//  
//
//  Created by St Life on 15.10.2025.
//

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScoresTable extends Migration
{
    public function up()
    {
        Schema::create('score', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('unit_id')->unsigned();
            $table->integer('exercise_count');
            $table->date('date');
            $table->softDeletes();

            $table->foreign('unit_id')->references('id')->on('unit');
        });
    }

    public function down()
    {
        Schema::table('score', function (Blueprint $table) {
            $table->dropForeign(['unit_id']);
        });
        Schema::dropIfExists('score');
    }
}
