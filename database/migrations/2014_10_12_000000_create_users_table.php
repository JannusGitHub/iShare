<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            $table->string('email')->unique();
            $table->string('tupt_id_number')->comment = 'Username';
            $table->string('password');
            $table->string('status')->nullable()->default(1)->comment = '0-Not Active, 1-Active';
            $table->tinyInteger('is_password_changed')->nullable()->default(0)->comment = '0-No, 1-Yes';
            $table->unsignedBigInteger('user_level_id')->comment = '1-Admin, 2-Faculty, 3-Student';
            $table->unsignedBigInteger('section_id')->nullable();

           // Defaults
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('last_updated_by')->nullable();
            $table->tinyInteger('is_deleted')->nullable()->default(0)->comment = '0-Active, 1-Deleted';
            $table->timestamps();

            // Foreign key
            $table->foreign('user_level_id')->references('id')->on('user_levels');
            $table->foreign('section_id')->references('id')->on('sections');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
