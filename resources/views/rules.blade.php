@extends('layouts.main')
@section('title','Rules all should respect')
@section('main-container')
    <div class="content col-xs-9">

        <div class="panel" style="padding: 20px;">
            <div style="padding-left:10px">
                <h3 class="text"><b>Rules of </b>&nbsp;<i title="thumb" class="tooltipster fa fa-thumbs-up fa-2x"></i> </h3>
                <hr style="margin-top: 10px;margin-bottom: 10px">
                <ul class="ruleslist" style="list-style-type: square;font-family: 'Ubuntu', Helvetica, Arial, sans-serif;">
                    <li>Using hacks is not allowed.</li>
                    <li>Be <b>polite</b>. Insulting others will not be tolerated.</li>
                    <li><b>Racism</b>, Hatred, etc are strictly prohibited. This may lead to permanent ban.</li>
                    <li>Using bugs/glitches of any kind is not allowed.</li>
                    <li>Do not start kick/map/ask/taser votes without reason.</li>
                    <li>Do not team -kill, -nade, -tase, etc. on purpose.</li>
                    <li>Do not kill or steal arrests.</li>
                    <li>Hard <b>camping</b> is strictly <b>prohibited</b>. <i>( tactical camping  allowed )</i></li>
                    <li>Tactical camping is only a short wait of 15-20 seconds.</li>
                    <li>Do not spam/flood/attack the server.</li>
                    <li>Do not use another player's name. <b>Impersonation</b> will get you banned.</li>
                    <li>If you find any admin/superadmin <b>misusing his powers</b>, plz <b>shout</b> at shoutbox.</li>
                    <li>Respect KnightofSorrow ;)</li>
                </ul>
                <p style="padding-bottom:20px">Respect these rules so everyone can have a fun gameplay experience or <span class="text-bold">risk getting kicked/banned</span>.</p>	</div>
        </div>

        @if(Auth::check() && Auth::user()->isAdmin())
        <div class="panel" style="padding: 20px;">
            <div style="padding-left:10px">
                <h3 class="text"><b>Rules for </b>&nbsp;<i title="Administrator" class="tooltipster fa fa-user-secret fa-2x"></i> </h3>
                <hr style="margin-top: 10px;margin-bottom: 10px">
                <ul class="ruleslist" style="list-style-type: square;font-family: 'Ubuntu', Helvetica, Arial, sans-serif;">
                    <li>Don't kick/ban without reason.</li>
                    <li>Be <b>polite</b> with players.</li>
                    <li>Warn <b>3 times</b> before kick/ban.</li>
                    <li>Don't <b>unban</b> the bans added by other admins without their permission.</li>
                    <li>Don't <b>switch</b> player/teams without reason. Use balance team instead.</li>
                    <li>Don't change <b>Server settings</b> without senior permission.</li>
                    <li>Don't change map or lock/unlock teams without <b>majority</b> support.</li>
                    <li>Don't <b>misuse</b> your powers.</li>
                </ul>
            </div>
        </div>
        @endif


    </div>
@endsection