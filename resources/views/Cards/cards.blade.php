@extends('layouts.app')

@section('content')

    @include('resources_common.items', ['resourceName' => 'Card', 'items' => $cards])

@endsection