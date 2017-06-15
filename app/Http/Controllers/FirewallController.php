<?php

namespace App\Http\Controllers;

use App\Http\Requests\FirewallRequest;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use PragmaRX\Firewall\Vendor\Laravel\Models\Firewall as FirewallModel;
use Firewall;

class FirewallController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ips = FirewallModel::latest()->paginate(10);
        return view('firewall.index')->withIps($ips);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param FirewallRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(FirewallRequest $request)
    {
        FirewallModel::create(
            ['ip_address' => $request->ip_address]
        );
        return back()->with('message',"Success! IP: $request->ip_address has been blocked");
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param $ip
     * @return \Illuminate\Http\Response
     */
    public function destroy($ip)
    {
        if (Firewall::whichList($ip))  // returns false, 'whitelist' or 'blacklist'
        {
            Firewall::remove($ip);
            return back()->with('message',"Success! IP: $ip has been unblocked");
        }
        return back()->with('message',"Error! Unknown error occured");
    }
}
