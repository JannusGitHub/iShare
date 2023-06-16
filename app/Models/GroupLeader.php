<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Import Models here
 */
use App\Models\User;
use App\Models\Group;
use App\Models\GroupLeaderTitle;
use App\Models\GroupLeaderMember;
use App\Models\Section;
class GroupLeader extends Model
{
    use HasFactory;

    public function group_leader_name_info(){
        return $this->hasOne(User::class, 'id', 'group_leader_name');
    }

    public function group_info(){
        return $this->hasOne(Group::class, 'id', 'group_id');
    }
    
    public function section_info(){
        return $this->hasOne(Section::class, 'id', 'group_section');
    }

    public function group_leader_title_details(){
        return $this->hasMany(GroupLeaderTitle::class, 'group_leader_id', 'id');
    }

    public function group_leader_members_details(){
        return $this->hasMany(GroupLeaderMember::class, 'group_leader_id', 'id');
    }
}
