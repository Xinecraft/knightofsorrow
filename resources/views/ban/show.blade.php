@extends('layouts.main')
@section('meta-desc',"List of all bans.")
@section('title',"Ban #".$ban->id." of ".$ban->name)

@section('main-container')
    <div class="col-xs-9">
        <div class="panel" style="padding: 50px">
            @if(Auth::check() && Auth::user()->isAdmin())
            <a class="btn btn-sm btn-info pull-right" href="{{ route('bans.edit',$ban->id) }}">Edit Ban</a>
            @endif
            <h2 style="margin-bottom: 20px"><img class="tooltipster" title="{{ $ban->countryName }}" src="{{ $ban->countryImage }}" alt="" height="22px"/> {{ $ban->name }}</h2>
            <hr>
            <table style="font-size: large" class="table table-striped table-hover table-bordered">
                <tbody><tr>
                    <td class="col-xs-4">Ban ID</td>
                    <td class="col-xs-8">
                        <b>{{ $ban->id }}</b>
                    </td>
                </tr>
                <tr>
                    <td>Name</td>
                    <td>
                        {!! $ban->bannedUserURL !!}
                    </td>
                </tr>
                <tr>
                    <td>IP Address</td>
                    <td>
                        {{ $ban->ipAddrWithMask }}
                    </td>
                </tr>
                <tr>
                    <td>
                        Country
                    </td>
                    <td>
                        {{ $ban->countryName }}
                    </td>
                </tr>
                <tr>
                    <td>
                        Status
                    </td>
                    <td>
                        <b>{!! $ban->statusWithColor !!}</b>
                    </td>
                </tr>
                <tr>
                    <td>
                        Reason
                    </td>
                    <td>
                        {{ $ban->reason }}
                    </td>
                </tr>
                <tr>
                    <td>
                        Created
                    </td>
                    <td>
                        {{ $ban->created_at->diffForHumans() }} ( by {!! $ban->bannedByAdminURL !!} )
                    </td>
                </tr>
                @if($ban->updated_by != null)
                <tr>
                    <td>
                        Last Modified
                    </td>
                    <td>
                        {{ $ban->updated_at->diffForHumans() }} ( by {!! $ban->updatedByAdminURL !!} )
                    </td>
                </tr>
                @endif
                </tbody></table>
        </div>
    </div>
@endsection