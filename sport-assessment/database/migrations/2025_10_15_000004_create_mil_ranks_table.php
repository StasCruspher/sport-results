//
//  2025_15_10_000004_create_mil_rank_table.php
//  
//
//  Created by St Life on 15.10.2025.
//

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMilRanksTable extends Migration
{
    public function up()
    {
        Schema::create('mil_rank', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 250);
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mil_rank');
    }
}
