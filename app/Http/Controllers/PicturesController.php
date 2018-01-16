<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Picture;
use App\Artist;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;

class PicturesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchWord = $request->search;

        $pictures = Picture::join('Artists', 'Pictures.artist_id', '=', 'Artists.id')
            ->select('Pictures.*', 'Artists.name AS artist_name')
            ->where('Pictures.code', 'LIKE', "%{$searchWord}%")
            ->orWhere('Pictures.name', 'LIKE', "%{$searchWord}%")
            ->orWhere('Artists.name', 'LIKE', "%{$searchWord}%")
            ->paginate(10);

        return View('Pictures.pictures', ['pictures' => $pictures]);
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


        return View('Pictures.create', ['artists' => $artists]);
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
//           'code' => 'required|unique:Pictures|regex:/CARD*/',
            'name' => 'required|max:255',
            'artist_id' => 'required',
            'width' => 'required|numeric|min:1',
            'height' => 'required|numeric|min:1',
            'thumbnail_location' => 'required|image',
            'stock_count' => 'numeric',
            'sold_count' => 'numeric'
        ]);

        $id = Picture::max('id') + 1;
        $picture = new Picture($request->all());
        $picture->code = $id;


        $destination = 'uploads/Pictures';
        $extension = Input::file('thumbnail_location')->getClientOriginalExtension();
        $filename = "{$picture->code}.{$extension}";
        $picture->thumbnail_location = "{$destination}/{$filename}";
        Input::file('thumbnail_location')->move($destination, $filename);


        $picture->save();

        return redirect('Picture/')->with(['success' => 'Record Stored Successfully']);
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
        $picture = Picture::find($id);

        return View('Pictures.show', ['picture' => $picture]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $picture = Picture::find($id);

        $artist = new Artist;

        $artists = $artist->getArtists();

        return View('Pictures.edit', ['picture' => $picture, 'artists' => $artists]);
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
        $picture = Picture::find($id);
//        dd($picture->id);
        $this->validate($request, [
//            'code' => 'required|unique:Pictures,code,' .$picture->id .'|regex:/CARD*/',
            'name' => 'required|max:255',
            'artist_id' => 'required',
            'width' => 'required|numeric|min:1',
            'height' => 'required|numeric|min:1',
            'thumbnail_location' => 'required|image',
            'stock_count' => 'numeric',
            'sold_count' => 'numeric'
        ]);


        $record = $request->all();

        $destination = 'uploads/Pictures';
        $extension = Input::file('thumbnail_location')->getClientOriginalExtension();
        $filename = "{$record['code']}.{$extension}";
        Input::file('thumbnail_location')->move($destination, $filename);
        $record['thumbnail_location'] = "{$destination}/{$filename}";

        Picture::find($id)
            ->update($record);

        return redirect('Picture/')->with(['success' => 'Record Updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Picture::find($id)
            ->delete();
        return redirect('Picture')->with(['success' => 'Record Deleted Successfully']);
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

        $pictures = Picture::join('Artists', 'Pictures.artist_id', '=', 'Artists.id')
            ->select('Pictures.*', 'Artists.name AS artist_name')
            ->where('Pictures.code', 'LIKE', "%{$searchWord}%")
            ->orWhere('Pictures.name', 'LIKE', "%{$searchWord}%")
            ->orWhere('Artists.name', 'LIKE', "%{$searchWord}%");


        Excel::create("{$request->fileName}", function ($excel) use ($request, $resourceName, $pictures) {
            $excel->sheet('Items', function ($sheet) use ($request, $resourceName, $pictures) {
                $sheet->loadView("{$request->viewName}")
                    ->with(['items' => $pictures, 'resourceName' => $resourceName]);
            });
        })->export('xlsx');
    }

}
