@extends('layouts.app')

@section('title', '資安語錄')

@section('content')
    <h1>資安語錄</h1>
    <div id="#quotation">
        <ul class="list-group">
            <quotation-list api="{{ route('quotation.index') }}"></quotation-list>
        </ul>
    </div>
@endsection
