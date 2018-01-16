@extends('layouts.app')

@section('content')

    <div class="container">

        <h2>Edit: {{$book->name}}</h2>
        <hr/>


        <div class ="well">
        {!! Form::model($book, ['url' => url("Book/{$book->id}"), 'method' => 'put']) !!}

            @include('errors._errors')

            @include('Books._form')

            {!! Form::submit('Save', ['class' => 'btn btn-lg btn-primary']) !!}
        {!! Form::close() !!}
        </div>
    </div>
@endsection