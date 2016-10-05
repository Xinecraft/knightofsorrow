<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlayerPointRequest;
use App\PlayerPoint;
use App\PlayerTotal;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    /**
     * View to show player points table
     *
     * @return \Illuminate\View\View
     */
    public function createAddpoints()
    {
        return view('playerpoints.create');
    }

    /**
     * @param PlayerPointRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeAddpoints(PlayerPointRequest $request)
    {
        $playerTotal = PlayerTotal::findOrFail($request->name);

        $reason = $request->reason == "" ? null : $request->reason;

        $request->user()->createdPlayerPoints()->create([
            'name' => $playerTotal->name,
            'player_total_id' => $playerTotal->id,
            'points' => $request->points,
            'reason' => $reason
        ]);

        return redirect()->route('extrapoints')->with('success',"Added Successfully! It may take 1 hour to refect changes.");
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyAddpoints($id,Request $request)
    {
        $playerPoints = PlayerPoint::findOrFail($id);

        $playerPoints->delete();

        return back()->with('success',"Deleted Successfully");
    }
}
