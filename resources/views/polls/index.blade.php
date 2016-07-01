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
    </style>
@endsection
@section('main-container')
    <div class="content col-md-9" id="app" xmlns:v-on="http://www.w3.org/1999/xhtml">
        @include('partials._errors')

        @forelse($polls as $poll)
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
                            <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="{{ $percent = $poll->users()->count() == 0 ? 0 : ( $pollo->users()->count() / $poll->users()->count())*100 }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $percent }}%;">
                                {{ $percent }}% ({{ $pollo->users()->count() }})
                            </div>
                        </div>
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
        @empty
            None Poll Now
        @endforelse

    </div>
@endsection

@section('scripts')
    <script src="{{ url('/') }}/js/vue.min.js"></script>
@endsection