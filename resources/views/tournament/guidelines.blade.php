@extends('layouts.main')
@section('title',"Tournament Guidelines")
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
            <h1 class="ng-binding text-center">Tournament</h1>
            <h3 class="ng-binding text-center">Guidelines & Rules</h3>
            <!-- ngIf: ctrl.tournament.twitch --><!--end .tournament-twitch-->
        </div><!--end .container-->
    </div>
@endsection

@section('main-container')
    @include('partials._tournavbar')
    <div class="col-xs-12 panel">
        <h3 class="text-center">Tournament HowTo</h3>
        <hr style="margin-top: 10px;margin-bottom: 10px">
        <ul class="ruleslist" style="line-height:25px; list-style-type: square;font-family: 'Ubuntu', Helvetica, Arial, sans-serif;">
            <li>A player is applied to join only <b>one team</b> per tournament.</li>
            <li>A player can also create new team abd join it, but the team will be validated by a manager before it is made qualify for tournament.</li>
            <li>A player applied to join existing team will be <b>approved/rejected</b> by Team Leader</li>
            <li>
                Tournament will not begin if :
                <ul>
                    <li>Disabled by Super Administrator.</li>
                    <li>Minimum participants criteria not met.</li>
                </ul>
            </li>
            <li>A player can't leave/change team once registration time expires, and also no team can be created.</li>
            <li>Team will not be included in tournament even qualified if minimum required players is not met.</li>
            <li>Teams & Players will be Ranked separately when tournament ends.</li>
            <li>All <b>Time</b> provided are according to ServerTime <i class="small">(UTC)</i>. You can see current ServerTime at footer of website.</li>
            <li>If you need any support, Please contact any manager or super administrator.</li>
        </ul>
    </div>
    <div class="col-xs-12 panel">
        <h3 class="text-center">Tournament Rules</h3>
        <hr style="margin-top: 10px;margin-bottom: 10px">
        <ul class="ruleslist" style="line-height:25px; list-style-type: square;font-family: 'Ubuntu', Helvetica, Arial, sans-serif;">
            <li>It will be <b>1v1 Solo</b> or <b>2v2, 3v3 Team</b> matches with strict rules and guidelines.</li>
            <li>On the beginning all registered players will have 0 pts on our tournament ranking.</li>
            <li>A player is eligible to apply for tournies if not banned.</li>
            <li>All player applying should have a account at this website. <i>(Player linked account is recommended)</i></li>
            <li>All team should have minimum players criteria met before registration ends to join the tournament.</li>
            <li>All teams should report 15 minutes before match schedule time at Venue server.</li>
            <li>All players should be available on TeamSpeak3 server during his/her match.</li>
            <li>Manager will wait for 10-20 minutes for team to join before he declare result <i>(in case of absence)</i></li>
            <li>Failing to report will lead oppnent team declared as winner <i>(if reported)</i>.</li>
            <li>If both team fail to report, no points will be awarded and match will be cancelled.</li>
            <li>If drop during game occurs then its all in manager's hand to take any action.</li>
            <li>All matches will be either in no spectator mode or with 1-2 spectators<i>(only managers)</i>.</li>
            <li>Every tournament carry certain number of points. Example: Winners will won 1000 pts, finalist 600 pts, semifinalists 300 pts etc.</li>
            <li>Every players who won points on one of the tournies he need to defend for it in next upcoming sequel of that tournament. Example: If u won KoS alpha tournament in 2016 u need to defend it in KoS Alpha Tournament 2017.</li>
            <li><b>All star tournament</b>: Only top 8 players on the rankings can play this tourny. In 1v1 8 player, in 2v2 4 teams.</li>
            <li>Number of competetors on every tournament will be choosen by organizators.</li>
            <li>Changing of IP in the middle of the game is not allowed.</li>
        </ul>
        <div class="col-xs-6">
            <h5 class="col-xs-offset-2"><i class="fa fa-star-o"></i> Outcome of Match according to no. of player reported:</h5>
        <table class="col-xs-offset-2 table table-hover table-striped table-bordered">
            <tr>
                <th>Team 1</th>
                <th>Team 2</th>
                <th>Result</th>
            </tr>
            <tr>
                <td>2 players</td>
                <td>2 players</td>
                <td>Based on games outcome</td>
            </tr>
            <tr>
                <td>1 player</td>
                <td>1 player</td>
                <td>Manager's call <small>(1v1 or cancel)</small></td>
            </tr>
            <tr>
                <td>0 players</td>
                <td>0 players</td>
                <td>Match will be canceled</td>
            </tr>
            <tr>
                <td>2 players</td>
                <td>1 player</td>
                <td>Team 1 will be declared as winner</td>
            </tr>
            <tr>
                <td>1 player</td>
                <td>2 players</td>
                <td>Team 2 will be declared as winner</td>
            </tr>
            <tr>
                <td>2 players</td>
                <td>0 players</td>
                <td>Team 1 will be declared as winner</td>
            </tr>
            <tr>
                <td>0 players</td>
                <td>2 players</td>
                <td>Team 2 will be declared as winner</td>
            </tr>
            <tr>
                <td>1 player</td>
                <td>0 players</td>
                <td>Match will be canceled</td>
            </tr>
            <tr>
                <td>0 players</td>
                <td>1 player</td>
                <td>Match will be canceled</td>
            </tr>
        </table>
        </div>
    </div>
@endsection
