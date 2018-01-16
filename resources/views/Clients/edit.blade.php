@extends('layouts.app')

@section('content')

    <div class="container">

        <h2>Edit: {{$client->name}}</h2>
        <hr/>


        <div class="well">
            {!! Form::model($client, ['url' => url("Client/{$client->id}"), 'method' => 'put']) !!}

            @include('errors._errors')

            @include('Clients._form')

            {!! Form::submit('Save', ['class' => 'btn btn-lg btn-primary']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection