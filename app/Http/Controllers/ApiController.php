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

                if($playerTotal = Player::findOrFailByNameWithNull($playerNameStripped))
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
        return (User::where('username', 'like', '%' . $query . '%')->orWhere('name', 'like', '%' . $query . '%')->orWhere('email', 'like', '%' . $query . '%')->get(['id', 'name', 'username', 'country_id']));

    }

    /**
     * @param $query
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getQueryPlayer($query)
    {
        $player = PlayerTotal::with('country')->where('name', 'like',  $query )->get(['id', 'name', 'position', 'country_id']);
        if(!$player->isEmpty())
            return $player;
        return (PlayerTotal::with('country')->where('name', 'like', '%' . $query . '%')->get(['id', 'name', 'position', 'country_id']));

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
}
