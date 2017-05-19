@extends('layouts.main')
@section('title', 'Polls')
@section('styles')
    <style>
        .progress {
            height: 20px;
            border: 1px solid;
            padding:1px;
            -webkit-border-radius:0px;
            -moz-border-radius:0px;
            border-radius:0px;
        }
        .progress .progress-bar {
            font-size: 12px;
            line-height: 15px;
        }
        .pagination
        {
            display: block !important;
            visibility: visible !important;
        }
    </style>
@endsection
@section('main-container')
    <div class="content col-xs-9" id="app" xmlns:v-on="http://www.w3.org/1999/xhtml">
        @include('partials._errors')

        <div class="page-data-items">
        @forelse($polls as $poll)
            <div class="page-item">
            @if(!$poll->isExpired() && !$poll->isVoted())
                <div class="panel pad10">
                    {!! Form::open(['route' => ['poll.vote',$poll->id]]) !!}
                    <h4 class=""><b>{{ $poll->question }}</b></h4>
                    <div class="panel pad10">
                    @foreach($poll->pollos as $pollo)
                        <input type="radio" name="option" value="{{ $pollo->id }}"> {{ $pollo->option }}<br>
                    @endforeach
                    <input type="submit" value="Vote" class="btn btn-primary btn-xs">
                    {!! Form::close() !!}
                    </div>
                    <span class="small">Total Votes: <b>{{ $poll->users()->count() }}</b></span>
                    <p class="pull-right small">Started {{ $poll->created_at->diffForHumans() }} by
                        <a class="" href="{{ route('user.show',$poll->user->username) }}">
                            <strong class="">{{ $poll->user->displayName() }}</strong>
                        </a>
                    </p>
                </div>

            @else
                <div class="panel pad10">
                    <h4 class=""><b>{{ $poll->question }}</b></h4>
                    <div class="panel pad10">
                        @foreach($poll->pollos as $pollo)
                            {{ $pollo->option }}<br>
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped active {{ $polluserscount = $poll->users()->count() }}" role="progressbar"
                                     aria-valuenow="{{ $percent = round($polluserscount == 0 ? 0 : ( $pollo->users->count() / $polluserscount)*100) }}"
                                     aria-valuemin="0" aria-valuemax="100" style="width: {{ $percent }}%;">
                                    {{ $percent }}% ({{ $pollo->users->count() }})
                                </div>
                            </div>

                        @if(Auth::check() && Auth::user()->isAdmin())
                            <table style="margin-bottom: 20px;border-bottom: 2px dashed #c3c3c3;" class="table table-hover table-striped table-bordered">
                                <tbody><tr> <th class="col-xs-1"></th> <th>Name</th> <th>Voted On</th> </tr>
                                @foreach($pollo->users as $user)
                                <tr> <td class="text-muted"><img class="tooltipster" title="{{ $user->country->countryName }}" src="/images/flags/20_shiny/{{ $user->country->countryCode }}.png" alt="" height="22px"></td> <td class="color-main"><a class="" href="{{ route('user.show',$user->username) }}">
                                            <strong class="">{{ $user->displayName() }}</strong></a></td> <td><span class="tooltipster" title="{{ $user->pivot->created_at->toDayDateTimeString() }}">{{ $user->pivot->created_at->diffForHumans() }}</span></td> </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endif

                        @endforeach
                    </div>

                    <span class="small">Total Votes: <b>{{ $poll->users()->count() }}</b></span>
                    <p class="pull-right small">Started {{ $poll->created_at->diffForHumans() }} by
                        <a class="" href="{{ route('user.show',$poll->user->username) }}">
                            <strong class="">{{ $poll->user->displayName() }}</strong>
                        </a>
                    </p>
                </div>
            @endif
            </div>
        @empty
            None Poll Now
        @endforelse
        </div>

        <div class="col-xs-12 no-padding" style="margin-bottom: 20px;">
            {!! $polls->appends(Request::except('page'))->render() !!}
        </div>
    </div>
@endsection