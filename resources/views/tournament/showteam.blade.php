@extends('layouts.main')
@section('title', $team->name." - Team")
@section('styles')
    <style>
        form
        {
            display: inline-block;
        }
    </style>
@endsection

@section('before-container')
    <div class="header wg-primary">
        <div class="container">
            <h1 class="ng-binding text-center"><a href="{{ route('tournament.show',$tournament->slug) }}">{{ $tournament->name }}</a></h1>
            <h1 class="text-green">{{ $team->name }}</h1>
        </div>
    </div>
@endsection

@section('main-container')
    <div class="content col-xs-12">

        <div class="row">
        <div class="panel col-xs-6 padding10">
            <h5 class="info-title" style="margin:0 0 10px 0;border-bottom:2px dashed grey">General Statistics</h5>
            <table style="font-size: large" class="table table-striped table-hover table-bordered">
                <tbody>
                <tr>
                    <td>Team Position</td>
                    <td>
                        {!! "<b>".$team->team_position."</b>" or "<i class='small text-muted'>Not available</i>"  !!}
                    </td>
                </tr>
                <tr>
                    <td>Country</td>
                    <td>
                        <img class="tooltipster" title="{{ $team->country->countryName }}" src="/images/flags/20_shiny/{{ $team->country->countryCode }}.png" alt="" height="22px">
                        <b> &nbsp;{{ $team->country->countryName }}</b>
                    </td>
                </tr>
                <tr>
                    <td>Players</td>
                    <td>
                        <b>{{ $team->playerselected()->count() ." / ". $team->tournament->maxPlayersPerTeam() }}</b>
                    </td>
                </tr>
                <tr>
                    <td>Team Status</td>
                    <td>
                        {!! $team->getColorAppr2() !!}
                    </td>
                </tr>
                <tr>
                    <td>Joining Status</td>
                    <td>
                        <b>{!! $team->getColorStatus() !!} for joining</b>

                    @if(Auth::check() && Auth::user()->canHandleTeam($team) && $tournament->canAlterTeams())
                        @if($team->isClosed())
                            {!! Form::open(['route' => ['tournament.team.makeopen',$tournament->slug,$team->id], 'class' => 'form pull-right form-inline']) !!}
                            {!! Form::hidden('team_id',$team->id) !!}
                            <button title="Open Team (player will be able to apply to join this team)." type="submit" class="tooltipster btn confirm btn-xs btn-info">
                                Open Team
                            </button>
                            {!! Form::close() !!}
                        @else
                            {!! Form::open(['route' => ['tournament.team.makeclose',$tournament->slug,$team->id], 'class' => 'form pull-right form-inline']) !!}
                            {!! Form::hidden('team_id',$team->id) !!}
                            <button title="Close Team (player will not be able to apply to join your team). We recommend this doing this only after making your team full." type="submit" class="tooltipster btn confirm btn-xs btn-warning">
                                Close Team
                            </button>
                            {!! Form::close() !!}
                        @endif
                    @endif

                    </td>
                </tr>
                <tr>
                    <td>Match Played</td>
                    <td>
                        <b>{{ $team->total_wins+$team->total_lost+$team->total_tie }}</b>
                    </td>
                </tr>
                <tr>
                    <td>Match Won</td>
                    <td>
                        <b>{{ $team->total_wins }}</b>
                    </td>
                </tr>
                <tr>
                    <td>Match Lost</td>
                    <td>
                        <b>{{ $team->total_lost }}</b>
                    </td>
                </tr>
                <tr>
                    <td>
                        Match Tied
                    </td>
                    <td>
                        <b>{{ $team->total_tie }}</b>
                    </td>
                </tr>
                <tr>
                    <td>
                        Total Score
                    </td>
                    <td>
                        <b>{{ $team->total_score }}</b>
                    </td>
                </tr>
                <tr>
                    <td>
                        Created
                    </td>
                    <td>
                        {{ $team->created_at->diffForHumans() }} by <b>{!! link_to_route('user.show',$team->user->displayName(),$team->user->username)  !!}</b>
                    </td>
                </tr>
                </tbody></table>
        </div>
        <div class="panel col-xs-5 col-xs-offset-1 padding10">
            <h5 class="info-title" style="margin:0 0 10px 0;border-bottom:2px dashed grey">Selected Players</h5>
            @if($team->playerselected()->get()->isEmpty())
                <span class="small">No Players</span>
            @else
                <table id="" class="table table-striped table-hover no-margin">
                    <thead>
                    <tr>
                        <th class="">#</th>
                        <th class="">Flag</th>
                        <th class="col-xs-5">Name</th>
                        <th class="col-xs-1 text-right">Score</th>
                        <th class="col-xs-3 text-right">Seen</th>
                        @if(Auth::check() && Auth::user()->canHandleTeam($team) && $tournament->canAlterPlayersInTeam())
                            <th class="text-right">
                                Action
                            </th>
                        @endif
                    </tr>
                    </thead>
                    <tbody id="">
                    @foreach($team->playerselected()->get() as $user)
                        <tr class="item">
                            <td class="text-green"><b>{{ "#" }}</b></td>
                            <td class="text-muted"><img class="tooltipster" title="{{ $user->country->countryName }}" src="/images/flags/20_shiny/{{ $user->country->countryCode }}.png" alt="" height="22px"></td>
                            <td class="color-main text-bold">
                                <a class="" style="margin-right:1em" href="{{ route('user.show',$user->username) }}">
                                    <strong class="">{{ $user->displayName() }}</strong>
                                </a>
                            </td>
                            <td class="text-right">
                                {{ $user->pivot->total_score or "0" }}
                            </td>
                            <td class="text-right" style="font-size: 12px">
                                {{ $user->updated_at->diffForHumans() }}
                            </td>
                            @if(Auth::check() && Auth::user()->canHandleTeam($team) && $tournament->canAlterPlayersInTeam())
                                <td class="text-right">
                                    {!! Form::open(['route' => ['tournament.team.player.pending',$tournament->slug,$team->id,$user->id], 'class' => 'form form-inline']) !!}
                                    {!! Form::hidden('team_id',$team->id) !!}
                                    {!! Form::hidden('user_id',$user->id) !!}
                                    <button title="Demote to pending list" type="submit" class="tooltipster btn confirm btn-xs btn-warning">
                                        <i class="fa fa-minus-circle"></i>
                                    </button>
                                    {!! Form::close() !!}
                                </td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>

            <div class="panel col-xs-5 col-xs-offset-1 padding10">
                <h5 class="info-title" style="margin:0 0 10px 0;border-bottom:2px dashed grey">Pending Players</h5>
                @if($team->playerpending()->get()->isEmpty())
                    <span class="small">No pending players</span>
                @else
                    <table id="" class="table table-striped table-hover no-margin">
                        <thead>
                        <tr>
                            <th class="">Flag</th>
                            <th class="col-xs-6">Name</th>
                            <th class="col-xs-3 text-right">Seen</th>
                            @if(Auth::check() && Auth::user()->canHandleTeam($team) && $tournament->canAlterPlayersInTeam())
                                <th class="col-xs-3 text-right">Action</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody id="">
                        @foreach($team->playerpending()->get() as $user)
                            <tr class="item">
                                <td class="text-muted"><img class="tooltipster" title="{{ $user->country->countryName }}" src="/images/flags/20_shiny/{{ $user->country->countryCode }}.png" alt="" height="22px"></td>
                                <td class="color-main text-bold">
                                    <a class="" style="margin-right:1em" href="{{ route('user.show',$user->username) }}">
                                        <strong class="">{{ $user->displayName() }}</strong>
                                    </a>
                                </td>
                                <td class="text-right" style="font-size: 12px">
                                    {{ $user->updated_at->diffForHumans() }}
                                </td>

                                @if(Auth::check() && Auth::user()->canHandleTeam($team)  && $tournament->canAlterPlayersInTeam())
                                    <td class="text-right">
                                        {!! Form::open(['route' => ['tournament.team.player.approve',$tournament->slug,$team->id,$user->id], 'class' => 'form form-inline']) !!}
                                        {!! Form::hidden('team_id',$team->id) !!}
                                        {!! Form::hidden('user_id',$user->id) !!}
                                        <button title="Promote to Selected List" type="submit" class="tooltipster btn confirm btn-xs btn-success">
                                            <i class="fa fa-plus-circle"></i>
                                        </button>
                                        {!! Form::close() !!}

                                        {!! Form::open(['method' => 'delete', 'route' => ['tournament.team.player.reject',$tournament->slug,$team->id,$user->id], 'class' => 'form form-inline']) !!}
                                        {!! Form::hidden('team_id',$team->id) !!}
                                        {!! Form::hidden('user_id',$user->id) !!}
                                        <button title="Reject & Delete Player" type="submit" class="tooltipster btn confirm btn-xs btn-danger">
                                            <i class="fa fa-trash-o"></i>
                                        </button>
                                        {!! Form::close() !!}
                                    </td>
                                @endif

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

        </div>

        <div class="row">
            <div class="col-xs-6 padding10 panel">
                <h5 class="info-title" style="margin:0 0 10px 0;border-bottom:2px dashed grey">Description</h5>
                <p class="convert-emoji">{!! BBCode::parseCaseInsensitive((htmlentities($team->description))) !!}</p>
            </div>


        </div>
        </div>


    </div>
@endsection

@section('scripts')
@endsection