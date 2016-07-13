<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Events\ShoutWasFired;
use App\Shout;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ShoutsController extends Controller
{
    /**
     * ShoutsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        /*$this->validate($request, [
            'shout' => 'required|max:160',
        ]);

        $request->user()->shouts()->create([
            'shout' => $request->shout
        ]);

        return back();*/


        $validator = \Validator::make($request->all(), [
            'shout' => 'required|max:500'
        ]);

        /**
         * Try validating the request
         * If validation failed
         * Return the validator's errors with 422 HTTP status code
         */
        if ($validator->fails())
        {
            return response($validator->messages(), 422);
        }

        $shout = $request->user()->shouts()->create([
            'shout' => $request->shout
        ]);

        // fire Shout Added event if shout successfully added to database
        event(new ShoutWasFired($shout));

        return response($shout, 201);
    }

    public function getShouts(Request $request)
    {
        $offset = (int)$request->offset;

        if($offset == null || $offset == "" || !is_numeric($offset))
        {
            $offset = 0;
        }

        $shouts = Shout::latest()->skip($offset)->take(20)->get()->sortBy('created_at');

        return view('partials._getshouts')->with('shouts',$shouts);
    }

}
