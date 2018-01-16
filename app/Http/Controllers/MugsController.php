<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Mug;
use App\Artist;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;

class MugsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchWord = $request->search;

        $mugs = Mug::join('Artists', 'Mugs.artist_id', '=', 'Artists.id')
            ->select('Mugs.*', 'Artists.name AS artist_name')
            ->where('Mugs.code', 'LIKE', "%{$searchWord}%")
            ->orWhere('Mugs.name', 'LIKE', "%{$searchWord}%")
            ->orWhere('Artists.name', 'LIKE', "%{$searchWord}%")
            ->paginate(10);

        return View('Mugs.mugs', ['mugs' => $mugs]);
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


        return View('Mugs.create', ['artists' => $artists]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
//           'code' => 'required|unique:Mugs|regex:/CARD*/',
            'name' => 'required|max:255',
            'artist_id' => 'required',
            'width' => 'required|numeric|min:1',
            'height' => 'required|numeric|min:1',
            'thumbnail_location' => 'required|image'
        ]);

        $id = Mug::max('id') + 1;
        $mug = new Mug($request->all());
        $mug->code = $id;


        $destination = 'uploads/Mugs';
        $extension = Input::file('thumbnail_location')->getClientOriginalExtension();
        $filename = "{$mug->code}.{$extension}";
        $mug->thumbnail_location = "{$destination}/{$filename}";
        Input::file('thumbnail_location')->move($destination, $filename);


        $mug->save();

        return redirect('Mug/')->with(['success' => 'Record Stored Successfully']);
//        dd($request->image);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mug = Mug::find($id);

        return View('Mugs.show', ['mug' => $mug]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $mug = Mug::find($id);

        $artist = new Artist;

        $artists = $artist->getArtists();

        return View('Mugs.edit', ['mug' => $mug, 'artists' => $artists]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $mug = Mug::find($id);
//        dd($mug->id);
        $this->validate($request, [
//            'code' => 'required|unique:Mugs,code,' .$mug->id .'|regex:/CARD*/',
            'name' => 'required|max:255',
            'artist_id' => 'required',
            'width' => 'required|numeric|min:1',
            'height' => 'required|numeric|min:1',
            'thumbnail_location' => 'required|image'
        ]);


        $record = $request->all();

        $destination = 'uploads/Mugs';
        $extension = Input::file('thumbnail_location')->getClientOriginalExtension();
        $filename = "{$record['code']}.{$extension}";
        Input::file('thumbnail_location')->move($destination, $filename);
        $record['thumbnail_location'] = "{$destination}/{$filename}";

        Mug::find($id)
            ->update($record);

        return redirect('Mug/')->with(['success' => 'Record Updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Mug::find($id)
            ->delete();
        return redirect('Mug')->with(['success' => 'Record Deleted Successfully']);
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

        $mugs = Mug::join('Artists', 'Mugs.artist_id', '=', 'Artists.id')
            ->select('Mugs.*', 'Artists.name AS artist_name')
            ->where('Mugs.code', 'LIKE', "%{$searchWord}%")
            ->orWhere('Mugs.name', 'LIKE', "%{$searchWord}%")
            ->orWhere('Artists.name', 'LIKE', "%{$searchWord}%");

//        dd($mugs->get());


        Excel::create("{$request->fileName}", function ($excel) use ($request, $resourceName, $mugs) {
            $excel->sheet('Items', function ($sheet) use ($request, $resourceName, $mugs) {
                $sheet->loadView("{$request->viewName}")
                    ->with(['items' => $mugs, 'resourceName' => $resourceName]);
            });
        })->export('xlsx');
    }

}
