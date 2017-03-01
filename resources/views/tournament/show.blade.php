@extends('layouts.main')
@section('title',$tournament->name)
@section('styles')
    <style>
        .tab-pane {
            padding: 10px;
        }

        .form.form-inline {
            display: inline-block;
        }

        .vs:before {
            content: 'vs';
            font-size: 25px;
            float: right;
            color: #03A9F4;
        }

        .team-name {
            padding: 10px !important;
        }

        .team-name.small {
            padding: 5px !important;
        }

        .label {
            display: inline;
            font-size: 100%;
            font-weight: normal;
            line-height: 1;
            text-align:start;
            color:black;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: .25em;
        }
        .dd-bracket
        {
            padding: 20px;
        }

    </style>
@endsection

@section('before-container')
    <div class="header wg-primary">
        <div class="container">
            <h1 class="ng-binding">{{ $tournament->name }}</h1>
            @if($tournament->isRegistrationOpen()==6)
            <h3 style="color:#1aff0d" class="text-center"><a href="kos-alpha-tournament/team/{{ $tournament->winnerteam->id }}">{{ $tournament->winnerteam->name }}</a> has won {{ $tournament->name }}</h3>
            <h4 style="color:#ff9600" class="text-center"><a href="kos-alpha-tournament/team/{{ $tournament->secondteam->id }}">{{ $tournament->secondteam->name }}</a> is runner of {{ $tournament->name }}</h4>
                @if($tournament->thirdteam != null)
                    <h5 style="color:yellow" class="text-center"><a href="kos-alpha-tournament/team/{{ $tournament->thirdteam->id }}">{{ $tournament->thirdteam->name }}</a> came third in {{ $tournament->name }}</h5>
                @endif
            @endif
        </div>
    </div>
@endsection

@section('main-container')
    @include('partials._tournavbar')

    <div class="col-xs-12 panel padding10">

<div class="row">
        <div class="col-xs-8">
            <div class="wizard row">
                <div class="col-lg-12">
                    <ul>
                        <li class="col-lg-4">
                            <span translate=""><span class="ng-scope">Registration Starts</span></span>
                            <span class="clearfix ng-binding">{{ $tournament->registration_starts_at->toDayDateTimeString() }}</span>
                            {{--<span class="clearfix ng-binding small">{{ $tournament->registration_starts_at->diffForHumans() }}</span>--}}
                        </li>
                        <li class="col-lg-4">
                            <span translate=""><span class="ng-scope">Registrations Ends</span></span>
                            <span class="ng-binding">{{ $tournament->registration_ends_at->toDayDateTimeString() }}</span>
                            {{--<span class="ng-binding small">{{ $tournament->registration_ends_at->diffForHumans() }}</span>--}}
                        </li>
                        <li class="col-lg-4">
                            <span translate=""><span class="ng-scope">Tournament Starts</span></span>
                            <span class="ng-binding">{{ $tournament->tournament_starts_at->toDayDateTimeString() }}</span>
                            {{--<span class="ng-binding small">{{ $tournament->tournament_starts_at->diffForHumans() }}</span>--}}
                        </li>
                    </ul>
                </div><!--end col-lg-12-->
            </div>

            <div id="tabs-id">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#overview" aria-controls="overview" role="tab"
                                                              data-toggle="tab">Overview</a></li>
                    <li role="presentation"><a href="#description" aria-controls="description" role="tab"
                                               data-toggle="tab">Description</a></li>
                    <li role="presentation"><a href="#rules" aria-controls="rules" role="tab"
                                               data-toggle="tab">Rules</a></li>
                    <li role="presentation"><a href="#teams" aria-controls="teams" role="tab"
                                               data-toggle="tab">Teams</a></li>
                    <li role="presentation"><a href="#players" aria-controls="players" role="tab"
                                               data-toggle="tab">Top Players</a></li>
                    <li role="presentation"><a href="#pastchamps" aria-controls="pastchamps" role="tab"
                                               data-toggle="tab">History</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="overview">

                        <table style="font-size: large" class="table table-striped table-hover table-bordered">
                            <tbody>
                            <tr>
                                <td>Game Name</td>
                                <td>
                                    <b>{{ $tournament->game_name }}</b>
                                </td>
                            </tr>
                            <tr>
                                <td>Game Type</td>
                                <td>
                                    <b>{{ $tournament->game_type }}</b>
                                </td>
                            </tr>
                            <tr>
                                <td>Tournament Type</td>
                                <td>
                                    <b>{{ $tournament->getHumanReadableType() }}</b>
                                </td>
                            </tr>
                            <tr>
                                <td>Draw Type</td>
                                <td>
                                    <b>{{ $tournament->getHumanReadableBType() }}</b>
                                </td>
                            </tr>
                            <tr>
                                <td>Rounds per match</td>
                                <td>
                                    <b>{{ $tournament->rounds_per_match }}</b>
                                </td>
                            </tr>
                            <tr>
                                <td>Minimum Participants</td>
                                <td>
                                    <b>{{ $tournament->minimum_participants }} teams</b>
                                </td>
                            </tr>
                            <tr>
                                <td>Maximum Participants</td>
                                <td>
                                    <b>{{ $tournament->maximum_participants }} teams</b>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Applied Participants
                                </td>
                                <td>
                                    <b>{{ $tournament->teams->count() }} teams</b>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Qualified Participants
                                </td>
                                <td>
                                    <b>{{ $tournament->teams()->where('team_status','1')->count() }} teams</b>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                    </div>
                    <div role="tabpanel" class="tab-pane" id="description">
                        <p class="convert-emoji">{!! BBCode::parseCaseInsensitive((htmlentities($tournament->description))) !!}</p>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="rules">
                        <p class="convert-emoji">{!! BBCode::parseCaseInsensitive((htmlentities($tournament->rules))) !!}</p>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="teams">
                        @if($tournament->teams()->where('team_status','1')->count() > 0)
                            <h5 class="text-bold text-green" style="margin:0 0 0 0;border-bottom:1px dashed grey">
                                Qualified Teams</h5>
                            <table id="" class="table table-striped table-hover no-margin">
                                <thead>
                                <tr>
                                    <th class="tooltipster" title="Rank">#</th>
                                    <th class="col-xs-1">Flag</th>
                                    <th class="col-xs-5">Name</th>
                                    <th class="tooltipster" title="Players"><i class="fa fa-users"></i></th>
                                    <th class="tooltipster" title="Joining Status">Status</th>
                                    <th class="col-xs-1 text-right">Win</th>
                                    <th class="col-xs-1 text-right">Lost</th>
                                    <th class="col-xs-1 text-right">Tie</th>
                                    <th class="col-xs-1 text-right">Score</th>
                                    <th class="col-xs-1 text-right tooltipster" title="Win/Lost Index">WLI</th>
                                    @if(Auth::check() && Auth::user()->canManageTournament($tournament) && $tournament->canAlterTeams())
                                        <th class="text-right ">
                                            Action
                                        </th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody id="">
                                @foreach($tournament->teams()->where('team_status','1')->orderby('team_position')->orderBy('points','desc')->get() as $team)
                                    <tr class="item">
                                        <td>{{ $team->team_position }}</td>
                                        <td class="text-muted"><img class="tooltipster"
                                                                    title="{{ $team->country->countryName }}"
                                                                    src="/images/flags/20_shiny/{{ $team->country->countryCode }}.png"
                                                                    alt="" height="22px"></td>
                                        <td class="color-main text-bold"><a
                                                    href="{{ route('tournament.team.show',[$tournament->slug,$team->id]) }}">{{ $team->name }}</a>
                                        </td>
                                        <td> {{ $team->playerselected()->count() ."/". $team->tournament->maxPlayersPerTeam() }} </td>
                                        <td>{!! $team->getColorStatus() !!}</td>
                                        <td class="text-right">{{ $team->total_wins }}</td>
                                        <td class="text-right">{{ $team->total_lost }}</td>
                                        <td class="text-right">{{ $team->total_tie }}</td>
                                        <td class="text-right"><b>{{ $team->total_score or "0" }}</b></td>
                                        <td class="text-right"><b>{{ $team->points or "0" }}</b></td>
                                        @if(Auth::check() && Auth::user()->canManageTournament($tournament) && $tournament->canAlterTeams())
                                            <td class="text-right">
                                                {!! Form::open(['route' => ['tournament.team.handleteams',$tournament->slug,$team->id], 'class' => 'form form-inline']) !!}
                                                {!! Form::hidden('team_id',$team->id) !!}
                                                {!! Form::hidden('action_id',0) !!}
                                                <button title="Send to pending list" type="submit"
                                                        class="tooltipster btn confirm btn-xs btn-primary">
                                                    <i class="fa fa-minus-circle"></i>
                                                </button>
                                            {!! Form::close() !!}
                                        @endif
                                    </tr>
                                    @endforeach
                                            <!--<tr class="item">
                                <td class="text-muted"><img class="tooltipster" title="United States" src="/images/flags/20_shiny/US.png" alt="" height="22px"></td>
                                <td class="color-main text-bold"><a href="http://kos.dev/banlist/13">~ManualIPBan</a></td>
                                <td>11.11.xx.xx</td>
                                <td><a href="http://kos.dev/statistics/player/Kinnngg" class="ainorange">Kinnngg</a></td>
                                <td><b><span class="text-green">Unbanned</span></b></td>
                                <td class="text-right">2 days ago</td>
                            </tr>-->
                                </tbody>
                            </table>
                        @else
                            <div class="text-center alert alert-danger text-bold">No Participants yet! Be the first to
                                join this tournament.
                            </div>
                        @endif


                        <hr>

                        @if($tournament->teams()->where('team_status','!=','1')->count() > 0)
                            <h5 class="text-bold text-danger" style="margin:0 0 0 0;border-bottom:1px dashed grey">
                                Pending Teams</h5>
                            <table id="" class="table table-striped table-hover no-margin">
                                <thead>
                                <tr>
                                    {{--<th class="tooltipster" title="Rank">#</th>--}}
                                    <th class="">Flag</th>
                                    <th class="">Name</th>
                                    <th class="tooltipster" title="Players"><i class="fa fa-users"></i></th>
                                    <th class="col-xs-2 tooltipster" title="Joining Status">Join Status</th>
                                    <th class="col-xs-3 text-right">Team Status</th>
                                    @if(Auth::check() && Auth::user()->canManageTournament($tournament) && $tournament->canAlterTeams())
                                        <th class="text-right ">
                                            Action
                                        </th>
                                    @endif

                                </tr>
                                </thead>
                                <tbody id="">
                                @foreach($tournament->teams()->where('team_status','!=','1')->orderBy('total_score','desc')->get() as $team)
                                    <tr class="item">
                                        {{--<td>{{ $team->team_position }}</td>--}}
                                        <td class="text-muted"><img class="tooltipster"
                                                                    title="{{ $team->country->countryName }}"
                                                                    src="/images/flags/20_shiny/{{ $team->country->countryCode }}.png"
                                                                    alt="" height="22px"></td>
                                        <td class="color-main text-bold"><a
                                                    href="{{ route('tournament.team.show',[$tournament->slug,$team->id]) }}">{{ $team->name }}</a>
                                        </td>
                                        <td> {{ $team->playerselected()->count() ."/". $team->tournament->maxPlayersPerTeam() }} </td>
                                        <td>{!! $team->getColorStatus() !!}</td>
                                        <td class="text-bold text-right">{!! $team->getColorAppr()  !!}</td>

                                        @if(Auth::check() && Auth::user()->canManageTournament($tournament) && $tournament->canAlterTeams())
                                            <td class="text-right">
                                                {!! Form::open(['route' => ['tournament.team.handleteams',$tournament->slug,$team->id], 'class' => 'form form-inline']) !!}
                                                {!! Form::hidden('team_id',$team->id) !!}
                                                {!! Form::hidden('action_id',1) !!}
                                                <button title="Approve team for tournament" type="submit"
                                                        class="tooltipster btn confirm btn-xs btn-success">
                                                    <i class="fa fa-check-circle"></i>
                                                </button>
                                                {!! Form::close() !!}
                                                {!! Form::open(['route' => ['tournament.team.handleteams',$tournament->slug,$team->id], 'class' => 'form form-inline']) !!}
                                                {!! Form::hidden('team_id',$team->id) !!}
                                                {!! Form::hidden('action_id',3) !!}
                                                <button title="Set as Not Eligible" type="submit"
                                                        class="tooltipster btn confirm btn-xs btn-warning">
                                                    <i class="fa fa-exclamation-triangle"></i>
                                                </button>
                                                {!! Form::close() !!}
                                                {!! Form::open(['route' => ['tournament.team.handleteams',$tournament->slug,$team->id], 'class' => 'form form-inline']) !!}
                                                {!! Form::hidden('team_id',$team->id) !!}
                                                {!! Form::hidden('action_id',2) !!}
                                                <button title="Disqualify team" type="submit"
                                                        class="tooltipster btn confirm btn-xs btn-danger">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                                {!! Form::close() !!}
                                            </td>
                                        @endif

                                    </tr>
                                    @endforeach
                                            <!--<tr class="item">
                                <td class="text-muted"><img class="tooltipster" title="United States" src="/images/flags/20_shiny/US.png" alt="" height="22px"></td>
                                <td class="color-main text-bold"><a href="http://kos.dev/banlist/13">~ManualIPBan</a></td>
                                <td>11.11.xx.xx</td>
                                <td><a href="http://kos.dev/statistics/player/Kinnngg" class="ainorange">Kinnngg</a></td>
                                <td><b><span class="text-green">Unbanned</span></b></td>
                                <td class="text-right">2 days ago</td>
                            </tr>-->
                                </tbody>
                            </table>
                        @else

                        @endif
                    </div>
                    <div role="tabpanel" class="tab-pane" id="players">
                        @if($players != null && !$players->isEmpty())
                            <h5 class="text-bold text-green" style="margin:0 0 0 0;border-bottom:1px dashed grey">
                                Top Players</h5>
                            <table id="" class="table table-striped table-hover no-margin">
                                <thead>
                                <tr>
                                    <th class="tooltipster" title="Rank">#</th>
                                    <th class="col-xs-1">Flag</th>
                                    <th class="col-xs-4">Name</th>
                                    <th class="tooltipster">Team</th>
                                    <th class="col-xs-1 text-right">Score</th>
                                </tr>
                                </thead>
                                <tbody id="{{ $i = 1 }}">
                                @foreach($players as $player)
                                    <tr class="item">
                                        <td>{{ $i++ }}</td>
                                        <td class="text-muted"><img class="tooltipster" title="{{ $player->country->countryName }}" src="/images/flags/20_shiny/{{ $player->country->countryCode }}.png" alt="" height="22px"></td>
                                        <td class="color-main text-bold">
                                            <a class="" style="margin-right:1em" href="{{ route('user.show',$player->username) }}">
                                                <strong class="">{{ $player->displayName() }}</strong>
                                            </a>
                                        </td>
                                        <span id="{{ $team = $player->getTeamOfUserForTournament($tournament) }}"></span>
                                        <td class="text-muted"><img class="tooltipster"
                                                                    title="{{ $team->country->countryName }}"
                                                                    src="/images/flags/20_shiny/{{ $team->country->countryCode }}.png"
                                                                    alt="" height="22px">
                                            <a class="ainorange" href="{{ route('tournament.team.show',[$tournament->slug,$team->id]) }}">{{ $team->name }}</a>
                                        </td>
                                        <td class="text-right"><b>{{ $player->pivot->total_score }}</b></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="text-center alert alert-warning text-bold">No Player to Show
                            </div>
                        @endif
                    </div>

                    <div role="tabpanel" class="tab-pane" id="pastchamps">
                        <div class="text-center alert alert-warning text-bold"><i>No History for this tournament!</i>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-xs-4">
            <img src="/uploaded_images/{{ $tournament->photo->url }}" class="img img-thumbnail" alt="">

            <hr>
            @if(Auth::check() && $tournament->isRegistrationOpen()==1)
                @if(Auth::user()->isAppliedForTournament($tournament))
                    <p>Your Team :
                        <b>{!! link_to_route('tournament.team.show',Auth::user()->getTeamOfUserForTournament($tournament)->name,[$tournament->slug,Auth::user()->getTeamOfUserForTournament($tournament)->id])  !!}</b>
                        <br>
                    <span class="small">Your Status &nbsp;&nbsp;: <b>{!! Auth::user()->getAppliedTeamStatusWithColor($tournament,Auth::user()->getTeamOfUserForTournament($tournament))  !!}</b>
                </span>
                    </p>
                    <a class="btn btn-danger confirm btn-block" href="{{ route('tournament.leave',$tournament->id) }}">Leave
                        this Tournament</a>
                @else
                    <a class="btn btn-info btn-block" href="{{ route('tournament.apply',$tournament->slug) }}">Join this
                        Tournament</a>
                    <br>
                    <span class="small text-info">Please read the rules & eligibility criteria before applying.</span>
                @endif

            @elseif(Auth::check() && $tournament->isRegistrationOpen()==2)
                <span class="text-info">Registrations will begin <b>{{ $tournament->registration_starts_at->diffForHumans() }}</b></span>
            @elseif(Auth::check() && $tournament->isRegistrationOpen()==3)
                <p class="text-danger">Registration ended
                    <b>{{ $tournament->registration_ends_at->diffForHumans() }}</b></p>
                @if(Auth::user()->isAppliedForTournament($tournament))
                    <p>Your Team :
                        <b>{!! link_to_route('tournament.team.show',Auth::user()->getTeamOfUserForTournament($tournament)->name,[$tournament->slug,Auth::user()->getTeamOfUserForTournament($tournament)->id])  !!}</b>
                        <br>
                    <span class="small">Your Status &nbsp;&nbsp;: <b>{!! Auth::user()->getAppliedTeamStatusWithColor($tournament,Auth::user()->getTeamOfUserForTournament($tournament))  !!}</b>
                </span>
                    </p>
                @endif
            @elseif(Auth::check() && $tournament->isRegistrationOpen()==4)
                <span class="text-danger">Tournament has been <b>disabled</b> by Super Admin</span>
            @elseif(Auth::check() && $tournament->isRegistrationOpen()==5)
                @if($tournament->minimum_participants > $tournament->teams()->qualified()->count())
                    <p class="text-warning">Tournament has been <b>Postponed</b>.</p>
                @else
                    <p class="text-green">Tournament has begun
                        <b>{{ $tournament->tournament_starts_at->diffForHumans() }}</b></p>
                @endif

                @if(Auth::user()->isAppliedForTournament($tournament))
                    <p>Your Team :
                        <b>{!! link_to_route('tournament.team.show',Auth::user()->getTeamOfUserForTournament($tournament)->name,[$tournament->slug,Auth::user()->getTeamOfUserForTournament($tournament)->id])  !!}</b>
                        <br>
                    <span class="small">Your Status &nbsp;&nbsp;: <b>{!! Auth::user()->getAppliedTeamStatusWithColor($tournament,Auth::user()->getTeamOfUserForTournament($tournament))  !!}</b>
                </span>
                    </p>
                @endif
            @elseif(Auth::check() && $tournament->isRegistrationOpen()==6)
                <p class="text-warning">Tournament has ended
                    <b>{{ $tournament->tournament_ends_at->diffForHumans() }}</b></p>
                @if(Auth::user()->isAppliedForTournament($tournament))
                    <p>Your Team :
                        <b>{!! link_to_route('tournament.team.show',Auth::user()->getTeamOfUserForTournament($tournament)->name,[$tournament->slug,Auth::user()->getTeamOfUserForTournament($tournament)->id])  !!}</b>
                        <br>
                    <span class="small">Your Status &nbsp;&nbsp;: <b>{!! Auth::user()->getAppliedTeamStatusWithColor($tournament,Auth::user()->getTeamOfUserForTournament($tournament))  !!}</b>
                </span>
                    </p>
                @endif
            <div class="well text-center">
                <p style="font-size: 20px"><b><span style="color: green;">Winner</span> <a href="kos-alpha-tournament/team/4">{{ $tournament->winnerteam->name }}</a></b></p>
                <p style="font-size: 15px"><b><span style="color: lawngreen">Runner</span> <a href="kos-alpha-tournament/team/6">{{ $tournament->secondteam->name }}</a></b></p>
            </div>
            @endif

            <hr>
            @if($tournament->managers->isEmpty())
                <span class="small">No Managers</span>
            @else
                <table id="" class="table table-striped table-bordered table-hover no-margin">
                    <thead>
                    <tr>
                        <th class="">Flag</th>
                        <th class="col-xs-8">Manager</th>
                        <th class="col-xs-4 text-right">Seen</th>
                    </tr>
                    </thead>
                    <tbody id="">
                    @foreach($tournament->managers as $user)
                        <tr class="item">
                            <td class="text-muted"><img class="tooltipster" title="{{ $user->country->countryName }}"
                                                        src="/images/flags/20_shiny/{{ $user->country->countryCode }}.png"
                                                        alt="" height="22px"></td>
                            <td class="color-main text-bold">
                                <a class="" style="margin-right:1em" href="{{ route('user.show',$user->username) }}">
                                    <strong class="">{{ $user->displayName() }}</strong>
                                </a>
                            </td>
                            <td class="text-right" style="font-size: 12px">
                                {{ $user->updated_at->diffForHumans() }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif

        </div>
</div>

        <div class="col-xs-12" style="border: 2px solid lightgrey;margin-top: 15px;">
            <div role="tabpanel" class="" id="bracket">
                <h3 style="border-bottom: 2px dashed lightgrey">Draw</h3>
                @if($tournament->canShowBrackets())
                    <a class="btn btn-sm btn-info pull-right"
                       href="{{ route('tournament.bracket.show',$tournament->slug) }}">View Full Draw</a>
                    @if($tournament->bracket_type == 0)
                        @foreach($tournament->rounds as $round)
                            <h4 style="padding: 10px;background-color: #e2e2e2;">
                                Round {{ $round->round_index }}</h4>
                            @foreach($round->matches as $match)
                                <div class="media">
                                    <div class="media-body" style="font-size: 80%">
                                        {{--<h4 class="">
                                            <a href="{{ route('tournament.show',$tournament->slug) }}">{{ $tournament->name }}</a>
                                        </h4>--}}
                                        <div class="col-xs-12 no-padding media-heading text-center">
                                            <div class="col-xs-3 no-padding vs">
                                                <div class="team-name text-bold">
                                                    {!! link_to_route('tournament.team.show',$match->team1->name,[$tournament->slug,$match->team1->id])  !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-3" style="border-right: 5px solid dodgerblue">
                                                <div class="team-name text-bold">
                                                    {!! link_to_route('tournament.team.show',$match->team2->name,[$tournament->slug,$match->team2->id])  !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-2">
                                                <img src="/images/flags/20_shiny/{{ $match->team1->country->countryCode.".png" }}"
                                                     alt="" class="img tooltipster"
                                                     title="{{ $match->team1->country->countryName }}">
                                                <img src="/images/flags/20_shiny/{{ $match->team2->country->countryCode.".png" }}"
                                                     alt="" class="img tooltipster"
                                                     title="{{ $match->team2->country->countryName }}">

                                                <div class="team-name small">{{ $match->starts_at->toDayDateTimeString() }}</div>
                                            </div>
                                            @if($match->has_been_played)
                                                <div class="col-xs-4">
                                                    {!! $match->getWinningTextForHumans() !!}
                                                    <br>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                    @elseif($tournament->bracket_type == 1)
                        <div class="dd-bracket col-xs-12">
                            <iframe src="{{ $tournament->challonge_src }}/module?match_width_multiplier=1.1" width="100%" height="500" frameborder="0" scrolling="auto" allowtransparency="true"></iframe>
                        </div>
                    @endif
                @else
                    <div class="text-center alert alert-danger text-bold">Draw is not available at this
                        time.
                    </div>
                @endif
            </div>
        </div>

    </div>

    @if(Auth::check())
        <div class="media comment-media panel padding10">
            <div class="pull-left">
                {!! Html::image(Auth::user()->getGravatarLink(40),'',array('class'=>'img media-oject inprofile-thumbs','width'=>'40','height'=>'40')) !!}
            </div>

            @if(Auth::user()->muted)
                <form class="comment-create-form media-body">
                    <textarea name="" id="muted" cols="5" rows="2" class="form-control comment-textarea no-margin"
                              placeholder="You are muted because of your behaviors" disabled></textarea>
                </form>
            @else
                {!! Form::open(['route' => ['tournament.comment',$tournament->id], 'class'=>'comment-create-form media-body']) !!}
                {!! Form::textarea('body', null, ['placeholder' => 'Your comment here', 'class' => 'form-control comment-textarea no-margin', 'rows' => 2, 'cols' => 5]) !!}
                {!! Form::submit('Comment',['class' => 'btn btn-xs btn-default right comment-create-form-submit']) !!}
                {!! Form::close() !!}
            @endif
        </div>
    @endif

    <div class="comments-container" id="data-items">
        @foreach($render = $tournament->comments()->latest()->paginate() as $comment)
            <div class="media comment-media panel padding10 item">
                <div class="pull-left">
                    {!! Html::image($comment->user->getGravatarLink(50),'',array('class'=>'img media-oject inprofile-thumbs','width'=>'50','height'=>'50')) !!}
                </div>
                <div class="media-body" style="font-size: 14px;word-break: break-all;">
                    @if(Auth::check() && (Auth::user()->isAdmin() || Auth::user()->id == $comment->user_id))
                        <span class="pull-right">
                                    {!! Form::open(['method' => 'delete','route' => ['comment.destroy',$comment->id],'class' => 'pull-right']) !!}
                            <button type="submit" class="tooltipster confirm submit btn-link"
                                    title="Delete Comment"><i class="fa fa-times"></i></button>
                            {!! Form::close() !!}
                                </span>
                    @endif
                    <p class="no-margin convert-emoji">
                        <b >
                            <a class="{{ "color-".$comment->user->roles()->first()->name }}" href="{{ route('user.show',$comment->user->username) }}">{{ $comment->user->displayName() }}</a>
                        </b>
                    </p>
                    <p class="no-margin text-muted small">{{ $comment->created_at->diffForHumans() }}</p>
                    <p>{!! $comment->showBody() !!}</p>
                </div>
            </div>
        @endforeach
    </div>
    {!! $render->appends(Request::except('page'))->render() !!}
    <div id="loading" class="text-center"></div>
@endsection