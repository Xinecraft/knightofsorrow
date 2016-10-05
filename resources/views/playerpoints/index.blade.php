@extends('layouts.main')
@section('meta-desc',"List of all players who are awarded extra points.")
@section('title',"Player with Extra Points")

@section('main-container')
    <div class="col-xs-9">

        <div class="rounds panel panel-default">
            <div class="panel-heading"><strong>Points Awarded Players ({{ App\PlayerPoint::count() }})</strong></div>
            <div class="panel-body">
                <table id="" class="table table-striped table-hover no-margin">
                    <thead>
                    <tr>
                        <th class="col-xs-3">Name</th>
                        <th class="col-xs-1">Points</th>
                        <th class="col-xs-3">Reason</th>
                        <th class="col-xs-2">Awarded By</th>
                        <th class="col-xs-2 text-right">Awarded At</th>
                        @if(Auth::check() && Auth::user()->isAdmin())
                            <th class="col-xs-1"></th>
                        @endif
                    </tr>
                    </thead>
                    <tbody id="data-items">
                    @forelse($players as $player)
                        <tr class="item">
                            <td class="color-main text-bold">{!! link_to_route('player-detail',$player->name,$player->name)   !!}</td>
                            <td class="text-bold">{!! $player->points < 0 ?  "<span class='text-danger'>".$player->points."</span>" : "<span class='text-green'>".$player->points."</span>" !!}</td>
                            <td class="tooltipster" title="{{ $player->reason }}">{{ str_limit($player->reason,25) }}</td>
                            <td class="color-main text-bold">
                                <a class="" style="margin-right:1em" href="{{ route('user.show',$player->admin->username) }}">
                                    <strong class="">{{ $player->admin->displayName() }}</strong>
                                </a>
                            </td>
                            <td class="text-right">{{ $player->created_at->diffForHumans() }}</td>
                            @if(Auth::check() && Auth::user()->isAdmin())
                                <td>
                                    {!! Form::open(['route' => ['delete-playerpoints',urlencode($player->id)]]) !!}
                                    {!! Form::hidden('p_id',$player->id) !!}
                                    <button class="btn btn-xs btn-danger confirm tooltipster" title="Delete" type="submit">Delete</button>
                                    {!! Form::close() !!}
                                </td>
                            @endif
                        </tr>
                    @empty
                        <h1>Nothing in here :(</h1>
                    @endforelse
                    </tbody>
                </table>
            </div>
            {!! $players->appends(Request::except('page'))->render() !!}
            <div id="loading" class="text-center"></div>
        </div>

    </div>
@endsection