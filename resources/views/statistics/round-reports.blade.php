@extends('layouts.main')
@section('meta-desc',"List of all rounds played.")
@section('title',"Round Reports")

@section('main-container')
    <div class="col-xs-9">
        @include('partials._statistics-navbar')

        @if(Request::route()->uri() == 'statistics/war-round-reports')
            <div style="background: #090b0a" class="text-center alert text-bold"><span style="color: deeppink">War Server</span> <span style="color: red">(Antics)</span></div>
        @endif

        <div class="rounds panel panel-default">
            @if(Request::route()->uri() == 'statistics/war-round-reports')
                <div class="panel-heading"><strong>Total <em>{{ App\Game::whereNotNull('server_id')->count() }}</em> Rounds Reports</strong></div>
            @else
                <div class="panel-heading"><strong>Total <em>{{ App\Game::whereNull('server_id')->count() }}</em> Rounds Reports</strong></div>
            @endif
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