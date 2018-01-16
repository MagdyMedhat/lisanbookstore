<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Writer extends Model
{
    protected $fillable = [
        'name', 'birth_date', 'nationality'
    ];

    protected $dates = ['birth_date'];

    public function getWriters()
    {
        $writersRecords = Writer::all(['id', 'name'])->toArray();
        $writers = array();

        foreach($writersRecords as $record)
        {
            $writers[$record['id']] = $record['name'];
        }

        return $writers;
    }

    public function Books()
    {
        return $this->hasMany('App\Book');
    }

    protected $table = 'Writers';
}
