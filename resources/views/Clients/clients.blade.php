@extends('layouts.app')

@section('content')
    <div class="container">

        @include('shared._status')

        <h2>Clients</h2>

        <div class="row">

            <div class="col-md-3">
                {!! Form::open(['method' => 'get']) !!}

                <div class="input-group">
                    {!! Form::text('search', null, ['class' => 'form-control', 'placeholder' => 'search', 'id' =>
                    'search'])
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

                    <a href="{{url('Client/create')}}" class="btn btn-default">Add New <span
                                class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>
                </div>
            </div>
            {!! Form::close() !!}


            <!--Row End --> </div>

        <hr/>

        @if(count($clients))
            <table class="table table-striped table-hover">
                <thead>
                {!! Form::open(['url' => url("Client/export")]) !!}
                {!! Form::text('viewName', 'Clients.export_table', ['hidden' => 'true']) !!}
                {!! Form::text('fileName', "Clients", ['hidden' => 'true']) !!}
                {!! Form::text('searchWord', '', ['hidden' => 'true', 'id' => 'searchWord']) !!}
                {!! Form::button('Export <span class="glyphicon glyphicon-print" aria-hidden="true"></span>', ['class'
                => 'btn btn-default', 'type' => 'submit']) !!}
                {!! Form::close() !!}
                <tr>
                    <th>Name</th>
                    <th>Rank</th>
                    <th>Address</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                {{--{{dd($clients)}}--}}
                @foreach($clients as $client)
                    {{--{{dd($client->id)}}--}}
                    <tr>
                        <td>{{$client->client_name}}</td>
                        <td>{{$client->rank_name}}</td>
                        <td>{{$client->client_address}}</td>
                        <td><a href="{{url("Client/{$client->id}")}}" class="btn"><span
                                        class="glyphicon glyphicon-folder-open"></span></a></td>
                        <td><a href="{{url("Client/{$client->id}/edit")}}" class="btn"><span
                                        class="glyphicon glyphicon-edit"></span></a></td>
                        {!! Form::open(['url' => "Client/{$client->id}", 'method' => 'delete']) !!}
                        <td>{!! Form::button('<span class="glyphicon glyphicon-remove"></span>', [
                            'style' => 'background-color: Transparent;
                            background-repeat:no-repeat;
                            border: none;
                            cursor:pointer;
                            overflow: hidden;
                            outline:none;
                            padding-top:5% ',
                            'type' => 'submit',
                            'onClick' => 'return deleteConfirm()']) !!}
                        </td>
                        {!! Form::close() !!}
                    </tr>
                @endforeach
            </table>
            {!! $clients->links() !!}

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
@endsection