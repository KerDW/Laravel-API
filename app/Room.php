<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $guarded = ['id'];
    protected $appends = ['user_count'];

    public function users(){
        return $this->hasMany("App\User");
    }

    public function getUserCountAttribute(){
        return $this->hasMany("App\User")->count();
    }

}
