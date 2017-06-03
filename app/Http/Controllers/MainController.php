<?php

namespace App\Http\Controllers;

use App\Ban;
use App\Clanrole;
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
            $cookie = Cookie::make('seen_donation_info','true',21600);
            Cookie::queue($cookie);
            $show_donation = true;
        }
        else
        {
            $show_donation= false;
        }

        if(!Cookie::has('seen_add_info'))
        {
            $cookie = Cookie::make('seen_add_info','true',4320);
            Cookie::queue($cookie);
            $show_add = false;
        }
        else
        {
            $show_add= false;
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
                Cache::put('alltime_totalScore',$AllTime->totalScore,720);
            }

            //All Time Highest Score
            if(Cache::has('alltime_highestScore')) {
                $AllTime->highestScore = Cache::get('alltime_highestScore');
            }
            else {
                $AllTime->highestScore = $player->getBestIn('MAX(score) as highestscore', 'highestscore');
                Cache::put('alltime_highestScore',$AllTime->highestScore,720);
            }

            //All Time Total Arrests
            if(Cache::has('alltime_totalArrests')) {
                $AllTime->totalArrests = Cache::get('alltime_totalArrests');
            }
            else {
                $AllTime->totalArrests = $player->getBestIn('SUM(arrests) as totalarrests', 'totalarrests');
                Cache::put('alltime_totalArrests',$AllTime->totalArrests,720);
            }

            //All Time Total Arrested
            if(Cache::has('alltime_totalArrested')) {
                $AllTime->totalArrested = Cache::get('alltime_totalArrested');
            }
            else {
                $AllTime->totalArrested = $player->getBestIn('SUM(arrested) as totalarrested', 'totalarrested');
                Cache::put('alltime_totalArrested',$AllTime->totalArrested,720);
            }

            //All Time Total Kills
            if(Cache::has('alltime_totalKills')) {
                $AllTime->totalKills = Cache::get('alltime_totalKills');
            }
            else {
                $AllTime->totalKills = $player->getBestIn('SUM(kills) as totalkills', 'totalkills');
                Cache::put('alltime_totalKills',$AllTime->totalKills,720);
            }

            //All Time Total Deaths
            if(Cache::has('alltime_totalDeaths')) {
                $AllTime->totalDeaths = Cache::get('alltime_totalDeaths');
            }
            else {
                $AllTime->totalDeaths = $player->getBestIn('SUM(deaths) as totaldeaths', 'totaldeaths');
                Cache::put('alltime_totalDeaths',$AllTime->totalDeaths,720);
            }

            //All Time Best Arrest Steak
            if(Cache::has('alltime_bestArrestStreak')) {
                $AllTime->bestArrestStreak = Cache::get('alltime_bestArrestStreak');
            }
            else {
                $AllTime->bestArrestStreak = $player->getBestIn('MAX(arrest_streak) as best_arrest_streak', 'best_arrest_streak');
                Cache::put('alltime_bestArrestStreak',$AllTime->bestArrestStreak,720);
            }

            //All Time best Kill Streak
            if(Cache::has('alltime_bestKillStreak')) {
                $AllTime->bestKillStreak = Cache::get('alltime_bestKillStreak');
            }
            else {
                $AllTime->bestKillStreak = $player->getBestIn('MAX(kill_streak) as best_kill_streak', 'best_kill_streak');
                Cache::put('alltime_bestKillStreak',$AllTime->bestKillStreak,720);
            }

            //All Time best Death Streak
            if(Cache::has('alltime_bestDeathStreak')) {
                $AllTime->bestDeathStreak = Cache::get('alltime_bestDeathStreak');
            }
            else {
                $AllTime->bestDeathStreak = $player->getBestIn('MAX(death_streak) as best_death_streak', 'best_death_streak');
                Cache::put('alltime_bestDeathStreak',$AllTime->bestDeathStreak,720);
            }

            //All Time Total Team Kills
            if(Cache::has('alltime_totalTeamKills')) {
                $AllTime->totalTeamKills = Cache::get('alltime_totalTeamKills');
            }
            else {
                $AllTime->totalTeamKills = $player->getBestIn('SUM(team_kills) as totalteamkills', 'totalteamkills');
                Cache::put('alltime_totalTeamKills',$AllTime->totalTeamKills,720);
            }

            //All Time Total Time Played
            if(Cache::has('alltime_totalTimePlayed')) {
                $AllTime->totalTimePlayed = Cache::get('alltime_totalTimePlayed');
            }
            else {
                $AllTime->totalTimePlayed = $player->getBestIn('SUM(time_played) as totaltimeplayed', 'totaltimeplayed');
                Cache::put('alltime_totalTimePlayed',$AllTime->totalTimePlayed,720);
            }

            //All Time bestScorePerMin
            if(Cache::has('alltime_bestScorePerMin')) {
                $AllTime->bestScorePerMin = Cache::get('alltime_bestScorePerMin');
            }
            else {
                $AllTime->bestScorePerMin = $player->getBestIn('SUM(score)/SUM(time_played)*60 as scorepermin', 'scorepermin');
                Cache::put('alltime_bestScorePerMin',$AllTime->bestScorePerMin,720);
            }

            //dd($AllTime);

            $pastWeekDate = \Carbon\Carbon::now()->subWeek(1);
            //Past Week totalScore
            if(Cache::has('pastweek_totalScore')) {
                $PastWeek->totalScore = Cache::get('pastweek_totalScore');
            }
            else {
                $PastWeek->totalScore = $player->getBestIn('SUM(score) as totalscore', 'totalscore', $pastWeekDate);
                Cache::put('pastweek_totalScore',$PastWeek->totalScore,720);
            }

            //Past Week highestScore
            if(Cache::has('pastweek_highestScore')) {
                $PastWeek->highestScore = Cache::get('pastweek_highestScore');
            }
            else {
                $PastWeek->highestScore = $player->getBestIn('MAX(score) as highestscore', 'highestscore', $pastWeekDate);
                Cache::put('pastweek_highestScore',$PastWeek->highestScore,720);
            }

            //Past Week totalArrests
            if(Cache::has('pastweek_totalArrests')) {
                $PastWeek->totalArrests = Cache::get('pastweek_totalArrests');
            }
            else {
                $PastWeek->totalArrests = $player->getBestIn('SUM(arrests) as totalarrests', 'totalarrests', $pastWeekDate);
                Cache::put('pastweek_totalArrests',$PastWeek->totalArrests,720);
            }

            //Past Week totalArrested
            if(Cache::has('pastweek_totalArrested')) {
                $PastWeek->totalArrested = Cache::get('pastweek_totalArrested');
            }
            else {
                $PastWeek->totalArrested = $player->getBestIn('SUM(arrested) as totalarrested', 'totalarrested', $pastWeekDate);
                Cache::put('pastweek_totalArrested',$PastWeek->totalArrested,720);
            }

            //Past Week totalKills
            if(Cache::has('pastweek_totalKills')) {
                $PastWeek->totalKills = Cache::get('pastweek_totalKills');
            }
            else {
                $PastWeek->totalKills = $player->getBestIn('SUM(kills) as totalkills', 'totalkills', $pastWeekDate);
                Cache::put('pastweek_totalKills',$PastWeek->totalKills,720);
            }

            //Past Week totalDeaths
            if(Cache::has('pastweek_totalDeaths')) {
                $PastWeek->totalDeaths = Cache::get('pastweek_totalDeaths');
            }
            else {
                $PastWeek->totalDeaths = $player->getBestIn('SUM(deaths) as totaldeaths', 'totaldeaths', $pastWeekDate);
                Cache::put('pastweek_totalDeaths',$PastWeek->totalDeaths,720);
            }

            //Past Week bestArrestStreak
            if(Cache::has('pastweek_bestArrestStreak')) {
                $PastWeek->bestArrestStreak = Cache::get('pastweek_bestArrestStreak');
            }
            else {
                $PastWeek->bestArrestStreak = $player->getBestIn('MAX(arrest_streak) as best_arrest_streak', 'best_arrest_streak', $pastWeekDate);
                Cache::put('pastweek_bestArrestStreak',$PastWeek->bestArrestStreak,720);
            }

            //Past Week bestKillStreak
            if(Cache::has('pastweek_bestKillStreak')) {
                $PastWeek->bestKillStreak = Cache::get('pastweek_bestKillStreak');
            }
            else {
                $PastWeek->bestKillStreak = $player->getBestIn('MAX(kill_streak) as best_kill_streak', 'best_kill_streak', $pastWeekDate);
                Cache::put('pastweek_bestKillStreak',$PastWeek->bestKillStreak,720);
            }

            //Past Week bestDeathStreak
            if(Cache::has('pastweek_bestDeathStreak')) {
                $PastWeek->bestDeathStreak = Cache::get('pastweek_bestDeathStreak');
            }
            else {
                $PastWeek->bestDeathStreak = $player->getBestIn('MAX(death_streak) as best_death_streak', 'best_death_streak', $pastWeekDate);
                Cache::put('pastweek_bestDeathStreak',$PastWeek->bestDeathStreak,720);
            }

            //Past Week totalTeamKills
            if(Cache::has('pastweek_totalTeamKills')) {
                $PastWeek->totalTeamKills = Cache::get('pastweek_totalTeamKills');
            }
            else {
                $PastWeek->totalTeamKills = $player->getBestIn('SUM(team_kills) as totalteamkills', 'totalteamkills', $pastWeekDate);
                Cache::put('pastweek_totalTeamKills',$PastWeek->totalTeamKills,720);
            }

            //Past Week totalTimePlayed
            if(Cache::has('pastweek_totalTimePlayed')) {
                $PastWeek->totalTimePlayed = Cache::get('pastweek_totalTimePlayed');
            }
            else {
                $PastWeek->totalTimePlayed = $player->getBestIn('SUM(time_played) as totaltimeplayed', 'totaltimeplayed', $pastWeekDate);
                Cache::put('pastweek_totalTimePlayed',$PastWeek->totalTimePlayed,720);
            }

            //Past Week bestScorePerMin
            if(Cache::has('pastweek_bestScorePerMin')) {
                $PastWeek->bestScorePerMin = Cache::get('pastweek_bestScorePerMin');
            }
            else {
                $PastWeek->bestScorePerMin = $player->getBestIn('SUM(score)/SUM(time_played)*60 as scorepermin', 'scorepermin', $pastWeekDate);
                Cache::put('pastweek_bestScorePerMin',$PastWeek->bestScorePerMin,720);
            }

            $pastMonthDate = \Carbon\Carbon::now()->subMonth(1);

            //Past Month totalScore
            if(Cache::has('pastmonth_totalScore')) {
                $PastMonth->totalScore = Cache::get('pastmonth_totalScore');
            }
            else {
                $PastMonth->totalScore = $player->getBestIn('SUM(score) as totalscore', 'totalscore', $pastMonthDate);
                Cache::put('pastmonth_totalScore',$PastMonth->totalScore,720);
            }

            //Past Month highestScore
            if(Cache::has('pastmonth_highestScore')) {
                $PastMonth->highestScore = Cache::get('pastmonth_highestScore');
            }
            else {
                $PastMonth->highestScore = $player->getBestIn('MAX(score) as highestscore', 'highestscore', $pastMonthDate);
                Cache::put('pastmonth_highestScore',$PastMonth->highestScore,720);
            }

            //Past Month totalArrests
            if(Cache::has('pastmonth_totalArrests')) {
                $PastMonth->totalArrests = Cache::get('pastmonth_totalArrests');
            }
            else {
                $PastMonth->totalArrests = $player->getBestIn('SUM(arrests) as totalarrests', 'totalarrests', $pastMonthDate);
                Cache::put('pastmonth_totalArrests',$PastMonth->totalArrests,720);
            }

            //Past Month totalArrested
            if(Cache::has('pastmonth_totalArrested')) {
                $PastMonth->totalArrested = Cache::get('pastmonth_totalArrested');
            }
            else {
                $PastMonth->totalArrested = $player->getBestIn('SUM(arrested) as totalarrested', 'totalarrested', $pastMonthDate);
                Cache::put('pastmonth_totalArrested',$PastMonth->totalArrested,720);
            }

            //Past Month totalKills
            if(Cache::has('pastmonth_totalKills')) {
                $PastMonth->totalKills = Cache::get('pastmonth_totalKills');
            }
            else {
                $PastMonth->totalKills = $player->getBestIn('SUM(kills) as totalkills', 'totalkills', $pastMonthDate);
                Cache::put('pastmonth_totalKills',$PastMonth->totalKills,720);
            }

            //Past Month totalDeaths
            if(Cache::has('pastmonth_totalDeaths')) {
                $PastMonth->totalDeaths = Cache::get('pastmonth_totalDeaths');
            }
            else {
                $PastMonth->totalDeaths = $player->getBestIn('SUM(deaths) as totaldeaths', 'totaldeaths', $pastMonthDate);
                Cache::put('pastmonth_totalDeaths',$PastMonth->totalDeaths,720);
            }

            //Past Month bestArrestStreak
            if(Cache::has('pastmonth_bestArrestStreak')) {
                $PastMonth->bestArrestStreak = Cache::get('pastmonth_bestArrestStreak');
            }
            else {
                $PastMonth->bestArrestStreak = $player->getBestIn('MAX(arrest_streak) as best_arrest_streak', 'best_arrest_streak', $pastMonthDate);
                Cache::put('pastmonth_bestArrestStreak',$PastMonth->bestArrestStreak,720);
            }

            //Past Month bestKillStreak
            if(Cache::has('pastmonth_bestKillStreak')) {
                $PastMonth->bestKillStreak = Cache::get('pastmonth_bestKillStreak');
            }
            else {
                $PastMonth->bestKillStreak = $player->getBestIn('MAX(kill_streak) as best_kill_streak', 'best_kill_streak', $pastMonthDate);
                Cache::put('pastmonth_bestKillStreak',$PastMonth->bestKillStreak,720);
            }

            //Past Month bestDeathStreak
            if(Cache::has('pastmonth_bestDeathStreak')) {
                $PastMonth->bestDeathStreak = Cache::get('pastmonth_bestDeathStreak');
            }
            else {
                $PastMonth->bestDeathStreak = $player->getBestIn('MAX(death_streak) as best_death_streak', 'best_death_streak', $pastMonthDate);
                Cache::put('pastmonth_bestDeathStreak',$PastMonth->bestDeathStreak,720);
            }

            //Past Month totalTeamKills
            if(Cache::has('pastmonth_totalTeamKills')) {
                $PastMonth->totalTeamKills = Cache::get('pastmonth_totalTeamKills');
            }
            else {
                $PastMonth->totalTeamKills = $player->getBestIn('SUM(team_kills) as totalteamkills', 'totalteamkills', $pastMonthDate);
                Cache::put('pastmonth_totalTeamKills',$PastMonth->totalTeamKills,720);
            }

            //Past Month totalTimePlayed
            if(Cache::has('pastmonth_totalTimePlayed')) {
                $PastMonth->totalTimePlayed = Cache::get('pastmonth_totalTimePlayed');
            }
            else {
                $PastMonth->totalTimePlayed = $player->getBestIn('SUM(time_played) as totaltimeplayed', 'totaltimeplayed', $pastMonthDate);
                Cache::put('pastmonth_totalTimePlayed',$PastMonth->totalTimePlayed,720);
            }

            //Past Month bestScorePerMin
            if(Cache::has('pastmonth_bestScorePerMin')) {
                $PastMonth->bestScorePerMin = Cache::get('pastmonth_bestScorePerMin');
            }
            else {
                $PastMonth->bestScorePerMin = $player->getBestIn('SUM(score)/SUM(time_played)*60 as scorepermin', 'scorepermin', $pastMonthDate);
                Cache::put('pastmonth_bestScorePerMin',$PastMonth->bestScorePerMin,720);
            }

            $pastYearDate = \Carbon\Carbon::now()->subYear(1);

            //Past Year totalScore
            if(Cache::has('pastyear_totalScore')) {
                $PastYear->totalScore = Cache::get('pastyear_totalScore');
            }
            else {
                $PastYear->totalScore = $player->getBestIn('SUM(score) as totalscore', 'totalscore', $pastYearDate);
                Cache::put('pastyear_totalScore',$PastYear->totalScore,720);
            }

            //Past Year highestScore
            if(Cache::has('pastyear_highestScore')) {
                $PastYear->highestScore = Cache::get('pastyear_highestScore');
            }
            else {
                $PastYear->highestScore = $player->getBestIn('MAX(score) as highestscore', 'highestscore', $pastYearDate);
                Cache::put('pastyear_highestScore',$PastYear->highestScore,720);
            }

            //Past Year totalArrests
            if(Cache::has('pastyear_totalArrests')) {
                $PastYear->totalArrests = Cache::get('pastyear_totalArrests');
            }
            else {
                $PastYear->totalArrests = $player->getBestIn('SUM(arrests) as totalarrests', 'totalarrests', $pastYearDate);
                Cache::put('pastyear_totalArrests',$PastYear->totalArrests,720);
            }

            //Past Year totalArrested
            if(Cache::has('pastyear_totalArrested')) {
                $PastYear->totalArrested = Cache::get('pastyear_totalArrested');
            }
            else {
                $PastYear->totalArrested = $player->getBestIn('SUM(arrested) as totalarrested', 'totalarrested', $pastYearDate);
                Cache::put('pastyear_totalArrested',$PastYear->totalArrested,720);
            }

            //Past Year totalKills
            if(Cache::has('pastyear_totalKills')) {
                $PastYear->totalKills = Cache::get('pastyear_totalKills');
            }
            else {
                $PastYear->totalKills = $player->getBestIn('SUM(kills) as totalkills', 'totalkills', $pastYearDate);
                Cache::put('pastyear_totalKills',$PastYear->totalKills,720);
            }

            //Past Year totalDeaths
            if(Cache::has('pastyear_totalDeaths')) {
                $PastYear->totalDeaths = Cache::get('pastyear_totalDeaths');
            }
            else {
                $PastYear->totalDeaths = $player->getBestIn('SUM(deaths) as totaldeaths', 'totaldeaths', $pastYearDate);
                Cache::put('pastyear_totalDeaths',$PastYear->totalDeaths,720);
            }

            //Past Year bestArrestStreak
            if(Cache::has('pastyear_bestArrestStreak')) {
                $PastYear->bestArrestStreak = Cache::get('pastyear_bestArrestStreak');
            }
            else {
                $PastYear->bestArrestStreak = $player->getBestIn('MAX(arrest_streak) as best_arrest_streak', 'best_arrest_streak', $pastYearDate);
                Cache::put('pastyear_bestArrestStreak',$PastYear->bestArrestStreak,720);
            }

            //Past Year bestKillStreak
            if(Cache::has('pastyear_bestKillStreak')) {
                $PastYear->bestKillStreak = Cache::get('pastyear_bestKillStreak');
            }
            else {
                $PastYear->bestKillStreak = $player->getBestIn('MAX(kill_streak) as best_kill_streak', 'best_kill_streak', $pastYearDate);
                Cache::put('pastyear_bestKillStreak',$PastYear->bestKillStreak,720);
            }

            //Past Year bestDeathStreak
            if(Cache::has('pastyear_bestDeathStreak')) {
                $PastYear->bestDeathStreak = Cache::get('pastyear_bestDeathStreak');
            }
            else {
                $PastYear->bestDeathStreak = $player->getBestIn('MAX(death_streak) as best_death_streak', 'best_death_streak', $pastYearDate);
                Cache::put('pastyear_bestDeathStreak',$PastYear->bestDeathStreak,720);
            }

            //Past Year totalTeamKills
            if(Cache::has('pastyear_totalTeamKills')) {
                $PastYear->totalTeamKills = Cache::get('pastyear_totalTeamKills');
            }
            else {
                $PastYear->totalTeamKills = $player->getBestIn('SUM(team_kills) as totalteamkills', 'totalteamkills', $pastYearDate);
                Cache::put('pastyear_totalTeamKills',$PastYear->totalTeamKills,720);
            }

            //Past Year totalTimePlayed
            if(Cache::has('pastyear_totalTimePlayed')) {
                $PastYear->totalTimePlayed = Cache::get('pastyear_totalTimePlayed');
            }
            else {
                $PastYear->totalTimePlayed = $player->getBestIn('SUM(time_played) as totaltimeplayed', 'totaltimeplayed', $pastYearDate);
                Cache::put('pastyear_totalTimePlayed',$PastYear->totalTimePlayed,720);
            }

            //Past Year bestScorePerMin
            if(Cache::has('pastyear_bestScorePerMin')) {
                $PastYear->bestScorePerMin = Cache::get('pastyear_bestScorePerMin');
            }
            else {
                $PastYear->bestScorePerMin = $player->getBestIn('SUM(score)/SUM(time_played)*60 as scorepermin', 'scorepermin', $pastYearDate);
                Cache::put('pastyear_bestScorePerMin',$PastYear->bestScorePerMin,720);
            }
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

        $activeUsers = User::orderBy('updated_at','DESC')->limit(99)->get();
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
            'show_add' => $show_add,
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

    /**
     * Return stream page
     *
     * @return \Illuminate\View\View
     */
    public function stream()
    {
        return view('stream');
    }

    public function getRulesOfClan()
    {
        return view('rulesofclan');
    }

    public function getuSmembers()
    {
        $clanroles = Clanrole::with('users')->get();
        return view('usmembers')->with('roles',$clanroles);
    }
}