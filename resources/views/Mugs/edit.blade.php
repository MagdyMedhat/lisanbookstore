@extends('layouts.app')

@section('content')
    @include('resources_common',['resourceName' => 'Mug' ,'item' => $mug])
@endsection