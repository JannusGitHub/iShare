<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_levels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_level_name');
            $table->string('user_level_status')->nullable()->default(1)->comment = '0-Not Active, 1-Active';
            $table->timestamps();

            // Defaults
            $table->tinyInteger('is_deleted')->nullable()->default(0)->comment = '0-active, 1-deleted';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_levels');
    }
}
