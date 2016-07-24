<?php

namespace App\Http\Controllers;

use App\Kost;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class KostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function kost(Request $request)
    {
        \Log::info($request->all());

        $key = $request->key;

        //if($key != env("SERVER_QUERY_KEY"))
        if($key != "123456789")
        {
            \Log::error("KOST: Invalid Query Key Provided");
            exit();
        }

        $server_ip = $request->getClientIp();
        $server_port = $request->server_port;
        $server_uid = $request->server_uid;
        $type = $request->type;
        $playerone = $request->playerone;
        $playerone_ip = $request->playeroneip;
        $playertwo = $request->has('playertwo') ? $request->get('playertwo') : null;
        $playertwo_ip = $request->has('playertwo') && $request->has('playertwoip') ? $request->get('playertwoip') : null;
        $extra = $request->has('extra') ? $request->get('extra') : null;

        //$numberformatter = new \NumberFormatter('en',\NumberFormatter::ORDINAL);

        // Bake the response
        $response = "";
        $response .= $type."\n";
        $response .= $playerone."\n";
        switch($type)
        {
            case 'PlayerSuicide':
                $times = Kost::where('type',$type)->where('server_uid',$server_uid)->where('playerone',$playerone)->count();
                ++$times;
                $response .= "[b][c=ff5722]Stats[\\c][\\b]: You committed suicide [b][c=ff0000]{$times}[\\c][\\b] time!";
                break;
            case 'PlayerArrest':
            case 'PlayerTeamKill':
            case 'PlayerKill':
            case 'PlayerTeamHit':
            case 'PlayerHit':

                if($type == 'PlayerArrest')
                    $type2 = 'arrests';
                elseif($type == 'PlayerTeamKill')
                    $type2 = 'team kills';
                elseif($type == 'PlayerKill')
                    $type2 = 'kills';
                elseif($type == 'PlayerTeamHit')
                    $type2 = 'team tases';
                elseif($type == 'PlayerHit')
                    $type2 = 'tases';
                else
                    $type2 = '';

                $times = Kost::where('type',$type)->where('server_uid',$server_uid)->where('playerone',$playerone)->where('playertwo',$playertwo)->count();
                $times2 = Kost::where('type',$type)->where('server_uid',$server_uid)->where('playerone',$playertwo)->where('playertwo',$playerone)->count();
                ++$times;
                $response .= $playertwo."\n";
                $response .= "[b][c=ff5722]Stats[\\c][\\b]: [b]You[\\b] vs [b]{$playertwo}[\\b] [c=00ff00]{$times}[\\c]/[c=ff0000]{$times2}[\\c] [c=00ff00](+1)[\\c] {$type2}!\n";
                $response .= "[b][c=ff5722]Stats[\\c][\\b]: [b]You[\\b] vs [b]{$playerone}[\\b] [c=00ff00]{$times2}[\\c]/[c=ff0000]{$times}[\\c] [c=ff0000](+1)[\\c] {$type2}!";
                break;
            default:
                break;
        }

        //Now add current data to DB

        Kost::create([
            'server_ip' => $server_ip,
            'server_port' => $server_port,
            'server_uid' => $server_uid,
            'type' => $type,
            'playerone' => $playerone,
            'playerone_ip' => $playerone_ip,
            'playertwo' => $playertwo,
            'playertwo_ip' => $playertwo_ip,
            'extra' => $extra,
        ]);

        printf("%s",$response);
        exit(0);
    }
}
