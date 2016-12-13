<?php

namespace App\Http\Controllers;

use App\Http\Requests\MailRequest;
use App\Jobs\SendNewMessageEmail;
use App\Mail;
use App\Server\Repositories\UserRepository;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MailController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $user;

    /**
     * MailController constructor.
     * @param UserRepository $user
     */
    public function __construct(UserRepository $user)
    {
        $this->middleware('auth');
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $messages = $request->user()->receivedMessages()->with('reciever','sender')->latest()->groupBy('sender_id')->get();

        return view('messages.index')->withMessages($messages);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param $username
     * @param MailRequest $request
     * @return Response
     */
    public function store($username, MailRequest $request)
    {
        $receiver = $this->user->findOrFailByUsername($username);
        $m = $request->user()->messages()->create([
            'message' => $request->message,
            'reciever_id' => $receiver->id
        ]);

        if($m)
        {
            // Create notification and dispatch it
            $receiver->newNotification()
                ->from($request->user())
                ->withType('UserMessageSent')
                ->withSubject('New message!')
                ->withBody(link_to_route('user.show',$request->user()->displayName(),$request->user()->username)." has sent you ".link_to_route('messages.show',"new message",$request->user()->username))
                ->regarding($m)
                ->deliver();

            // Sends email to reciever if activated notifications
            if($receiver->email_notifications_new_message == true)
            {
                $this->dispatch(new SendNewMessageEmail($m, $request->user(), $receiver));
            }

            return redirect()->route('messages.show',$receiver->username)->with('message', "Message Sent!");
        }

        return back()->with('error',"Error! Something not well.");
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function start(Request $request)
    {
        $with = User::whereUsername($request->with)->orWhere('email', $request->with)->first();
        if(is_null($with))
            abort(404,"User not found");
        return redirect()->route('messages.show',$with->username);
    }

    /**
     * Display the specified resource.
     *
     * @param $username
     * @param Request $request
     * @return Response
     */
    public function show($username, Request $request)
    {
        $user = $this->user->findOrFailByUsername($username);

        $messages = Mail::conversation($user,$request->user())->where('deleted_at',null)->with('sender')->latest()->paginate(10);

        return view('messages.show')->withMessages($messages)->withRecuser($user);
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
     * @param $username1
     * @param $username2
     * @param Request $request
     * @return mixed
     */
    public function showAdmin($username1,$username2, Request $request)
    {
        $user1 = $this->user->findOrFailByUsername($username1);
        $user2 = $this->user->findOrFailByUsername($username2);

        $messages = Mail::conversation($user1,$user2)->withTrashed()->latest()->paginate(10);

        return view('messages.showadmin')->withMessages($messages)->withRecuser1($user1)->withRecuser2($user2);
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
     * @param  int $id
     * @param Request $request
     * @return Response
     */
    public function destroy($id, Request $request)
    {
        $message = Mail::findOrFail($id);

        if($message->canBeDeletedBy($request->user()))
        {
            $message->delete();
            return back()->with('message',"Message Deleted");
        }
        return back()->with('error',"Sorry! You are not authorized.");
    }
}
