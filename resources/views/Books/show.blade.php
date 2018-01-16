@extends('layouts.app')


@section('content')
    <div class="container">
<div class="row well">
    <div class="col-md-6">
            <label>Code</label>
            <p>{{$book->code}}</p>
    </div>
    <div class="col-md-6">
            <label>Title</label>
            <p>{{$book->name}}</p>
    </div>
    <div class="col-md-6">
            <label>Description</label>
            <p>{{$book->description}}</p>
    </div>
    <div class="col-md-6">
            <label>Number of Pages</label>
            <p>{{$book->page_count}}</p>
    </div>
    <div class="col-md-6">
            <label>Published on</label>
            <p>{{$book->published_date}}</p>
    </div>
    <div class="col-md-6">
            <label>Artist</label>
            <p>{{$book->artist_name}}</p>
    </div>
    <div class="col-md-6">
            <label>Writer</label>
            <p>{{$book->writer_name}}</p>
    </div>
    <div class="col-md-6">
            <label>Sales</label>
            <p>{{$book->sold_count}}</p>
    </div>
    <div class="col-md-6">
            <label>Quantity in Stock</label>
            <p>{{$book->stock_count}}</p>
    </div>
</div>
</div>
    <hr/>

    <style>
        .col-md-6{
            font-size: 20px;
        }
    </style>

@endsection