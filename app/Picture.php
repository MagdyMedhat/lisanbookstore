<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    protected $fillable = ['name', 'description', 'width', 'height', 'thumbnail_location',
        'artist_id', 'sold_count', 'stock_count', 'notes'];

    public function setCodeAttribute($id)
    {
        $id += 100;
        $code = "2{$id}";
        $this->attributes['code'] = $code;
    }

    public function Artist()
    {
        return $this->belongsTo('App\Artist');
    }

    public function transactions()
    {
        return $this->morphToMany('App\Transaction', 'transactable');
    }


    protected $table = 'Pictures';
}
