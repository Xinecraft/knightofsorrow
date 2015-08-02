<?php

namespace App\Http\Controllers;

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
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'body' => 'required|min:5'
        ]);

        $status = [
            'body' => $request->body
        ];

        $this->status->publish($status);
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
        return $this->status->find($id);
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
