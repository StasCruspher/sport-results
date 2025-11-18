//
//  2025_15_10_000003_create_category_table.php
//  
//
//  Created by St Life on 15.10.2025.
//

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('category', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('category_number');
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('category');
    }
}
