<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * Import Models here
 */
use App\Models\User;

class GroupLeaderMember extends Model
{
    use HasFactory;
    public function member_name_info(){
        return $this->hasOne(User::class, 'id', 'member_name');
    }
}
