@extends('layouts.main')
@section('main-container')
    <div class="content col-md-7">
        @include('partials._errors')

        <div class="row">
            <div class="">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="">
                                {!! Html::image('/img/ext/computer-767776_1280.jpg',null,['class' => 'img profile-cover-img']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <h3 class="text-center">{{ $user->name }}</h3>
                        <p class="text-info text-center"><b>{{ $statusCount = $user->statuses()->count() }} {{ str_plural("Status", $statusCount) }}</b></p>
                    </div>
                    <div class="panel-footer">
                        <div class="row">
                            @if(Auth::check())
                                @if(Auth::user()->isFollowing($user))
                                    {!! Form::open(['name'=>'unfollow','method'=>'DELETE','action'=>'UserController@deleteUnfollow','class'=>'form col-md-3']) !!}
                                    {!! Form::hidden('user_id',$user->id) !!}
                                    {!! Form::submit("unfollow @$user->username",['class'=>'btn btn-danger']) !!}
                                    {!! Form::close() !!}
                                @else
                                    {!! Form::open(['name'=>'follow','method'=>'POST','action'=>'UserController@postFollow','class'=>'form col-md-3']) !!}
                                    {!! Form::hidden('user_id',$user->id) !!}
                                    {!! Form::submit("follow @$user->username",['class'=>'btn btn-info']) !!}
                                    {!! Form::close() !!}
                                @endif
                            @endif
                            <div class="followlinks col-md-3 right">
                                <ul class="nav nav-pills text-center" role="tablist">
                                    <p role="presentation">Following <span class="badge">{{ $user->following->count() }}</span></p>

                                    <p role="presentation">Followers <span class="badge">{{ $user->followers->count() }}</span></p>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div id="data-items">
        @forelse($pagin = $user->statuses()->paginate(5) as $status)
                @include('partials._view_statuses')
        @empty
            <div class="panel">
                <h3>No Status yet!</h3>
            </div>
        @endforelse
        </div>
        {!! $pagin->render() !!}
        <div id="loading" class="text-center"></div>
        </div>

    </div>
@endsection