<?php

namespace App\Http\Controllers;

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
            return \Redirect::back();

        $status->comments()->create([
            'body' => $comment,
            'user_id' => Auth::user()->id
        ]);

        return \Redirect::back();

    }

}
