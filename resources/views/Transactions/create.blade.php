@extends('layouts.app')

@section('content')



    <div class="container">
        <h2>Add New Transaction</h2>
        <hr/>

        <div class="well">
            {!! Form::open(['url' => url('Transaction')]) !!}

            <div class="row">
                {{--@include('Transactions._transaction')--}}
                {{--@include('Transactions._resources')--}}
                @include('Transactions._form')

                <div class="col-md-12">
                    {!! Form::button('Add', ['class' => 'btn btn-lg btn-primary', 'onClick' => 'return validateForm()'
                    , 'type' => 'submit', 'id' => 'formSubmit']) !!}
                </div>

            </div>

            {!! Form::close() !!}
        </div>

    </div>
@include('Transactions._create-script')


@endsection