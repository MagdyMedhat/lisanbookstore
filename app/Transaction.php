<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Book;
use App\Card;
use App\Picture;
use App\Poster;
use App\Mug;
use Illuminate\Support\Facades\DB;

class Transaction extends Model
{
    protected $fillable = [
        'category_id', 'client_id'
    ];

    protected $table = 'Transactions';

    function delete()
    {
        $transactable = DB::table('transactables')->where('transaction_id', $this->id)->first();
//        dd($transactable);
        $resource = $this->getResourceFromIDType($transactable->transactable_id, $transactable->transactable_type);
        $resource->stock_count += $transactable->quantity;
        $resource->sold_count -= $transactable->quantity;
        $resource->save();
        DB::table('transactables')->where('transaction_id', $this->id)->delete();


        parent::delete();
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    public function books()
    {
        return $this->morphedByMany('App\Book', 'transactable');
    }

    public function cards()
    {
        return $this->morphedByMany('App\Card', 'transactable');

    }

    public function posters()
    {
        return $this->morphedByMany('App\Poster', 'transactable');

    }

    public function pictures()
    {
        return $this->morphedByMany('App\Picture', 'transactable');

    }

    public function mugs()
    {
        return $this->morphedByMany('Mug\Card', 'transactable');

    }

    public function getTypeFromCode($code)
    {
        $typeDigit = $code[0];

        switch ($typeDigit)
        {
            case  '0' :
                return 'App\Book';
            case '1' :
                return 'App\Card';
            case '2' :
                return 'App\Picture';
            case '3' :
                return 'App\Poster';
            case '4' :
                return 'App\Mug';
        }
    }

    public function getResourceFromCode($code, $id)
    {
        $typeDigit = $code[0];

        switch ($typeDigit)
        {
            case  '0' :
            {
                return Book::find($id);
            }
            case  '1' :
            {
                return Card::find($id);
            }
            case  '2' :
            {
                return Picture::find($id);
            }
            case  '3' :
            {
                return Poster::find($id);
            }
            case  '4' :
            {
                return Mug::find($id);
            }
        }
    }

    public function getResourceFromIDType($id, $type)
    {
        switch ($type)
        {
            case 'App\Book':
                return Book::find($id);
            case 'App\Card':
                return Card::find($id);
            case 'App\Picture':
                return Picture::find($id);
            case 'App\Poster':
                return Poster::find($id);
            case 'App\Mug':
                return Mug::find($id);
        }
    }
}
