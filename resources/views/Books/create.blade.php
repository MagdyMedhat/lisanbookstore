@extends('layouts.app')

@section('content')

    <div class="container">
        <h2>Add New Book</h2>
        <hr/>

        <div class="well">
        {!! Form::open(['url' => url('Book')]) !!}

        @include('errors._errors')

            <div class="row">
                @include('Books._form')

                <div class="col-md-6">
                    {!! Form::submit('Add', ['class' => 'btn btn-lg btn-primary']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>


@endsection