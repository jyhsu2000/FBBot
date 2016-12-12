@extends('layouts.app')

@section('title', '抽獎面板')

@section('content')
    <h1>抽獎面板</h1>
    <a href="{{ route('qualification.index') }}" class="btn btn-primary">
        <i class="fa fa-arrow-left" aria-hidden="true"></i> 抽獎資格
    </a>
@endsection
