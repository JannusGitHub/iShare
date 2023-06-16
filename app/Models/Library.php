<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
class Library extends Model
{
    use HasFactory;

    public function user_info(){
        return $this->hasOne(User::class, 'id', 'created_by');
    }
}
