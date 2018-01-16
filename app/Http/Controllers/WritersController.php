<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use App\Writer;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class WritersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchWord = $request->search;

        $writers = Writer::where('Writers.name', 'LIKE', "%{$searchWord}%")
            ->orWhere('Writers.birth_date', 'LIKE', "%{$searchWord}%")
            ->orWhere('Writers.nationality', 'LIKE', "%{$searchWord}%")
            ->paginate(10);


        return View('Writers.writers', ['writers' => $writers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


        return View('Writers.create');
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


        $writer = new Writer($request->all());
        $writer->save();

        return redirect('Writer/')->with(['success' => 'Record Stored Successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $writer = Writer::find($id);

        return View("Writers.show", ['writer' => $writer]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $writer = Writer::find($id);

        return View('Writers.edit');
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

        Writer::find($id)
            ->update($request->all());

        return redirect('Writer/')->with(['success' => 'Record Updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Writer::find($id)
            ->delete();

        return redirect('Writer/')->with(['success' => 'Record Deleted Successfully']);
    }

}
