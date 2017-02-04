@extends('layouts.main')
@section('title',"World Clock")
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
    </style>
@endsection

@section('before-container')
    <div class="header wg-primary">
        <div class="container">
            <h1 class="ng-binding text-center">World Clock</h1>
            <!-- ngIf: ctrl.tournament.twitch --><!--end .tournament-twitch-->
        </div><!--end .container-->
    </div>
@endsection

@section('main-container')
    @include('partials._tournavbar')
    <div class="row">
        <div class="col-xs-8">
            <iframe scrolling="no" frameborder="no" clocktype=\"html5\" style="overflow:hidden;border:0;margin:0;padding:0;width:720px;height:375px;" src="http://www.clocklink.com/clocks/HTML5/html5-world.html?New_Delhi&Paris&New_York&720&gray"></iframe>
        </div>
        <div class="col-xs-4 panel text-center" style="margin-left: -15px">
            <div style="margin: 15px 0px 0px; display: inline-block; text-align: center;"><div style="display: inline-block; padding: 2px 4px; margin: 0px 0px 5px; border: 1px solid rgb(204, 204, 204); text-align: center; background-color: transparent;"><a href="http://localtimes.info/difference" style="text-decoration: none; font-size: 13px; color: rgb(0, 0, 0);">World Clock</a></div><script type="text/javascript" src="http://localtimes.info/world_clock2.php?&cp1_Hex=000000&cp2_Hex=FFFFFF&cp3_Hex=000000&fwdt=110&ham=0&hbg=1&hfg=0&sid=0&mon=0&wek=0&wkf=0&sep=0&widget_number=11000&lcid=INXX0096,PKXX0006,SRXX0001,MOXX0007,RSXX0063,USNY0996,EGXX0004,UKXX0085,GMXX0040,IRXX0018,BGXX0003,ENXX0004"></script></div>
        </div>
        <div class="col-xs-12 text-center panel" style="padding: 10px;">
            <h4>Visit <a href="https://www.timeanddate.com/worldclock/" target="_blank">Full World Clock</a> for more</h4>
        </div>
    </div>
@endsection
