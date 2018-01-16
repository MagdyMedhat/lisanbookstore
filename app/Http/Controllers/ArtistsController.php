<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use App\Artist;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ArtistsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchWord = $request->search;

        $artists = Artist::where('Artists.name', 'LIKE', "%{$searchWord}%")
            ->orWhere('Artists.birth_date', 'LIKE', "%{$searchWord}%")
            ->orWhere('Artists.nationality', 'LIKE', "%{$searchWord}%")
            ->paginate(10);


        return View('Artists.artists', ['artists' => $artists]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


        return View('Artists.create');
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
            'name' => 'required|max:255',
        ]);


        $artist = new Artist($request->all());
        $artist->save();

        return redirect('Artist/')->with(['success' => 'Record Stored Successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $artist = Artist::find($id);

        return View("Artists.show", ['artist' => $artist]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $artist = Artist::find($id);

        return View('Artists.edit');
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
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);

        Artist::find($id)
            ->update($request->all());

        return redirect('Artist/')->with(['success' => 'Record Updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Artist::find($id)
            ->delete();

        return redirect('Artist/')->with(['success' => 'Record Deleted Successfully']);
    }

}
