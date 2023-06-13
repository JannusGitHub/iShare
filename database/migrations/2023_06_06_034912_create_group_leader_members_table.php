<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupLeaderMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_leader_members', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('group_id')->comment = 'groups(table)';
            $table->unsignedBigInteger('group_leader_id')->comment = 'group_leaders(table)';
            $table->unsignedBigInteger('member_name')->comment = 'users(table)';
            $table->string('status')->nullable()->comment = '0-Not exist in Group, 1-Exist in Group';

           // Defaults
            $table->tinyInteger('is_deleted')->nullable()->default(0)->comment = '0-Active, 1-Deleted';
            $table->timestamps();

            // Foreign key
            $table->foreign('group_id')->references('id')->on('groups');
            $table->foreign('group_leader_id')->references('id')->on('group_leaders');
            $table->foreign('member_name')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_leader_members');
    }
}
