@extends('layouts.app')

@section('content')
    @include('resources_common.items', ['resourceName' => 'Mug', 'items' => $mugs])
@endsection