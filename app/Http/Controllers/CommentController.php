<?php

namespace App\Http\Controllers;

use App\Ban;
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

        $status->comments()->create([
            'body' => $comment,
            'user_id' => Auth::user()->id
        ]);

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

        return \Redirect::back()->with('success','Success! Comment posted for the ban.');

    }

}
