<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use App\Book;
use App\Writer;
use App\Artist;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchWord = $request->search;

        $books =  Book::join('Writers', 'Books.writer_id', '=', 'Writers.id')
                    ->join('Artists', 'Books.artist_id', '=', 'Artists.id')
                    ->select('Books.*', 'Writers.name AS writer_name', 'Artists.name AS artist_name')
                    ->where('Books.code', 'LIKE', "%{$searchWord}%")
                    ->orWhere('Books.name', 'LIKE', "%{$searchWord}%")
                    ->orWhere('Artists.name', 'LIKE', "%{$searchWord}%")
                    ->orWhere('Writers.name', 'LIKE', "%{$searchWord}%")
            ->paginate(10);


        return View('Books.books', ['books' => $books]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $artist = new Artist;
        $writer = new Writer;

        $artists = $artist->getArtists();
        $writers = $writer->getWriters();



//        dd($artists);



        return View('Books.create',['writers' => $writers, 'artists' => $artists]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
//            'code' => 'required|unique:Books|regex:/BOOK*/',
            'name' => 'required|max:255',
            'page_count' => 'required|numeric',
            'writer_id' => 'required',
            'artist_id' => 'required',
            'published_date' => 'required',
            'sold_count' => 'numeric',
            'stock_count' => 'numeric'
        ]);

        $id = Book::max('id');

        $book = new Book($request->all());
        $book->code = $id;

        $book->save();

        return redirect('Book/')->with(['success' => 'Record Stored Successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = DB::table('Books')
            ->join('Writers', 'Books.writer_id', '=', 'Writers.id')
            ->join('Artists', 'Books.artist_id', '=', 'Artists.id')
            ->select('Books.*', 'Writers.name AS writer_name', 'Artists.name AS artist_name')
            ->where('Books.id', $id)->first();


        return View("Books.show", ['book' => $book]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $book = Book::find($id);

        $artist = new Artist;
        $writer = new Writer;

        $artists = $artist->getArtists();
        $writers = $writer->getWriters();

        return View('Books.edit', ['book' => $book, 'artists' =>$artists, 'writers' => $writers]);
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
        $this->validate($request,[
//            'code' => 'required|unique:Books|regex:/BOOK*/',
            'name' => 'required|max:255',
            'page_count' => 'required|numeric',
            'writer_id' => 'required',
            'artist_id' => 'required',
            'published_date' => 'required',
            'sold_count' => 'numeric',
            'stock_count' => 'numeric'
        ]);

        Book::find($id)
            ->update($request->all());

        return redirect('Book/')->with(['success' => 'Record Updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Book::find($id)
            ->delete();

        return redirect('Book/')->with(['success' => 'Record Deleted Successfully']);
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

        $books = Book::join('Writers', 'Books.writer_id', '=', 'Writers.id')
            ->join('Artists', 'Books.artist_id', '=', 'Artists.id')
            ->select('Books.*', 'Writers.name AS writer_name', 'Artists.name AS artist_name')
            ->where('Books.code', 'LIKE', "%{$searchWord}%")
            ->orWhere('Books.name', 'LIKE', "%{$searchWord}%")
            ->orWhere('Artists.name', 'LIKE', "%{$searchWord}%")
            ->orWhere('Writers.name', 'LIKE', "%{$searchWord}%")
            ->get();


        Excel::create("{$request->fileName}", function ($excel) use ($request, $books) {
            $excel->sheet('Items', function ($sheet) use ($request, $books) {
                $sheet->loadView("{$request->viewName}")
                    ->with(['books' => $books]);
            });
        })->export('xlsx');
    }

}
