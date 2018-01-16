@extends('layouts.app')

@section('content')
    @include('resources_common.items', ['resourceName' => 'Picture', 'items' => $pictures])
@endsection