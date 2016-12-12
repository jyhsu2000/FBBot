@extends('layouts.app')

@section('title', '抽獎資格')

@section('content')
    <h1>抽獎資格</h1>
    {!! $dataTable->table() !!}
@endsection

@section('js')
    {!! $dataTable->scripts() !!}
@endsection
