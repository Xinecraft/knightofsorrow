<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Kinnngg\Swat4query\Server as Swat4Server;
use App\Server;

class ServerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $servers = Server::orderBy('rank','ASC')->paginate();

        $collection = new Collection();

        foreach ($servers as $server) {
            try {
                $query = new Swat4Server($server->ip_address, $server->query_port);
                $query->query();
            } catch (\Exception $e) {
                continue;
            }
            $serverquery = json_decode($query);

            if ($serverquery->hostname == '...server is reloading or offline' || $serverquery->hostname == null || $serverquery->hostname == "" || empty($serverquery->hostname) )
                continue;

            $newserver = new Arr();
            $newserver->hostname = html_entity_decode(fixHostNameForServerList($serverquery->hostname));
            $newserver->map = $serverquery->map;
            $newserver->gametype = $serverquery->gametype;
            $newserver->version = $serverquery->patch;
            $newserver->players_current = $serverquery->players_current;
            $newserver->players_max = $serverquery->players_max;
            $newserver->ip_address = $server->ip_address;
            $newserver->join_port = $server->join_port;
            $newserver->id = $server->id;

            $collection->push($newserver);
        }
        $collection = $collection->sortByDesc('players_current');

        return view('server.list')->with('servers', $collection)->with('page', $servers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('server.submit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(),
            ['ip_address' => 'required|ip|max:255',
                'join_port' => 'required|numeric|min:0|max:65535',
                'query_port' => 'required|numeric|min:0|max:65535'
            ]);
        if ($validator->fails())
            return \Redirect::back()->with('errors', $validator->errors())->withInput();

        if ($this->is_server_registered($request)) {
            return \Redirect::back()->with('error', "Server already registered")->withInput();
        }

        try {
            $server = new Swat4Server($request->ip_address, $request->query_port);
            $server->query();
        } catch (\Exception $e) {
            return \Redirect::back()->with('error', "Unable to query Server. Are you sure it is live ?")->withInput();
        }

        $server = json_decode($server);

        if ($server->hostname == "...server is reloading or offline")
            return \Redirect::back()->with('error', "Unable to query Server. Are you sure it is live ?")->withInput();

        /**
         * Get the Country of Server
         */
        $geoip = \App::make('geoip');
        $server_ip = $request->ip_address;
        try {
            if ($server_geoip = $geoip->city($server_ip)) {
                $server_isoCode = $server_geoip->country->isoCode;
                $country = \App\Country::where('countryCode', 'LIKE', $server_isoCode)->first();

                /**
                 * Country returned is not in Countrie table
                 */
                if ($country == null) {
                    $server_country_id = 0;
                } else {
                    $server_country_id = $country->id;
                }
            }
        } /**
         * If the GeoIp2 failed to retrieve data
         */
        catch (\Exception $e) {
            switch ($e) {
                case $e instanceof \InvalidArgumentException:
                    $server_country_id = 0;
                    break;
                case $e instanceof \GeoIp2\Exception\AddressNotFoundException:
                    $server_country_id = 0;
                    break;
                default:
                    $server_country_id = 0;
                    break;
            }
        }

        $newServer = new Server();
        $newServer->ip_address = $request->ip_address;
        $newServer->join_port = $request->join_port;
        $newServer->query_port = $request->query_port;
        $newServer->description = $request->description == '' ? NULL : $request->description;
        $newServer->hostname = $server->hostname;
        $newServer->country_id = $server_country_id;
        $newServer->submitter_id = \Auth::user()->id;
        $newServer->save();

        return \Redirect::back()->with('message', "Server has been submitted!");
    }

    public function is_server_registered($request)
    {
        $d1 = Server::where('ip_address', $request->ip_address)->where('join_port', $request->join_port)->first();
        $d2 = Server::where('ip_address', $request->ip_address)->where('query_port', $request->query_port)->first();
        if ($d1 || $d2)
            return true;
        else
            return false;
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $server = Server::findOrFail($id);

        $serverquery = new Swat4Server($server->ip_address, $server->query_port);
        $serverquery->query();

        return \Response::make($serverquery, 200, ['Content-Type' => "text/json"]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function chatInGameForKOS(Request $request)
    {
        $Username = $request->user()->username;
        $Msg = $request->serverchatmsg;
        $Msg = htmlentities($Msg);
        if ($Msg == '' || empty($Msg)) {
            return;
        }
        $MsgFormated = "[c=ffa500][b]" . $Username . "[\\b] (Server Viewer):[\\c] [c=FFFFFF]" . $Msg;
        $txtip = "127.0.0.1";
        $txtportnum = "10483";
        $sock = fsockopen("udp://" . $txtip, $txtportnum, $errno, $errstr, 2);
        if (!$sock) {
            echo "$errstr ($errno)<br/>\n";
            exit;
        }
        fputs($sock, $MsgFormated);
        $gotfinal = False;
        $data = "";
        socket_set_timeout($sock, 0, 1000);
        fclose($sock);
        exit();
    }
}
