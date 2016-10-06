<?php

namespace App\Http\Controllers;

use App\Http\Requests\TrophyRequest;
use App\Photo;
use App\Trophy;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Image;

class TrophyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('trophy.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TrophyRequest $request
     * @return Response
     */
    public function store(TrophyRequest $request)
    {
        $icon = $request->icon ? $request->icon : null;
        $color = $request->color ? $request->color : null;

        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            // Create name for new Image
            $photoName = md5(Carbon::now()) . "." . $request->file('photo')->getClientOriginalExtension();

            // Move image to storage
            $image = Image::make($request->file('photo'));
            $image->fit(500)->save(public_path('uploaded_images/') . $photoName);
            $photo = Photo::create([
                'url' => $photoName
            ]);

            $request->user()->createTrophy()->create([
                'name' => $request->name,
                'short_name' => $request->short_name,
                'description' => $request->description,
                'photo_id' => $photo->id,
                'max_bearer' => $request->max_bearer,
                'icon' => $icon,
                'color' => $color,
            ]);

            return back()->with('success','Trophy Created Successfully!');
        }
        return back()->with('error','Some Error in Form!')->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
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

    /**
     * Show for that give trophy to users
     *
     * @return \Illuminate\View\View
     */
    public function giveToUser()
    {
        return view('trophy.givetouser');
    }

    /**
     * Give trophy to user
     *
     * @param Request $request
     */
    public function postGiveToUser(Request $request)
    {
        $trophy = Trophy::findOrFail($request->trophy);

        $users = [];

        if($request->users == "" || $request->users == null)
        {
            return back()->with('error',"Select atleast 1 user")->withInput();
        }

        foreach ($request->users as $user_id)
        {
            if($trophy->users->contains($user_id))
            {
            }
            else
            {
                $users[] = $user_id;
            }
        }

        if($trophy->max_bearer <= $trophy->users->count())
        {
            return back()->with('error',"Trophy already have max_users({$trophy->max_bearer}) in it");
        }
        else if($trophy->max_bearer < ($trophy->users->count()+count($users)))
        {
            return back()->with('error',"Trophy don't have enough space in it");
        }

        $trophy->users()->attach($users);

        return back()->with('success',"Trophy awaded to users");
    }
}
