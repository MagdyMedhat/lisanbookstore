@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="row well">
            <div class="col-md-6">
                <label>Name</label>

                <p>{{$client->name}}</p>
            </div>
            <div class="col-md-6">
                <label>Telephone</label>

                <p>{{$client->telephone}}</p>
            </div>
            <div class="col-md-6">
                <label>Address</label>

                <p>{{$client->address}}</p>
            </div>
            <div class="col-md-6">
                <label>E-mail</label>

                <p>{{$client->email}}</p>
            </div>
            <div class="col-md-6">
                <label>Rank</label>

                <p>{{$client->rank_name}}</p>
            </div>
        </div>
    </div>
    <hr/>

    <style>
        .col-md-6 {
            font-size: 20px;
        }
    </style>
@endsection