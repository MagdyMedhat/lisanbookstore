@extends('layouts.app')

@section('content')
    @include('resources_common.edit', ['resourceName' => 'Poster', 'item' => $poster])
@endsection