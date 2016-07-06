@extends('layouts.main')
@section('title','Your Feedline')
@section('main-container')
    <div class="content col-xs-7">
        @include('partials._errors')
        @include('partials._status_update_form')

        <div id="data-items">
        @forelse($statuses as $status)
                @include('partials._view_statuses')
        @empty
            <div class="panel">
                <h3>No Status yet!</h3>
            </div>
        @endforelse
        </div>

        {!! $statuses->render() !!}
        <div id="loading" class="text-center"></div>
    </div>

@endsection