@extends('layouts.app')

@section('title', '玩家管理')

@section('content')
    <h1>玩家管理</h1>
    {!! $dataTable->table() !!}
@endsection

@section('js')
    {!! $dataTable->scripts() !!}
@endsection
