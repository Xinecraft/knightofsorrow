@extends('layouts.main')
@section('title','Edit status')
@section('main-container')
    <div class="content col-md-7">
    @include('partials._errors')
        {!! Form::open(['name'=>'status','method'=>'PUT','action'=>['StatusController@update']]) !!}
        {!! Form::textarea('body',$status->body,['id'=>'statusupdatetextarea','class'=>'form-control','placeholder'=>'Write your status here.']) !!} <br>
        {!! Form::hidden('id',$status->id) !!}
        {!! Form::submit('Post Update',['class'=>'btn btn-success']) !!}
    </div>

@endsection