@extends('layouts.app')

@section('content')

    @include('authors_common.items', ['resourceName' => 'Writer', 'items' => $writers])

@endsection