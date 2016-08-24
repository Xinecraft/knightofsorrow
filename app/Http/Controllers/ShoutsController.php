<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

use App\Events\ShoutWasFired;
use App\Shout;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ShoutsController extends Controller
{
    use SoftDeletes;
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

        /**
         * Muted user cant shout
         */
        if($request->user()->muted)
            return false;

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

    /**
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function destroy($id,Request $request)
    {
        $shout = Shout::findOrFail($id);
        if($request->user()->isAdmin())
        {
            $shout->delete();
            return back()->with('success',"Success! Shout deleted");
        }
        else
        {
            return back()->with('error',"Sorry! You are not authorized for that action");
        }
    }
}