<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $table = 'Categories';

    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }

    public function categories()
    {
        return Category::lists('name', 'id');
    }
}
