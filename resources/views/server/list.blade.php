@extends('layouts.main')
@section('main-container')
    <div class="content col-xs-9">

        <div class="rounds panel panel-default">
            <div class="panel-heading"><strong>All SWAT4 Servers</strong></div>
            <div class="panel-body">
                <table id="" class="table table-striped table-hover no-margin">
                    <thead>
                    <tr>
                        <th class="col-xs-3">Name</th>
                        <th class="col-xs-1">Players</th>
                        <th class="col-xs-3">Gametype</th>
                        <th class="col-xs-3">Map</th>
                        <th class="col-xs-2">IP</th>
                        <th class="col-xs-1 text-right">Ver</th>
                    </tr>
                    </thead>
                    <tbody id="data-items">
                    @forelse($servers as $server)
                        <tr class="item">
                            <td class="color-main text-bold"><a href="{{ route('servers.show',[$server->id]) }}">{!! $server->hostname !!}</a></td>
                            <td>{{ $server->players_current."/".$server->players_max }}</td>
                            <td>{{ $server->gametype }}</td>
                            <td>{{ $server->map }}</td>
                            <td>{{ $server->ip_address.":".$server->join_port }}</td>
                            <td class="text-right">{{ $server->version }}</td>
                        </tr>
                    @empty
                        <th>No Server Online</th>
                    @endforelse
                    </tbody>
                </table>
            </div>
            {!! $page->render() !!}
            <div id="loading" class="text-center"></div>
        </div>

    </div>
@endsection