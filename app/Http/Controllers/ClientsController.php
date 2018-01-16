<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Client;
use App\Rank;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchWord = $request->searchWord;

        $clients = Client::join('Ranks', 'Clients.rank_id', '=', 'Ranks.id')
            ->select('Clients.name AS client_name', 'Clients.id as id', 'Ranks.name AS rank_name', 'Clients.address AS client_address')
            ->where('Clients.name', 'LIKE', "%{$searchWord}%")
            ->orWhere('Clients.address', 'LIKE', "%{$searchWord}%")
            ->orWhere('Ranks.name', 'LIKE', "%{$searchWord}%")
            ->paginate(10);

        return View('Clients.clients', ['clients' => $clients]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rank = new Rank;
        $ranks = $rank->ranks();

        return View('Clients.create', ['ranks' => $ranks]);
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
            'name' => 'required',
            'email' => 'email|unique:Clients',
        ]);

        $client = new Client($request->all());
        $client->save();

        return redirect('/Client')->with(['success' => 'Record Stored Successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = Client::join('Ranks', 'Clients.rank_id', '=', 'Ranks.id')
            ->select('Clients.*', 'Ranks.name AS rank_name')
            ->where('Clients.id', $id)
            ->first();


        return View('Clients.show', ['client' => $client]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rank = new Rank;
        $ranks = $rank->ranks();

        $client = Client::find($id);

        return View('Clients.edit', ['client' => $client, 'ranks' => $ranks]);
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
        $this->validate($request, [
            'name' => 'required',
            'email' => "email|unique:Clients,email,{$id}",
        ]);

        Client::find($id)->update($request->all());

        return redirect('/Client')->with(['success' => 'Record Updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
//        dd('hello');

        Client::find($id)->delete();

        return redirect('/Client')->with(['success' => 'Record Deleted Successfully']);
    }
}
