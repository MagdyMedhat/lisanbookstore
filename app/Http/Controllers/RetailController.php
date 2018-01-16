<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Book;
use App\Card;
use App\Picture;
use App\Mug;
use App\Poster;
use App\Transaction;
use Illuminate\Support\Facades\DB;

class RetailController extends Controller
{
    public function getResource(Request $request)
    {

        $code = $request->code;
        $resourceType = $code[0];



        switch($resourceType)
        {
            case '0':
            {
                $book = Book::where('code', $code)->first();
                return response()->json(['resource' => $book]);
            }
            case '1':
            {
                $card = Card::where('code', $code)->first();
                return response()->json(['resource' => $card]);
            }
            case '2':
            {
                $picture = Picture::where('code', $code)->first();
                return response()->json(['resource' => $picture]);
            }
            case '3':
            {
                $poster = Poster::where('code', $code)->first();
                return response()->json(['resource' => $poster]);
            }
            case '4':
            {
                $mug = Mug::where('code', $code)->first();
                return response()->json(['resource' => $mug]);
            }
        }

//        return response()->json(['code' => $code]);

    }


    public function getTransactionResources($id)
    {
        $transaction = new Transaction();

        $transactables = DB::table('transactables')->where('transaction_id', $id)->get();
        $resources = [];
        foreach($transactables as $transactable)
        {
            $resource = $transaction->getResourceFromIDType($transactable->transactable_id, $transactable->transactable_type);

            $item = ['qtty' => $transactable->quantity,
                'code' => $resource->code,
                'id' => $transactable->transactable_id,
                'stock_count' => ($resource->stock_count + $transactable->quantity),
                'name' => $resource->name];

            array_push($resources, $item);
        }

        return response()->json($resources);
    }



}
