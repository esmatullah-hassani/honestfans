<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['content','user_1','user_2'];
    
    /**
     * message has belongsto user
     */
    public function user(){
        return $this->belongsTo(User::class,'user_1','id');
    }
}
