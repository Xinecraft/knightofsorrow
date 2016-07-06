@extends('layouts.main')
@section('title', 'News Archive')
@section('main-container')
    <div class="content col-xs-8">
        <div class="col-xs-12 panel" style="padding: 15px">
            <h3>News Archive</h3>
            <hr>
            <ul style="list-style-type:square">
            @forelse($newses as $news)
                <li class="news-title" style="border-bottom: 1px solid #e7e7e7">
                    <a href="{{ route('news.show',$news->summary) }}"><b>{{ $news->title }}</b></a>
                    <small class="text-muted pull-right"><i>{{ $news->created_at->toDayDateTimeString() }}</i></small>
                </li>
                @empty
                No News
                @endforelse
                </ul>

        </div>

    </div>
@endsection