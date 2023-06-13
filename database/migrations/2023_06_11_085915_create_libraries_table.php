<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLibrariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('libraries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->nullable()->comment = '0-Not exist in Group, 1-Exist in Group';
            $table->string('author')->nullable();
            $table->string('original_file_name')->nullable();
            $table->string('generated_file_name')->nullable();
            $table->string('details')->nullable();
            $table->string('status')->nullable()->default(0)->comment = '0-Pending, 1-Approved, 2-Rejected';
            $table->unsignedBigInteger('created_by')->comment = 'users(table)';

           // Defaults
            $table->tinyInteger('is_deleted')->nullable()->default(0)->comment = '0-Active, 1-Deleted';
            $table->timestamps();

            // Foreign key
            $table->foreign('created_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('libraries');
    }
}
