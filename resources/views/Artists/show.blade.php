@extends('layouts.app')

@section('content')

    @include('authors_common.show', ['item' => $artist])

@endsection