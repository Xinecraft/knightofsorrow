<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Player;
use App\PlayerTotal;
use App\Server\Utils;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Kinnngg\Swat4query\Server as Swat4Server;
use Yandex\Translate\Translator;
use Yandex\Translate\Exception;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Response
     */
    public function index()
    {
        return ('Whois Server 1.0');
    }


    /**
     * Query SWAT4 Server and returns JSON Data
     * @return Swat4Server
     */
    public function getServerQuery()
    {
        $data = new Swat4Server('127.0.0.1', 10485);
        $data->query();
        return htmlspecialchars_decode(html_entity_decode($data));
    }

    /**
     * @return string
     *
     * {"hostname":"<span style='color: #00ff00'>WWW.KNIGHTofSORROW.TK (Antics)<\/span>","password":"No","patch":"1.0","mods":"None","map":"Food Wall Restaurant","gametype":"Barricaded Suspects","players_current":"4","players_max":"12","statsenabled":"No","swatwon":"1","suspectswon":"2","round":"4","numrounds":"5","suspectsscore":"20","swatscore":"55","timeleft":"483","nextmap":"MP-ABomb","players":[{"name":"Hi_all","score":"15","ping":"84","ip":"...","team":"1","kills":"-","tkills":"-","deaths":"-","arrests":"3","arrested":"4","vipe":"-","vipkv":"-","vipki":"-","vipa":"-","vipua":"-","bombsd":"-","rdobjective":"-","sgobjective":"-","sge":"-","sgk":"-","countryCode":"MA","countryName":"Morocco"},{"name":"\u00abRick\u00bb","score":"5","ping":"176","ip":"...","team":"0","kills":"-","tkills":"-","deaths":"-","arrests":"-","arrested":"-","vipe":"-","vipkv":"-","vipki":"-","vipa":"-","vipua":"-","bombsd":"-","rdobjective":"-","sgobjective":"-","sge":"-","sgk":"-","countryCode":"MX","countryName":"Mexico"},{"name":"-","score":"-","ping":"-","ip":"...","team":"-","kills":"-","tkills":"-","deaths":"-","arrests":"-","arrested":"-","vipe":"-","vipkv":"-","vipki":"-","vipa":"-","vipua":"-","bombsd":"-","rdobjective":"-","sgobjective":"-","sge":"-","sgk":"-","countryCode":"_unknown","countryName":"Unknown Territory"},{"name":"-","score":"-","ping":"-","ip":"...","team":"-","kills":"-","tkills":"-","deaths":"-","arrests":"-","arrested":"-","vipe":"-","vipkv":"-","vipki":"-","vipa":"-","vipua":"-","bombsd":"-","rdobjective":"-","sgobjective":"-","sge":"-","sgk":"-","countryCode":"_unknown","countryName":"Unknown Territory"}]}
     */
    public function getServerQueryv3()
    {
        $data = new Swat4Server('31.186.250.32', 10485);
        $data->query();

        $chats = Chat::orderBy('created_at', 'DESC')->limit(25)->get();
        $chatList = "";
        foreach ($chats as $chat) {
            $chatList = $chatList.($chat->message) . "<br>";
        }

        $sv = [];
        $sv['isOnline'] = $data->option['hostname'] != "...server is reloading or offline";
        $sv['title'] = $data->option['map'];
        $sv['numPlayers'] = $data->option['players_current'];
        $sv['maxPlayers'] = $data->option['players_max'];
        $sv['swatWon'] = $data->option['swatwon'];
        $sv['susWon'] = $data->option['suspectswon'];
        $sv['roundNumber'] = $data->option['round'];
        $sv['numRounds'] = $data->option['numrounds'];
        $sv['scoreSuspects'] = $data->option['suspectsscore'];
        $sv['scoreSwat'] = $data->option['swatscore'];
        $sv['roundTime'] = $data->option['timeleft'];
        $sv['nextMap'] = $data->option['nextmap'];
        $sv['created'] = \Carbon\Carbon::now()->timestamp;
        $sv['chatContent'] = ($chatList);

        if($data->option['players_current'] <= 0)
        {
            $playerTableData = "<div class='no-player-online'>There are no players online.</div>";
        }
        else
        {
            $playerTableData = "<table class='table table-striped table-hover no-margin' id='ls-player-table'>";
            $playerTableData .= "<thead><tr><th class='col-xs-1'>Flag</th><th class='col-xs-7'>Name</th><th class='col-xs-2'>Score</th><th class='text-right col-xs-2'>Ping</th></tr></thead><tbody id='ls-player-table-body'></tbody>";

            foreach($data->option['players'] as $player)
            {
                $IP = explode(":",$player['ip'])[0];
                $geoip = \App::make('geoip');
                $playerCountryCode = "_unknown";
                $playerCountryName = "Unknown Territory";
                try {
                    if ($player_geoip = $geoip->city($IP)) {
                        $playerCountryName = $player_geoip->country->name;
                        $playerCountryCode = $player_geoip->country->isoCode;
                    }
                }
                catch(\Exception $e)
                {
                    switch($e)
                    {
                        case $e instanceof \InvalidArgumentException:
                            $playerCountryCode = "_unknown";
                            $playerCountryName = "Unknown Territory";
                            break;
                        case $e instanceof \GeoIp2\Exception\AddressNotFoundException:
                            $playerCountryCode = "_unknown";
                            $playerCountryName = "Unknown Territory";
                            break;
                        default:
                            $playerCountryCode = "_unknown";
                            $playerCountryName = "Unknown Territory";
                            break;
                    }
                }

                $playerTableData .= "<tr class=''><td><img src='/images/flags/20_shiny/{$playerCountryCode}.png' title='{$playerCountryName}' class='tooltipster' alt='$playerCountryCode'></td>";

                $playerNameStripped = str_replace('(VIEW)','',$player['name']);
                $playerNameStripped = str_replace('(SPEC)','',$playerNameStripped);
                $playerNameStripped = htmlspecialchars_decode(html_entity_decode(html_entity_decode($playerNameStripped)));

                $showRadioIfAdmin="";
                $IPorNull = "";
                if(\Auth::check() && \Auth::user()->isAdmin())
                {
                    //$showRadioIfAdmin = "<input class='pull-left' type='radio' name='selected_player' value='$playerNameStripped'> &nbsp;";
                    $showRadioIfAdmin = $showRadioIfAdmin . "<a style='color:purple' class='fancybox livepfancy fancybox.ajax' href='./liveplayeraction?player={$playerNameStripped}' title='{$player['name']}'><i class='fa fa-cog'></i></a> &nbsp;";
                    $IPorNull = $IP;
                }

                if($playerTotal = PlayerTotal::findOrFailByNameWithNull($playerNameStripped))
                {
                    $playerTableData .= "<td>{$showRadioIfAdmin}<b><a title='{$IPorNull}' class='tooltipster team-{$player['team']}' href='".route('player-detail',$playerNameStripped)."'>".$player['name']."</b></a></td>";
                }
                else
                {
                    $playerTableData .= "<td>{$showRadioIfAdmin}<span title='{$IPorNull}' class='tooltipster team-{$player['team']}'>".$player['name']."</span></td>";
                }

                $playerTableData .= "<td class='text-bold'>{$player['score']}</td>";
                $playerTableData .= "<td class='text-right text-bold'>{$player['ping']}</td>";
            }
        }

        $sv['onlinePlayersContent'] = htmlspecialchars_decode(html_entity_decode($playerTableData));

        $data = json_encode($sv);
        return ($data);

    }

    public function getServerQueryv2()
    {
        $data = new Swat4Server('127.0.0.1', 10485);
        $data->query();

        $sv = [];

        $sv['map'] = $data->option['map'];
        $sv['players_current'] = $data->option['players_current'];
        $sv['players_max'] = $data->option['players_max'];
        $sv['swatwon'] = $data->option['swatwon'];
        $sv['suspectswon'] = $data->option['suspectswon'];
        $sv['round'] = $data->option['round'];
        $sv['numrounds'] = $data->option['numrounds'];
        $sv['suspectsscore'] = $data->option['suspectsscore'];
        $sv['swatscore'] = $data->option['swatscore'];
        $sv['timeleft'] = $data->option['timeleft'];
        $sv['nextmap'] = $data->option['nextmap'];


        array_walk($data->option['players'],function(&$item1, $key){
            $item1['ip'] = explode(":",$item1['ip'])[0];

            // Country Fetch with IP
            $IP = $item1['ip'];

            $geoip = \App::make('geoip');
            $playerCountryCode = "_unknown";
            $playerCountryName = "Unknown Territory";
            try {
                if ($player_geoip = $geoip->city($IP)) {
                    $playerCountryName = $player_geoip->country->name;
                    $playerCountryCode = $player_geoip->country->isoCode;
                }
            }
            catch(\Exception $e)
            {
                switch($e)
                {
                    case $e instanceof \InvalidArgumentException:
                        $playerCountryCode = "_unknown";
                        $playerCountryName = "Unknown Territory";
                        break;
                    case $e instanceof \GeoIp2\Exception\AddressNotFoundException:
                        $playerCountryCode = "_unknown";
                        $playerCountryName = "Unknown Territory";
                        break;
                    default:
                        $playerCountryCode = "_unknown";
                        $playerCountryName = "Unknown Territory";
                        break;
                }
            }

            $item1['ip'] = "...";
            $item1['countryCode'] = $playerCountryCode;
            $item1['countryName'] = $playerCountryName;
        });

        return htmlspecialchars_decode(html_entity_decode($data));
    }

    /**
     * Return Server chats
     */
    public function getServerChats()
    {
        $chats = Chat::orderBy('created_at', 'DESC')->limit(25)->get();
        foreach ($chats as $chat) {
            print($chat->message) . "<br>";
        }
    }

    /**
     * @param $query
     * @return mixed
     */
    public function getQueryUser($query)
    {
        return (User::with(['country','photo'])->where('username', 'like', '%' . $query . '%')->orWhere('name', 'like', '%' . $query . '%')->orWhere('email', 'like', '%' . $query . '%')->get(['id', 'name', 'username', 'country_id', 'created_at', 'player_totals_name', 'dob', 'gr_id', 'facebook_url', 'website_url', 'steam_nickname', 'discord_username', 'photo_id', 'gender']));
    }

    /**
     * @param $query
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getQueryPlayer($query)
    {
        $player = PlayerTotal::with(['country','rank'])->where('name', 'like',  $query )->orderBy('position')->get(['id', 'name', 'position', 'country_id', 'rank_id', 'total_score', 'total_points']);
        if(!$player->isEmpty())
            return $player;
        return (PlayerTotal::with(['country','rank'])->where('name', 'like', '%' . $query . '%')->orderBy('position')->get(['id', 'name', 'position', 'country_id', 'rank_id', 'total_score', 'total_points']));
    }

    /**
     * Query API for Gameserver to query for Players
     *
     * @param Request $request
     * @return $this|void
     */
    public function whois(Request $request)
    {
        $data = $request->data;
        $data = explode("$$", $data);
        $playerName = $data[0];
        $playerIp = $data[1];
        $bOffline = $data[2];
        $key = $data[3];

        if ($data == NULL || empty($data) || env('SERVER_QUERY_KEY') != $key) {
            return;
        }


        /**
         * Stats Query System
         * Like Top 10 Player etc.
         */
        if($playerName == "top 10")
        {
            $players = PlayerTotal::orderBy('position')->limit(10)->get();
            $i = 1;
            $pl = "";
            foreach($players as $player)
            {
                if($i%2 == 0)
                    $pl = $pl.("[c=FFFFFF][b]#$player->position[\\c] [c=FFFF00][b]$player->name[\\b][\\c]\n");
                else
                    $pl = $pl.("[c=FFFFFF][b]#$player->position[\\c] [c=FFFF00][b]$player->name[\\b][\\c][c=00ff00][b]  -  [\\b][\\c]");
                $i++;
            }
            printf("[c=00ffdd][b][u]Top #10 Players of Server[\\u][\\b][\\c]\n");
            printf("%s",$pl);
            exit();
        }


        /**
         * Player Query System
         */

        /**
         * If the Searched Name is Not Present in Server
         *
         */
        if ($bOffline == "yes") {
            $players = PlayerTotal::where('name', 'LIKE', "%$playerName%")->get();

            /**
             * If Not Found
             */
            if ($players->isEmpty() || is_null($players)) {
                return view('api.whois.notfound')->with('playerName', $playerName);
            } /**
             * Else if only one found
             */
            elseif ($players->count() == 1) {
                $al = "";
                $player = $players->first();
                $aliases = $player->aliases()->whereNotIn('name',\App\DeletedPlayer::lists('player_name'))->where('name','!=',$player->name)->limit(3)->get();
                if(!$aliases->isEmpty())
                {
                    foreach ($aliases as $alias)
                    {
                        $al = $al . $alias->name." - ";
                    }
                }

                /*$data = [
                    'player' => $player,
                    'playerAddr' => $player->country->countryName,
                ];*/

                printf("[c=FFFF00][b][u]%s[\\u][\\b][\\c] is from [b][c=EBFFFF]%s[\\c][\\b]\n", $player->name, $player->country->countryName);
                printf("[b][c=FFFF00][u]%s[\\u][\\c][\\b]'s Position: [c=FFFEEB][b][u]#%d[\\u][\\b][\\c] [c=00FF00]-[\\c] Score: [c=FFFEEB][b][u]%d[\\u][\\b][\\c] [c=00FF00]-[\\c] Rank: [c=FFFEEB][b][u]%s[\\u][\\b][\\c]\n", $player->name, $player->position, $player->total_score, $player->rank->name);
                printf("Score Per Min: [c=FFFEEB][b][u]%.2f points[\\u][\\b][\\c] [c=00FF00]-[\\c] Highest Score: [c=FFFEEB][b][u]%d[\\u][\\b][\\c]\n", round($player->score_per_min,2), $player->highest_score);
                printf("Time Played: [c=FFFEEB][b][u]%s[\\u][\\b][\\c] [c=00ff00]-[\\c] Last Seen: [c=00FF00][b][u]%s[\\u][\\b][\\c]\n", gmdate("H\\h i\\m", $player->total_time_played), $player->lastGame->created_at->diffForHumans());
                if(!$aliases->isEmpty())
                    printf("[b]Aka: [c=f39c12]%s[\\c]", substr($al, 0, -3));

                $user = $player->user();
                if($user)
                {
                    printf("\nOwner's username: [c=0000FF][b]@%s[\\c]", $user->username);
                }
                exit();

                //return view('api.whois.onefound', $data);

            } /**
             * More than one player matched that search string.
             * But Still the name provided matches the Exact one amoung many so display the Exact matching Playername
             */
            else {
                $playerss = PlayerTotal::where('name', 'LIKE', "$playerName")->get();

                // Display single one
                if ($playerss->count() == 1) {
                    $al = "";
                    $player = $playerss->first();
                    $aliases = $player->aliases()->whereNotIn('name',\App\DeletedPlayer::lists('player_name'))->where('name','!=',$player->name)->limit(3)->get();
                    if(!$aliases->isEmpty())
                    {
                        foreach ($aliases as $alias)
                        {
                            $al = $al . $alias->name." - ";
                        }
                    }

                    printf("[c=FFFF00][b][u]%s[\\u][\\b][\\c] is from [b][c=EBFFFF]%s[\\c][\\b]\n", $player->name, $player->country->countryName);
                    printf("[b][c=FFFF00][u]%s[\\u][\\c][\\b]'s Position: [c=FFFEEB][b][u]#%d[\\u][\\b][\\c] [c=00FF00]-[\\c] Score: [c=FFFEEB][b][u]%d[\\u][\\b][\\c] [c=00FF00]-[\\c] Rank: [c=FFFEEB][b][u]%s[\\u][\\b][\\c]\n", $player->name, $player->position, $player->total_score, $player->rank->name);
                    printf("Score Per Min: [c=FFFEEB][b][u]%.2f points[\\u][\\b][\\c] [c=00FF00]-[\\c] Highest Score: [c=FFFEEB][b][u]%d[\\u][\\b][\\c]\n", round($player->score_per_min,2), $player->highest_score);
                    printf("Time Played: [c=FFFEEB][b][u]%s[\\u][\\b][\\c] [c=00ff00]-[\\c] Last Seen: [c=00FF00][b][u]%s[\\u][\\b][\\c]\n", gmdate("H\\h i\\m", $player->total_time_played), $player->lastGame->created_at->diffForHumans());
                    if(!$aliases->isEmpty())
                        printf("[b]Aka: [c=f39c12]%s[\\c]", substr($al, 0, -3));

                    $user = $player->user();
                    if($user)
                    {
                        printf("\nOwner's username: [c=0000FF][b]@%s[\\c]", $user->username);
                    }
                    exit();

                    /*$data = [
                        'player' => $player,
                        'playerAddr' => $player->country->countryName,
                    ];
                    return view('api.whois.onefound', $data);*/

                } // Display list of all players matching
                else {
                        $playerlist = "";
                        $i = 1;
                    foreach($players->take(2) as $player){
                        // If the limit exceed 4 players then only show 2
                        $playerlist = $playerlist ."[c=FFFF00]". $player->name . "[\\c][c=00ff00] - [\\c]";
                    }

                    $playerlist = substr($playerlist, 0, -17);
                    printf("Found [b]%s[\\b] players matching [b]%s[\\b]:\\n [b]%s[\\b]", $players->count(), $playerName, $playerlist);
                    exit();
                    /*$data = [
                        'players' => $players,
                        'searchQuery' => $playerName
                    ];
                    return view('api.whois.manyfound', $data);*/
                }
            }
        } /**
         * If player name queried for is already present in Server
         * i.e, the player name queried for is Live in server....
         */
        else if ($bOffline == "no") {
            $players = PlayerTotal::where('name', 'LIKE', "$playerName")->get();

            $geoip = \App::make('geoip');
            $playerCountryName = "[c=d3d3d3]Unknown Territory[\\c]";
            try {
                if ($player_geoip = $geoip->city($playerIp)) {
                    //$playerCountryName = $player_geoip->country->names['en'];
                    $playerCountryName = $player_geoip->city->names['en'] == "" ? "" : $player_geoip->city->names['en'].", ";
                    $playerCountryName = $playerCountryName.$player_geoip->country->names['en'];
                }
            }
            catch(\Exception $e)
            {
                switch($e)
                {
                    case $e instanceof \InvalidArgumentException:
                        $playerCountryName = "[c=d3d3d3]Unknown Territory[\\c]";
                        break;
                    case $e instanceof \GeoIp2\Exception\AddressNotFoundException:
                        $playerCountryName = "[c=d3d3d3]Unknown Territory[\\c]";
                        break;
                    default:
                        $playerCountryName = "[c=d3d3d3]Unknown Territory[\\c]";
                        break;
                }
            }

            /**
             * Player has never played in this server before
             */
            if ($players->count() <= 0)
            {
                printf("[c=FFFF00][b][u]%s[\\u][\\b][\\c] is from [b][c=EBFFFF]%s[\\c][\\b]", $playerName, $playerCountryName);
                exit();
            }
            /**
             * Check if this player has played before or not
             * Do this if player is old mate :)
             */
            else
            {
                $al = "";
                $player = $players->first();
                $aliases = $player->aliases()->whereNotIn('name',\App\DeletedPlayer::lists('player_name'))->where('name','!=',$player->name)->limit(3)->get();
                if(!$aliases->isEmpty())
                {
                    foreach ($aliases as $alias)
                    {
                        $al = $al . $alias->name." - ";
                    }
                }

                printf("[c=FFFF00][b][u]%s[\\u][\\b][\\c] is from [b][c=EBFFFF]%s[\\c][\\b]\n", $player->name, $playerCountryName);
                printf("[b][c=FFFF00][u]%s[\\u][\\c][\\b]'s Position: [c=FFFEEB][b][u]#%d[\\u][\\b][\\c] [c=00FF00]-[\\c] Score: [c=FFFEEB][b][u]%d[\\u][\\b][\\c] [c=00FF00]-[\\c] Rank: [c=FFFEEB][b][u]%s[\\u][\\b][\\c]\n", $player->name, $player->position, $player->total_score, $player->rank->name);
                printf("Score Per Min: [c=FFFEEB][b][u]%.2f points[\\u][\\b][\\c] [c=00FF00]-[\\c] Highest Score: [c=FFFEEB][b][u]%d[\\u][\\b][\\c]\n", round($player->score_per_min,2), $player->highest_score);
                printf("Time Played: [c=FFFEEB][b][u]%s[\\u][\\b][\\c] [c=00ff00]-[\\c] Last Seen: [c=00FF00][b][u]%s[\\u][\\b][\\c]\n", gmdate("H\\h i\\m", $player->total_time_played), $player->lastGame->created_at->diffForHumans());
                if(!$aliases->isEmpty())
                    printf("[b]Aka: [c=f39c12]%s[\\c]", substr($al, 0, -3));

                $user = $player->user();
                if($user)
                {
                    printf("\nOwner's username: [c=0000FF][b]@%s[\\c]", $user->username);
                }
                exit();

                /*$data = [
                    'player' => $player,
                    'playerAddr' => $playerCountryName,
                ];
                return view('api.whois.onefound', $data);*/
            }
        }

        /**
         * Send this for the Player Joining the server if whois on join is enabled in Server
         */
        elseif ($bOffline == "justjoined")
        {
            $players = PlayerTotal::where('name', 'LIKE', "$playerName")->get();

            $geoip = \App::make('geoip');
            $playerCountryName = "[c=d3d3d3]Unknown Territory[\\c]";
            try {
                if ($player_geoip = $geoip->city($playerIp)) {
                    //$playerCountryName = $player_geoip->country->names['en'];
                    $playerCountryName = $player_geoip->city->names['en'] == "" ? "" : $player_geoip->city->names['en'].", ";
                    $playerCountryName = $playerCountryName.$player_geoip->country->names['en'];
                }
            }
            catch(\Exception $e)
            {
                switch($e)
                {
                    case $e instanceof \InvalidArgumentException:
                        $playerCountryName = "[c=d3d3d3]Unknown Territory[\\c]";
                        break;
                    case $e instanceof \GeoIp2\Exception\AddressNotFoundException:
                        $playerCountryName = "[c=d3d3d3]Unknown Territory[\\c]";
                        break;
                    default:
                        $playerCountryName = "[c=d3d3d3]Unknown Territory[\\c]";
                        break;
                }
            }

            /**
             * Player has never played in this server before
             */
            if ($players->count() <= 0)
            {
                printf("[c=FFFF00][b][u]%s[\\u][\\b][\\c] is coming from [b][c=EBFFFF]%s[\\c][\\b]", $playerName, $playerCountryName);
                exit();
            }

            /**
             * Check if this player has played before or not
             * Do this if player is old mate :)
             */
            else
            {
                $al = "";
                $player = $players->first();
                $aliases = $player->aliases()->whereNotIn('name',\App\DeletedPlayer::lists('player_name'))->where('name','!=',$player->name)->limit(3)->get();
                if(!$aliases->isEmpty())
                {
                    foreach ($aliases as $alias)
                    {
                        $al = $al . $alias->name." - ";
                    }
                }
                printf("[c=FFFF00][b][u]%s[\\u][\\b][\\c] is coming from [b][c=EBFFFF]%s[\\c][\\b]\n", $player->name, $playerCountryName);
                printf("[b][c=FFFF00][u]%s[\\u][\\c][\\b]'s Position: [c=FFFEEB][b][u]#%d[\\u][\\b][\\c] [c=00FF00]-[\\c] Score: [c=FFFEEB][b][u]%d[\\u][\\b][\\c] [c=00FF00]-[\\c] Rank: [c=FFFEEB][b][u]%s[\\u][\\b][\\c]\n", $player->name, $player->position, $player->total_score, $player->rank->name);
                printf("Score Per Min: [c=FFFEEB][b][u]%.2f points[\\u][\\b][\\c] [c=00FF00]-[\\c] Highest Score: [c=FFFEEB][b][u]%d[\\u][\\b][\\c]\n", round($player->score_per_min,2), $player->highest_score);
                printf("Time Played: [c=FFFEEB][b][u]%s[\\u][\\b][\\c] [c=00ff00]-[\\c] Last Seen: [c=00FF00][b][u]%s[\\u][\\b][\\c]\n", gmdate("H\\h i\\m", $player->total_time_played), $player->lastGame->created_at->diffForHumans());
                if(!$aliases->isEmpty())
                    printf("[b]Aka: [c=f39c12]%s[\\c]", substr($al, 0, -3));

                $user = $player->user();
                if($user)
                {
                    printf("\nOwner's username: [c=0000FF][b]@%s[\\c]", $user->username);
                }
                exit();
                /*$data = [
                    'player' => $player,
                    'playerAddr' => $playerCountryName,
                ];
                return view('api.whois.justjoined', $data);*/
            }
        }
    }

    public function whoisforserver(Request $request)
    {
        $data = $request->data;
        $data = explode("$$", $data);
        $playerName = $data[0];
        $playerIp = $data[1];
        $bOffline = $data[2];
        $key = $data[3];

        if ($data == NULL || empty($data) || "koswhois1337" != $key) {
            printf("%s","[b]([c=00ff00]KNIGHTofSORROW.TK[\\c]): [c=ff0000]Unable to Query Server");
            exit;
        }

        /**
         * Player Query System
         */

        /**
         * If the Searched Name is Not Present in Server
         *
         */
        if ($bOffline == "yes") {
            $players = PlayerTotal::where('name', 'LIKE', "%$playerName%")->get();

            /**
             * If Not Found
             */
            if ($players->isEmpty() || is_null($players)) {
                return view('api.whois.notfound')->with('playerName', $playerName);
            } /**
             * Else if only one found
             */
            elseif ($players->count() == 1) {
                $player = $players->first();

                /*$data = [
                    'player' => $player,
                    'playerAddr' => $player->country->countryName,
                ];*/

                printf("[c=FFFF00][b][u]%s[\\u][\\b][\\c] is from [b][c=EBFFFF]%s[\\c][\\b]", $player->name, $player->country->countryName);
                exit();

                //return view('api.whois.onefound', $data);

            } /**
             * More than one player matched that search string.
             * But Still the name provided matches the Exact one amoung many so display the Exact matching Playername
             */
            else {
                $playerss = PlayerTotal::where('name', 'LIKE', "$playerName")->get();

                // Display single one
                if ($playerss->count() == 1) {
                    $player = $playerss->first();

                    printf("[c=FFFF00][b][u]%s[\\u][\\b][\\c] is from [b][c=EBFFFF]%s[\\c][\\b]", $player->name, $player->country->countryName);
                    exit();

                    /*$data = [
                        'player' => $player,
                        'playerAddr' => $player->country->countryName,
                    ];
                    return view('api.whois.onefound', $data);*/

                } // Display list of all players matching
                else {
                    $playerlist = "";
                    $i = 1;
                    foreach($players->take(2) as $player){
                        // If the limit exceed 4 players then only show 2
                        $playerlist = $playerlist ."[c=FFFF00]". $player->name . "[\\c][c=00ff00] - [\\c]";
                    }

                    $playerlist = substr($playerlist, 0, -17);
                    printf("Found [b]%s[\\b] players matching [b]%s[\\b]:\\n [b]%s[\\b]", $players->count(), $playerName, $playerlist);
                    exit();
                    /*$data = [
                        'players' => $players,
                        'searchQuery' => $playerName
                    ];
                    return view('api.whois.manyfound', $data);*/
                }
            }
        } /**
         * If player name queried for is already present in Server
         * i.e, the player name queried for is Live in server....
         */
        else if ($bOffline == "no") {

            $geoip = \App::make('geoip');
            $playerCountryName = "[c=d3d3d3]Unknown Territory[\\c]";
            try {
                if ($player_geoip = $geoip->city($playerIp)) {
                    $playerCountryName = $player_geoip->city->names['en'] == "" ? "" : $player_geoip->city->names['en'].",";
                    $playerCountryName = $playerCountryName.$player_geoip->country->names['en'];
                }
            }
            catch(\Exception $e)
            {
                switch($e)
                {
                    case $e instanceof \InvalidArgumentException:
                        $playerCountryName = "[c=d3d3d3]Unknown Territory[\\c]";
                        break;
                    case $e instanceof \GeoIp2\Exception\AddressNotFoundException:
                        $playerCountryName = "[c=d3d3d3]Unknown Territory[\\c]";
                        break;
                    default:
                        $playerCountryName = "[c=d3d3d3]Unknown Territory[\\c]";
                        break;
                }
            }

            /**
             * Player has never played in this server before
             */

            printf("[c=FFFF00][b][u]%s[\\u][\\b][\\c] is from [b][c=EBFFFF]%s[\\c][\\b]", $playerName, $playerCountryName);
            exit();
        }

        /**
         * Send this for the Player Joining the server if whois on join is enabled in Server
         */
        elseif ($bOffline == "justjoined")
        {
            $geoip = \App::make('geoip');
            $playerCountryName = "[c=d3d3d3]Unknown Territory[\\c]";
            try {
                if ($player_geoip = $geoip->city($playerIp)) {
                    $playerCountryName = $player_geoip->city->names['en'] == "" ? "" : $player_geoip->city->names['en'].",";
                    $playerCountryName = $playerCountryName.$player_geoip->country->names['en'];
                }
            }
            catch(\Exception $e)
            {
                switch($e)
                {
                    case $e instanceof \InvalidArgumentException:
                        $playerCountryName = "[c=d3d3d3]Unknown Territory[\\c]";
                        break;
                    case $e instanceof \GeoIp2\Exception\AddressNotFoundException:
                        $playerCountryName = "[c=d3d3d3]Unknown Territory[\\c]";
                        break;
                    default:
                        $playerCountryName = "[c=d3d3d3]Unknown Territory[\\c]";
                        break;
                }
            }

                printf("[c=FFFF00][b][u]%s[\\u][\\b][\\c] is coming from [b][c=EBFFFF]%s[\\c][\\b]", $playerName, $playerCountryName);
                exit();
        }
    }

    public function getCountryCodeFromIP($IP)
    {
        $geoip = \App::make('geoip');
        $playerCountryCode = "_unknown";
        try {
            if ($player_geoip = $geoip->city($IP)) {
                $playerCountryCode = $player_geoip->country->isoCode;
            }
        }
        catch(\Exception $e)
        {
            switch($e)
            {
                case $e instanceof \InvalidArgumentException:
                    $playerCountryCode = "_unknown";
                    break;
                case $e instanceof \GeoIp2\Exception\AddressNotFoundException:
                    $playerCountryCode = "_unknown";
                    break;
                default:
                    $playerCountryCode = "_unknown";
                    break;
            }
        }
        printf("%s",$playerCountryCode);
    }

    /**
     * Translate from one langage to other via google translate api
     * @param Request $request
     */
    public function translateText(Request $request)
    {
        \Log::info(\Input::all());
        if(env('TRANSLATE_KEY') != $request->key)
        {
            print("KnightofSorrow.tk: Invalid Usage Key");
            exit();
        }

        $from_lang = $request->from_lang;
        if($from_lang == "detect")
            $from_lang = null;

        $to_lang = $request->to_lang;
        $text = $request->text;
        $player = $request->player;

        try {
            $translator = new Translator(env('YANDEX_API_KEY'));
            $translation = $translator->translate($text, 'en');

            $translated_text =  $translation;

            $language = $translation->getSourceLanguage();
        } catch (Exception $e) {
            $language = "Unknown";
            $translated_text = $text;
        }

        if($language == false || $language == null || $language == "")
        {
            $language = "Unknown";
        }
        else
        {
            $language = Utils::languageByCode1($language);
        }
        printf("[c=00ff00][b]%s[\\b][c=ffff00] (in %s)[c=00ff00]: %s[\\c]",$player,$language,$translated_text);
        exit();
    }

    public function getRandomJoke()
    {
        $joke = Collection::make([
            'I m so bored like Schumacher in taxi.',
            'I m bored like black man in solarium.',
            'Bro you are lying like brothers Grimm together!',
            'Didnt I tell you that you can speak only when chickens piss!',
            'Can a kangaroo jump higher than a house? Of course, a house doesn’t jump at all.',
            'Doctor: "I\'m sorry but you suffer from a terminal illness and have only 10 to live."
Patient: "What do you mean, 10? 10 what? Months? Weeks?!"
Doctor: "Nine. Eight, Seven..."',
            'Dentist: "You need a crown."
Patient: "Finally someone who understands me"',
            'It is so cold outside I saw a politician with his hands in his own pockets.',
            'Patient: Oh doctor, I’m just so nervous. This is my first operation.
Doctor: Don\'t worry. Mine too.',
            'Men 1845: I just killed a buffalo.
Men 1952: I just fixed the roof.
Men 2017: I just shaved my leg',
            'I can’t believe I forgot to go to the gym today. That’s 7 years in a row now.',
            'A naked women robbed a bank. Nobody could remember her face.',
            'Naked women always have right!',
            'I’m selling my talking parrot. Why? Because yesterday, the bastard tried to sell me.',
            'Doctor says to his patient: "You have cancer and Alzheimer."
Patient: "At least I don\'t have cancer."',
            'What is risky?
Sneezing while having diarrhea!',
            'A wife is like a hand grenade. Take off the ring and say good bye to your house.',
            'Never trust to a woman that lying!',
            'I told my girlfriend she drew her eyebrows too high. She seemed surprised.',
            'My friend says to me: "What rhymes with orange" I said: "no it doesn\'t"',
            'What is faster or rabbit?',
            'I want to die peacefully in my sleep like my grandfather did, not screaming in terror like the passengers in his car.',
            'Why is six afraid of sever? because sever ate nine.',
            'Q: Did you hear about the guy who ran infront of the bus? A: He got tired ',
            'Q: What do u call a bunny with a bent dick? A: FUCKS FUNNY ',
            'Q: Why did Hitler commit suicide? A: He got the gas bill. ',
            'Q: Why did the Mafia cross the road? A: Forget about it. ',
            'Q: What do you call an Italian hooker? A: A Pasta-tute',
            'People say nothing is impossible, but I do nothing every day.',
            'If you can\'t beat them, arrange to have them beaten.',
            'To all you virgins, thanks for nothing.',
            'Error. No keyboard. Press F1 to continue.',
            'This sentence is a lie.',
            'There are 7 days in a week, but no fun at all.'
        ])->random();

        return \Response::json(['joke' => $joke],200);
    }

    public function getRandomInsult()
    {
        $joke = Collection::make([
            'I just stepped in something that was smarter than you… and smelled better too.',
            'Your parents hated you so much your bath toys were an iron and a toaster',
            'Even if you were twice as smart, you\'d still be stupid!',
            'Am I getting smart with you? How would you know?',
            'The only way you\'ll ever get laid is if you crawl up a chicken\'s ass and wait.',
            'You\'re a person of rare intelligence. It\'s rare when you show any.',
            'The only way you\'ll ever get laid is if you crawl up a chicken\'s ass and wait.',
            'If you were any less intelligent we\'d have to water you three times a week.',
            'If you spoke your mind, you\'d be speechless.',
            'You\'re so fat you show up on radar.',
            'You\'re so fat I\'d have to grease the door frame and hold a Twinkie on the other side just to get you through',
            '(if you try to insult bot) How original. No one else had thought of trying to get the bot to insult itself. I applaud your creativity. 
Yawn. Perhaps this is why you don\'t have friends. You don\'t add anything new to any conversation. 
You are more of a bot than me, predictable answers, and absolutely dull to have an actual conversation with.',
            'Yo Mama so fat she\'s on both sides of the family.',
            'I hear the only place you\'re ever invited is outside.',
            'I can explain it to you, but I can\'t understand it for you.',
            'I heard your parents took you to a dog show and you won.',
            'You\'re so ugly, when you popped out the doctor said "Aww what a treasure" and your mom said "Yeah, lets bury it."',
            'If you really want to know about mistakes, you should ask your parents.',
            'You\'re so ugly you make blind kids cry.',
            'Yo Mama so dumb she bought tickets to Xbox Live.',
            'You\'re so fat when you turn around, people throw you a welcome back party.',
            'You\'re not pretty enough to be this stupid.',
            'You\'re so ugly, when you popped out the doctor said "Aww what a treasure" and your mom said "Yeah, lets bury it',
            'The only way you\'ll ever get laid is if you crawl up a chicken\'s ass and wait.',
            'Did your parents ever ask you to run away from home?',
            'You\'re so ugly, when you got robbed, the robbers made you wear their masks.',
            'Hey, your village called – they want their idiot back',
            'You couldn\'t pour water out of a boot if the instructions were on the heel.',
            'Don\'t you need a license to be that ugly?',
            'Ordinarily people live and learn. You just live.',
            'You\'re so fat that when you fell from your bed you fell from both sides.',
            'I don\'t exactly hate you, but if you were on fire and I had water, I\'d drink it.',
            'You\'re so fat when you get on the scale it says "To be continued."',
            'You\'re so fat that at the zoo the elephants started throwing you peanuts.',
            'You \'re ugly like ass from inside.',
            'You\'re so fat every time you turn around, it\'s your birthday.',
            'You\'re so ugly, when you got robbed, the robbers made you wear their masks.',
            'You\'re so fat you got arrested at the airport for ten pounds of crack.',
            'You \'re so bad luck that when black cat sees you, she spits 3 times.',
            'You\'re so fat you fell in love and broke it.',
            'What\'s the difference between you and eggs? Eggs get laid and you don\'t',
            'You\'re so fat you can\'t fit in any timeline.',
            'You\'re so fat when you go swimming the whales start singing "We Are Family".',
            'You\'re so ugly, you scared the crap out of the toilet.',
            'If you were any less intelligent we\'d have to water you three times a week.',
            'The only way you\'ll ever get laid is if you crawl up a chicken\'s ass and wait.',
            'You\'re a person of rare intelligence. It\'s rare when you show any.'
        ])->random();

        return \Response::json(['insult' => $joke],200);
    }

    public function getRandomAss()
    {
        $images = glob('images/nsfw/ass/*');
        $image = url()."/".$images[rand(0, count($images) - 1)];
        return \Response::json(['image' => $image],200);
    }

    public function getRandomBoobs()
    {
        $images = glob('images/nsfw/boobs/*');
        $image = url()."/".$images[rand(0, count($images) - 1)];
        return \Response::json(['image' => $image],200);
    }
}
