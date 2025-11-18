//
//  2025_15-10_000002_create_age_groups_table.php
//  
//
//  Created by St Life on 15.10.2025.
//

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgeGroupsTable extends Migration
{
    public function up()
    {
        Schema::create('age_group', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('age_group_number');
            $table->enum('gender', ['чоловік', 'жінка']);
            $table->text('description');
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('age_group');
    }
}
