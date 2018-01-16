<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Writer;
use App\Artist;

class Book extends Model
{
    protected $fillable = [
        'name', 'description', 'page_count', 'published_date',
        'writer_id', 'artist_id', 'stock_count', 'sold_count', 'notes'
    ];

    protected $dates = [
      'published_date'
    ];

    public function setCodeAttribute($id)
    {
        $id += 100;
        $code = "0{$id}";
        $this->attributes['code'] = $code;
    }

    public function Writer()
    {
        return $this->belongsTo('App\Writer');
    }

    public function Artist()
    {
        return $this->belongsTo('App\Artist');
    }

    public function transactions()
    {
        return $this->morphToMany('App\Transaction', 'transactable');
    }

    protected $table = 'Books';
}
