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

        if($user == null)
            abort(404);

        return view('user.profile')->with('user', $user);
    }

       /**
     * Display profile of current authenticated user
     *
     * @return Response
     */
    public function showOwnProfile()
    {
        $user = \Auth::user();

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
     * Show the form for editing User Profile
     *
     */
    public function editOwnProfile()
    {
        $currentIp = \Request::getClientIp();

        $playerTotals = \App\PlayerTotal::where('last_ip_address','LIKE',$currentIp)->latest()->get();
        $array = [
            'players' => $playerTotals
        ];
        return view('user.edit',$array);
    }

    /**
     * Update the specified resource in storage.
     * @return Response
     * @internal param int $id
     */
    public function updateProfile(Request $request)
    {
        $type = $request->type;
        switch($type)
        {
            case "UpdatePassword":
                $validator = \Validator::make($request->all(),
                    ['email' => 'required|email|max:255',
                    'password' => 'required|confirmed|min:6'
                ]);
                if($validator->fails())
                    return \Redirect::back()->with('errors',$validator->errors())->withInput();

                if($request->email != \Auth::user()->getEmailForPasswordReset())
                {
                    return \Redirect::back()->with('error', 'Email doesnot match current users.');
                }

                $user = \Auth::user();
                $user->password = bcrypt($request->password);
                $user->save();
                return \Redirect::back()->with('message', 'Password has been updated successfully! :)');
                break;

            case "LinkPlayer":
                $playerIP = $request->getClientIp();
                $inGamePlayerName = $request->ingameplayer;
                $playerTotal = \App\PlayerTotal::where('last_ip_address','LIKE',$playerIP)->where('name','LIKE',$inGamePlayerName)->get();

                $playerAlreadyClaimed = \App\PlayerTotal::isClaimed($inGamePlayerName);

                if($playerTotal->isEmpty())
                {
                    $user = \Auth::user();
                    $user->player_totals_name = null;
                    $user->save();
                    return \Redirect::back()->with('message', 'You have successfully unlinked player from your profile.');
                }
                elseif($playerAlreadyClaimed)
                {
                    return \Redirect::back()->with('error', "Player already claimed by @$playerAlreadyClaimed->username :/");
                }
                else
                {
                    $user = \Auth::user();
                    $user->player_totals_name = $inGamePlayerName;
                    $user->save();
                    return \Redirect::back()->with('message', "You have successfully linked $inGamePlayerName to your profile.");
                }
                break;

            default:
                return \Redirect::back()->with('error', "Something went wrong :(");
                break;
        }
        return \Redirect::back()->with('error', "Something went wrong :(");
    }

    public function getInbox()
    {
        $inbox = \Auth::user()->inbox()->paginate();
        return view('user.inbox')->with('inbox',$inbox);
    }

    public function getOutbox()
    {
        $outbox = \Auth::user()->outbox()->paginate();
        return view('user.outbox')->with('outbox',$outbox);
    }

    public function getComposeMail()
    {
        return view('user.composemail');
    }

    public function postComposeMail(Request $request)
    {
        $validator = \Validator::make($request->all(),
                    ['to_username' => 'required|max:255',
                    'to_subject' => 'required|min:1:max:255'
                ]);
                if($validator->fails())
                    return \Redirect::back()->with('errors',$validator->errors())->withInput();

        $reciever = $this->user->findOrFailByUsername($request->to_username);
        if($reciever == null)
             return \Redirect::back()->with('error',"Username not found in out Database :(")->withInput();

        \Auth::user()->sendmail($reciever,$request->to_subject,$request->to_body);
        return \Redirect::back()->with('message',"Message has been sent! :)");
    }

    public function getShowMail($id)
    {
        $mail = \App\Mail::findOrFail($id);

        if(\Auth::user()->id != $mail->sender_id && \Auth::user()->id != $mail->reciever_id)
        {
            throw new \Exception("Not Authorised");
        }

        // If the current viewer is reciever and he is viewing it for first time
        if($mail->reciever->id == \Auth::user()->id && $mail->seen_at == null)
        {
            $mail->seen_at = \Carbon\Carbon::now();
            $mail->save();
        }
        return view('user.showmail')->with('mail',$mail);
    }

    // Used to check User online or not and list of active users
    public function sendPing(Request $request)
    {
        if(\Auth::check())
        {
            $request->user()->touch();
        }
    }

}
