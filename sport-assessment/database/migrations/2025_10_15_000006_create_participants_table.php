//
//  2025_15_10_000006_create_participants_table.php
//  
//
//  Created by St Life on 15.10.2025.
//

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParticipantsTable extends Migration
{
    public function up()
    {
        Schema::create('participant', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fullname', 200);
            $table->integer('mil_rank_id')->unsigned();
            $table->enum('gender', ['чоловік', 'жінка']);
            $table->integer('badge_number')->nullable();
            $table->integer('category_id')->unsigned();
            $table->integer('age_group_id')->unsigned();
            $table->integer('unit_id')->unsigned();
            $table->softDeletes();

            $table->foreign('unit_id')->references('id')->on('unit');
            $table->foreign('category_id')->references('id')->on('category');
            $table->foreign('age_group_id')->references('id')->on('age_group');
            $table->foreign('mil_rank_id')->references('id')->on('mil_rank');
        });
    }

    public function down()
    {
        Schema::table('participant', function (Blueprint $table) {
            $table->dropForeign(['unit_id']);
            $table->dropForeign(['category_id']);
            $table->dropForeign(['age_group_id']);
            $table->dropForeign(['mil_rank_id']);
        });
        Schema::dropIfExists('participant');
    }
}
