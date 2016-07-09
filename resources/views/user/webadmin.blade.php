@extends('layouts.main')
@section('styles')
    <style>
        .main-sidebar
        {
            display: none !important;
        }
    </style>
@endsection
@section('title','KoS Web Admin')
@section('main-container')
    <div class="content col-xs-9">
        <iframe src="http://knightofsorrow.tk:10490" frameborder="0" width="1080" height="500"></iframe>
    </div>
@endsection