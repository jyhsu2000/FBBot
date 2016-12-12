@extends('layouts.app')

@section('title', '抽獎資格')

@section('content')
    <h1>抽獎資格</h1>
    <a href="{{ route('qualification.panel') }}" class="btn btn-primary">
        <i class="fa fa-arrow-right" aria-hidden="true"></i> 抽獎面板
    </a>
    {!! $dataTable->table() !!}
@endsection

@section('js')
    {!! $dataTable->scripts() !!}
@endsection
