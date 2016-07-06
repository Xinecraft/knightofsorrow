@extends('layouts.main')
@section('main-container')
    <div class="content col-xs-8">
    @include('partials._errors')

        <div class="col-xs-12 panel" style="padding: 15px">
            <h5 class="" style="margin:10px 0 10px 0;border-bottom:1px dashed grey">From: <b>{!! link_to_route('user.show',$mail->sender->displayName(),[$mail->sender->username]) !!}</b></h5>
            <h5 class="" style="margin:10px 0 10px 0;border-bottom:1px dashed grey">To: <b>{!! link_to_route('user.show',$mail->reciever->displayName(),[$mail->sender->username]) !!}</b></h5>
            <h4 class="" style="margin:0 0 10px 0;border-bottom:2px dashed grey">Subject: {{ $mail->subject }}</h4>
            <p class="convert-emoji">{!! nl2br(htmlentities($mail->body)) !!}</p>
        </div>


    </div>
@endsection