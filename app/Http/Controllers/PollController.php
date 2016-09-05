<?php

namespace App\Http\Controllers;

use App\Http\Requests\PollRequest;
use App\Pollo;
use App\Pollq;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PollController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $polls = Pollq::where('disabled','!=','1')->latest()->paginate(4);
        return view('polls.index')->with('polls',$polls);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('polls.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PollRequest $request
     * @return Response
     */
    public function store(PollRequest $request)
    {
        //dd(\Input::all());

        $question = $request->question;
        $closed_at = \Carbon\Carbon::parse($request->closed_at);

        $pollq = $request->user()->pollqs()->create([
            'question' => $question,
            'closed_at' => $closed_at,
        ]);

        foreach($request->options as $option)
        {
            $pollq->pollos()->create([
                'option' => $option
            ]);
        }

        return redirect()->route('poll.index')->with('message','Poll created!');

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

    public function vote(Request $request, $id)
    {
        if(!$request->has('option'))
        {
            return back()->with('error','Choose one option');
        }
        $pollq = Pollq::findOrFail($id);

        // Not allow to vote when Poll is disabled
        if($pollq->disabled == 1)
        {
            return;
        }

        if($pollq->hasVoted($request->user()))
        {
            return back()->with('error','Already voted!');
        }

        $pollo = Pollo::findOrFail($request->option);

        $request->user()->pollos()->attach($pollo->id);

        return back()->with('message','Vote Successful!');
    }
}
