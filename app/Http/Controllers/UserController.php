<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Auth;
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
        $user = Auth::user();

        return view('user.profile')->with('user', $user);
    }

    public function postFollow()
    {
        $user = Auth::user();
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
        $user = Auth::user();
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
        $user = Auth::user();
        $array = [
            'players' => $playerTotals,
            'user' => $user
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

                if($request->email != Auth::user()->getEmailForPasswordReset())
                {
                    return \Redirect::back()->with('error', 'Email doesnot match current users.');
                }

                $user = Auth::user();
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
                    $user = Auth::user();
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
                    $user = Auth::user();
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
        $inbox = Auth::user()->inbox()->paginate();
        return view('user.inbox')->with('inbox',$inbox);
    }

    public function getOutbox()
    {
        $outbox = Auth::user()->outbox()->paginate();
        return view('user.outbox')->with('outbox',$outbox);
    }

    public function getComposeMail()
    {
        if(\Request::has('user'))
        {
            \Session::flash('_old_input.to_username',\Request::get('user'));
        }
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

        Auth::user()->sendmail($reciever,$request->to_subject,$request->to_body);
        return \Redirect::back()->with('message',"Message has been sent! :)");
    }

    public function getShowMail($id)
    {
        $mail = \App\Mail::findOrFail($id);

        if(Auth::user()->id != $mail->sender_id && Auth::user()->id != $mail->reciever_id)
        {
            throw new \Exception("Not Authorised");
        }

        // If the current viewer is reciever and he is viewing it for first time
        if($mail->reciever->id == Auth::user()->id && $mail->seen_at == null)
        {
            $mail->seen_at = \Carbon\Carbon::now();
            $mail->save();
        }
        return view('user.showmail')->with('mail',$mail);
    }

    // Used to check User online or not and list of active users
    public function sendPing(Request $request)
    {
        if(Auth::check())
        {
            $request->user()->touch();
        }
    }


    public function updateProfile2(Request $request)
    {
        $user = $request->user();

        $this->validate($request, [
            'dob' => 'date|before:2016-01-01',
            'name' => 'required',
            'about' => 'min:5',
            'gender' => 'in:Male,Female,unspecified,Others',
        ], [
            'dob.required' => 'Please specify your Date of Birth.',
            'dob.date' => 'Invalid Date of Birth format',
            'dob.before' => 'You are not enough old :)',
            'name.required' => 'Please specify your Display name',
        ]);

        $dob = $request->dob ? $request->dob : null;
        $about = $request->about ? $request->about : null;
        $gender = $request->gender ? $request->gender : null;
        $gender = $gender == 'unspecified' ? null : $gender;

        $user->update([
            'dob' => $dob,
            'name' => $request->name,
            'about' => $about,
            'gender' => $gender,
        ]);

        return \Redirect::back()->with('message',"Profile has been updated!");

    }

    /**
     * @param Request $request
     * @param $username
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleBanUser(Request $request, $username)
    {
        if(!$request->user()->isAdmin())
        {
            return \Redirect::back()->with('error',"Aw! You are not any Admin ;)");
        }

        if ($request->username != $username) {
            return \Redirect::back()->with('error',"Aw! Please don't try to mess up the code ;)");
        }

        $user = User::whereUsername($request->username)->first();

        if (is_null($user)) {
            return \Redirect::back()->with('error',"User not Found");
        }

        if ($user->isSuperAdmin()) {
            return \Redirect::back()->with('error',"You don't have rights to ban this User");
        }

        if($request->user()->roles()->first()->id == $user->roles()->first()->id)
        {
            return \Redirect::back()->with('error',"You don't have rights to ban this User");
        }

        if ($user->banned == 1) {
            $user->banned = 0;
            $user->save();
            return \Redirect::back()->with('message',"Success! You have successfully Unbanned this User");
        } elseif ($user->banned == 0) {
            $user->banned = 1;
            $user->save();
            return \Redirect::back()->with('message',"Success! You have banned this User");
        }

        return \Redirect::back()->with('error',"Error! Something not well.");
    }


    /**
     * Change role of user
     *
     * @param Request $request
     * @param $username
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeRole(Request $request,$username)
    {
        if(!$request->user()->isAdmin())
        {
            return \Redirect::back()->with('error',"Aw! You are not any Admin ;)");
        }

        if ($request->username != $username) {
            return \Redirect::back()->with('error',"Aw! Please don't try to mess up the code ;)");
        }

        $user = User::findOrFail($request->user_id);

        if ($request->username != $user->username) {
            return \Redirect::back()->with('error',"Aw! Please don't try to mess up the code ;)");
        }

        if($request->job == 'promote') {

            // If User role is equal to the one other person role - 1
            // If user admin 3 other also admin 3
            // 3 >= 4 -> True
            if ($request->user()->roles()->first()->id >= ($user->roles()->first()->id)-1) {
                return \Redirect::back()->with('error', "Sorry! Not enough permissions");
            }

            // Cannot promote if already a SA
            if ($user->roles()->first()->id <= 2)
                return \Redirect::back()->with('error', "Sorry! No more higher rank.");

            $role = $user->roles()->first();
            $prevRoleID = $role->id;
            $nextRoleID = $prevRoleID - 1;
            $user->detachRole($role);
            $user->attachRole($nextRoleID);

            return \Redirect::back()->with('message', "User promoted!");

        }

        elseif($request->job == 'demote') {
            if ($request->user()->roles()->first()->id >= $user->roles()->first()->id) {
                return \Redirect::back()->with('error', "Sorry! Not enough permissions");
            }

            // Cannot demote if already a member
            if ($user->roles()->first()->id >= 5)
                return \Redirect::back()->with('error', "Sorry! No more lower rank.");

            $role = $user->roles()->first();
            $prevRoleID = $role->id;
            $nextRoleID = $prevRoleID + 1;
            $user->detachRole($role);
            $user->attachRole($nextRoleID);

            return \Redirect::back()->with('message', "User demoted!");
        }
        else
        {
            return \Redirect::back()->with('error', "Whoops! Unknown error");
        }
    }

    /**
     * Send view
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function viewServerCredentials(Request $request)
    {
        if($request->user()->isSubAdmin())
            return view('user.serverkeys');
        return \Redirect::home()->with('error', "Whoops! Not Authorized");
    }

    /**
     * Handle Viewer
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postServerCredentials(Request $request)
    {
        $this->validate($request, [
            'password' => 'required'
        ]);

        $user = $request->user();

        $cred = [
            'username' => $user->username,
            'password' => $request->password,
        ];

        if(Auth::attempt($cred))
        {
            // Get user Role
            $userRole = $user->roles()->first()->id;

            //SA
            if($userRole <= 2)
            {
                $credentials = [
                    'maxjoinpassword' => env('MAX_JOIN_PASSWORD'),
                    'adminpassword' => env('ADMIN_PASSWORD'),
                    'sapassword' => env('SA_PASSWORD')
                ];
            }
            elseif($userRole == 3)
            {
                $credentials = [
                    'maxjoinpassword' => env('MAX_JOIN_PASSWORD'),
                    'adminpassword' => env('ADMIN_PASSWORD'),
                ];
            }
            elseif($userRole == 4)
            {
                $credentials = [
                    'maxjoinpassword' => env('MAX_JOIN_PASSWORD'),
                ];
            }
            \Session::flash('post-back','yes');
            return back()->with('credentials',$credentials)->withMessage('Plz view credentials and close the page ASAP.');
        }
        else
        {
            return \Redirect::back()->with('error', "Whoops! Password Incorrect.");
        }
    }

    public function adminList()
    {
        $role = Role::where('id','<','4')->where('id','>','1')->with('users')->get();
        $roleM = Role::where('id','4')->with('users')->get();

        return view('user.adminlist')->withRoles($role)->withRoless($roleM);
    }

}
