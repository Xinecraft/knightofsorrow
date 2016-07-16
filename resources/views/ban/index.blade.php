@extends('layouts.main')
@section('meta-desc',"List of all bans.")
@section('title',"Ban List")

@section('main-container')
    <div class="col-xs-9">

        <div class="rounds panel panel-default">
            <div class="panel-heading"><strong>Found {{ $bans->total() }} Bans</strong></div>
            <div class="panel-body">
                <table id="" class="table table-striped table-hover no-margin">
                    <thead>
                    <tr>
                        {{--<th class="col-xs-1">{!! sort_bans_by('position','#') !!}</th>--}}
                        <th class="col-xs-1">{!! sort_bans_by('country_id','Flag') !!}</th>
                        <th class="col-xs-3">{!! sort_bans_by('name','Name') !!}</th>
                        <th class="col-xs-2">{!! sort_bans_by('ip_address','IP Address') !!}</th>
                        <th class="col-xs-3">{!! sort_bans_by('admin_name','Banned By') !!}</th>
                        <th class="col-xs-1">{!! sort_bans_by('status','Status') !!}</th>
                        <th class="col-xs-2 text-right">{!! sort_bans_by('updated_at','Updated') !!}</th>
                    </tr>
                    </thead>
                    <tbody id="data-items">
                    @foreach($bans as $ban)
                        <tr class="item">
                            <td class="text-muted"><img class="tooltipster" title="{{ $ban->countryName }}" src="{{ $ban->countryImage }}" alt="" height="22px"/></td>
                            <td class="color-main text-bold">{!! link_to_route('bans.show',$ban->name,[$ban->id]) !!}</td>
                            <td>{!! $ban->ipAddrWithMask !!}</td>
                            <td>{!! $ban->bannedByAdminURL !!}</td>
                            <td><b>{!! $ban->statusWithColor !!}</b></td>
                            <td class="text-right">{!! $ban->updated_at->diffForHumans() !!}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {!! $bans->appends(Request::except('page'))->render() !!}
            <div id="loading" class="text-center"></div>
        </div>

    </div>
@endsection