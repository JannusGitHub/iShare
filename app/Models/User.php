<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Import Models here
 */
use App\Models\UserLevel;
use App\Models\Section;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public function user_level_info(){
        return $this->hasOne(UserLevel::class, 'id', 'user_level_id');
    }

    public function section_info(){
        return $this->hasOne(Section::class, 'id', 'section_id');
    }
}
