@extends('layouts.app')

@section('content')

    @include('authors_common.edit', ['resourceName' => 'Artist', 'item' => $artist])

@endsection