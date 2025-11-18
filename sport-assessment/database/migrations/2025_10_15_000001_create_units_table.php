//
//  2025_15-10_create_units_table.php
//  
//
//  Created by St Life on 15.10.2025.
//

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitsTable extends Migration
{
    public function up()
    {
        Schema::create('unit', function (Blueprint $table) {
            $table->increments('id');
            $table->string('unit_name', 200);
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('unit');
    }
}
