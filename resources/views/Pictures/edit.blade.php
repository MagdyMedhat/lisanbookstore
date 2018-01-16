@extends('layouts.app')

@section('content')
    @include('resources_common.edit', ['resourceName' => 'Picture', 'item' => $picture])
@endsection