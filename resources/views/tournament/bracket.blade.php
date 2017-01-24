@extends('layouts.main')
@section('title',$tournament->name." Bracket")
@section('styles')
    <style>
        .tab-pane
        {
            padding: 10px;
        }
        .form.form-inline
        {
            display: inline-block;
        }
        .vs:before
        {
            content: 'vs';
            font-size: 25px;
            float: right;
            color: #03A9F4;
        }
        .team-name
        {
            padding: 10px !important;
        }
        .team-name.small
        {
            padding: 5px !important;
        }
        .font125p
        {
            font-size:125% !important;
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
            border: 2px grey dashed;
        }
    </style>
@endsection

@section('before-container')
    <div class="header wg-primary">
        <div class="container">
            <h1 class="ng-binding text-center"><a href="{{ route('tournament.show',$tournament->slug) }}">{{ $tournament->name }}</a> Bracket</h1>

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
    <div class="col-xs-12 panel padding10">

        <div class="tab-pane" id="teams">
            @if($tournament->teams()->where('team_status','1')->count() > 0)
                <h4 class="text-bold text-green" style="margin:0 0 0 0;padding: 10px 0;border-bottom:1px dashed grey">Participating Teams</h4>
                <table id="" class="table table-striped table-hover font125p">
                    <thead>
                    <tr>
                        <th class="tooltipster" title="Rank">#</th>
                        <th class="col-xs-1">Flag</th>
                        <th class="col-xs-5">Name</th>
                        <th class="tooltipster" title="Players"><i class="fa fa-users"></i></th>
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
                            <td class="text-muted"><img class="tooltipster" title="{{ $team->country->countryName }}" src="/images/flags/20_shiny/{{ $team->country->countryCode }}.png" alt="" height="22px"></td>
                            <td class="color-main text-bold"><a href="{{ route('tournament.team.show',[$tournament->slug,$team->id]) }}">{{ $team->name }}</a></td>
                            <td> {{ $team->playerselected()->count() ."/". $team->tournament->maxPlayersPerTeam() }} </td>
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
                                    <button title="Send to pending list" type="submit" class="tooltipster btn confirm btn-xs btn-primary">
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
                <div class="text-center alert alert-danger text-bold">No Participants yet! Be the first to join this tournament.</div>
            @endif


            <hr>

            @if($tournament->teams()->where('team_status','!=','1')->count() > 0 && Auth::check() && Auth::user()->canManageTournament($tournament))
                <h5 class="text-bold text-danger" style="margin:0 0 0 0;border-bottom:1px dashed grey">Pending Teams</h5>
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
                            <td class="text-muted"><img class="tooltipster" title="{{ $team->country->countryName }}" src="/images/flags/20_shiny/{{ $team->country->countryCode }}.png" alt="" height="22px"></td>
                            <td class="color-main text-bold"><a href="{{ route('tournament.team.show',[$tournament->slug,$team->id]) }}">{{ $team->name }}</a></td>
                            <td> {{ $team->playerselected()->count() ."/". $team->tournament->maxPlayersPerTeam() }} </td>
                            <td>{!! $team->getColorStatus() !!}</td>
                            <td class="text-bold text-right">{!! $team->getColorAppr()  !!}</td>

                            @if(Auth::check() && Auth::user()->canManageTournament($tournament) && $tournament->canAlterTeams())
                                <td class="text-right">
                                    {!! Form::open(['route' => ['tournament.team.handleteams',$tournament->slug,$team->id], 'class' => 'form form-inline']) !!}
                                    {!! Form::hidden('team_id',$team->id) !!}
                                    {!! Form::hidden('action_id',1) !!}
                                    <button title="Approve team for tournament" type="submit" class="tooltipster btn confirm btn-xs btn-success">
                                        <i class="fa fa-check-circle"></i>
                                    </button>
                                    {!! Form::close() !!}
                                    {!! Form::open(['route' => ['tournament.team.handleteams',$tournament->slug,$team->id], 'class' => 'form form-inline']) !!}
                                    {!! Form::hidden('team_id',$team->id) !!}
                                    {!! Form::hidden('action_id',3) !!}
                                    <button title="Set as Not Eligible" type="submit" class="tooltipster btn confirm btn-xs btn-warning">
                                        <i class="fa fa-exclamation-triangle"></i>
                                    </button>
                                    {!! Form::close() !!}
                                    {!! Form::open(['route' => ['tournament.team.handleteams',$tournament->slug,$team->id], 'class' => 'form form-inline']) !!}
                                    {!! Form::hidden('team_id',$team->id) !!}
                                    {!! Form::hidden('action_id',2) !!}
                                    <button title="Disqualify team" type="submit" class="tooltipster btn confirm btn-xs btn-danger">
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

        <div class="tab-pane" id="bracket">
            @if($tournament->canShowBrackets())
                @if($tournament->bracket_type == 0)
                @foreach($tournament->rounds as $round)
                    <h4 style="padding: 10px;background-color: #e2e2e2;">Round {{ $round->round_index }}</h4>
                    @foreach($round->matches as $match)
                        <div class="media">
                            <div class="media-body">
                                {{--<h4 class="">
                                    <a href="{{ route('tournament.show',$tournament->slug) }}">{{ $tournament->name }}</a>
                                </h4>--}}
                                <div class="col-xs-12 no-padding media-heading text-center">
                                    <div class="col-xs-1">

                                    </div>

                                    <div class="col-xs-1">
                                        <img src="/images/flags/20_shiny/{{ $match->team1->country->countryCode.".png" }}" alt="" class="img tooltipster" title="{{ $match->team1->country->countryName }}">
                                        <br>vs<br>
                                        <img src="/images/flags/20_shiny/{{ $match->team2->country->countryCode.".png" }}" alt="" class="img tooltipster" title="{{ $match->team2->country->countryName }}">
                                    </div>

                                    <div class="col-xs-4">
                                        <div class="text-bold">
                                            {!! link_to_route('tournament.team.show',$match->team1->name,[$tournament->slug,$match->team1->id])  !!}
                                        </div>
                                        vs
                                        <div class="text-bold">
                                            {!! link_to_route('tournament.team.show',$match->team2->name,[$tournament->slug,$match->team2->id])  !!}
                                        </div>
                                    </div>

                                    <div class="col-xs-3" style="border-left: 5px solid dodgerblue;border-right: 5px solid dodgerblue">
                                        <div class="">
                                            <p>Venue: <b>War Server</b><br>
                                                {{ $match->starts_at->toDayDateTimeString() }}<br>
                                                <small>({{ $match->starts_at->diffForHumans() }})</small>
                                            </p>
                                        </div>
                                    </div>

                                    @if(Auth::check() && Auth::user()->canManageTournament($tournament) && !$match->has_been_played)
                                        <div class="col-xs-3">
                                            <a class="btn btn-warning confirm" href="{{ route('tournament.match.getcalculate',[$tournament->slug,$match->id]) }}">Calculate</a>
                                        </div>
                                    @endif

                                    @if($match->has_been_played)
                                        <div class="col-xs-3">
                                            {!! $match->getWinningTextForHumans() !!}
                                            <br>
                                            <a class="btn btn-xs btn-info" href="{{ route('tournament.match.show',[$tournament->slug,$match->id]) }}">View Details</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <hr class="no-margin">
                    @endforeach
                @endforeach
                @elseif($tournament->bracket_type == 1)
                    <iframe src="{{ $tournament->challonge_src }}/module?multiplier=1.0&match_width_multiplier=1.1" width="100%" height="500" frameborder="0" scrolling="auto" allowtransparency="true"></iframe>
                    <div class="col-xs-12">
                        <h4 style="padding: 10px;background-color: #e2e2e2;">Matches:</h4>
                    @foreach($tournament->matches()->get() as $match)
                        <div class="media">
                            <div class="media-body">
                                {{--<h4 class="">
                                    <a href="{{ route('tournament.show',$tournament->slug) }}">{{ $tournament->name }}</a>
                                </h4>--}}
                                <div class="col-xs-12 no-padding media-heading text-center">
                                    <div class="col-xs-1" style="font-size: 3em;color: lightgray;">
                                        {{ ++$match->match_index }}
                                    </div>

                                    <div class="col-xs-1">
                                        @if($match->team1 != null)
                                            <img src="/images/flags/20_shiny/{{ $match->team1->country->countryCode.".png" }}" alt="" class="img tooltipster" title="{{ $match->team1->country->countryName }}">
                                        @else
                                            <img src="/images/flags/20_shiny/_unknown.png" alt="" class="img tooltipster" title="To be Announced">
                                        @endif
                                        <br>vs<br>
                                        @if($match->team2 != null)
                                            <img src="/images/flags/20_shiny/{{ $match->team2->country->countryCode.".png" }}" alt="" class="img tooltipster" title="{{ $match->team2->country->countryName }}">
                                        @else
                                            <img src="/images/flags/20_shiny/_unknown.png" alt="" class="img tooltipster" title="To be Announced">
                                        @endif
                                    </div>

                                    <div class="col-xs-4">
                                        <div class="text-bold">
                                            @if($match->team1 != null)
                                            {!! link_to_route('tournament.team.show',$match->team1->name,[$tournament->slug,$match->team1->id])  !!}
                                            @else
                                                <i>TBA</i>
                                            @endif
                                        </div>
                                        vs
                                        <div class="text-bold">
                                            @if($match->team2 != null)
                                            {!! link_to_route('tournament.team.show',$match->team2->name,[$tournament->slug,$match->team2->id]) !!}
                                            @else
                                                <i>TBA</i>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-xs-3" style="border-left: 5px solid dodgerblue;border-right: 5px solid dodgerblue">
                                        <div class="">
                                            <p>Venue: <b>War Server</b><br>
                                                {{ $match->starts_at->toDayDateTimeString() }}<br>
                                                <small>({{ $match->starts_at->diffForHumans() }})</small>
                                            </p>
                                        </div>
                                    </div>

                                    @if(Auth::check() && Auth::user()->canManageTournament($tournament) && !$match->has_been_played && $match->team1 != null && $match->team2 != null)
                                        <div class="col-xs-3">
                                            <a class="btn btn-warning confirm" href="{{ route('tournament.match.getcalculate',[$tournament->slug,$match->id]) }}">Calculate</a>
                                        </div>
                                    @endif


                                    @if($match->has_been_played)
                                        <div class="col-xs-3">
                                            {!! $match->getWinningTextForHumans() !!}
                                            <br>
                                            <a class="btn btn-xs btn-info" href="{{ route('tournament.match.show',[$tournament->slug,$match->id]) }}">View Details</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <hr class="no-margin">
                    @endforeach
                    </div>
                @endif
            @else
                <div class="text-center alert alert-danger text-bold">Bracket is not available at this time.</div>
            @endif
        </div>

    </div>
@endsection