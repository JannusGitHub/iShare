<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Import Models here
 */
use App\Models\User;
use App\Models\Group;
use App\Models\GroupLeader;
use App\Models\Section;

class GroupLeaderTitle extends Model
{
    use HasFactory;

    public function group_info(){
        return $this->hasOne(Group::class, 'id', 'group_id');
    }

    public function group_leader_info(){
        return $this->hasOne(GroupLeader::class, 'id', 'group_leader_id');
    }
}
