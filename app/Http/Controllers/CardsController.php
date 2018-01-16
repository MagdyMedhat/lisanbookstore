<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Card;
use App\Artist;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;

class CardsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchWord = $request->search;

        $cards =  Card::join('Artists', 'Cards.artist_id', '=', 'Artists.id')
            ->select('Cards.*', 'Artists.name AS artist_name')
            ->where('Cards.code', 'LIKE', "%{$searchWord}%")
            ->orWhere('Cards.name', 'LIKE', "%{$searchWord}%")
            ->orWhere('Artists.name', 'LIKE', "%{$searchWord}%")
            ->paginate(10);

        return View('Cards.cards', ['cards' => $cards]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $artist = new Artist;
        $artists = $artist->getArtists();


        return View('Cards.create', ['artists' => $artists]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
//           'code' => 'required|unique:Cards|regex:/CARD*/',
            'name' => 'required|max:255',
            'artist_id' => 'required',
            'width' => 'required|numeric|min:1',
            'height' => 'required|numeric|min:1',
            'thumbnail_location' => 'required|image',
            'stock_count' => 'numeric',
            'sold_count' => 'numeric'
        ]);

        $id = Card::max('id') + 1;
        $card = new Card($request->all());
        $card->code = $id;


        $destination = 'uploads/Cards';
        $extension = Input::file('thumbnail_location')->getClientOriginalExtension();
        $filename = "{$card->code}.{$extension}";
        $card->thumbnail_location = "{$destination}/{$filename}";
        Input::file('thumbnail_location')->move($destination, $filename);


        $card->save();

        return redirect('Card/')->with(['success' => 'Record Stored Successfully']);
//        dd($request->image);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $card = Card::find($id);

        return View('Cards.show', ['card' => $card]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $card = Card::find($id);

        $artist = new Artist;

        $artists = $artist->getArtists();

        return View('Cards.edit', ['card' => $card, 'artists' =>$artists]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $card = Card::find($id);
//        dd($card->id);
        $this->validate($request, [
//            'code' => 'required|unique:Cards,code,' .$card->id .'|regex:/CARD*/',
            'name' => 'required|max:255',
            'artist_id' => 'required',
            'width' => 'required|numeric|min:1',
            'height' => 'required|numeric|min:1',
            'thumbnail_location' => 'required|image',
            'stock_count' => 'numeric',
            'sold_count' => 'numeric'
        ]);


        $record = $request->all();

        $destination = 'uploads/Cards';
        $extension = Input::file('thumbnail_location')->getClientOriginalExtension();
        $filename = "{$record['code']}.{$extension}";
        Input::file('thumbnail_location')->move($destination, $filename);
        $record['thumbnail_location'] = "{$destination}/{$filename}";

        Card::find($id)
            ->update($record);

        return redirect('Card/')->with(['success' => 'Record Updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
            Card::find($id)
                ->delete();
        return redirect('Card')->with(['success' => 'Record Deleted Successfully']);
    }

    /**
     * Exports the records table to excel sheet
     *
     * @param Request $request
     */
    public function exportToExcel(Request $request)
    {
        $searchWord = $request->searchWord;

        $resourceName = $request->resourceName;

        $cards = Card::join('Artists', 'Cards.artist_id', '=', 'Artists.id')
            ->select('Cards.*', 'Artists.name AS artist_name')
            ->where('Cards.code', 'LIKE', "%{$searchWord}%")
            ->orWhere('Cards.name', 'LIKE', "%{$searchWord}%")
            ->orWhere('Artists.name', 'LIKE', "%{$searchWord}%");

//        dd($cards->get());


        Excel::create("{$request->fileName}", function ($excel) use ($request, $resourceName, $cards) {
            $excel->sheet('Items', function ($sheet) use ($request, $resourceName, $cards) {
                $sheet->loadView("{$request->viewName}")
                    ->with(['items' => $cards, 'resourceName' => $resourceName]);
            });
        })->export('xlsx');
    }


}
