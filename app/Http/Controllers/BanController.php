<?php

namespace App\Http\Controllers;

use App\Ban;
use App\Country;
use App\Http\Requests\BanRequest;
use App\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request as InputRequest;
use Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class BanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $sortableColumns = ['country_id','name','ip_address','admin_name','status','updated_at'];

        $orderBy = Request::has('orderBy') && in_array(Request::get('orderBy'),$sortableColumns) ? Request::get('orderBy')  : 'updated_at';
        $sortDir = Request::has('direction') ? Request::get('direction') : 'desc';

        $bans = Ban::orderBy($orderBy,$sortDir)->with('country')->paginate(35);

        return view('ban.index')->with('bans',$bans);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('ban.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BanRequest $request
     * @return Response
     */
    public function store(BanRequest $request)
    {
        $ip_addr = $request->ip_address;
        $ip_addr = trim($ip_addr);
        $ip_without_mask = str_replace('*','0',$ip_addr);
        if(count(explode('.',$ip_without_mask)) != 4 || preg_match_all("/[^0-9.*]/",$ip_addr) > 0)
        {
            return back()->with('error',"Invalid IP Address")->withInput();
        }
        $reason = $request->reason;
        $reason = $reason == "" ? null : $reason;

        $banned_till = $request->banned_till;
        $banned_till = $banned_till == "" ? null : Carbon::parse($banned_till);

        $present = Ban::findOrNullByIP($ip_addr);
        if($present)
        {
            return redirect()->route('bans.show',$present->id)->with('error','IP Address already in banlist. We have redirected you there. Have a look.');
        }
        if($banned_till != null && $banned_till <= Carbon::now())
        {
            return redirect()->back()->with('error','Ban Till cannot me in past else its will be automatically un-banned by Server.')->withInput();
        }

        $player_country_id = 0;

        $geoip = \App::make('geoip');
        try
        {
            if($player_geoip = $geoip->city($ip_without_mask)) {
                $player_isoCode = $player_geoip->country->isoCode;
                $country = Country::where('countryCode', 'LIKE', $player_isoCode)->first();

                /**
                 * Country returned is not in Countries table
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

        $newBan = Ban::create([
            'name' => '~ManualIPBan',
            'ip_address' => $ip_addr,
            'banned_till' => $banned_till,
            'server_id' => 1,
            'country_id' => $player_country_id,
            'reason' => $reason,
            'admin_name' => $request->user()->username,
            'admin_ip' => $request->getClientIp(),
            'created_by_site' => true,
            'status' => true,
        ]);

        if($newBan)
        {
            // Create notification
            $not = new Notification();
            $not->from($request->user())
                ->withType('BanCreated')
                ->withSubject('A ban is created')
                ->withBody(link_to_route('user.show',$request->user()->displayName(),$request->user()->username)." has added a new ban rule ".link_to_route('bans.show','#'.$newBan->id,$newBan->id)." for <b>".$newBan->ipAddrWithMask()."</b> <img src='".$newBan->countryImage()."' class='tooltipster img' title='".$newBan->countryName()."'>")
                ->withStream(true)
                ->regarding($newBan)
                ->deliver();

            $newBan->tellServerToAdd();

            return redirect()->route('bans.show',$newBan->id)->with('success','Ban has been added!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $ban = Ban::findOrFail($id);

        return view('ban.show')->with('ban',$ban);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $ban = Ban::findOrFail($id);
        return view('ban.edit')->with('ban',$ban);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param InputRequest $request
     * @return Response
     */
    public function update($id, InputRequest $request)
    {
        if(!$request->user()->isAdmin())
        {
            return redirect()->home()->with('error',"Not authorized");
        }

        $validator = \Validator::make($request->all(),
            [   'status' => 'required|in:0,1',
            ]);
        if($validator->fails())
            return \Redirect::back()->with('errors',$validator->errors())->withInput();

        $ban = Ban::findOrFail($id);

        $prev_status = $ban->status;

        $status = $request->status;
        $reason = $request->reason == "" ? null : $request->reason;

        $banned_till = $request->banned_till;
        $banned_till = $banned_till == "" ? null : Carbon::parse($banned_till);

        // If its a unban work then banned till will be set to now.
        if($status == 0 && $prev_status == 1)
        {
            $banned_till = Carbon::now();
        }
        else if($status == 1 && $prev_status == 0 && $banned_till != null && $banned_till <= Carbon::now())
        {
            $banned_till = null;
        }
        else if($status == 0 && $prev_status == 0)
        {
            if($banned_till >= Carbon::now())
            {
                return redirect()->back()->with('error','Ban Till cannot me in future if status is "Unbanned".')->withInput();
            }
            else if($banned_till == "" || $banned_till == null)
            {
                $banned_till = $ban->banned_till;
            }
        }
        $ban->reason = $reason;
        $ban->status = $status;
        $ban->banned_till = $banned_till;
        $ban->updated_by = $request->user()->username;
        $ban->updated_by_site = true;
        $ban->save();

        // Create notification
        $not = new Notification();
        $not->from($request->user())
            ->withType('BanUpdated')
            ->withSubject('A ban is updated')
            ->withBody(link_to_route('user.show',$request->user()->displayName(),$request->user()->username)." has updated the ban ".link_to_route('bans.show','#'.$ban->id,$ban->id)." with IP <b>".$ban->ipAddrWithMask()."</b> <img src='".$ban->countryImage()."' class='tooltipster img' title='".$ban->countryName()."'>")
            ->withStream(true)
            ->regarding($ban)
            ->deliver();

        if($status == 0 && $prev_status == 1)
        {
            $ban->tellServerToRemove();
        }
        else if($status == 1 && $prev_status == 0)
        {
            $ban->tellServerToAdd();
        }

        return redirect()->route('bans.show',$ban->id)->with('success','Ban has need updated!');
    }

    /**
     * Handle Ban getting from Server
     *
     * @param InputRequest $request
     */
    public function handlebans(InputRequest $request)
    {
        $successResponse = false;

        \Log::info($request->ban);

        if(!$request->has('ban')|| !$request->has('key') || $request->get('key') != env('SERVER_QUERY_KEY'))
        {
            printf("ERROR: Invalid Response!");
            exit(0);
        }

        $banList = $request->get('ban');

        foreach($banList as $ban)
        {
            $ban = explode(" $ ",$ban);
            $type = $ban[0];
            if($type == "ban")
            {
                $ip_address = $ban[1];
                $name = $ban[2];

                $name = str_replace('(VIEW)','',$name);
                $name = str_replace('(SPEC)','',$name);

                $admin = $ban[3];
                $admin = str_replace('(VIEW)','',$admin);
                $admin = str_replace('(SPEC)','',$admin);

                $admin_ip = $ban[4];
                $reason = $ban[5] == "" ? null : $ban[5];

                $banQ = Ban::findOrNullByIP($ip_address);

                // If no ban for this IP at Server then do add Ban.
                if($banQ == null)
                {

                    $player_country_id = 0;

                    $geoip = \App::make('geoip');
                    try
                    {
                        $ip_without_mask = str_replace('*','0',$ip_address);
                        if($player_geoip = $geoip->city($ip_without_mask)) {
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

                    $newBan = Ban::create([
                        'name' => $name,
                        'ip_address' => $ip_address,
                        'server_id' => 1,
                        'country_id' => $player_country_id,
                        'reason' => $reason,
                        'admin_name' => $admin,
                        'admin_ip' => $admin_ip,
                        'status' => true,
                    ]);
                }

                //Ban already listed but check if its status is true or not
                // and if its status is false then set it true. and set updated_by to new admin
                else if(!$banQ->status)
                {
                    $banQ->name = $name;
                    $banQ->status = true;
                    $banQ->banned_till = null;
                    $banQ->reason = $ban[5] == "" ? $banQ->reason : $ban[5];
                    $banQ->updated_by = $admin;
                    $banQ->updated_by_site = false;
                    $banQ->save();
                }

                $successResponse = true;
            }

            // Unban request
            else if($type == "unban")
            {
                $ip_address = $ban[1];
                $admin = $ban[2];

                $admin = str_replace('(VIEW)','',$admin);
                $admin = str_replace('(SPEC)','',$admin);

                $banQ = Ban::findOrNullByIP($ip_address);

                if($banQ && $banQ->status)
                {
                    $banQ->status = false;
                    $banQ->banned_till = Carbon::now();
                    $banQ->updated_by = $admin;
                    $banQ->updated_by_site = false;
                    $banQ->save();
                }
                $successResponse = true;
            }
        }

        if($successResponse)
        {
            print("SUCCESS");
            exit(0);
        }
    }

    /**
     * Masterban masterbanlist.txt maker
     * @return null
     * @print txt
     */
    public function masterbantxt()
    {
        //$filename = "masterbanlist.txt";
        $bans = Ban::where('status','1')->get();

        $banlist="";
        foreach($bans as $ban)
        {
            $banlist = $banlist.$ban->ip_address.",";
        }

        printf("%s",$banlist);
        exit(0);

        //$headers = ['Content-type' => 'plain/txt', 'Connection' => 'close', 'Content-Disposition' => sprintf('attachment; filename=%s',$filename),'Content-length' => sizeof($banlist)];
        //return \Response::make($banlist,200,$headers);
    }
}
