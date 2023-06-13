<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Import Models here
 */
use App\Models\User;
use App\Models\Group;
class GroupLeader extends Model
{
    use HasFactory;

    public function group_leader_name_info(){
        return $this->hasOne(User::class, 'id', 'group_leader_name');
    }

    public function group_info(){
        return $this->hasOne(Group::class, 'id', 'group_id');
    }
}
