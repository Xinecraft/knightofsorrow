@extends('layouts.main')
@section('meta-desc',"List of all rounds played.")
@section('title',"Round Reports")

@section('main-container')
    <div class="col-md-9">
        @include('partials._statistics-navbar')
        <div class="rounds panel panel-default">
            <div class="panel-heading"><strong>Total <em>{{ App\Game::count() }}</em> Rounds Reports</strong></div>
            <div class="panel-body">
                <table id="" class="table table-striped table-hover no-margin">
                    <thead>
                    <tr>
                        <th class="col-md-1">{!! sort_rounds_by('id','Round') !!}</th>
                        <th class="col-md-2">{!! sort_rounds_by('round_time','Time') !!}</th>
                        <th class="col-md-1">{!! sort_rounds_by('swat_score','Swat') !!}</th>
                        <th class="col-md-2">{!! sort_rounds_by('suspects_score','Suspects') !!}</th>
                        <th class="">{!! sort_rounds_by('map_id','Map') !!}</th>
                        <th class="col-md-2 text-right">{!! sort_rounds_by('created_at','Date') !!}</th>
                    </tr>
                    </thead>
                    <tbody id="data-items" class="roundstabledata">
                    @foreach($rounds as $round)
                        <tr class="item pointer-cursor" data-id="{{ $round->id }}">
                            <td class="color-main text-bold">{!! link_to_route('round-detail',$round->id,[$round->id]) !!}</td>
                            <td class="text-muted">{{ $round->time }}</td>
                            <td>{!! $round->swatScoreWithColor !!}</td>
                            <td>{!! $round->suspectsScoreWithColor !!}</td>
                            <td>{{ $round->mapName }}</td>
                            <td class="text-right">{{ $round->timeAgo }}</td>
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