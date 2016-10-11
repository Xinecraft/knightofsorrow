@extends('layouts.main')
@section('title',"Twitch Stream Channel")
@section('styles')
    <style>
        .tab-pane {
            padding: 10px;
        }

        .form.form-inline {
            display: inline-block;
        }

        .vs:before {
            content: 'vs';
            font-size: 25px;
            float: right;
            color: #03A9F4;
        }

        .team-name {
            padding: 10px !important;
        }

        .team-name.small {
            padding: 5px !important;
        }

        .font125p {
            font-size: 125% !important;
        }

        .form-team-form {
            padding: 10px;
            border: 1px solid #dce4ec;
        }
        body
        {
            background: url("/images/steamback.jpg") !important;
            background-size: cover !important;
        }
    </style>
@endsection

@section('main-container')
    @if(Route::is('tournament.stream'))
    @include('partials._tournavbar')
    @endif
    <div class="col-xs-12 panel row">
        <h3 class="text-center">Live Stream</h3>
        <div class="col-xs-8"><iframe src="https://player.twitch.tv/?channel=knight0fsorrow" frameborder="0" scrolling="no" height="500" width="720"></iframe><a href="https://www.twitch.tv/knight0fsorrow?tt_medium=live_embed&tt_content=text_link" style="padding:2px 0px 4px; display:block; width:345px; font-weight:normal; font-size:10px; text-decoration:underline;">Watch live video from knight0fsorrow on www.twitch.tv</a>
        </div>
        <div class="col-xs-4"><iframe src="https://www.twitch.tv/knight0fsorrow/chat?popout=" frameborder="0" scrolling="no" height="500" width="350"></iframe>
        </div>
        <div class="col-xs-12">
            <a href="https://www.twitch.tv/knight0fsorrow" class="btn btn-link pull-right" target="_blank">Visit our Twitch Channel for more</a>
        </div>
    </div>
@endsection