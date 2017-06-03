@extends('layouts.main')
@section('title','uS|Team Members')
@section('main-container')
    <div class="content col-xs-9">
        <div class="panel text-center">
            <h1 class="text-danger" style="font-family: 'Passion One', cursive;font-size: 3.5em;">uS| Team Memberlist</h1>
        </div>
        @foreach($roles as $role)
        <div class="panel container-fluid">
            <div class="div col-xs-12 text-center padding10">
            <img class="tooltipster image" src="/images/ranks/{{ $role->img_url }}" alt="{{ $role->display_name }}" title="{{ $role->display_name }}">
                <hr>
            </div>
            @forelse($role->users as $user)
                <div class="col-xs-6">
                    <div class="thumbnail">
                        {!! Html::image($user->getGravatarLink(250),null,['class' => 'img img-thumbnail profile-cover-img']) !!}
                        <div class="caption">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Display Name</th>
                                    <td>{{ $user->displayName() }}</td>
                                </tr>
                                <tr>
                                    <th>Username</th>
                                    <td>{!! link_to_route('user.show',"@".$user->username,$user->username,['class' =>'username']) !!}</td>
                                </tr>
                                <tr>
                                    <th>Role at |KoS|</th>
                                    <td>
                                        {{ $user->roles->first()->display_name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Country</th>
                                    <td style="padding: 0 8px 0 8px !important;">
                                        {{ $user->country->countryName }} {!! Html::image("/images/flags_new/flags-iso/shiny/32/".$user->country->countryCode.".png",null,['class' => 'img user-flag tooltipster', 'title' => $user->country->countryName]) !!}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            @empty
                <h5 class="text-center"><i>This Team Rank List is empty!</i></h5>
            @endforelse
        </div>
        @endforeach
    </div>
@endsection
