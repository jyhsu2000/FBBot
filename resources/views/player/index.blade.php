@extends('layouts.app')

@section('title', '玩家管理')

@section('content')
    <h1>玩家管理</h1>
    {{-- TODO: 改用DataTable --}}
    {!! $dataTable->table() !!}
@endsection

@section('js')
    {!! $dataTable->scripts() !!}
@endsection
