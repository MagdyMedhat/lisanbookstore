<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rank extends Model
{
    protected $table = 'Ranks';

    public function clients()
    {
        return $this->hasMany('App\Client');
    }

    public function ranks()
    {
        return Rank::lists('name', 'id');
    }
}
