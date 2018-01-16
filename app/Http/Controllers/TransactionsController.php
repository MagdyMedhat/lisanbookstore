<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Transaction;
use App\Client;
use App\Category;
use Illuminate\Support\Facades\DB;

class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchWord = $request->search;

        $transactions = Transaction::join('Clients', 'Transactions.client_id', '=', 'Clients.id')
                                    ->join('Categories', 'Transactions.category_id', '=', 'Categories.id')
                                    ->select('Transactions.*', 'Clients.name AS client_name', 'Categories.name AS category_name')
                                    ->where('Transactions.created_at', 'LIKE', "%{$searchWord}%")
                                    ->orWhere('Clients.name', 'LIKE', "%{$searchWord}%")
                                    ->orWhere('Categories.name', 'LIKE', "%{$searchWord}%")
                                    ->paginate(10);

        return View('Transactions.transactions', ['transactions' => $transactions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = new Category();
        $categories = $category->categories();

        $client = new Client();
        $clients = $client->clients();


        return View('Transactions.create', ['clients' => $clients, 'categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request->category_id);

        $transaction = Transaction::create(['client_id' => $request->client_id, 'category_id' => $request->category_id]);
        $transaction_id = $transaction->id;

        $resources =  json_decode($request->resources);
//        dd($request);
        foreach($resources as $resource)
        {
            DB::table('transactables')->insert([
                'transaction_id' => $transaction_id,
                'transactable_id' => $resource->id,
                'transactable_type' => $transaction->getTypeFromCode($resource->code),
                'quantity' => $resource->qtty
            ]);
            $resourceModel = $transaction->getResourceFromCode($resource->code, $resource->id);
            $resourceModel->stock_count -= $resource->qtty;
            $resourceModel->sold_count += $resource->qtty;
            $resourceModel->save();
        }

//        //return;
////        return response()->json("hello");
       return redirect('Transaction/')->with(['success', 'Transaction Stored Successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transaction = Transaction::join('Clients', 'Transactions.client_id', '=', 'Clients.id')
            ->join('Categories', 'Transactions.category_id', '=', 'Categories.id')
            ->select('Transactions.*', 'Clients.name AS client_name', 'Categories.name AS category_name')
            ->where('Transactions.id', $id)
            ->first();

        $resources = $this->getTransactionResources($id);
//        dd($resources);
        return View('Transactions.show', ['transaction' => $transaction, 'resources' => $resources]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $category = new Category();
        $categories = $category->categories();

        $client = new Client();
        $clients = $client->clients();

        $transaction = Transaction::find($id);

//        $data = ['resources' => serialize($resources), 'transaction' => $transaction];
        return View('Transactions.edit', ['transaction' => $transaction, 'clients' => $clients, 'categories' => $categories]);
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
//        dd(Transaction::find($id));
        Transaction::find($id)->delete();
//        $this->store($request);
        $transaction = Transaction::create(['client_id' => $request->client_id, 'category_id' => $request->category_id]);
        $transaction_id = $transaction->id;

        $resources =  json_decode($request->resources);
//dd($resources);
        foreach($resources as $resource)
        {
            DB::table('transactables')->insert([
                'transaction_id' => $transaction_id,
                'transactable_id' => $resource->id,
                'transactable_type' => $transaction->getTypeFromCode($resource->code),
                'quantity' => $resource->qtty
            ]);
            $resourceModel = $transaction->getResourceFromCode($resource->code, $resource->id);
            $resourceModel->stock_count -= $resource->qtty;
            $resourceModel->sold_count += $resource->qtty;
            $resourceModel->save();
        }

        return redirect ('Transaction/')->with(['success' => 'Record Updated Successfull']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Transaction::find($id)->delete();

        return redirect('Transaction/')->with(['success' => 'Record Deleted Successfully']);
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

        return $resources;
    }


}
