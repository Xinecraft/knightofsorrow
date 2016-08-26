<?php

namespace App\Http\Controllers;

use App\Notification;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Server\Repositories\StatusRepository;

class StatusController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Status Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling all Statuses of Users.
    |
    */

    protected $status;

    function __construct(StatusRepository $status)
    {
        $this->status = $status;
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $statuses = $this->status->getFeedsForUser(\Auth::user())->paginate(5);

        return view('status.home')->with('statuses',$statuses);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'body' => 'required|min:5'
        ]);

        if($request->user()->muted)
            return \Redirect::back()->with('error','You are muted.');

        $status = [
            'body' => $request->body
        ];

        $st = $this->status->publish($status);

        // Create notification with Stream
        $not = new Notification();
        $not->from($request->user())
            ->withType('UserStatusUpdate')
            ->withSubject('A status is posted')
            ->withBody(link_to_route('user.show',$request->user()->displayName(),$request->user()->username)." published a post in his feedline ".link_to_route('show-status',"#".$st->id,$st->id))
            ->withStream(true)
            ->regarding($st)
            ->deliver();

        return \Redirect::back()->with('message', 'Status updated successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $status = $this->status->find($id);

        return view('status.show')->with('status',$status);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $status = $this->status->findOnlyIfOwner($id);

        return view('status.edit')->with('status',$status);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request)
    {
        $status = $this->status->findOnlyIfOwner($request->id);

        $this->validate($request, [
            'body' => 'required|min:5'
        ]);

        $status->body = $request->body;
        $status->save();

        return \Redirect::route('feeds-home')->with('message','Status edited Successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     * @internal param int $id
     */
    public function destroy()
    {
        $Status = \Auth::user()->Statuses()->findOrFail(\Input::get('id'));
        $Status->delete();

        return \Redirect::back()->with('message', 'Status has been Deleted!');
    }
}
