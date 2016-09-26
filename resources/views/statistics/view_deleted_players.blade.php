@extends('layouts.main')
@section('meta-desc',"List of all Deleted players.")
@section('title',"Deleted Players")

@section('main-container')
    <div class="col-xs-9">

        <div class="rounds panel panel-default">
            <div class="panel-heading"><strong>Deleted Players ({{ App\DeletedPlayer::count() }})</strong></div>
            <div class="panel-body">
                <table id="" class="table table-striped table-hover no-margin">
                    <thead>
                    <tr>
                        <th class="col-xs-3">Name</th>
                        <th class="col-xs-3">Reason</th>
                        <th class="col-xs-2">Deleted By</th>
                        <th class="col-xs-2 text-right">Deleted At</th>
                        @if(Auth::check() && Auth::user()->isAdmin())
                        <th class="col-xs-1"></th>
                        @endif
                    </tr>
                    </thead>
                    <tbody id="data-items">
                    @forelse($players as $player)
                        <tr class="item">
                            <td class="color-main text-bold">{{ $player->player_name }}</td>
                            <td class="tooltipster" title="{{ $player->reason }}">{{ str_limit($player->reason,25) }}</td>
                            <td class="color-main text-bold">
                                <a class="" style="margin-right:1em" href="{{ route('user.show',$player->creator->username) }}">
                                    <strong class="">{{ $player->creator->displayName() }}</strong>
                                </a>
                            </td>
                            <td class="text-right">{{ $player->created_at->diffForHumans() }}</td>
                            @if(Auth::check() && Auth::user()->isAdmin())
                            <td>
                                {!! Form::open(['route' => ['undelete-player',urlencode($player->player_name)]]) !!}
                                {!! Form::hidden('player_name',$player->name) !!}
                                <button class="btn btn-xs btn-primary confirm tooltipster" title="Undelete" type="submit">Undo</button>
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