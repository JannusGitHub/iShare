<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResetPasswordCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reset_password_codes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('reset_password_code');
            $table->tinyInteger('expired')->default(0)->comment = '0-No, 1-Yes';

           // Defaults
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reset_password_codes');
    }
}
