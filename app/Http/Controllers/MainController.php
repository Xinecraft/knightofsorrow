<?php

namespace App\Http\Controllers;

use App\Ban;
use App\Notification;
use App\Status;
use App\User;
use Carbon\Carbon;
use Cookie;
use Illuminate\Http\Request;
use Cache;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MainController extends Controller
{
    public function getIndex()
    {
        if(!Cookie::has('seen_donation_info'))
        {
            $cookie = Cookie::make('seen_donation_info','true',43200);
            Cookie::queue($cookie);
            $show_donation = true;
        }
        else
        {
            $show_donation= false;
        }
        /*
            $data1 = '{"0":"DUYFu8ao","1":"1.0.0","2":"10480","3":"1437386880","4":"11cc6f19","6":"1.0","7":"[c=FFFF00]WWW.KNIGHTofSORROW.TK (Antics)","11":"3","12":"12","13":"1","14":"5","15":"19371","16":"569","17":"900","19":"1","21":"1","22":"0","27":[{"0":"0","1":"182.185.80.115","2":"1","5":"YUG_X_Gmr","7":"67","38":"2"},{"0":"1","1":"182.185.83.84","2":"1","5":"YUG_X_Gmr","7":"139"},{"0":"2","1":"182.181.216.180","2":"1","5":"||KhaN||Namo(VIEW)","7":"247","11":"1","17":"1","38":"4"},{"0":"3","1":"182.181.184.161","5":"YUG_X_Gmr","7":"86","11":"1","17":"1","38":"4"},{"0":"4","1":"182.185.27.16","5":"RainBoW","6":"1","7":"71","8":"1","9":"1","15":"1","38":"2"},{"0":"5","1":"182.181.216.180","5":"||KhaN||_Namo","7":"66","38":"2"}]}';

        {"0":"4VPwFgFe","1":"1.2.0","2":"10480","3":"1464673260","4":"39869856","6":"1.0","7":"Swat4 Server","9":"13","11":"1","12":"16","13":"3","14":"5","15":"300","16":"300","17":"900","22":"5","27_0_0":"0","27_0_1":"127.0.0.1","27_0_3":"1","27_0_5":"Kinnngg","27_0_6":"1","27_0_7":"294","27_0_38":"2","27_0_39_0":"10","27_0_39_1":"16","27_0_39_2":"16","27_0_39_3":"25","27_0_39_4":"25","27_0_39_5":"23","27_0_39_6":"25","27_0_39_7":"25","27_0_39_8":"25","27_0_39_9":"3","27_0_39_10":"19","27_0_39_11":"22","27_0_40_0_0":"10","27_0_40_0_1":"277","27_0_40_0_2":"24","27_0_40_1_0":"25","27_0_40_1_1":"8","27_0_40_1_2":"2"}


            $data2 = '{"0":"AIq1F3LG","1":"1.0.0","2":"10480","3":"1437386820","4":"481b525e","6":"1.0","7":"[c=FFFF00]WWW.KNIGHTofSORROW.TK (Antics)","11":"3","12":"12","13":"1","14":"5","15":"19301","16":"499","17":"900","19":"1","22":"0","27":[{"0":"0","1":"182.185.80.115","2":"1","5":"YUG_X_Gmr","7":"67","38":"2"},{"0":"1","1":"182.185.83.84","2":"1","5":"YUG_X_Gmr","7":"139"},{"0":"2","1":"182.181.216.180","2":"1","5":"||KhaN||Namo(VIEW)","7":"247","11":"1","17":"1","38":"4"},{"0":"3","1":"182.181.184.161","5":"YUG_X_Gmr","7":"19"},{"0":"4","1":"182.185.27.16","5":"RainBoW","6":"1","7":"4"}]}';

            $data3 = '{"0":"FTuq4Tox","1":"1.0.0","2":"10480","3":"1437386820","4":"481b525e","6":"1.0","7":"[c=FFFF00]WWW.KNIGHTofSORROW.TK (Antics)","11":"3","12":"12","13":"1","14":"5","15":"19331","16":"529","17":"900","19":"1","22":"0","27":[{"0":"0","1":"182.185.80.115","2":"1","5":"YUG_X_Gmr","7":"67","38":"2"},{"0":"1","1":"182.185.83.84","2":"1","5":"YUG_X_Gmr","7":"139"},{"0":"2","1":"182.181.216.180","2":"1","5":"||KhaN||Namo(VIEW)","7":"247","11":"1","17":"1","38":"4"},{"0":"3","1":"182.181.184.161","5":"YUG_X_Gmr","7":"48","38":"2"},{"0":"4","1":"182.185.27.16","5":"RainBoW","6":"1","7":"33","38":"1"},{"0":"5","1":"182.181.216.180","5":"||KhaN||_Namo","7":"28","38":"1"}]}';

            $data4 = '{"0":"aoCjMXOs","1":"1.0.0","2":"10480","3":"1437386940","4":"6512549a","6":"1.0","7":"[c=FFFF00]WWW.KNIGHTofSORROW.TK (Antics)","11":"3","12":"12","13":"1","14":"5","15":"19457","16":"656","17":"900","19":"1","20":"11","21":"1","22":"0","27":[{"0":"0","1":"182.185.80.115","2":"1","5":"YUG_X_Gmr","7":"67","38":"2"},{"0":"1","1":"182.185.83.84","2":"1","5":"YUG_X_Gmr","7":"139"},{"0":"2","1":"182.181.216.180","2":"1","5":"||KhaN||Namo(VIEW)","7":"247","11":"1","17":"1","38":"4"},{"0":"3","1":"182.181.184.161","2":"1","5":"YUG_X_Gmr","7":"98","11":"1","17":"1","38":"2"},{"0":"4","1":"182.185.27.16","5":"RainBoW","6":"1","7":"154","8":"1","9":"1","11":"1","14":"2","15":"1","17":"1","38":"2"},{"0":"5","1":"182.181.216.180","5":"||KhaN||_Namo","7":"149","8":"10","13":"2","16":"2","38":"2"},{"0":"6","1":"182.181.184.161","5":"YUG_X_Gmr","7":"58","8":"1","9":"1","15":"1","38":"2"}]}';

            $data5 = '{"0":"gZzV5JGQ","1":"1.0.0","2":"10480","3":"1437386880","4":"11cc6f19","6":"1.0","7":"[c=FFFF00]WWW.KNIGHTofSORROW.TK (Antics)","11":"3","12":"12","13":"1","14":"5","15":"19362","16":"560","17":"900","19":"1","22":"0","27":[{"0":"0","1":"182.185.80.115","2":"1","5":"YUG_X_Gmr","7":"67","38":"2"},{"0":"1","1":"182.185.83.84","2":"1","5":"YUG_X_Gmr","7":"139"},{"0":"2","1":"182.181.216.180","2":"1","5":"||KhaN||Namo(VIEW)","7":"247","11":"1","17":"1","38":"4"},{"0":"3","1":"182.181.184.161","5":"YUG_X_Gmr","7":"77","38":"2"},{"0":"4","1":"182.185.27.16","5":"RainBoW","6":"1","7":"62","38":"2"},{"0":"5","1":"182.181.216.180","5":"||KhaN||_Namo","7":"58","38":"2"}]}';

            $data6 = '{"0":"hdr5q4FG","1":"1.0.0","2":"10480","3":"1437386820","4":"481b525e","6":"1.0","7":"[c=FFFF00]WWW.KNIGHTofSORROW.TK (Antics)","11":"3","12":"12","13":"1","14":"5","15":"19343","16":"541","17":"900","19":"1","22":"0","27":[{"0":"0","1":"182.185.80.115","2":"1","5":"YUG_X_Gmr","7":"67","38":"2"},{"0":"1","1":"182.185.83.84","2":"1","5":"YUG_X_Gmr","7":"139"},{"0":"2","1":"182.181.216.180","2":"1","5":"||KhaN||Namo(VIEW)","7":"247","11":"1","17":"1","38":"4"},{"0":"3","1":"182.181.184.161","5":"YUG_X_Gmr","7":"60","38":"2"},{"0":"4","1":"182.185.27.16","5":"RainBoW","6":"1","7":"44","38":"2"},{"0":"5","1":"182.181.216.180","5":"||KhaN||_Namo","7":"40","38":"2"}]}';

            $data6 = '{"0":"jWO6l3xa","1":"1.0.0","2":"10480","3":"1437386820","4":"481b525e","6":"1.0","7":"[c=FFFF00]WWW.KNIGHTofSORROW.TK (Antics)","11":"3","12":"12","13":"1","14":"5","15":"19339","16":"537","17":"900","19":"1","22":"0","27":[{"0":"0","1":"182.185.80.115","2":"1","5":"YUG_X_Gmr","7":"67","38":"2"},{"0":"1","1":"182.185.83.84","2":"1","5":"YUG_X_Gmr","7":"139"},{"0":"2","1":"182.181.216.180","2":"1","5":"||KhaN||Namo(VIEW)","7":"247","11":"1","17":"1","38":"4"},{"0":"3","1":"182.181.184.161","5":"YUG_X_Gmr","7":"56","38":"2"},{"0":"4","1":"182.185.27.16","5":"RainBoW","6":"1","7":"40","38":"2"},{"0":"5","1":"182.181.216.180","5":"||KhaN||_Namo","7":"36","38":"2"}]}';

            $data7 = '{"0":"kZ4Jk2DK","1":"1.0.0","2":"10480","3":"1437386820","4":"481b525e","6":"1.0","7":"[c=FFFF00]WWW.KNIGHTofSORROW.TK (Antics)","11":"3","12":"12","13":"1","14":"5","15":"19334","16":"532","17":"900","19":"1","22":"0","27":[{"0":"0","1":"182.185.80.115","2":"1","5":"YUG_X_Gmr","7":"67","38":"2"},{"0":"1","1":"182.185.83.84","2":"1","5":"YUG_X_Gmr","7":"139"},{"0":"2","1":"182.181.216.180","2":"1","5":"||KhaN||Namo(VIEW)","7":"247","11":"1","17":"1","38":"4"},{"0":"3","1":"182.181.184.161","5":"YUG_X_Gmr","7":"51","38":"2"},{"0":"4","1":"182.185.27.16","5":"RainBoW","6":"1","7":"36","38":"2"},{"0":"5","1":"182.181.216.180","5":"||KhaN||_Namo","7":"32","38":"2"}]}';

            $data8 = '{"0":"yTuq4Toy","1":"1.0.0","2":"10480","3":"1437386820","4":"481b525e","6":"1.0","7":"[c=FFFF00]WWW.KNIGHTofSORROW.TK (Antics)","11":"3","12":"12","13":"1","14":"5","15":"19331","16":"529","17":"900","19":"1","22":"0","27":[{"0":"0","1":"182.185.80.115","2":"1","5":"YUG_X_Gmr","7":"67","38":"2"},{"0":"1","1":"182.185.83.84","2":"1","5":"YUG_X_Gmr","7":"139"},{"0":"2","1":"182.181.216.180","2":"1","5":"||KhaN||Namo(VIEW)","7":"247","11":"1","17":"1","38":"4"},{"0":"3","1":"182.181.184.161","5":"YUG_X_Gmr","7":"48","38":"2"},{"0":"4","1":"182.185.27.16","5":"RainBoW","6":"1","7":"33","38":"1"},{"0":"5","1":"182.181.216.180","5":"||KhaN||_Namo","7":"28","38":"1"}]}';

            $data9 = '{"0":"gcqo6buP","1":"1.0.0","2":"10480","3":"1437386820","4":"481b525e","6":"1.0","7":"[c=FFFF00]WWW.KNIGHTofSORROW.TK (Antics)","11":"3","12":"12","13":"1","14":"5","15":"19331","16":"529","17":"900","19":"1","22":"0","27":[{"0":"0","1":"182.185.80.115","2":"1","5":"YUG_X_Gmr","7":"67","38":"2"},{"0":"1","1":"182.185.83.84","2":"1","5":"YUG_X_Gmr","7":"139"},{"0":"2","1":"182.181.216.180","2":"1","5":"||KhaN||Namo(VIEW)","7":"247","11":"1","17":"1","38":"4"},{"0":"3","1":"182.181.184.161","5":"YUG_X_Gmr","7":"48","38":"2"},{"0":"4","1":"182.185.27.16","5":"RainBoW","6":"1","7":"33","38":"1"},{"0":"5","1":"182.181.216.180","5":"||KhaN||_Namo","7":"28","38":"1"}]}';

            $data10 = '{"0":"rTjAGcAF","1":"1.0.0","2":"10480","3":"1437386820","4":"481b525e","6":"1.0","7":"[c=FFFF00]WWW.KNIGHTofSORROW.TK (Antics)","11":"3","12":"12","13":"1","14":"5","15":"19301","16":"499","17":"900","19":"1","22":"0","27":[{"0":"0","1":"182.185.80.115","2":"1","5":"YUG_X_Gmr","7":"67","38":"2"},{"0":"1","1":"182.185.83.84","2":"1","5":"YUG_X_Gmr","7":"139"},{"0":"2","1":"182.181.216.180","2":"1","5":"||KhaN||Namo(VIEW)","7":"247","11":"1","17":"1","38":"4"},{"0":"3","1":"182.181.184.161","5":"YUG_X_Gmr","7":"20"},{"0":"4","1":"182.185.27.16","5":"RainBoW","6":"1","7":"4"},{"0":"5","1":"182.181.216.180","5":"||KhaN||_Namo"}]}';


            $s1 = new App\Server\ServerTracker(json_decode($data1,true));
            $s2 = new App\Server\ServerTracker(json_decode($data2,true));
            $s3 = new App\Server\ServerTracker(json_decode($data3,true));
            $s4 = new App\Server\ServerTracker(json_decode($data4,true));
            $s5 = new App\Server\ServerTracker(json_decode($data5,true));
            $s6 = new App\Server\ServerTracker(json_decode($data6,true));
            $s7 = new App\Server\ServerTracker(json_decode($data7,true));
            $s8 = new App\Server\ServerTracker(json_decode($data8,true));
            $s9 = new App\Server\ServerTracker(json_decode($data9,true));
            $s10 = new App\Server\ServerTracker(json_decode($data10,true));
            $s1->track();
            $s2->track();
            $s3->track();
            $s4->track();
            $s5->track();
            $s6->track();
            $s7->track();
            $s8->track();
            $s9->track();
            $s10->track();
            */

        if(Cache::has('top_players'))
        {
            $topPlayers = Cache::get('top_players');
        }
        else
        {
            $topPlayers = \App\PlayerTotal::with(['country','rank'])->orderBy('position')->limit(10)->get();
        }

        $latestGames = \App\Game::normal()->orderBy('created_at', 'desc')->limit(5)->get();

        //return (Carbon\Carbon::now()->subYears(100));

        $player = \App\Player::first();

        $AllTime = new \Illuminate\Support\Collection();
        $PastWeek = new \Illuminate\Support\Collection();
        $PastMonth = new \Illuminate\Support\Collection();
        $PastYear = new \Illuminate\Support\Collection();

        if ($player != null) {
            //All Time Total Score
            if(Cache::has('alltime_totalScore')) {
                $AllTime->totalScore = Cache::get('alltime_totalScore');
            }
            else {
                $AllTime->totalScore = $player->getBestIn('SUM(score) as totalscore', 'totalscore');
                Cache::put('alltime_totalScore',$AllTime->totalScore,10);
            }

            //All Time Highest Score
            if(Cache::has('alltime_highestScore')) {
                $AllTime->highestScore = Cache::get('alltime_highestScore');
            }
            else {
                $AllTime->highestScore = $player->getBestIn('MAX(score) as highestscore', 'highestscore');
                Cache::put('alltime_highestScore',$AllTime->highestScore,10);
            }

            //All Time Total Arrests
            if(Cache::has('alltime_totalArrests')) {
                $AllTime->totalArrests = Cache::get('alltime_totalArrests');
            }
            else {
                $AllTime->totalArrests = $player->getBestIn('SUM(arrests) as totalarrests', 'totalarrests');
                Cache::put('alltime_totalArrests',$AllTime->totalArrests,10);
            }

            //All Time Total Arrested
            if(Cache::has('alltime_totalArrested')) {
                $AllTime->totalArrested = Cache::get('alltime_totalArrested');
            }
            else {
                $AllTime->totalArrested = $player->getBestIn('SUM(arrested) as totalarrested', 'totalarrested');
                Cache::put('alltime_totalArrested',$AllTime->totalArrested,10);
            }

            //All Time Total Kills
            if(Cache::has('alltime_totalKills')) {
                $AllTime->totalKills = Cache::get('alltime_totalKills');
            }
            else {
                $AllTime->totalKills = $player->getBestIn('SUM(kills) as totalkills', 'totalkills');
                Cache::put('alltime_totalKills',$AllTime->totalKills,10);
            }

            //All Time Total Deaths
            if(Cache::has('alltime_totalDeaths')) {
                $AllTime->totalDeaths = Cache::get('alltime_totalDeaths');
            }
            else {
                $AllTime->totalDeaths = $player->getBestIn('SUM(deaths) as totaldeaths', 'totaldeaths');
                Cache::put('alltime_totalDeaths',$AllTime->totalDeaths,10);
            }

            //All Time Best Arrest Steak
            if(Cache::has('alltime_bestArrestStreak')) {
                $AllTime->bestArrestStreak = Cache::get('alltime_bestArrestStreak');
            }
            else {
                $AllTime->bestArrestStreak = $player->getBestIn('MAX(arrest_streak) as best_arrest_streak', 'best_arrest_streak');
                Cache::put('alltime_bestArrestStreak',$AllTime->bestArrestStreak,10);
            }

            //All Time best Kill Streak
            if(Cache::has('alltime_bestKillStreak')) {
                $AllTime->bestKillStreak = Cache::get('alltime_bestKillStreak');
            }
            else {
                $AllTime->bestKillStreak = $player->getBestIn('MAX(kill_streak) as best_kill_streak', 'best_kill_streak');
                Cache::put('alltime_bestKillStreak',$AllTime->bestKillStreak,10);
            }

            //All Time best Death Streak
            if(Cache::has('alltime_bestDeathStreak')) {
                $AllTime->bestDeathStreak = Cache::get('alltime_bestDeathStreak');
            }
            else {
                $AllTime->bestDeathStreak = $player->getBestIn('MAX(death_streak) as best_death_streak', 'best_death_streak');
                Cache::put('alltime_bestDeathStreak',$AllTime->bestDeathStreak,10);
            }

            //All Time Total Team Kills
            if(Cache::has('alltime_totalTeamKills')) {
                $AllTime->totalTeamKills = Cache::get('alltime_totalTeamKills');
            }
            else {
                $AllTime->totalTeamKills = $player->getBestIn('SUM(team_kills) as totalteamkills', 'totalteamkills');
                Cache::put('alltime_totalTeamKills',$AllTime->totalTeamKills,10);
            }

            //All Time Total Time Played
            if(Cache::has('alltime_totalTimePlayed')) {
                $AllTime->totalTimePlayed = Cache::get('alltime_totalTimePlayed');
            }
            else {
                $AllTime->totalTimePlayed = $player->getBestIn('SUM(time_played) as totaltimeplayed', 'totaltimeplayed');
                Cache::put('alltime_totalTimePlayed',$AllTime->totalTimePlayed,10);
            }

            //All Time bestScorePerMin
            if(Cache::has('alltime_bestScorePerMin')) {
                $AllTime->bestScorePerMin = Cache::get('alltime_bestScorePerMin');
            }
            else {
                $AllTime->bestScorePerMin = $player->getBestIn('SUM(score)/SUM(time_played)*60 as scorepermin', 'scorepermin');
                Cache::put('alltime_bestScorePerMin',$AllTime->bestScorePerMin,10);
            }

            //dd($AllTime);

            $pastWeekDate = \Carbon\Carbon::now()->subWeek(1);
            $PastWeek->totalScore = $player->getBestIn('SUM(score) as totalscore', 'totalscore', $pastWeekDate);
            $PastWeek->highestScore = $player->getBestIn('MAX(score) as highestscore', 'highestscore', $pastWeekDate);
            $PastWeek->totalArrests = $player->getBestIn('SUM(arrests) as totalarrests', 'totalarrests', $pastWeekDate);
            $PastWeek->totalArrested = $player->getBestIn('SUM(arrested) as totalarrested', 'totalarrested', $pastWeekDate);
            $PastWeek->totalKills = $player->getBestIn('SUM(kills) as totalkills', 'totalkills', $pastWeekDate);
            $PastWeek->totalDeaths = $player->getBestIn('SUM(deaths) as totaldeaths', 'totaldeaths', $pastWeekDate);
            $PastWeek->bestArrestStreak = $player->getBestIn('MAX(arrest_streak) as best_arrest_streak', 'best_arrest_streak', $pastWeekDate);
            $PastWeek->bestKillStreak = $player->getBestIn('MAX(kill_streak) as best_kill_streak', 'best_kill_streak', $pastWeekDate);
            $PastWeek->bestDeathStreak = $player->getBestIn('MAX(death_streak) as best_death_streak', 'best_death_streak', $pastWeekDate);
            $PastWeek->totalTeamKills = $player->getBestIn('SUM(team_kills) as totalteamkills', 'totalteamkills', $pastWeekDate);
            $PastWeek->totalTimePlayed = $player->getBestIn('SUM(time_played) as totaltimeplayed', 'totaltimeplayed', $pastWeekDate);
            $PastWeek->bestScorePerMin = $player->getBestIn('SUM(score)/SUM(time_played)*60 as scorepermin', 'scorepermin', $pastWeekDate);

            $pastMonthDate = \Carbon\Carbon::now()->subMonth(1);
            $PastMonth->totalScore = $player->getBestIn('SUM(score) as totalscore', 'totalscore', $pastMonthDate);
            $PastMonth->highestScore = $player->getBestIn('MAX(score) as highestscore', 'highestscore', $pastMonthDate);
            $PastMonth->totalArrests = $player->getBestIn('SUM(arrests) as totalarrests', 'totalarrests', $pastMonthDate);
            $PastMonth->totalArrested = $player->getBestIn('SUM(arrested) as totalarrested', 'totalarrested', $pastMonthDate);
            $PastMonth->totalKills = $player->getBestIn('SUM(kills) as totalkills', 'totalkills', $pastMonthDate);
            $PastMonth->totalDeaths = $player->getBestIn('SUM(deaths) as totaldeaths', 'totaldeaths', $pastMonthDate);
            $PastMonth->bestArrestStreak = $player->getBestIn('MAX(arrest_streak) as best_arrest_streak', 'best_arrest_streak', $pastMonthDate);
            $PastMonth->bestKillStreak = $player->getBestIn('MAX(kill_streak) as best_kill_streak', 'best_kill_streak', $pastMonthDate);
            $PastMonth->bestDeathStreak = $player->getBestIn('MAX(death_streak) as best_death_streak', 'best_death_streak', $pastMonthDate);
            $PastMonth->totalTeamKills = $player->getBestIn('SUM(team_kills) as totalteamkills', 'totalteamkills', $pastMonthDate);
            $PastMonth->totalTimePlayed = $player->getBestIn('SUM(time_played) as totaltimeplayed', 'totaltimeplayed', $pastMonthDate);
            $PastMonth->bestScorePerMin = $player->getBestIn('SUM(score)/SUM(time_played)*60 as scorepermin', 'scorepermin', $pastMonthDate);

            $pastYearDate = \Carbon\Carbon::now()->subYear(1);
            $PastYear->totalScore = $player->getBestIn('SUM(score) as totalscore', 'totalscore', $pastYearDate);
            $PastYear->highestScore = $player->getBestIn('MAX(score) as highestscore', 'highestscore', $pastYearDate);
            $PastYear->totalArrests = $player->getBestIn('SUM(arrests) as totalarrests', 'totalarrests', $pastYearDate);
            $PastYear->totalArrested = $player->getBestIn('SUM(arrested) as totalarrested', 'totalarrested', $pastYearDate);
            $PastYear->totalKills = $player->getBestIn('SUM(kills) as totalkills', 'totalkills', $pastYearDate);
            $PastYear->totalDeaths = $player->getBestIn('SUM(deaths) as totaldeaths', 'totaldeaths', $pastYearDate);
            $PastYear->bestArrestStreak = $player->getBestIn('MAX(arrest_streak) as best_arrest_streak', 'best_arrest_streak', $pastYearDate);
            $PastYear->bestKillStreak = $player->getBestIn('MAX(kill_streak) as best_kill_streak', 'best_kill_streak', $pastYearDate);
            $PastYear->bestDeathStreak = $player->getBestIn('MAX(death_streak) as best_death_streak', 'best_death_streak', $pastYearDate);
            $PastYear->totalTeamKills = $player->getBestIn('SUM(team_kills) as totalteamkills', 'totalteamkills', $pastYearDate);
            $PastYear->totalTimePlayed = $player->getBestIn('SUM(time_played) as totaltimeplayed', 'totaltimeplayed', $pastYearDate);
            $PastYear->bestScorePerMin = $player->getBestIn('SUM(score)/SUM(time_played)*60 as scorepermin', 'scorepermin', $pastYearDate);
        }
        else
        {
            $AllTime->totalScore = 0;
            $AllTime->highestScore = 0;
            $AllTime->totalArrests = 0;
            $AllTime->totalArrested = 0;
            $AllTime->totalKills = 0;
            $AllTime->totalDeaths = 0;
            $AllTime->bestArrestStreak = 0;
            $AllTime->bestKillStreak = 0;
            $AllTime->bestDeathStreak = 0;
            $AllTime->totalTeamKills = 0;
            $AllTime->totalTimePlayed = 0;
            $AllTime->bestScorePerMin = 0;

            $pastWeekDate = \Carbon\Carbon::now()->subWeek(1);
            $PastWeek->totalScore = 0;
            $PastWeek->highestScore = 0;
            $PastWeek->totalArrests = 0;
            $PastWeek->totalArrested = 0;
            $PastWeek->totalKills = 0;
            $PastWeek->totalDeaths = 0;
            $PastWeek->bestArrestStreak = 0;
            $PastWeek->bestKillStreak = 0;
            $PastWeek->bestDeathStreak = 0;
            $PastWeek->totalTeamKills = 0;
            $PastWeek->totalTimePlayed = 0;
            $PastWeek->bestScorePerMin = 0;

            $pastMonthDate = \Carbon\Carbon::now()->subMonth(1);
            $PastMonth->totalScore = 0;
            $PastMonth->highestScore = 0;
            $PastMonth->totalArrests = 0;
            $PastMonth->totalArrested = 0;
            $PastMonth->totalKills = 0;
            $PastMonth->totalDeaths = 0;
            $PastMonth->bestArrestStreak = 0;
            $PastMonth->bestKillStreak = 0;
            $PastMonth->bestDeathStreak = 0;
            $PastMonth->totalTeamKills = 0;
            $PastMonth->totalTimePlayed = 0;
            $PastMonth->bestScorePerMin = 0;

            $pastYearDate = \Carbon\Carbon::now()->subYear(1);
            $PastYear->totalScore = 0;
            $PastYear->highestScore = 0;
            $PastYear->totalArrests = 0;
            $PastYear->totalArrested = 0;
            $PastYear->totalKills = 0;
            $PastYear->totalDeaths = 0;
            $PastYear->bestArrestStreak = 0;
            $PastYear->bestKillStreak = 0;
            $PastYear->bestDeathStreak = 0;
            $PastYear->totalTeamKills = 0;
            $PastYear->totalTimePlayed = 0;
            $PastYear->bestScorePerMin = 0;
        }

        if($PastYear->totalScore == null)
            $PastYear = $AllTime;
        if($PastMonth->totalScore == null)
            $PastMonth = $PastYear;
        if($PastWeek->totalScore == null)
            $PastWeek = $PastMonth;

        //Latest Feeds
        //$feeds  = Status::with('user')->latest()->limit(5)->get();
        $notifications = Notification::stream()->latest()->limit(5)->get();

        $activeUsers = User::orderBy('updated_at','DESC')->limit(50)->get();
        $bans = Ban::orderBy('updated_at','desc')->limit(5)->get();

        $array = [
            'topPlayers' => $topPlayers,
            'latestGames' => $latestGames,
            'AllTime' => $AllTime,
            'PastWeek' => $PastWeek,
            'PastMonth' => $PastMonth,
            'PastYear' => $PastYear,
            'bans' => $bans,
            'notifications' => $notifications,
            'activeUsers' => $activeUsers,
            'show_donation' => $show_donation,
        ];

        return view('home', $array);
    }


    public function getRulesOfServer()
    {
        return view('rules');
    }

    /**
     * Redirectors
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirects(Request $request)
    {
        if($request->has('to'))
        {
            if(substr($request->to,0,4) == "http")
            {
                return redirect()->away($request->to);
            }
            else
            {
                $redirect = "http://".$request->to;
                return redirect()->away($redirect);
            }
        }
        else
        {
            return redirect()->home();
        }
    }
}