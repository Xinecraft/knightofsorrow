<?php

namespace App\Http\Controllers;

use App\Notification;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    /**
     * @return $this
     */
    public function indexGlobal()
   {
       $notifications = Notification::stream()->latest()->paginate(20);
       return view('notifications.global')->with('notifications',$notifications)->with('header','Global Notifications');
   }

    /**
     * @param Request $request
     * @return $this
     */
    public function indexUser(Request $request)
    {
        $notifications = $request->user()->notifications()->latest()->paginate(20);
        return view('notifications.global')->with('notifications',$notifications)->with('header','Your Notifications');
    }

    /**
     * @param Request $request
     * @return $this
     */
    public function getLatest(Request $request)
    {
        $notifications = $request->user()->notifications()->latest()->limit(15)->get();

        return view('notifications.navbar')->with('notifications',$notifications);
    }
}
