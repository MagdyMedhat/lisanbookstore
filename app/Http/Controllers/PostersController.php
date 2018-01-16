<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Poster;
use App\Artist;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;

class PostersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchWord = $request->search;

        $posters = Poster::join('Artists', 'Posters.artist_id', '=', 'Artists.id')
            ->select('Posters.*', 'Artists.name AS artist_name')
            ->where('Posters.code', 'LIKE', "%{$searchWord}%")
            ->orWhere('Posters.name', 'LIKE', "%{$searchWord}%")
            ->orWhere('Artists.name', 'LIKE', "%{$searchWord}%")
            ->paginate(10);

        return View('Posters.posters', ['posters' => $posters]);
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


        return View('Posters.create', ['artists' => $artists]);
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
//           'code' => 'required|unique:Posters|regex:/CARD*/',
            'name' => 'required|max:255',
            'artist_id' => 'required',
            'width' => 'required|numeric|min:1',
            'height' => 'required|numeric|min:1',
            'thumbnail_location' => 'required|image',
            'stock_count' => 'numeric',
            'sold_count' => 'numeric'
        ]);

        $id = Poster::max('id') + 1;
        $poster = new Poster($request->all());
        $poster->code = $id;


        $destination = 'uploads/Posters';
        $extension = Input::file('thumbnail_location')->getClientOriginalExtension();
        $filename = "{$poster->code}.{$extension}";
        $poster->thumbnail_location = "{$destination}/{$filename}";
        Input::file('thumbnail_location')->move($destination, $filename);


        $poster->save();

        return redirect('Poster/')->with(['success' => 'Record Stored Successfully']);
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
        $poster = Poster::find($id);

        return View('Posters.show', ['poster' => $poster]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $poster = Poster::find($id);

        $artist = new Artist;

        $artists = $artist->getArtists();

        return View('Posters.edit', ['poster' => $poster, 'artists' => $artists]);
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
        $poster = Poster::find($id);
//        dd($poster->id);
        $this->validate($request, [
//            'code' => 'required|unique:Posters,code,' .$poster->id .'|regex:/CARD*/',
            'name' => 'required|max:255',
            'artist_id' => 'required',
            'width' => 'required|numeric|min:1',
            'height' => 'required|numeric|min:1',
            'thumbnail_location' => 'required|image',
            'stock_count' => 'numeric',
            'sold_count' => 'numeric'
        ]);


        $record = $request->all();

        $destination = 'uploads/Posters';
        $extension = Input::file('thumbnail_location')->getClientOriginalExtension();
        $filename = "{$record['code']}.{$extension}";
        Input::file('thumbnail_location')->move($destination, $filename);
        $record['thumbnail_location'] = "{$destination}/{$filename}";

        Poster::find($id)
            ->update($record);

        return redirect('Poster/')->with(['success' => 'Record Updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Poster::find($id)
            ->delete();
        return redirect('Poster')->with(['success' => 'Record Deleted Successfully']);
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

        $posters = Poster::join('Artists', 'Posters.artist_id', '=', 'Artists.id')
            ->select('Posters.*', 'Artists.name AS artist_name')
            ->where('Posters.code', 'LIKE', "%{$searchWord}%")
            ->orWhere('Posters.name', 'LIKE', "%{$searchWord}%")
            ->orWhere('Artists.name', 'LIKE', "%{$searchWord}%");

//        dd($posters->get());


        Excel::create("{$request->fileName}", function ($excel) use ($request, $resourceName, $posters) {
            $excel->sheet('Items', function ($sheet) use ($request, $resourceName, $posters) {
                $sheet->loadView("{$request->viewName}")
                    ->with(['items' => $posters, 'resourceName' => $resourceName]);
            });
        })->export('xlsx');
    }
}
