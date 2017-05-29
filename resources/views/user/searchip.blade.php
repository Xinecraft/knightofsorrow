@extends('layouts.main')
@section('title', 'Search Player with IP for admins')
@section('main-container')
    <div class="content col-xs-9">
        <div class="row">
            <div class="col-xs-10 col-xs-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Search Player via IP</div>
                    <div class="panel-body">

                        {!! Form::open(['class' => 'form-horizontal form']) !!}
                        <div class="form-group{{ $errors->has('ipaddr') ? ' has-error' : '' }}">
                            {!! Form::label('ipaddr', 'Enter IP or Name', ['class' => 'col-xs-4 control-label'])  !!}
                            <div class="col-xs-6">
                                {!! Form::text('ipaddr',null,['class' => 'form-control'])  !!}
                                @if ($errors->has('ipaddr'))
                                    <span class="help-block">
                                <strong>{{ $errors->first('ipaddr') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-6 col-xs-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Search
                                </button>
                            </div>
                        </div>
                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>

        @if(Session::has('post-back'))
            <div class="rounds panel panel-default">
                <div class="panel-heading"><strong>Search Results ({{ $players->count() }})</strong></div>
                <div class="panel-body">
                    <table id="" class="table table-striped table-hover no-margin">
                        <thead>
                        <tr>
                            <th class="col-xs-1">{!! sort_players_by('country_id','Flag') !!}</th>
                            <th class="col-xs-4">{!! sort_players_by('name','Name') !!}</th>
                            <th class="col-xs-1">{!! sort_players_by('game_id','Round No') !!}</th>
                            <th class="col-xs-2">{!! sort_players_by('created_at','Seen At') !!}</th>
                            <th class="col-xs-2 text-right">{!! sort_players_by('ip_address','IP Address') !!}</th>
                        </tr>
                        </thead>
                        <tbody id="data-items">
                        @foreach($players as $player)
                            <tr class="item">
                                <td class="text-muted"><img class="tooltipster" title="{{ $player->country->countryName }}" src="{{ "/images/flags/20_shiny/".$player->country->countryCode.".png" }}" alt="" height="22px"/></td>
                                <td class="color-main text-bold">{!! link_to_route('player-detail', $player->name, [$player->name]) !!}</td>
                                <td>{!! link_to_route('round-detail',$player->game_id,[$player->game_id]) !!}</td>
                                <td class="tooltipster" title="{{ $player->created_at->toDayDateTimeString() }}">{{ $player->created_at->diffForHumans() }}</td>
                                <td class="text-right">{{ $player->ip_address }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{--{!! $players->appends(Request::except('page'))->render() !!}
                <div id="loading" class="text-center"></div>--}}
            </div>
        @endif
    </div>
@endsection
