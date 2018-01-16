@extends('layouts.app')

@section('content')

    @include('resources_common.edit', ['resourceName' => 'Card', 'item' => $card])

@endsection