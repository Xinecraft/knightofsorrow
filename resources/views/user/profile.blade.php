@extends('layouts.main')
@section('main-container')
    <div class="content col-md-7">
        @include('partials._errors')

        <div class="row">
            <div class="">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-5">
                                {!! Html::image($user->getGravatarLink(250),null,['class' => 'img img-thumbnail profile-cover-img']) !!}
                            </div>
                            <div class="col-md-5">
                                <h3 class="no-margin">{{ $user->name }}</h3>
                                <h4 class="">{!! link_to_route('user.show',"@".$user->username,$user->username,['class' =>'']) !!}</h4>
                                <p class="info-title">{{ $user->role }}</p>
                                <p class="text-muted small no-margin">Joined : {{ $user->joinedOn }}</p>
                                <p class="text-muted small no-margin">Last Seen : {{ $user->lastSeenOn }}</p>

                            </div>
                            <div class="col-md-2">
                            <h4 class="no-margin text-muted">{{ $user->country->countryName }}</h4>
                                {!! Html::image("/images/flags_new/flags-iso/shiny/64/".$user->country->countryCode.".png",null,['class' => 'img']) !!}
                            </div>
                        </div>

                    </div>
                    <div class="panel-body">
                        <div class="col-md-6 well pad5">
                        <h5 class="info-title" style="margin:0 0 10px 0;border-bottom:2px dashed grey">General Info</h5>
                        <p class="">Age: {!! $user->age !!} &nbsp;
                        @unless($user->gender == '' || $user->gender == null || empty($user->gender))
                            @if($user->gender == 'Male')
                                <i title="Male" class="tooltipster fa fa-male" style="color: cornflowerblue"></i>
                            @elseif($user->gender == 'Female')
                                <i title="Female" class="tooltipster fa fa-female" style="color:deeppink;"></i>
                            @else
                                <i title="Others" class="tooltipster fa fa-question-circle-o" style="color: #00A000"></i>
                            @endif
                        @endunless
                        </p>
                            <p class="">Status Count: <b class="">{{ $statusCount = $user->statuses()->count() }} {{ str_plural("Status", $statusCount) }}</b></p>
                            <p class="">Followers: <b class="">{{ $followersCount = $user->followers->count() }} {{ str_plural("gamer", $followersCount) }}</b></p>
                            <p class="">Following: <b class="">{{ $followingCount = $user->following->count() }} {{ str_plural("gamer", $followingCount) }}</b></p>
                        </div>
                        <div class="col-md-6 well pad5">
                        <h5 class="info-title" style="margin:0 0 10px 0;border-bottom:2px dashed grey">Stats Tracker</h5>
                            <p class="">Player Name: {!! $user->linkPlayerNamewithLink !!}</p>
                            <p class="">Position: {!! $user->linkPlayerPosition !!}</p>
                            <p class="">Time Played: {!! $user->linkPlayerTimePlayed !!}</p>
                            <p class="">Last Seen: {!! $user->linkPlayerLastSeen !!}</p>
                        </div>
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
                                @if(Auth::check() && Auth::user()->isAdmin())
                                        {!! Form::open(['method' => 'patch', 'route' => ['user.toggleban',$user->username]])  !!}
                                        {!! Form::hidden('username',$user->username)  !!}
                                        @if($user->banned == 1)
                                            {!! Form::submit('Unban @'.$user->username,['class' => 'btn confirm btn-success'])  !!}
                                        @else
                                            {!! Form::submit('Ban @'.$user->username,['class' => 'btn confirm btn-danger'])  !!}
                                        @endif
                                        {!! Form::close()  !!}
                                @endif

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