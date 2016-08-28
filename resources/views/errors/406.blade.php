@extends('layouts.main')
@section('styles')
    <link href='https://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'>
    <style>
        .red {
            font-size: 72px;
            margin-bottom: 40px;
            color: rebeccapurple;
        }
        .large
        {
            font-size: 20px;
            color: darkred;
        }
        .content
        {
            font-family: 'Pacifico',Cursive,sans-serif;
            height: 500px !important;
        }
    </style>
@endsection
@section('title','406! Not Acceptable')
@section('main-container')
    <div class="content col-xs-9 panel text-center">
        <h1 class="red">406 Not Acceptable!</h1>
        <p class="large">Either a token mismatch occurred or request is not acceptable.</p>
    </div>
@endsection