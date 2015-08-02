<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Server\Repositories\UserRepository;

class UserController extends Controller
{

    protected $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function showProfile($username)
    {
        $user = $this->user->findByUsername($username);

        return view('user.profile')->with('user', $user);
    }

    public function postFollow()
    {
        $user = \Auth::user();
        $followee = \Input::get('user_id');
        $followee = User::findOrFail($followee);

        if($user->isFollowing($followee))
        {
            return \Redirect::back()->with('message','You already following '.$followee->name); 
        }
        elseif($user->id == $followee->id)
        {
            return \Redirect::back()->with('message','You cannot follow yourself'); 
        }

        $user->follow($followee->id);
        return \Redirect::back()->with('message','Now you are following '.$followee->name);
    }

    public function deleteUnfollow()
    {
        $user = \Auth::user();
        $followee = \Input::get('user_id');
        $followee = User::findOrFail($followee);
        
        if($user->isFollowing($followee))
        {
            $user->unfollow($followee->id);
            return \Redirect::back()->with('message','You are not following '.$followee->name.' anymore :(');
        }

        return \Redirect::back()->with('message','You are not following '.$followee->name); 
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
}
