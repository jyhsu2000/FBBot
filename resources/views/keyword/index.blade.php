@extends('layouts.app')

@section('title', '關鍵字')

@section('content')
    <h1>關鍵字</h1>
    <keyword-input api="{{ route('keyword.index') }}"></keyword-input>
    {!! $dataTable->table() !!}
@endsection

@section('js')
    {!! $dataTable->scripts() !!}
@endsection
