<?php

namespace App\Http\Controllers;

use App\Chat;
use App\PlayerTotal;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Kinnngg\Swat4query\Server as Swat4Server;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return ('Not Allowed');
    }


    /**
     * Query SWAT4 Server and returns JSON Data
     * @return Swat4Server
     */
    public function getServerQuery()
    {
        $data = new Swat4Server('127.0.0.1', 10481);
        $data->query();
        return htmlspecialchars_decode(html_entity_decode($data));
    }

    /**
     * Return Server chats
     */
    public function getServerChats()
    {
        $chats = Chat::orderBy('created_at', 'DESC')->limit(35)->get();
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

        if ($data == NULL || empty($data || env('SERVER_QUERY_KEY') != $key)) {
            return;
        }


        /**
         * Stats Query System
         * Like Top 10 Player etc.
         */
        if($playerName = "top 10")
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
                $player = $players->first();

                /*$data = [
                    'player' => $player,
                    'playerAddr' => $player->country->countryName,
                ];*/
                printf("[c=FFFF00][b][u]%s[\\u][\\b][\\c] is from [b][c=EBFFFF]%s[\\c][\\b]\n", $player->name, $player->country->countryName);
                printf("[b][c=FFFF00][u]%s[\\u][\\c][\\b]'s Position: [c=FFFEEB][b][u]#%d[\\u][\\b][\\c] [c=00FF00]-[\\c] Score: [c=FFFEEB][b][u]%d[\\u][\\b][\\c] [c=00FF00]-[\\c] Rank: [c=FFFEEB][b][u]%s[\\u][\\b][\\c]\n", $player->name, $player->position, $player->total_score, $player->rank->name);
                printf("Score Per Min: [c=FFFEEB][b][u]%.2f points[\\u][\\b][\\c] [c=00FF00]-[\\c] Highest Score: [c=FFFEEB][b][u]%d[\\u][\\b][\\c]\n", round($player->score_per_min,2), $player->highest_score);
                printf("Time Played: [c=FFFEEB][b][u]%s[\\u][\\b][\\c] [c=00ff00]-[\\c] Last Seen: [c=00FF00][b][u]%s[\\u][\\b][\\c]", gmdate("H\\h i\\m", $player->total_time_played), $player->lastGame->created_at->diffForHumans());
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

                    printf("[c=FFFF00][b][u]%s[\\u][\\b][\\c] is from [b][c=EBFFFF]%s[\\c][\\b]\n", $player->name, $player->country->countryName);
                    printf("[b][c=FFFF00][u]%s[\\u][\\c][\\b]'s Position: [c=FFFEEB][b][u]#%d[\\u][\\b][\\c] [c=00FF00]-[\\c] Score: [c=FFFEEB][b][u]%d[\\u][\\b][\\c] [c=00FF00]-[\\c] Rank: [c=FFFEEB][b][u]%s[\\u][\\b][\\c]\n", $player->name, $player->position, $player->total_score, $player->rank->name);
                    printf("Score Per Min: [c=FFFEEB][b][u]%.2f points[\\u][\\b][\\c] [c=00FF00]-[\\c] Highest Score: [c=FFFEEB][b][u]%d[\\u][\\b][\\c]\n", round($player->score_per_min,2), $player->highest_score);
                    printf("Time Played: [c=FFFEEB][b][u]%s[\\u][\\b][\\c] [c=00ff00]-[\\c] Last Seen: [c=00FF00][b][u]%s[\\u][\\b][\\c]", gmdate("H\\h i\\m", $player->total_time_played), $player->lastGame->created_at->diffForHumans());
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
            $playerCountryName = "[c=d3d3d3]Terra Incognita[\\c]";
            try {
                if ($player_geoip = $geoip->city($playerIp)) {
                    $playerCountryName = $player_geoip->country->names['en'];
                }
            }
            catch(\Exception $e)
            {
                switch($e)
                {
                    case $e instanceof \InvalidArgumentException:
                        $playerCountryName = "[c=d3d3d3]Terra Incognita[\\c]";
                        break;
                    case $e instanceof \GeoIp2\Exception\AddressNotFoundException:
                        $playerCountryName = "[c=d3d3d3]Terra Incognita[\\c]";
                        break;
                    default:
                        $playerCountryName = "[c=d3d3d3]Terra Incognita[\\c]";
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
                $player = $players->first();

                printf("[c=FFFF00][b][u]%s[\\u][\\b][\\c] is from [b][c=EBFFFF]%s[\\c][\\b]\n", $player->name, $playerCountryName);
                printf("[b][c=FFFF00][u]%s[\\u][\\c][\\b]'s Position: [c=FFFEEB][b][u]#%d[\\u][\\b][\\c] [c=00FF00]-[\\c] Score: [c=FFFEEB][b][u]%d[\\u][\\b][\\c] [c=00FF00]-[\\c] Rank: [c=FFFEEB][b][u]%s[\\u][\\b][\\c]\n", $player->name, $player->position, $player->total_score, $player->rank->name);
                printf("Score Per Min: [c=FFFEEB][b][u]%.2f points[\\u][\\b][\\c] [c=00FF00]-[\\c] Highest Score: [c=FFFEEB][b][u]%d[\\u][\\b][\\c]\n", round($player->score_per_min,2), $player->highest_score);
                printf("Time Played: [c=FFFEEB][b][u]%s[\\u][\\b][\\c] [c=00ff00]-[\\c] Last Seen: [c=00FF00][b][u]%s[\\u][\\b][\\c]", gmdate("H\\h i\\m", $player->total_time_played), $player->lastGame->created_at->diffForHumans());
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
            $playerCountryName = "[c=d3d3d3]Terra Incognita[\\c]";
            try {
                if ($player_geoip = $geoip->city($playerIp)) {
                    $playerCountryName = $player_geoip->country->names['en'];
                }
            }
            catch(\Exception $e)
            {
                switch($e)
                {
                    case $e instanceof \InvalidArgumentException:
                        $playerCountryName = "[c=d3d3d3]Terra Incognita[\\c]";
                        break;
                    case $e instanceof \GeoIp2\Exception\AddressNotFoundException:
                        $playerCountryName = "[c=d3d3d3]Terra Incognita[\\c]";
                        break;
                    default:
                        $playerCountryName = "[c=d3d3d3]Terra Incognita[\\c]";
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
                $player = $players->first();

                printf("[c=FFFF00][b][u]%s[\\u][\\b][\\c] is coming from [b][c=EBFFFF]%s[\\c][\\b]\n", $player->name, $playerCountryName);
                printf("[b][c=FFFF00][u]%s[\\u][\\c][\\b]'s Position: [c=FFFEEB][b][u]#%d[\\u][\\b][\\c] [c=00FF00]-[\\c] Score: [c=FFFEEB][b][u]%d[\\u][\\b][\\c] [c=00FF00]-[\\c] Rank: [c=FFFEEB][b][u]%s[\\u][\\b][\\c]\n", $player->name, $player->position, $player->total_score, $player->rank->name);
                printf("Score Per Min: [c=FFFEEB][b][u]%.2f points[\\u][\\b][\\c] [c=00FF00]-[\\c] Highest Score: [c=FFFEEB][b][u]%d[\\u][\\b][\\c]\n", round($player->score_per_min,2), $player->highest_score);
                printf("Time Played: [c=FFFEEB][b][u]%s[\\u][\\b][\\c] [c=00ff00]-[\\c] Last Seen: [c=00FF00][b][u]%s[\\u][\\b][\\c]", gmdate("H\\h i\\m", $player->total_time_played), $player->lastGame->created_at->diffForHumans());
                exit();

                /*$data = [
                    'player' => $player,
                    'playerAddr' => $playerCountryName,
                ];
                return view('api.whois.justjoined', $data);*/
            }
        }
    }
}
