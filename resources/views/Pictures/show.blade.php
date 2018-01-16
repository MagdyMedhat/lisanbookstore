@extends('layouts.app')

@section('content')
    @include('resources_common.show', ['item' => $picture])
@endsection