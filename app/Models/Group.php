<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Import Models here
 */
use App\Models\User;
use App\Models\GroupLeader;

class Group extends Model
{
    use HasFactory;

    public function group_creator_info(){
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function group_leader_details(){
        return $this->hasMany(GroupLeader::class, 'group_id', 'id');
    }
}
