<?php

namespace App\Http\Controllers;

use App\Ban;
use App\KTournament;
use App\Notification;
use App\Status;
use Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    public function storeForStatus($id,Request $request)
    {
        $status = Status::findOrFail($id);
        $comment = \Input::get('body');

        if($comment == '')
            return \Redirect::back()->with('error','Comment Empty.');

        $com = $status->comments()->create([
            'body' => $comment,
            'user_id' => Auth::user()->id
        ]);

        // Own status comment
        if($request->user()->id == $status->user->id)
        {
            // Create notification
            $not = new Notification();
            $not->from($request->user())
                ->withType('UserCommentOnStatus')
                ->withSubject('A comment is done on status')
                ->withBody(link_to_route('user.show',$request->user()->displayName(),$request->user()->username)." has commented on his own status")
                ->withStream(true)
                ->regarding($com)
                ->deliver();
        }
        else
        {
            // Create notification
            $not = new Notification();
            $not->from($request->user())
                ->withType('UserCommentOnStatus')
                ->withSubject('A comment is done on status')
                ->withBody(link_to_route('user.show',$request->user()->displayName(),$request->user()->username)." has commented on ".link_to_route('user.show',$status->user->displayName(),$status->user->username)."'s status")
                ->withStream(true)
                ->regarding($com)
                ->deliver();
            $status->user->newNotification()
                ->from($request->user())
                ->withType('UserCommentOnStatus')
                ->withSubject('A comment is done on status.')
                ->withBody(link_to_route('user.show',$request->user()->displayName(),$request->user()->username)." has commented on  your status")
                ->regarding($com)
                ->deliver();
        }

        return \Redirect::back()->with('success','Success! Commented on that status.');

    }

    public function storeForBan($id,Request $request)
    {
        $ban = Ban::findOrFail($id);
        $comment = \Input::get('body');

        if($comment == '')
            return \Redirect::back();

        $ban->comments()->create([
            'body' => $comment,
            'user_id' => Auth::user()->id
        ]);

        // Create notification
        $not = new Notification();
        $not->from($request->user())
            ->withType('UserCommentOnBan')
            ->withSubject('A comment is done on ban')
            ->withBody(link_to_route('user.show',$request->user()->displayName(),$request->user()->username)." has commented on a ban ".link_to_route('bans.show','#'.$ban->id,$ban->id))
            ->withStream(true)
            ->regarding($ban)
            ->deliver();

        return \Redirect::back()->with('success','Success! Comment posted for the ban.');

    }

    public function storeForTournament($id,Request $request)
    {
        $t = KTournament::findOrFail($id);
        $comment = \Input::get('body');

        if($comment == '')
            return \Redirect::back();

        $t->comments()->create([
            'body' => $comment,
            'user_id' => Auth::user()->id
        ]);

        // Create notification
        $not = new Notification();
        $not->from($request->user())
            ->withType('UserCommentOnTournament')
            ->withSubject('A comment is done on tournament')
            ->withBody(link_to_route('user.show',$request->user()->displayName(),$request->user()->username)." has commented on ".link_to_route('tournament.show',$t->name,$t->slug)." tournament")
            ->withStream(true)
            ->regarding($t)
            ->deliver();

        return \Redirect::back()->with('success','Success!');

    }

}
