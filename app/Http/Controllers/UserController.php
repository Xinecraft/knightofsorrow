<?php

namespace App\Http\Controllers;

use App\Iphistory;
use App\Notification;
use App\Photo;
use App\Player;
use App\PlayerTotal;
use App\Role;
use App\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Server\Repositories\UserRepository;
use Image;
use File;
use App\Server\Mailers\Mailer;

class UserController extends Controller
{

    protected $user;
    protected $mailer;

    public function __construct(UserRepository $user,Mailer $mailer)
    {
        $this->user = $user;
        $this->mailer = $mailer;
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

        // Create notification and send it
        $followee->newNotification()
            ->from($user)
            ->withType('UserFollow')
            ->withSubject('You got +1 follow count.')
            ->withBody(link_to_route('user.show',$user->displayName(),$user->username)." has <span class='text-green notify-bold'>started</span> following you")
            ->regarding($user)
            ->deliver();

        return \Redirect::back()->with('message','Now you are following '.$followee->name);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteUnfollow()
    {
        $user = Auth::user();
        $followee = \Input::get('user_id');
        $followee = User::findOrFail($followee);
        
        if($user->isFollowing($followee))
        {
            $user->unfollow($followee->id);

            // Create notification and send
            $followee->newNotification()
                ->from($user)
                ->withType('UserUnfollow')
                ->withSubject('You got -1 follow count.')
                ->withBody(link_to_route('user.show',$user->displayName(),$user->username)." has <span class='text-danger notify-bold'>stopped</span> following you")
                ->regarding($user)
                ->deliver();

            return \Redirect::back()->with('message','You are not following '.$followee->name.' anymore :(');
        }

        return \Redirect::back()->with('error','You are not following '.$followee->name);
    }


    /**
     * Show the form for editing User Profile
     *
     */
    public function editOwnProfile()
    {
        $currentIp = \Request::getClientIp();

        $playerTotals = PlayerTotal::where('last_ip_address','LIKE',$currentIp)->latest()->get();
        $user = Auth::user();

        // Push already linked player account too..
        if($user->playerTotal())
        {
            $playerTotals->push($user->playerTotal());
        }

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

                if($inGamePlayerName == $request->user()->player_totals_name)
                {
                    return \Redirect::back()->with('message', 'This player is already linked to your account. ;)');
                }
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
            $user = $request->user();
            $user_ip = \Input::getClientIp();

            //Update IP History
            if($iphistory = Iphistory::whereIp($user_ip)->first())
            {
                $iphistory->touch();
            }
            else
            {
                $user->iphistory()->create(['ip' => $user_ip]);
            }
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
            'gr_id' => 'numeric',
            'facebook_url' => 'url',
            'website_url' => 'url',
            'photo' => 'image|max:500',
        ], [
            'dob.required' => 'Please specify your Date of Birth.',
            'dob.date' => 'Invalid Date of Birth format',
            'dob.before' => 'You are not enough old :)',
            'name.required' => 'Please specify your Display name',
            'gr_id.numeric' => 'Please enter a valid GameRanger account Id',
            'faccebook_url.url' => 'Facebook URL is not valid. Please prefix "http://"',
            'website_url.url' => 'Website URL is not valid. Please prefix "http://"',
            'photo.image' => "Profile picture must be image type",
            'photo.max' => "Profile picture must not be greater than 500kb in size",
        ]);

        $dob = $request->dob ? $request->dob : null;
        $grid = $request->gr_id ? $request->gr_id : null;
        $fburl = $request->facebook_url ? $request->facebook_url : null;
        $weburl = $request->website_url ? $request->website_url : null;
        $evolveid = $request->evolve_id ? $request->evolve_id : null;
        $steam_nickname = $request->steam_nickname ? $request->steam_nickname : null;
        $discord_username = $request->discord_username ? $request->discord_username : null;
        $about = $request->about ? $request->about : null;
        $gender = $request->gender ? $request->gender : null;
        $gender = $gender == 'unspecified' ? null : $gender;
        if($request->has('email_notifications_new_message'))
        {
            $email_notifications_new_message = true;
        }
        else
        {
            $email_notifications_new_message = false;
        }

        // Background image only available for Elders++
        if($request->user()->isSubAdmin())
        {
            $back_img_url = $request->back_img_url ? $request->back_img_url : null;
        }
        else
        {
            $back_img_url = $request->user()->back_img_url;
        }


        /**
         * If Request has Photo Uploaded Then
         * 1> Delete prev Image
         * 2> Store Photo in storage and link in DB
         * 3> Pass new PhotoId
         */
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            // Create name for new Image
            $photoName = md5(Carbon::now()) . "." . $request->file('photo')->getClientOriginalExtension();

            // Move image to storage
            $image = Image::make($request->file('photo'));
            $image->fit(300)->save(public_path('uploaded_images/') . $photoName);
            $photo = Photo::create([
                'url' => $photoName
            ]);

            /*
             * Delete previous Profile pic if any
             * Delete only if this Photo is not referenced by any Alumini profile.
             */
            if ($prevPic = $request->user()->photo) {
                // If any alumini references then ignore deletion else delete
                    $file = public_path('uploaded_images/') . $prevPic->url;
                    if (File::exists($file)) {
                        // Delete from Storage
                        File::delete($file);
                        // Delete link from DB
                        $user->photo_id = null;
                        $user->save();
                        $prevPic->delete();
                    }
            }
            $photoId = $photo->id;
        }
        /**
         * If No Upload Then
         * 1> Check if already has a profile Pic
         *  Yes? : Pass old profile pic Id.
         *  No?  : Pass null as Profile pic Id
         */
        else {
            if ($prevPic = $request->user()->photo) {
                $photoId = $prevPic->id;
            } else {
                $photoId = null;
            }
        }

        $user->update([
            'dob' => $dob,
            'name' => $request->name,
            'about' => $about,
            'gender' => $gender,
            'gr_id' => $grid,
            'evolve_id' => $evolveid,
            'facebook_url' => $fburl,
            'website_url' => $weburl,
            'photo_id' => $photoId,
            'steam_nickname' => $steam_nickname,
            'discord_username' => $discord_username,
            'email_notifications_new_message' => $email_notifications_new_message,
            'back_img_url' => $back_img_url,
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

            // Create notification with Stream
            $not = new Notification();
            $not->from($request->user())
                ->withType('UserUnban')
                ->withSubject('An unban is performed')
                ->withBody(link_to_route('user.show',$request->user()->displayName(),$request->user()->username)." has <span class='text-green notify-bold'>unbanned</span> ".link_to_route('user.show',$user->displayName(),$user->username))
                ->withStream(true)
                ->regarding($user)
                ->deliver();
            /*$request->user()->newNotification()
                ->from($request->user())
                ->withType('UserUnban')
                ->withSubject('An unban is performed')
                ->withBody(" You have <span class='text-green notify-bold'>unbanned</span> ".link_to_route('user.show',$user->displayName(),$user->username))
                ->regarding($user)
                ->deliver();*/
            return \Redirect::back()->with('message',"Success! You have successfully Unbanned this User");
        } elseif ($user->banned == 0) {
            $user->banned = 1;
            $user->save();

            // Create notification
            $not = new Notification();
            $not->from($request->user())
                ->withType('UserBan')
                ->withSubject('A ban is performed.')
                ->withBody(link_to_route('user.show',$request->user()->displayName(),$request->user()->username)." has <span class='text-danger notify-bold'>banned</span> ".link_to_route('user.show',$user->displayName(),$user->username))
                ->withStream(true)
                ->regarding($user)
                ->deliver();
            /*$request->user()->newNotification()
                ->from($request->user())
                ->withType('UserBan')
                ->withSubject('A ban is performed')
                ->withBody(" You have <span class='text-danger notify-bold'>banned</span> ".link_to_route('user.show',$user->displayName(),$user->username))
                ->regarding($user)
                ->deliver();*/
            return \Redirect::back()->with('message',"Success! You have banned this User");
        }

        return \Redirect::back()->with('error',"Error! Something not well.");
    }


    /**
     * @param Request $request
     * @param $username
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleMuteUser(Request $request, $username)
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
            return \Redirect::back()->with('error',"You don't have rights to mute this User");
        }

        if($request->user()->roles()->first()->id == $user->roles()->first()->id)
        {
            return \Redirect::back()->with('error',"You don't have rights to mute this User");
        }

        if ($user->muted == 1) {
            $user->muted = 0;
            $user->save();

            return \Redirect::back()->with('message',"Success! You have successfully Unmuted this User");
        }
        elseif ($user->muted == 0) {
            $user->muted = 1;
            $user->save();
            return \Redirect::back()->with('message',"Success! You have muted this User");
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

            $nextrank = Role::find($nextRoleID);
            // Create notification
            $not = new Notification();
            $not->from($request->user())
                ->withType('UserRolePromote')
                ->withSubject('A User has promoted.')
                ->withBody(link_to_route('user.show',$request->user()->displayName(),$request->user()->username)." has <span class='text-green notify-bold'>promoted</span> ".link_to_route('user.show',$user->displayName(),$user->username)." to ".$nextrank->display_name)
                ->withStream(true)
                ->regarding($user)
                ->deliver();

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

            $nextrank = Role::find($nextRoleID);
            // Create notification
            $not = new Notification();
            $not->from($request->user())
                ->withType('UserRoleDemote')
                ->withSubject('A User has demoted.')
                ->withBody(link_to_route('user.show',$request->user()->displayName(),$request->user()->username)." has <span class='text-danger notify-bold'>demoted</span> ".link_to_route('user.show',$user->displayName(),$user->username)." to ".$nextrank->display_name)
                ->withStream(true)
                ->regarding($user)
                ->deliver();

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

    public function getWebAdmin()
    {
        return view('user.webadmin');
    }

    /**
     * Send view
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getSearchIP(Request $request)
    {
        if($request->user()->isAdmin())
            return view('user.searchip');
        return \Redirect::home()->with('error', "Whoops! Not Authorized");
    }

    /**
     * Handle Viewer
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postSearchIP(Request $request)
    {
        $this->validate($request, [
            'ipaddr' => 'required'
        ]);

        if(!$request->user()->isAdmin())
            return \Redirect::home()->with('error', "Whoops! Not Authorized");

        $players = Player::where('ip_address','LIKE','%'.$request->ipaddr."%")->orWhere('name','LIKE','%'.$request->ipaddr."%")->latest()->get();

        //dd($players);

        \Session::flash('post-back','yes');
        return view('user.searchip')->with('players',$players);
    }

    public function confirmEmail($user, $confirmation_token)
    {
        $user =User::findOrFail($user);
        if(!$user->confirmed)
        {
            if($user->confirmation_token == $confirmation_token)
            {
                $user->confirmed = true;
                $user->muted = false;
                $user->save();
            }
        }

        return \Redirect::home()->with('success','Email has been verified! Your account is unmuted.');;
    }

    public function viewIPofUser()
    {
        $user = User::where('username',\Input::get('user'))->first();

        if($user == null)
            abort(404);

        $useriphistory = $user->iphistory()->get();

        return view('partials.useriphistory')->with('useriphistory',$useriphistory);
    }

    public function resendConfirmEmail(Request $request)
    {
        $user = $request->user();
        $this->mailer->sendTo($user,"Confirm your Email KnightofSorrow.in Swat4 Community & Servers",'emails.welcome',['user' => $user]);
        return back()->with('success','Email sent successfully');
    }
}
