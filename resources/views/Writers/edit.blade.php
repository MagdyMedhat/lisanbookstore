@extends('layouts.app')

@section('content')

    @include('authors_common.edit', ['resourceName' => 'Writer', 'item' => $writer])

@endsection