<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coin extends Model
{
    public $fillable = ['amount','user_id'];

    /**
     * The coin that has one user
     */
    public function user(){
        return $this->hasOne(User::class);
    }
}
