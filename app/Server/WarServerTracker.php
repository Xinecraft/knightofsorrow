<?php

namespace App\Server;

use App;
use App\Alias;
use App\Country;
use App\Game;
use App\Loadout;
use App\Player;
use App\Profile;
use App\Weapon;
use Response;


class WarServerTracker {
    /**
     * @var string
     *
     * array[0]
     * This is a unqiue id for each game
     */
    protected $roundTag;

    /**
     * @var string
     *
     * array[1]
     * JuliaTracker Mod version current in use
     */
    protected $modVersion;

    /**
     * @var int
     *
     * array[2]
     * This is join port of the current server.
     */
    protected $joinPort;

    /**
     * @var timestamp
     *
     * array[3]
     * The time when round ended according to server in UTC
     */
    protected $serverTime;

    /**
     * @var string
     *
     * array[4]
     * Last 32 bits of an md5 encoded request signature hash
     * md5(server key` + `join port` + `timestamp`)
     */
    protected $serverHash;

    /**
     * @var int
     *
     * array[5]
     * This is the name of SWAT4 running
     * 0 -> SWAT4
     * 1 -> SWAT4X
     */
    protected $gameName;

    /**
     * @var string
     *
     * array[6]
     * The version of SWAT4 running
     * 1.0 or 1.1
     */
    protected $gameVersion;

    /**
     * @var string
     *
     * array[7]
     * Server Name
     */
    protected $hostName;

    /**
     * @var int
     *
     * array[8]
     * GameType in encoded form
     * 0 -> Barricaded Suspects
     * 1 -> VIP Escort
     * 2 -> CO-OP
     * 3 -> Smash and Grab
     */
    protected $gameType;

    /**
     * @var int
     *
     * array[9]
     * MapName in encoded form starting with 0
     * 0 -> A-Bomb Nightclub
     * 1 -> Brewer County Courthouse
     * 2 -> Children of Taronne Tenement
     * 3 -> DuPlessis Diamond Center
     * 4 -> Enverstar Power Plant
     * 5 -> Fairfax Residence
     * 6 -> Food Wall Restaurant
     * 7 -> Meat Barn Restaurant
     * 8 -> Mt. Threshold Research Center
     * 9 -> Northside Vending
     * 10 -> Old Granite Hotel
     * 11 -> Qwik Fuel Convenience Store
     * 12 -> Red Library Offices
     * 13 -> Riverside Training Facility
     * 14 -> St. Michael's Medical Center
     * 15 -> The Wolcott Projects
     * 16 -> Victory Imports Auto Center
     * 17 -> -EXP- Department of Agriculture
     * 18 -> -EXP- Drug Lab
     * 19 -> -EXP- Fresnal St. Station
     * 20 -> -EXP- FunTime Amusements
     * 21 -> -EXP- Sellers Street Auditorium
     * 22 -> -EXP- Sisters of Mercy Hostel
     * 23 -> -EXP- Stetchkov Warehouse
     */
    protected $gameMap;

    /**
     * @var int
     *
     * array[10]
     * Tell if game is password protected or not
     * 1 -> true
     * 2 -> false
     */
    protected $gamePassworded;

    /**
     * @var int
     *
     * array[11]
     * Total number of player played the round
     */
    protected $totalPlayers;

    /**
     * @var int
     *
     * array[12]
     * Maximum players allowed in Server
     */
    protected $maxPlayers;

    /**
     * @var int
     *
     * array[13]
     * round index of current round
     */
    protected $roundIndex;

    /**
     * @var int
     *
     * array[14]
     * Total number of round per Map
     */
    protected $roundLimit;

    /**
     * @var int
     *
     * array[15]
     * Time elapsed since the round start
     */
    protected $absoluteTime;

    /**
     * @var int
     *
     * array[16]
     * Game Time
     * Time the game has actually span in sec
     */
    protected $timePlayed;

    /**
     * @var int
     *
     * array[17]
     * Round time limit
     */
    protected $timeLimit;

    /**
     * @var int
     *
     * array[18]
     * Number of SWAT victories
     */
    protected $swatVictory;

    /**
     * @var int
     *
     * array[19]
     * Number of Suspects victories
     */
    protected $suspectsVictory;

    /**
     * @var int
     *
     * array[20]
     * Total Score earned by SWAT team
     */
    protected $swatScore;

    /**
     * @var int
     *
     * array[21]
     * Total Score earned by Suspects team
     */
    protected $suspectsScore;

    /**
     * @var int
     *
     * array[22]
     * Round outcome in encoded form
     *
    '0' : 'none',
    '1' : 'swat_bs',            # SWAT victory in Barricaded Suspects
    '2' : 'sus_bs',             # Suspects victory in Barricaded Suspects
    '3' : 'swat_rd',            # SWAT victory in Rapid Deployment (all bombs have been exploded)
    '4' : 'sus_rd',             # Suspects victory in Rapid Deployment (all bombs have been deactivated)
    '5' : 'tie',                # A tie
    '6' : 'swat_vip_escape',    # SWAT victory in VIP Escort - The VIP has escaped
    '7' : 'sus_vip_good_kill',  # Suspects victory in VIP Escort - Suspects have executed the VIP
    '8' : 'swat_vip_bad_kill',  # SWAT victory in VIP Escort - Suspects have killed the VIP
    '9' : 'sus_vip_bad_kill',   # Suspects victory in VIP Escort - SWAT have killed the VIP
    '10': 'coop_completed',     # COOP objectives have been completed
    '11': 'coop_failed',        # COOP objectives have been failed
    '12': 'swat_sg',            # SWAT victory in Smash and Grab
    '13': 'sus_sg',             # Suspects victory in Smash and Grab
     */
    protected $roundOutcome;

    /**
     * @type Array
     *
     * array[27]
     * Player List
     *  All Players are listed from 0 - $player_num-1 into inner array
     *  For Example $player[0][1] will have ID of first player
     *
     * 0    -   id          # ID of the Player
     * 1    -   ip          # IP Address of Player
     * 2    -   dropped     # Is Player dropped?
     * 3    -   admin       # Is Player a Admin?
     * 4    -   vip         # Is Player a VIP? . In VIP Mode
     * 5    -   name        # Player name
     * 6    -   team =>     # Player's team encoded
     *          0   -  swat
     *          1   -  suspect
     * 7    -   time        # Time the Player played the round
     * 8    -   score       # Total Score of the Player for the round
     * 9    -   kills       # Total Kills of the Player for the round
     * 10   -   teamkills   # Total Team Kills of the Player for the round
     * 11   -   deaths      # Total Deaths of the Player for the round
     * 12   -   suicides    # Total suicides of player for the round
     * 13   -   arrests     # Total Arrests of the Player for the round
     * 14   -   arrested    # Total Arrested action of the Player for the Round
     * 15   -   kill_streak # Best Kill Streak of the Player for that round
     * 16   -   arrest_streak   # Best Arrest Streak of the Player
     * 17   -   death_streak    # Best Death Streak of that player
     * 18   -   vip_captures    # the Player has captured VIP
     * 19   -   vip_rescues     # the Player has rescued the VIP
     * 20   -   vip_escapes     # the Player has escaped as VIP
     * 21   -   vip_kills_valid # The Player has killed VIP after time
     * 22   -   vip_kills_invalid   # The Player has Killed VIP before time
     * 23   -   rd_bombs_defused    # Number of Bomb defused by Player
     * 24   -   rd_crybaby          #
     * 25   -   sg_kills            #Smash and Grab Kills
     * 26   -   sg_escapes
     * 27   -   sg_crybaby
     * 28   -   coop_hostage_arrests# Total num of COOP hostage arrested
     * 29   -   coop_hostage_hits   # Total hostages hits in COOP mode
     * 30   -   coop_hostage_incaps # Total hostages incap by player in coop
     * 31   -   coop_hostage_kills  # Total hostages killed by player
     * 32   -   coop_enemy_arrests
     * 33   -   coop_enemy_incaps
     * 34   -   coop_enemy_kills
     * 35   -   coop_enemy_incaps_invalid
     * 36   -   coop_enemy_kills_invalid
     * 37   -   coop_toc_reports
     * 38   -   coop_status  =>
     *              '0': 'not_ready',
     *              '1': 'ready',
     *              '2': 'healthy',
     *              '3': 'injured',
     *              '4': 'incapacitated',
     * 39   -   loadout =>             # Player last Loadout of that round
     *              0   -   primary             # Primary Weapon ID
     *              1   -   primary_ammo        # Primary weapon ammo
     *              2   -   secondary           # Secondary weapon
     *              3   -   secondary_ammo      # Secondary weapon ammo
     *              4   -   equip_one           # Equipment Slot 1
     *              5   -   equip_two           # Equipment slot 2
     *              6   -   equip_three         # Equipment slot 3
     *              7   -   equip_four          # Equipment slot 4
     *              8   -   equip_five          # Equipment slot 5
     *              9   -   breacher            # Breacher
     *              10  -   body                # Body Armour
     *              11  -   head                # Head armor
     * 40   -   weapons =>          # Used Weapons for the Player in that Round
     *      All the Weapons will be stored from 0 to X as per uses and weapon details will contain in inner array
     *      Example weapns[1][0] will have second weapon name
     *
     *              0   -   name                # Weapon Name
     *              1   -   time                # Time Used
     *              2   -   shots               # Shots fired
     *              3   -   hits                # Hits
     *              4   -   teamhits            # Team Hits
     *              5   -   kills               # Total Kills
     *              6   -   teamkills           # Total TeamKills
     *              7   -   distance            # Longest Kill Distance
     */
    protected $players;
    /**
     * @param $data
     *
     * Initialize the data
     */
    public function __construct($data)
    {
        $this->roundTag = array_key_exists(0,$data) ? $data[0] : null;
        $this->modVersion = array_key_exists(1,$data) ? $data[1] : '0.0.0';
        $this->joinPort = array_key_exists(2,$data) ? $data[2] : 10480;
        $this->serverTime = array_key_exists(3,$data) ? $data[3] : null;
        $this->serverHash = array_key_exists(4,$data) ? $data[4] : null;
        $this->gameName = array_key_exists(5,$data) ? $data[5] : 0;
        $this->gameVersion = array_key_exists(6,$data) ? $data[6] : '1.0';
        $this->hostName = array_key_exists(7,$data) ? $data[7] : 'KoS Clan Server';
        $this->gameType = array_key_exists(8,$data) ? $data[8] : 0;
        $this->gameMap = array_key_exists(9,$data) ? $data[9] : 0;
        $this->gamePassworded = array_key_exists(10,$data) ? $data[10] : 0;
        $this->totalPlayers = array_key_exists(11,$data) ? $data[11] : 0;
        $this->maxPlayers = array_key_exists(12,$data) ? $data[12] : 0;
        $this->roundIndex = array_key_exists(13,$data) ? $data[13] : 0;
        $this->roundLimit = array_key_exists(14,$data) ? $data[14] : 0;
        $this->absoluteTime = array_key_exists(15,$data) ? $data[15] : 0;
        $this->timePlayed = array_key_exists(16,$data) ? $data[16] : 0;
        $this->timeLimit = array_key_exists(17,$data) ? $data[17] : 0;
        $this->swatVictory = array_key_exists(18,$data) ? $data[18] : 0;
        $this->suspectsVictory = array_key_exists(19,$data) ? $data[19] : 0;
        $this->swatScore = array_key_exists(20,$data) ? $data[20] : 0;
        $this->suspectsScore = array_key_exists(21,$data) ? $data[21] : 0;
        $this->roundOutcome = array_key_exists(22,$data) ? $data[22] : 0;
        $this->players = array_key_exists(27,$data) ? $data[27] : [];
        //dd($this->players);
    }


    /**
     * @return bool
     *
     * Track all round record into Database.
     */
    public function track()
    {
        /**
         * @var Game
         */
        $game = new Game();
        $game->tag = $this->roundTag;
        $game->server_time = $this->serverTime;
        $game->round_time = $this->timePlayed;
        $game->round_index = ($this->roundIndex+1)." / ".$this->roundLimit;
        $game->gametype = $this->gameType;
        $game->outcome = $this->roundOutcome;
        $game->map_id = $this->gameMap;
        $game->total_players = $this->totalPlayers;
        $game->swat_score = $this->swatScore;
        $game->suspects_score = $this->suspectsScore;
        $game->swat_vict = $this->swatVictory;
        $game->suspects_vict = $this->suspectsVictory;
        $game->server_id = 19;                          // ID of UG Server on our Server DB
        if(!$game->save()) return false;

        /**
         * Iterate over each player array
         */
        foreach($this->players as $p):

            /**
             * @var Player
             */
            $player = new Player();
            $player->ingame_id = $p[0];
            $player->ip_address = $p[1];
            $player->name = str_replace('(VIEW)','',$p[5]);
            $player->name = str_replace('(SPEC)','',$player->name);
            $player->team = array_key_exists(6,$p) ? $p[6] : 0;
            $player->is_admin = array_key_exists(3,$p) ? $p[3] : 0;
            $player->is_dropped = array_key_exists(2,$p) ? $p[2] : 0;
            $player->score = array_key_exists(8,$p) ? $p[8] : 0;
            $player->time_played = array_key_exists(7,$p) ? $p[7] : 0;
            $player->kills = array_key_exists(9,$p) ? $p[9] : 0;
            $player->team_kills = array_key_exists(10,$p) ? $p[10] : 0;
            $player->deaths = array_key_exists(11,$p) ? $p[11] : 0;
            $player->suicides = array_key_exists(12,$p) ? $p[12] : 0;
            $player->arrests = array_key_exists(13,$p) ? $p[13] : 0;
            $player->arrested = array_key_exists(14,$p) ? $p[14] : 0;
            $player->kill_streak = array_key_exists(15,$p) ? $p[15] : 0;
            $player->arrest_streak = array_key_exists(16,$p) ? $p[16] : 0;
            $player->death_streak = array_key_exists(17,$p) ? $p[17] : 0;
            $player->game_id = $game->id;
            $player_ip_trim = substr($p[1], 0, strrpos($p[1], "."));

            $player_country_id = 0;
            $geoip = App::make('geoip');
            try
            {
                if($player_geoip = $geoip->city($player->ip_address)) {
                    $player_isoCode = $player_geoip->country->isoCode;
                    $country = Country::where('countryCode', 'LIKE', $player_isoCode)->first();

                    /**
                     * Country returned is not in Countrie table
                     */
                    if($country == null)
                    {
                        $player_country_id = 0;
                    }
                    else
                    {
                        $player_country_id = $country->id;
                    }
                }

            }

                /**
                 * If the GeoIp2 failed to retrieve data
                 */
            catch(\Exception $e)
            {
                switch($e)
                {
                    case $e instanceof \InvalidArgumentException:
                        $player_country_id = 0;
                        break;
                    case $e instanceof \GeoIp2\Exception\AddressNotFoundException:
                        $player_country_id = 0;
                        break;
                    default:
                        $player_country_id = 0;
                        break;
                }
            }

            $loadout_array = array_key_exists(39, $p) ? $p[39] : [0,0,0,0,0,0,0,0,0,0,0] ;

            /**
             * @var Loadout
             *
             * Create or find and return instance of Loadout and save to database.
             */
            $loadout = Loadout::firstOrCreate([
                'primary_weapon' => array_key_exists(0,$loadout_array) ? $loadout_array[0] : 0,
                'primary_ammo' => array_key_exists(1,$loadout_array) ? $loadout_array[1] : 0,
                'secondary_weapon' => array_key_exists(2,$loadout_array) ? $loadout_array[2] : 0,
                'secondary_ammo' => array_key_exists(3,$loadout_array) ? $loadout_array[3] : 0,
                'equip_one' => array_key_exists(4,$loadout_array) ? $loadout_array[4] : 0,
                'equip_two' => array_key_exists(5,$loadout_array) ? $loadout_array[5] : 0,
                'equip_three' => array_key_exists(6,$loadout_array) ? $loadout_array[6] : 0,
                'equip_four' => array_key_exists(7,$loadout_array) ? $loadout_array[7] : 0,
                'equip_five' => array_key_exists(8,$loadout_array) ? $loadout_array[8] : 0,
                'breacher' => array_key_exists(9,$loadout_array) ? $loadout_array[9] : 0,
                'body' => array_key_exists(10,$loadout_array) ? $loadout_array[10] : 0,
                'head' => array_key_exists(11,$loadout_array) ? $loadout_array[11] : 0
            ]);

            /**
             * Create or find and return instance of Alias.
             */
            $alias = Alias::firstOrNew(['name' => $player->name]);

            /**
             * If Alias is not present then new instance is created.
             */
            if($alias->id == null)
            {
                //$profile = Profile::firstOrNew(['ip_address' => $player_ip_trim.'%']);

                $profile = Profile::where('ip_address','LIKE',$player_ip_trim.'%')->first();

                // If no profile present create new else ignore.
                if(!$profile)
                {
                    $profile = new Profile();
                }

                /**
                 * Neither Alias not Profile is present.
                 *
                 * So it will create both new Alias and Profile.
                 */
                if($profile->id == null)
                {
                    $profile->name = $player->name;
                    $profile->team = $player->team;
                    $profile->country_id = $player_country_id;
                    $profile->loadout_id = $loadout->id;
                    $profile->game_first = $game->id;
                    $profile->game_last = $game->id;
                    $profile->ip_address = $player->ip_address;
                    $profile->save();

                    $alias->name = $player->name;
                    $alias->profile_id = $profile->id;
                    $alias->ip_address = $player->ip_address;
                    $alias->save();
                }

                /**
                 * Profile present but not Alias.
                 *
                 * So this will create a new Alias and update some field in
                 * already present Profile.
                 */
                else
                {
                    $alias->name = $player->name;
                    $alias->profile_id = $profile->id;
                    $alias->ip_address = $player->ip_address;
                    $alias->save();

                    $profile->team = $player->team;
                    $profile->game_last = $game->id;
                    $profile->loadout_id = $loadout->id;
                    $profile->ip_address = $player->ip_address;
                    $profile->country_id = $player_country_id;
                    $profile->save();
                }
            }

            /**
             * If Alias already present.
             *
             * So just get the Alias and using that update Profile.
             * And also update IP Address of Alias.
             */
            else
            {
                $profile = Profile::find($alias->profile_id);
                $profile->team = $player->team;
                $profile->game_last = $game->id;
                $profile->loadout_id = $loadout->id;
                $profile->ip_address = $player->ip_address;
                $profile->country_id = $player_country_id;
                $profile->save();

                $alias->ip_address = $player->ip_address;
                $alias->save();
            }

            $player->alias_id = $alias->id;
            $player->loadout_id = $loadout->id;
            $player->country_id = $player_country_id;
            $player->save();

            /**
             * Iterate over all Weapon of each Player if exists
             */
            if(array_key_exists(40, $p)) {
                foreach ($p[40] as $w):
                    $weapon = new Weapon();
                    $weapon->name = $w[0];
                    $weapon->player_id = $player->id;
                    $weapon->seconds_used = array_key_exists(1, $w) ? $w[1] : 0;
                    $weapon->shots_fired = array_key_exists(2, $w) ? $w[2] : 0;
                    $weapon->shots_hit = array_key_exists(3, $w) ? $w[3] : 0;
                    $weapon->shots_teamhit = array_key_exists(4, $w) ? $w[4] : 0;
                    $weapon->kills = array_key_exists(5, $w) ? $w[5] : 0;
                    $weapon->teamkills = array_key_exists(6, $w) ? $w[6] : 0;
                    $weapon->distance = array_key_exists(7, $w) ? $w[7] : 0;
                    $weapon->save();
                endforeach;
            }
        endforeach;

        //$pt = new App\Server\Repositories\PlayerTotalRepository();
        //$pt->calculate();
        //$response = Response::make("0\\nStats has been successfully tracked",200);
        printf("%s","0\nRound report tracked.");
        exit(0);
    }
}