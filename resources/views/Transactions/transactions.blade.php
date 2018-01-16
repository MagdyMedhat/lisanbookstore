@extends('layouts.app')

@section('content')
    <div class="container">
        
        @include('shared._status')

        <h2>Transactions</h2>

        <div class="row">

            <div class="col-md-3">
                {!! Form::open(['method' => 'get']) !!}

                <div class="input-group">
                    {!! Form::text('search', null, ['class' => 'form-control', 'placeholder' => 'search', 'id' => 'search'])
                    !!}
                    <span class="input-group-btn">
                {!! Form::button('<span class="glyphicon glyphicon-search" aria-hidden="true"></span>',  ['type' => 'submit' ,'class' => 'btn btn-default']) !!}
                </span>
                </div>
            </div>
            <div class="col-md-7">
            </div>
            <div class="col-md-2">
                <div class="input-group">

                    <a href="{{url('Transaction/create')}}" class="btn btn-default">Add New  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>
                </div>
            </div>
            {!! Form::close() !!}


                    <!--Row End --> </div>
        
        <hr/>

        @if(count($transactions))
            <table class="table table-striped table-hover">
                <thead>
                {{--{!! Form::open(['url' => url("Transaction/export")]) !!}--}}
                {{--{!! Form::text('viewName', 'Transactions.export_table', ['hidden' => 'true']) !!}--}}
                {{--{!! Form::text('fileName', "Transactions", ['hidden' => 'true']) !!}--}}
                {{--{!! Form::text('searchWord', '', ['hidden' => 'true', 'id' => 'searchWord']) !!}--}}
                {{--{!! Form::button('Export <span class="glyphicon glyphicon-print" aria-hidden="true"></span>', ['class'--}}
                {{--=> 'btn btn-default', 'type' => 'submit']) !!}--}}
                {{--{!! Form::close() !!}--}}
                <tr>
                    <th>Created At</th>
                    <th>Client</th>
                    <th>Category</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                {{--{{dd($transactions)}}--}}
                @foreach($transactions as $transaction)
                    <tr>
                        <td>{{$transaction->created_at->toDateString()}}</td>
                        <td>{{$transaction->client_name}}</td>
                        <td>{{$transaction->category_name}}</td>
                        <td><a href="{{url("Transaction/{$transaction->id}")}}" class="btn"><span class="glyphicon glyphicon-folder-open"></span></a></td>
                        <td><a href="{{url("Transaction/{$transaction->id}/edit")}}" class="btn"><span class="glyphicon glyphicon-edit"></span></a></td>
                        {!! Form::open(['url' => "Transaction/{$transaction->id}", 'method' => 'delete']) !!}
                        <td>{!! Form::button('<span class="glyphicon glyphicon-remove"></span>', [
                            'style' => 'background-color: Transparent;
                            background-repeat:no-repeat;
                            border: none;
                            cursor:pointer;
                            overflow: hidden;
                            outline:none;
                            padding-top:10% ',
                            'type' => 'submit',
                            'onClick' => 'return deleteConfirm()']) !!}</td>
                        {!! Form::close() !!}
                    </tr>
                @endforeach
            </table>
            {!! $transactions->links() !!}

        @endif

    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script>
        //        $(document).ready(function () {
        function deleteConfirm() {
            return confirm('Do you want to delete this item?');
        }

        $('#search').on('change', function () {

            var value = $('#search').val();
            $('#searchWord').val(value);
        })
        //        });
    </script>
        
    </div>
@endsection