<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    protected $fillable = ['name', 'birth_date', 'nationality'];

    protected $table = 'Artists';

    protected $dates = ['birth_date'];

    public function getArtists()
    {
        $artistsRecords =  Artist::all(['id', 'name'])->toArray();
        $artists = array();
        foreach($artistsRecords as $record)
        {
            $artists[$record['id']] = $record['name'];
        }
        return $artists;
    }

    public function Books()
    {
        return $this->hasMany('App\Book');
    }

    public function Cards()
    {
        return $this->hasMany('App\Card');
    }

    public function Posters()
    {
        return $this->hasMany('App\Poster');
    }

    public function Pictures()
    {
        return $this->hasMany('App\Banner');
    }
}
