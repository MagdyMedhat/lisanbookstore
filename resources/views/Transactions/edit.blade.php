@extends('layouts.app')

@section('content')



    <div class="container">
        <h2>Edit Transaction</h2>
        <hr/>

        <div class="well">
            {{--{{dd($data)}}--}}
            {!! Form::model($transaction, ['url' => url("Transaction/{$transaction->id}"), 'method' => 'put']) !!}

            <div class="row">
                {{--@include('Transactions._transaction', ['transaction' => $data['transaction']])--}}
                {{--@include('Transactions._resources', ['resources' => $data['resources']])--}}
                @include('Transactions._form')

                <div class="col-md-12">
                    {!! Form::button('Save', ['class' => 'btn btn-lg btn-primary', 'onClick' => 'return validateForm()',
                     'type' => 'submit', 'id' => 'formSubmit']) !!}
                </div>

            </div>

            {!! Form::close() !!}
        </div>

    </div>
    @include('Transactions._edit-script')


@endsection