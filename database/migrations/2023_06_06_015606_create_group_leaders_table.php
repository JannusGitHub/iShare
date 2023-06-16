<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupLeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_leaders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('group_id')->comment = 'groups(table)';
            $table->unsignedBigInteger('group_leader_name')->nullable()->comment = 'users(table)';
            $table->integer('group_number')->nullable();
            $table->unsignedBigInteger('group_section')->nullable()->comment = 'sections(table)';
            $table->string('status')->nullable()->default(1)->comment = '0-Not Active, 1-Active';

           // Defaults
            $table->tinyInteger('is_deleted')->nullable()->default(0)->comment = '0-Active, 1-Deleted';
            $table->timestamps();

            // Foreign key
            $table->foreign('group_id')->references('id')->on('groups');
            $table->foreign('group_leader_name')->references('id')->on('users');
            $table->foreign('group_section')->references('id')->on('sections');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_leaders');
    }
}
