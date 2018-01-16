@extends('layouts.app')

@section('content')

    <div class="container">
        <h2>Add New Client</h2>
        <hr/>

        <div class="well">
            {!! Form::open(['url' => url('Client')]) !!}

            @include('errors._errors')

            <div class="row">
                @include('Clients._form')

                <div class="col-md-6">
                    {!! Form::submit('Add', ['class' => 'btn btn-lg btn-primary']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>


@endsection