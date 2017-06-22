@extends('layouts.main')
@section('styles')
    <style>
        @if($user->back_img_url != null && $user->back_img_url != "")
        body
        {
            background: url("{{ $user->back_img_url }}") fixed !important;
			background-size: cover !important;
        }
        @endif
        .about-well img
        {
            max-width: 100% !important;
        }
        .about-well iframe
        {
            max-width: 100% !important;
        }
        .general-info
        {
            height: 189px !important;
            border-right: 1px solid #d7d8d9;
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
            -webkit-box-shadow: none !important;
            -moz-box-shadow: none !important;
            box-shadow: none !important;
        }
        .stats-tracker
        {
            height:189px !important;
            border-left: 0;
            border-bottom-left-radius: 0;
            border-top-left-radius: 0;
            -webkit-box-shadow: none !important;
            -moz-box-shadow: none !important;
            box-shadow: none !important;
        }
        .profile-panel
        {
            border-color: #d7d8d9;
        }
        .hero-name
        {
            font-family:'Ubuntu', Helvetica, Arial, sans-serif;
            font-weight:900;
            font-size: 30px;
            color: #d62c1a;
            -webkit-text-shadow: 1px 1px 1px #000;
            -moz-text-shadow: 1px 1px 1px #000;
            -ms-text-shadow: 1px 1px 1px #000;
            -o-text-shadow: 1px 1px 1px #000;
            text-shadow: 1px 1px 1px #000;
        }
        .username
        {
            color: #ca970a !important;
            font-family: 'Ubuntu', Helvetica, Arial, sans-serif;
            font-size: 85%;
        }
        .profile-cover-img
        {
            background-color: #2c3e50;
            border: 1px solid #2c3e50;
        }
        .user-flag
        {
            margin: -8px 0px 2px 0px;
        }
        .about-well
        {
            margin-bottom: 10px;
            background-color: #293949;
            border: 1px solid rgb(40, 52, 65);
        }
        .absrz
        {
            position: absolute;
            right: 0;
        }
        .linethru
        {
            text-decoration: line-through;
        }
        .text-verified
        {
            color: greenyellow;
        }
        .text-banned
        {
            color: #df0000;
        }
        .superadmin
        {
            color:	#FFD700;
        }
        .admin
        {
            color:  #4285f4;
        }
        .elder
        {
            color: greenyellow;
        }
    </style>
@endsection
@section('title', $user->displayName()."'s profile")
@section('main-container')
    <div class="content col-xs-7">
        @include('partials._errors')

        <div class="row">
            <div class="">
                <div class="panel panel-primary profile-panel">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-5">
                                {!! Html::image($user->getGravatarLink(250),null,['class' => 'img img-thumbnail profile-cover-img']) !!}

                                @if(!$user->confirmed && !$user->banned)
                                <p class="text-warning padding10 text-center"><i class="fa fa-envelope"></i>
                                    Email not verified
                                </p>
                                @elseif($user->banned)
                                    <p class="text-banned padding10 text-center"><i class="fa fa-times-circle"></i>
                                        Banned Account
                                    </p>
                                @endif
                                @if($user->muted)
                                    <p class="text-banned padding10 text-center"><i class="fa fa-microphone"></i>
                                        Muted Account
                                    </p>
                                @endif
                                <div class="padding10 text-center">
                                @forelse($user->clanroles()->orderBy('weight')->get() as $clanrole)
                                    <img class="tooltipster image" src="/images/ranks/{{ $clanrole->img_url }}" alt="{{ $clanrole->display_name }}" title="{{ $clanrole->display_name }}">
                                @empty
                                @endforelse
                                </div>
                            </div>
                            <div class="col-xs-5">
                                <h3 class="no-margin hero-name {{ $user->roles->first()->name }} {{ $user->banned ? 'linethru' : '' }}">{{ $user->name }}</h3>
                                <h4 class="">{!! link_to_route('user.show',"@".$user->username,$user->username,['class' =>'username']) !!}</h4>


                                <img class="tooltipster image" src="{{ $user->roleImageLink }}" alt="{{ $user->role }}" title="{{ $user->role }}">

                            @unless($user->about == null || $user->about == '')
                                <p class="convert-emoji small text-muted well well-sm about-well">{!! BBCode::parseCaseInsensitive((htmlentities($user->about))) !!}</p>
                                @endunless
                                <div class="timeago-content" style="margin-bottom: 5px">
                                    <kbd class="text-muted small no-margin">Joined : {{ $user->joinedOn }}</kbd>
                                    <br>
                                    <kbd class="text-muted small no-margin">Last Seen : {!! $user->lastSeenOn !!}</kbd>
                                    @if(Auth::check() && Auth::user()->isAdmin())
                                        <br>
                                        <kbd class="text-muted small no-margin">Last Login IP : {{ $user->last_ipaddress }}</kbd>
                                        <kbd class="text-muted small no-margin">{{ $user->email }}</kbd> <br>
                                        <kbd class="text-muted small no-margin">User Id:{{ $user->id }}</kbd> <br>
                                        <kbd class="text-muted small no-margin">View IP History:</kbd> <a style='color:yellow' title="View IP History" class='tooltipster fancybox livepfancy fancybox.ajax' href='/viewiphistoryuser?user={{ $user->username }}'><i class='fa fa-cog'></i></a>
                                    @endif
                                </div>

                                @if(Auth::check() && Auth::user()->isAdmin())
                                <div class="col-xs-12 well well-sm about-well">
                                    {!! Form::open(['route'=> ['user.changerole',$user->username],'class' => 'form form-inline col-xs-3']) !!}
                                    {!! Form::hidden('user_id',$user->id) !!}
                                    {!! Form::hidden('job','demote') !!}
                                    <button title="Demote {{ $user->displayName() }} to previous rank" type="submit" class="tooltipster btn btn-danger btn-xs confirm">
                                        <i class="fa fa-btn fa-step-backward"></i>
                                    </button>
                                    {!! Form::close() !!}
                                    <div class="col-xs-6 text-center">
                                        {{ $user->role }}
                                    </div>
                                    {!! Form::open(['route'=> ['user.changerole',$user->username],'class' => 'form form-inline col-xs-3']) !!}
                                    {!! Form::hidden('user_id',$user->id) !!}
                                    {!! Form::hidden('job','promote') !!}
                                    <button title="Promote {{ $user->displayName() }} to next rank" type="submit" class="tooltipster btn btn-info btn-xs confirm">
                                        <i class="fa fa-btn fa-step-forward"></i>
                                    </button>
                                    {!! Form::close() !!}
                                </div>
                                @endif
                            </div>

                            <div class="col-xs-2">
                                {!! Html::image("/images/flags_new/flags-iso/shiny/64/".$user->country->countryCode.".png",null,['class' => 'img user-flag tooltipster', 'title' => $user->country->countryName]) !!}
                            </div>
                        </div>

                    </div>
                    <div class="panel-body">
                        <div class="col-xs-6 panel general-info pad5">
                            <h5 class="info-title" style="margin:0 0 10px 0;border-bottom:2px dashed grey">General
                                Info</h5>
                            <table style="font-size: large" class="table table-striped table-hover table-bordered">
                                <tr>
                                    <td>Age</td>
                                    <td>
                                        {!! $user->age !!} &nbsp;
                                        @unless($user->gender == '' || $user->gender == null || empty($user->gender))
                                            @if($user->gender == 'Male')
                                                <i title="Male" class="tooltipster fa fa-male"
                                                   style="color: cornflowerblue"></i>
                                            @elseif($user->gender == 'Female')
                                                <i title="Female" class="tooltipster fa fa-female" style="color:deeppink;"></i>
                                            @else
                                                <i title="Others" class="tooltipster fa fa-question-circle-o"
                                                   style="color: #00A000"></i>
                                            @endif
                                        @endunless
                                    </td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td>
                                        <b>{{ $statusCount = $user->statuses()->count() }} {{ str_plural("Status", $statusCount) }}</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Followers</td>
                                    <td>
                                        <b class="tooltipster" title="{{ $user->followersAsTitle }}">{{ $followersCount = $user->followers->count() }} {{ str_plural("gamer", $followersCount) }}</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Following
                                    </td>
                                    <td>
                                        <b class="tooltipster" title="{{ $user->followingsAsTitle }}">{{ $followingCount = $user->following->count() }} {{ str_plural("gamer", $followingCount) }}</b>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-xs-6 panel stats-tracker pad5">
                            <h5 class="info-title" style="margin:0 0 10px 0;border-bottom:2px dashed grey">Stats
                                Tracker</h5>
                            <table style="font-size: large" class="table table-striped table-hover table-bordered">
                                <tr>
                                    <td>Player Name</td>
                                    <td>
                                        {!! $user->linkPlayerRank() !!}
                                        {!! $user->linkPlayerNamewithLink !!}</td>
                                </tr>
                                <tr>
                                    <td>Position</td>
                                    <td>{!! $user->linkPlayerPosition !!}</td>
                                </tr>
                                <tr>
                                    <td>Time Played</td>
                                    <td>{!! $user->linkPlayerTimePlayed !!}</td>
                                </tr>
                                <tr>
                                    <td>Last Seen</td>
                                    <td>{!! $user->linkPlayerLastSeen !!}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-xs-6 panel general-info pad5" style="height: auto !important;">
                            <h5 class="info-title" style="margin:0 0 10px 0;border-bottom:2px dashed grey">Other
                                Info</h5>
                            <table style="font-size: large" class="table table-striped table-hover table-bordered">
                                <tr>
                                    <td class="tooltipster" title="EvolveHQ Username">Evolve Username</td>
                                    <td>
                                        {!! $user->evolveId !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="tooltipster" title="Steam Username">Steam Username</td>
                                    <td>
                                        {!! $user->steamId !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="tooltipster" title="Discord Username">Discord</td>
                                    <td>
                                        {!! $user->discordUsername !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="tooltipster" title="GameRanger Account Id">GR Account Id</td>
                                    <td>
                                        {!! $user->grId !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="tooltipster" title="Facebook Profile URL">Facebook</td>
                                    <td>
                                        {!! $user->fbURL !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Website
                                    </td>
                                    <td>
                                        {!! $user->websiteURL !!}
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-xs-6 panel stats-tracker pad5" style="height: 261px !important;">
                            <h5 class="info-title" style="margin:0 0 10px 0;border-bottom:2px dashed grey">Trophies</h5>
                            <ul class="list-group" style="overflow: auto;height: 186px;">
                            @forelse($user->trohpies as $trophy)
                                    <li class="list-group-item text-center" style="color: {{ $trophy->color }}"><i class="fa fa-2x {{ $trophy->icon }}"></i> <b class="tooltipster" title="{{ $trophy->name }}">{{ $trophy->short_name }}</b></li>
                            @empty
                                <h3 class="text-center text-danger" style="font-family: 'Passion One',cursive">
                                    <i class="fa fa-trophy fa-3x" style="color:#ffd92e"></i><br>
                                    No Trophy Won!
                                </h3>
                            @endforelse
                            </ul>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <div class="row">
                            @if(Auth::check())
                                @if(Auth::user()->isFollowing($user))
                                    {!! Form::open(['name'=>'unfollow','method'=>'DELETE','action'=>'UserController@deleteUnfollow','class'=>'form col-xs-2 col-xs-4']) !!}
                                    {!! Form::hidden('user_id',$user->id) !!}
                                    <button title="Stop following {{ $user->displayName() }}" type="submit" class="tooltipster btn btn-warning btn-sm">
                                        <i class="fa fa-btn fa-user"></i> Unfollow
                                    </button>
                                    {!! Form::close() !!}
                                @else
                                    {!! Form::open(['name'=>'follow','method'=>'POST','action'=>'UserController@postFollow','class'=>'form col-xs-2 col-xs-4']) !!}
                                    {!! Form::hidden('user_id',$user->id) !!}
                                    <button title="Start following {{ $user->displayName() }}" type="submit" class="tooltipster btn btn-info btn-sm">
                                        <i class="fa fa-btn fa-users"></i> Follow
                                    </button>
                                    {!! Form::close() !!}
                                @endif
                            @endif
                            @if(Auth::check() && Auth::user()->isAdmin())
                                {!! Form::open(['method' => 'patch', 'route' => ['user.toggleban',$user->username], 'class' => 'form col-xs-2 col-xs-4'])  !!}
                                {!! Form::hidden('username',$user->username)  !!}
                                @if($user->banned == 1)
                                        <button type="submit" class="btn btn-success btn-sm tooltipster" title="Remove Ban on {{ $user->displayname() }}">
                                            <i class="fa fa-btn fa-ban"></i> Unban
                                        </button>
                                @else
                                        <button type="submit" class="btn btn-danger confirm btn-sm tooltipster" title="Ban {{ $user->displayName() }}">
                                            <i class="fa fa-btn fa-ban"></i> Ban
                                        </button>
                                @endif
                                {!! Form::close()  !!}

                                    {!! Form::open(['method' => 'patch', 'route' => ['user.togglemute',$user->username], 'class' => 'form col-xs-2 col-xs-4'])  !!}
                                    {!! Form::hidden('username',$user->username)  !!}
                                    @if($user->muted == 1)
                                        <button type="submit" class="btn btn-success btn-sm tooltipster" title="Unmute {{ $user->displayname() }}">
                                            <i class="fa fa-btn fa-ban"></i> Unmute
                                        </button>
                                    @else
                                        <button type="submit" class="btn btn-warning confirm btn-sm tooltipster" title="Mute {{ $user->displayName() }}">
                                            <i class="fa fa-btn fa-microphone"></i> Mute
                                        </button>
                                    @endif
                                    {!! Form::close()  !!}
                            @endif
                            @if(Auth::check() && $user->id != Auth::user()->id)
                                <div class="col-xs-2 absrz">
                                    <a title="Start chatting with {{ $user->displayName() }}" class="btn btn-primary btn-sm tooltipster" href="{{ route('messages.show',$user->username) }}"><i class="fa fa-btn fa-comment-o"></i> Chat</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div id="data-items">
                @forelse($pagin = $user->statuses()->with('comments','user')->paginate(5) as $status)
                    @include('partials._view_statuses')
                @empty
                    <div class="panel padding10 text-center">
                        <h4><span class="text-danger">{{ $user->displayName() }}</span> has not posted any status yet :(</h4>
                    </div>
                @endforelse
            </div>
            {!! $pagin->render() !!}
            <div id="loading" class="text-center"></div>
        </div>

    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $('.fancybox').fancybox();
        })
    </script>
@endsection