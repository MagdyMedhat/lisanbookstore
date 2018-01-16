@extends('layouts.app')

@section('content')

    @include('authors_common.items', ['resourceName' => 'Artist', 'items' => $artists])

@endsection