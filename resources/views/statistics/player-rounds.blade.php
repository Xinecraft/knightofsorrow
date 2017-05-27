@extends('layouts.main')
@section('meta-desc',"All Rounds Played by $player->name")
@section('title',"Rounds of ".$player->name)
@section('styles')
    <style>
        .text-points
        {
            font-weight:normal !important;
            font-style:italic !important;
        }
        .alert-inactive
        {
            padding: 5px;
            margin-bottom: 15px;
            border: 1px solid rgb(255, 0, 0);
            border-radius: 0px !important;
            background: rgba(255, 97, 97, 0.17);
            color: #a70000;
            text-align: center;
        }
        .guagecan{
            width: 8em !important;
            height: auto !important;
        }
    </style>
@endsection

@section('main-container')
    <div class="col-xs-9">
        @include('partials._statistics-navbar')
        <div class="row well player-detail-summary no-margin">
            <div class="col-xs-3">
                <img class="left img-thumbnail" src="/images/game/chars/50/{{ $player->last_team."_".$player->loadout->body."_".$player->loadout->head }}.jpg">
                {!! $player->ownerWithPicture !!}
            </div>
            <div class="col-xs-6 text-center player-detail-summary-name">
                <div class="name-as-title">
                    {{ $player->name }}
                </div>
                <p class="small pad5">
                    @forelse($player->aliases()->whereNotIn('name',\App\DeletedPlayer::lists('player_name'))->limit(5)->get() as $alias)
                        @unless($player->name == $alias->name)
                            <a href="{{  route('player-detail',$alias->name) }}">{{ $alias->name }}</a>
                        @endunless
                    @empty

                    @endforelse
                </p>
            </div>
            <div class="col-xs-3 text-right">
                {!! Html::image('/images/flags_new/flags-iso/shiny/64/'.$player->country->countryCode.".png",$player->country->countryCode,['title' => $player->country->countryName, 'class'=> 'tooltipster']) !!}
            </div>
        </div>

        @unless((\Carbon\Carbon::now()->timestamp - $player->lastGame->updated_at->timestamp) <= 60*60*24*7)
            <p class="alert alert-danger alert-inactive">
                <b>{{ $player->name }}</b> is not seen playing this week!
            </p>
        @endunless

        <div class="rounds panel panel-default">
                <div class="panel-heading"><strong><em>{{ $rounds->total() }}</em> Rounds played by {{ $player->name }}</strong></div>
            <div class="panel-body">
                <table id="" class="table table-striped table-hover no-margin">
                    <thead>
                    <tr>
                        <th class="col-xs-1">{!! sort_rounds_by('id','Round') !!}</th>
                        <th class="col-xs-2">{!! sort_rounds_by('round_time','Time') !!}</th>
                        <th class="col-xs-1">{!! sort_rounds_by('swat_score','Swat') !!}</th>
                        <th class="col-xs-2">{!! sort_rounds_by('suspects_score','Suspects') !!}</th>
                        <th class="">{!! sort_rounds_by('map_id','Map') !!}</th>
                        <th class="col-xs-2 text-right">{!! sort_rounds_by('created_at','Date') !!}</th>
                    </tr>
                    </thead>
                    <tbody id="data-items" class="roundstabledata">
                    @foreach($rounds as $round)
                        <tr class="item pointer-cursor" data-id="{{ $round->id }}">
                            @if($round->server_id == null)
                                <td class="color-main text-bold">{!! link_to_route('round-detail',$round->index,[$round->id]) !!}</td>
                            @else
                                <td class="color-main text-bold">{!! link_to_route('war-round-detail',$round->index,[$round->id]) !!}</td>
                            @endif
                            <td class="text-muted">{{ $round->time }}</td>
                            <td>{!! $round->swatScoreWithColor !!}</td>
                            <td>{!! $round->suspectsScoreWithColor !!}</td>
                            <td>{{ $round->mapName }}</td>
                            <td class="text-right tooltipster" title="{{ $round->timeDDTS }}">{{ $round->timeAgo }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {!! $rounds->appends(Request::except('page'))->render() !!}
            <div id="loading" class="text-center"></div>
        </div>

    </div>
@endsection