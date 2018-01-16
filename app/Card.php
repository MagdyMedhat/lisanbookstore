<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = ['name', 'description', 'width', 'height', 'thumbnail_location',
        'artist_id', 'sold_count', 'stock_count', 'notes'];

    public function Artist()
    {
        return $this->belongsTo('App\Artist');
    }

    public function setCodeAttribute($id)
    {
        $id += 100;
        $code = "1{$id}";
        $this->attributes['code'] = $code;
    }

    public function transactions()
    {
        return $this->morphToMany('App\Transaction', 'transactable');
    }


    protected $table = 'Cards';
}
