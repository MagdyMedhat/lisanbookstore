@extends('layouts.app')

@section('content')
    <div class="container">
    <div class="row well">
        {{--{{dd($resources)}}--}}
        <div class="col-md-6">
            <label>
                Category
            </label>
            <p>
                {{$transaction->category_name}}
            </p>
        </div>
        <div class="col-md-6">
            <label>
                Client
            </label>
            <p>
                {{$transaction->client_name}}
            </p>
        </div>
        <div class="col-md-12">
            <label>
                Created At
            </label>
            <p>
                {{$transaction->created_at}}
            </p>
        </div>
        <hr/>
        <div class="col-md-12">
        <h2>
            Resources
        </h2>
        </div>
        @foreach($resources as $resource)
            <div class="col-md-12 panel">
                <div class="panel-body">
                <div class="col-md-4">
                    <label>
                        Title
                    </label>
                    <p>
                        {{$resource['name']}}
                    </p>
                </div>
                <div class="col-md-4">
                    <label>
                        Code
                    </label>
                    <p>
                        {{$resource['code']}}
                    </p>
                </div>
                <div class="col-md-4">
                    <label>
                        Quantity
                    </label>
                    <p>
                        {{$resource['qtty']}}
                    </p>
                </div>
                </div>
            </div>
        @endforeach
    </div>
    </div>
    <style>
        .well{
            font-size: 20px;
        }
    </style>

@endsection