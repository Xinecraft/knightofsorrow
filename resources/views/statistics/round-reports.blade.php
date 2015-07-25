@extends('layouts.main')

@section('main-container')
    <style>
        td{
            padding: 15px !important;
        }
    </style>
    <div class="col-md-9">
        <div class="rounds">
            <table id="" class="table table-striped table-hover">
                <thead>
                <tr>
                    <th class="col-md-1">Round</th>
                    <th class="col-md-2">Time</th>
                    <th class="col-md-1">Swat</th>
                    <th class="col-md-2">Suspects</th>
                    <th class="col-md-4">Map</th>
                    <th class="text-right">Date</th>
                </tr>
                </thead>
                <tbody id="round-items">
                @foreach($rounds as $round)
                    <tr class="item">
                        <td>{{ $round->id }}</td>
                        <td>{{ $round->time }}</td>
                        <td>{{ $round->swat_score }}</td>
                        <td>{{ $round->suspects_score }}</td>
                        <td>{{ $round->mapName }}</td>
                        <td class="text-right">{{ $round->timeAgo }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {!! $rounds->render() !!}
            <div id="loading" class="text-center"></div>
        </div>
    </div>
@endsection