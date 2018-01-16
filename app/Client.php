<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'name', 'address', 'email', 'rank_id', 'telephone'
    ];

    protected $table = 'Clients';

    public function rank()
    {
        return $this->belongsTo('App\Rank');
    }

    public function clients()
    {
        return Client::lists('name', 'id');
    }
}
