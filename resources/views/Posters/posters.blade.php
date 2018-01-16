@extends('layouts.app')

@section('content')
    @include('resources_common.items', ['resourceName' => 'Poster', 'items' => $posters])
@endsection