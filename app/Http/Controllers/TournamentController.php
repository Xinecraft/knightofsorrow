<?php

namespace App\Http\Controllers;

use App\Game;
use App\Http\Requests\KTeamRequest;
use App\Http\Requests\KTournamentRequest;
use App\KMatch;
use App\KTeam;
use App\KTournament;
use App\Notification;
use App\Photo;
use App\User;
use Cache;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;

class TournamentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $lasttourny = KTournament::enabled()->orderBy('tournament_ends_at','DESC')->where('tournament_ends_at','!=','null')->first();
        $upcomingtourny = KTournament::enabled()->orderBy('registration_starts_at','ASC')->where('tournament_starts_at','>',Carbon::now())->where('tournament_ends_at',null)->first();
        $ongoingtourny = KTournament::enabled()->orderBy('tournament_starts_at','DESC')->where('tournament_starts_at','<',Carbon::now())->where('tournament_ends_at',null)->first();
        $array = [
            'last' => $lasttourny,
            'upcoming' => $upcomingtourny,
            'ongoing' => $ongoingtourny,
        ];

        return view('tournament.index')->with($array);
    }


    public function getCalendar()
    {
        $months = KTournament::where('disabled','false')->orderBy('tournament_starts_at')->get()->groupBy(function($val){
            return Carbon::parse($val->tournament_starts_at)->format('m-Y');
        });

        return view('tournament.calendar')->with('months',$months);
    }

    public function getRatingSingle()
    {
        $users = \DB::select("select user_id,count(*) as tourny_played,sum(total_score) as total_score,sum(user_position) as points from k_tournament_user where user_status > 2 group by user_id order by points DESC, total_score DESC;");
        $us = new Collection();
        foreach ($users as $user)
        {
            $u = User::find($user->user_id);
            $u->total_score = $user->total_score;
            $u->tourny_played = $user->tourny_played;
            $u->points = $user->points;
            $us->push($u);
        }
        return view('tournament.rankingsingle')->with('players',$us)->with('ranking',1);
    }

    public function getRatingTeams()
    {
        $teams = KTeam::where('team_status',1)->groupBy('name')
            ->selectRaw('*,sum(total_score) as score,count(*) as tourny_played,avg(team_position) as team_position,sum(points) as points,sum(rating) as rating')
            ->orderby('rating','DESC')->paginate();

        $position = ($teams->currentPage()-1) * 15 + 1;
        return view('tournament.rankingteams')->with('teams',$teams)->with('ranking',$position);
    }

    public function getGuideline()
    {
        return view('tournament.guidelines');
    }

    public function getWorldClock()
    {
        return view('tournament.worldclock');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        if(!$request->user()->isSuperAdmin())
        {
            return redirect()->home();
        }

        return view('tournament.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param KTournamentRequest $request
     * @return Response
     */
    public function store(KTournamentRequest $request)
    {
        if(!$request->user()->isSuperAdmin())
        {
            return redirect()->home();
        }


        if ($request->hasFile('photo')) {
            if ($request->file('photo')->isValid()) {
                $photoName = md5(Carbon::now()).".".$request->file('photo')->getClientOriginalExtension();

                $request->file('photo')->move(public_path('uploaded_images'), $photoName);

                $photo = Photo::create([
                    'url' => $photoName
                ]);

                $slug = str_slug($request->name);

                $tournament = $request->user()->createdtournaments()->create([
                    'name' => $request->name,
                    'description' => $request->description,
                    'rules' => $request->rules,
                    'minimum_participants' => $request->minimum_participants,
                    'maximum_participants' => $request->maximum_participants,
                    'rounds_per_match' => $request->rounds_per_match,
                    'registration_starts_at' => $request->registration_starts_at,
                    'registration_ends_at' => $request->registration_ends_at,
                    'tournament_starts_at' => $request->tournament_starts_at,
                    'photo_id' => $photo->id,
                    'slug' => $slug,
                    'bracket_type' => $request->bracket_type,
                    'tournament_type' => $request->tournament_type,
                ]);

                if($request->managers)
                    $tournament->managers()->sync($request->managers);

                // Create notification
                $not = new Notification();
                $not->from($request->user())
                    ->withType('TournamentCreated')
                    ->withSubject('A tournament created.')
                    ->withBody("A new tournament has been created : ".link_to_route('tournament.show',$tournament->name,$tournament->slug))
                    ->withStream(true)
                    ->regarding($tournament)
                    ->deliver();

                return redirect()->route('tournament.show',$slug)->with('success','Tournament has been created!');
            }
        }
        else
        {
            return back()->with('error','Error! Try Again.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return Response
     */
    public function show($slug)
    {
        $tournament = KTournament::enabled()->whereSlug($slug)->first();

        if(Cache::has('tourny_'.$tournament->id."_players")) {
            $players = Cache::get('tourny_'.$tournament->id."_players");
        }
        else {
            $players = $tournament->players()->wherePivot('user_status','>=','3')->orderBy('pivot_total_score','desc')->get();
            Cache::put('tourny_'.$tournament->id."_players",$players,720);
        }

        if(!$tournament)
            abort(404);

        return view('tournament.show')->with('tournament',$tournament)->with('players',$players);
    }

    /**
     * @param $slug
     * @return $this
     */
    public function getBracket($slug)
    {
        $tournament = KTournament::enabled()->whereSlug($slug)->first();
        if(!$tournament)
            abort(404);
        //dd($tournament->managers->isEmpty());
        return view('tournament.bracket')->with('tournament',$tournament);
    }

    /**
     * Show player application form
     *
     * @return \Illuminate\View\View
     */
    public function applyForUser($slug)
    {
        $tournament = KTournament::enabled()->whereSlug($slug)->first();
        if(!$tournament)
            abort(404);

        if(!$tournament->canApplyToJoin())
        {
            return redirect()->route('tournament.show',$tournament->slug)->with('error','Error! Cannot join this tournament.');
        }

        return view('tournament.apply')->with('tournament',$tournament);
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
     * Apply user to tournament and create new team.
     *
     * @param $id
     * @param KTeamRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function applyForUserNewTeam($id, KTeamRequest $request)
    {
        $tournament = KTournament::enabled()->findOrFail($id);

        $name = $request->name;

        if(!$tournament->canApplyToJoin())
        {
            return redirect()->route('tournament.show',$tournament->slug)->with('error','Error! Cannot join this tournament.');
        }

        // Check if this name already present in current tournament.
        if(KTeam::where('k_tournament_id',$tournament->id)->where('name',$name)->first())
        {
            return redirect()->back()->with('error','Error! Name already registered with this tournament.');
        }

        $desc = $request->description == "" ? null : $request->description;

        $newteam = $request->user()->createdteams()->create([
            'name' => $name,
            'description' => $desc,
            'k_tournament_id' => $tournament->id,
            'country_id' => $request->country_id,
        ]);

        // Stream it.
        $not = new Notification();
        $not->from($request->user())
            ->withType('TeamCreated')
            ->withSubject('A new team is created')
            ->withBody(link_to_route('user.show',$request->user()->displayName(),$request->user()->username)." has created a new team ".link_to_route('tournament.team.show',$newteam->name,[$tournament->slug,$newteam->id])." for ".link_to_route('tournament.show',$tournament->name,$tournament->slug)." and joined it")
            ->withStream(true)
            ->regarding($newteam)
            ->deliver();
        // To creator.
        $request->user()->newNotification()
                ->from($request->user())
                ->withType('TeamCreated')
                ->withSubject('A new team is created')
                ->withBody("You created a new team ".link_to_route('tournament.team.show',$newteam->name,[$tournament->slug,$newteam->id])." for ".link_to_route('tournament.show',$tournament->name,$tournament->slug)." and joined it")
                ->regarding($newteam)
                ->deliver();

        // Add with role to highest!
        $newteam->addplayertoteam($request->user(),$tournament,4);

        // Stream it.
        /*$not = new Notification();
        $not->from($request->user())
            ->withType('TeamJoined')
            ->withSubject('A player joined a team')
            ->withBody(link_to_route('user.show',$request->user()->displayName(),$request->user()->username)." has joined team ".link_to_route('tournament.team.show',$newteam->name,[$tournament->slug,$newteam->id])." for ".link_to_route('tournament.show',$tournament->name,$tournament->slug))
            ->withStream(true)
            ->regarding($newteam)
            ->deliver();*/

        return redirect()->route('tournament.show',$tournament->slug)->with('success','Success! You have applied for tournament now pending approval');
    }


    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function applyForUserExistingTeam($id,Request $request)
    {
        $tournament = KTournament::enabled()->findOrFail($id);
        $team = $request->team;
        $team = KTeam::find($team);

        if(!$team)
        {
            return redirect()->back()->with('error','Error! Cannot find specified Team.');
        }

        if($team->isClosed())
        {
            return redirect()->back()->with('error','Error! Team is NOT ACCEPTING players anymore.');
        }

        if(!$team->isApproved())
        {
            return redirect()->back()->with('error','Error! Team is not APPROVED yet.');
        }

        if(!$tournament->canApplyToJoin())
        {
            return redirect()->route('tournament.show',$tournament->slug)->with('error','Error! Cannot join this tournament.');
        }

        if($tournament->id != $team->k_tournament_id)
            return redirect()->back()->with('error','Error! Team doesn\'t belong to current tournament. Stop messing with codes');

        if($team->isFull())
            return redirect()->back()->with('error','Error! Team capacity is FULL. Please try joining others.');

        $team->addplayertoteam($request->user(),$tournament);
        // Stream it.
        $not = new Notification();
        $not->from($request->user())
            ->withType('PlayerTeamApplied')
            ->withSubject('A player request to join a team')
            ->withBody(link_to_route('user.show',$request->user()->displayName(),$request->user()->username)." has applied to join team ".link_to_route('tournament.team.show',$team->name,[$tournament->slug,$team->id])." for ".link_to_route('tournament.show',$tournament->name,$tournament->slug))
            ->withStream(true)
            ->regarding($team)
            ->deliver();

        // To creator.
        $request->user()->newNotification()
            ->from($request->user())
            ->withType('PlayerTeamApplied')
            ->withSubject('A player request to join a team')
            ->withBody("You have applied to join team ".link_to_route('tournament.team.show',$team->name,[$tournament->slug,$team->id])." for ".link_to_route('tournament.show',$tournament->name,$tournament->slug))
            ->regarding($team)
            ->deliver();

        return redirect()->route('tournament.show',$tournament->slug)->with('success','Success! You have applied to join the team');
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function leaveTournamentForUser($id,Request $request)
    {
        $tournament = KTournament::enabled()->findOrFail($id);
        $team = $request->user()->getTeamOfUserForTournament($tournament);
        if(!$team)
            abort(404);

        if($tournament->isRegistrationOpen() == 3 || $tournament->isRegistrationOpen() == 5 || $tournament->isRegistrationOpen() == 6)
        {
            return redirect()->back()->with('error','Error! Cannot leave tournament now');
        }

        if($team->removeplayerfromteam($request->user()))
        {
            // Stream it.
            $not = new Notification();
            $not->from($request->user())
                ->withType('PlayerTeamLeft')
                ->withSubject('A player left team & tournament')
                ->withBody(link_to_route('user.show',$request->user()->displayName(),$request->user()->username)." has left the team ".link_to_route('tournament.team.show',$team->name,[$tournament->slug,$team->id])." & ".link_to_route('tournament.show',$tournament->name,$tournament->slug))
                ->withStream(true)
                ->regarding($team)
                ->deliver();

            // To creator.
            $request->user()->newNotification()
                ->from($request->user())
                ->withType('PlayerTeamLeft')
                ->withSubject('A player left team & tournament')
                ->withBody("You have left the team ".link_to_route('tournament.team.show',$team->name,[$tournament->slug,$team->id])." & ".link_to_route('tournament.show',$tournament->name,$tournament->slug))
                ->regarding($team)
                ->deliver();

            return redirect()->back()->with('success','Success! You removed yourself from tournament.');
        }
    }

    /**
     * @param $slug
     * @param $id
     * @return $this
     */
    public function showTeam($slug,$id)
    {
        $team = KTeam::find($id);
        if(!$team)
            abort(404);

        $tournament = $team->tournament;

        return view('tournament.showteam')->with('team',$team)->with('tournament',$tournament);
    }

    /**
     * Function that will de approve pending player to given team
     *
     * @param $slug
     * @param $id
     * @param $userid
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function rejectPlayerToTeam($slug, $id, $userid, Request $request)
    {
        if($request->team_id != $id)
        {
            return redirect()->home();
        }
        if($request->user_id != $userid)
        {
            return redirect()->home();
        }

        $user = User::findOrFail($request->user_id);
        $team = KTeam::findOrFail($request->team_id);

        //@TODO Maybe validate this for is enabled()
        $tournament = KTournament::whereSlug($slug)->first();

        // Only if user has enough power
        if(!$request->user()->canHandleTeam($team))
        {
            return redirect()->back()->with('error','Error! Not Authorised');
        }

        if($team->removeplayerfromteam($user))
        {
            // Stream it.
            $not = new Notification();
            $not->from($request->user())
                ->withType('PlayerTeamRemove')
                ->withSubject('Player removed from team')
                ->withBody(link_to_route('user.show',$request->user()->displayName(),$request->user()->username)." has removed ".link_to_route('user.show',$user->displayName(),$user->username)." from team ".link_to_route('tournament.team.show',$team->name,[$tournament->slug,$team->id])." of ".link_to_route('tournament.show',$tournament->name,$tournament->slug))
                ->withStream(true)
                ->regarding($team)
                ->deliver();
            // To the person who got removed.
            $user->newNotification()
                ->from($request->user())
                ->withType('PlayerTeamRemove')
                ->withSubject('Player removed from team')
                ->withBody(link_to_route('user.show',$request->user()->displayName(),$request->user()->username)." has removed you from team ".link_to_route('tournament.team.show',$team->name,[$tournament->slug,$team->id])." of ".link_to_route('tournament.show',$tournament->name,$tournament->slug))
                ->regarding($team)
                ->deliver();

            return redirect()->back()->with('success','Success! Player removed from your team.');
        }
    }

    /**
     * @param $slug
     * @param $id
     * @param $userid
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function pendingPlayerToTeam($slug, $id, $userid, Request $request)
    {
        if($request->team_id != $id)
        {
            return redirect()->home();
        }
        if($request->user_id != $userid)
        {
            return redirect()->home();
        }

        $user = User::findOrFail($request->user_id);
        $team = KTeam::findOrFail($request->team_id);

        //@TODO Maybe validate for enabled()
        $tournament = KTournament::whereSlug($slug)->first();

        // Only if user has enough power
        if(!$request->user()->canHandleTeam($team))
        {
            return redirect()->back()->with('error','Error! Not Authorised');
        }

        if($team->makeplayerpendingfromteam($user))
        {
            $user->newNotification()
                ->from($request->user())
                ->withType('PlayerTeamPending')
                ->withSubject('Player status set as pending on team')
                ->withBody(link_to_route('user.show',$request->user()->displayName(),$request->user()->username)." has sent you to <span class='text-warning notify-bold'>Pending</span> on team ".link_to_route('tournament.team.show',$team->name,[$tournament->slug,$team->id])." of ".link_to_route('tournament.show',$tournament->name,$tournament->slug))
                ->regarding($team)
                ->deliver();
            return redirect()->back()->with('success','Success! Player demoted to pending.');
        }
        else
        {
            return redirect()->back()->with('error','Error! Something went wrong.');
        }
    }

    /**
     * @param $slug
     * @param $id
     * @param $userid
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approvePlayerToTeam($slug, $id, $userid, Request $request)
    {
        if($request->team_id != $id)
        {
            return redirect()->home();
        }
        if($request->user_id != $userid)
        {
            return redirect()->home();
        }

        $tournament = KTournament::whereSlug($slug)->firstOrFail();
        $user = User::findOrFail($request->user_id);
        $team = KTeam::findOrFail($request->team_id);

        // Only if user has enough power
        if(!$request->user()->canHandleTeam($team))
        {
            return redirect()->back()->with('error','Error! Not Authorised');
        }

        if($tournament->isRegistrationOpen() == 4 || $tournament->isRegistrationOpen() == 5 || $tournament->isRegistrationOpen() == 6)
        {
            return redirect()->back()->with('error','Error! Cannot approve player');
        }

        //If team full then cant accept.
        if($team->isFull())
        {
            return redirect()->back()->with('error','Error! Team already have MAXIMUM selected players.');
        }

        if($team->approveplayertoteam($user))
        {
            // Stream it.
            $not = new Notification();
            $not->from($request->user())
                ->withType('PlayerTeamApproved')
                ->withSubject('Player status set as approved on team')
                ->withBody(link_to_route('user.show',$request->user()->displayName(),$request->user()->username)." has <span class='text-green notify-bold'>approved</span> ".link_to_route('user.show',$user->displayName(),$user->username)." request to join team ".link_to_route('tournament.team.show',$team->name,[$tournament->slug,$team->id])." of ".link_to_route('tournament.show',$tournament->name,$tournament->slug))
                ->withStream(true)
                ->regarding($team)
                ->deliver();
            // To User who applied to join
            $user->newNotification()
                ->from($request->user())
                ->withType('PlayerTeamApproved')
                ->withSubject('Player status set as approved on team')
                ->withBody(link_to_route('user.show',$request->user()->displayName(),$request->user()->username)." has <span class='text-green notify-bold'>approved</span> your request to join team ".link_to_route('tournament.team.show',$team->name,[$tournament->slug,$team->id])." of ".link_to_route('tournament.show',$tournament->name,$tournament->slug))
                ->regarding($team)
                ->deliver();

            return redirect()->back()->with('success','Success! Player has been selected.');
        }
        else
        {
            return redirect()->back()->with('error','Error! Something went wrong.');
        }

    }


    /**
     * @param $slug
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function closeTeamForJoining($slug,$id,Request $request)
    {
        if($request->team_id != $id)
        {
            return redirect()->home();
        }

        $tournament = KTournament::whereSlug($slug)->firstOrFail();
        $team = KTeam::findOrFail($request->team_id);

        // Only if user has enough power
        if(!$request->user()->canHandleTeam($team))
        {
            return redirect()->back()->with('error','Error! Not Authorised');
        }

        $team->teamclosed = true;
        $team->save();
        return redirect()->back()->with('message','Success! Now your team is CLOSE for joining');
    }

    /**
     * @param $slug
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function openTeamForJoining($slug,$id,Request $request)
    {
        if($request->team_id != $id)
        {
            return redirect()->home();
        }

        $tournament = KTournament::whereSlug($slug)->firstOrFail();
        $team = KTeam::findOrFail($request->team_id);

        // Only if user has enough power
        if(!$request->user()->canHandleTeam($team))
        {
            return redirect()->back()->with('error','Error! Not Authorised');
        }

        $team->teamclosed = false;
        $team->save();
        return redirect()->back()->with('message','Success! Now your team is OPEN for joining');
    }


    /**
     * @param $slug
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleTeamsForManager($slug,$id,Request $request)
    {
        if($request->team_id != $id)
        {
            return redirect()->home();
        }
        if(!($request->action_id == 0 || $request->action_id == 1 || $request->action_id == 2 || $request->action_id == 3))
        {
            return redirect()->back()->with('error','Error! Invalid action');
        }

        $tournament = KTournament::whereSlug($slug)->firstOrFail();
        $team = KTeam::findOrFail($request->team_id);

        // Only if team belongs to this tour
        if($team->k_tournament_id != $tournament->id)
        {
            return redirect()->home();
        }

        // Tournament has not begun or has ended or disabled then return
        if($tournament->isRegistrationOpen() == 6 || $tournament->isRegistrationOpen() == 5 || $tournament->isRegistrationOpen() == 4)
        {
            return redirect()->back()->with('error','Error! Cannot modify team now.');
        }

        // Only if user has enough power
        if(!$request->user()->canManageTournament($tournament))
        {
            return redirect()->back()->with('error','Error! Not Authorised');
        }

        // If Tournament is full
        if($request->action_id == 1 && $tournament->isFullParticipants())
        {
            return redirect()->back()->with('error','Error! Tournament already have maximum qualified participants.');
        }

        $old_action_id = $team->team_status;
        $team->team_status = $request->action_id;
        $team->save();

        // Stream Notifications.
        // Approved
        if($request->action_id == 1 && $request->action_id != $old_action_id)
        {
            $not = new Notification();
            $not->from($request->user())
                ->withType('TeamRequestApproved')
                ->withSubject('Team has approved to join tournament')
                ->withBody(link_to_route('user.show',$request->user()->displayName(),$request->user()->username)." has <span class='text-green notify-bold'>approved</span> team ".link_to_route('tournament.team.show',$team->name,[$tournament->slug,$team->id])." request to join ".link_to_route('tournament.show',$tournament->name,$tournament->slug))
                ->withStream(true)
                ->regarding($team)
                ->deliver();
        }
        //Disqualifed
        elseif($request->action_id == 2 && $request->action_id != $old_action_id)
        {
            $not = new Notification();
            $not->from($request->user())
                ->withType('TeamRequestDisqualified')
                ->withSubject('Team has set to disqualified to join tournament')
                ->withBody(link_to_route('user.show',$request->user()->displayName(),$request->user()->username)." has <span class='text-danger notify-bold'>disqualified</span> team ".link_to_route('tournament.team.show',$team->name,[$tournament->slug,$team->id])." from ".link_to_route('tournament.show',$tournament->name,$tournament->slug))
                ->withStream(true)
                ->regarding($team)
                ->deliver();
        }
        // Not Eligible
        elseif($request->action_id == 3 && $request->action_id != $old_action_id)
        {
            $not = new Notification();
            $not->from($request->user())
                ->withType('TeamRequestNoteligible')
                ->withSubject('Team has set not eligible to join tournament')
                ->withBody(link_to_route('user.show',$request->user()->displayName(),$request->user()->username)." has changed team ".link_to_route('tournament.team.show',$team->name,[$tournament->slug,$team->id])." status to <span class='text-danger notify-bold'>not eligible</span> in ".link_to_route('tournament.show',$tournament->name,$tournament->slug))
                ->withStream(true)
                ->regarding($team)
                ->deliver();
        }
        //Pending
        elseif($request->action_id == 0 && $request->action_id != $old_action_id)
        {
            $not = new Notification();
            $not->from($request->user())
                ->withType('TeamRequestPending')
                ->withSubject('Team has set pending to join tournament')
                ->withBody(link_to_route('user.show',$request->user()->displayName(),$request->user()->username)." has changed team ".link_to_route('tournament.team.show',$team->name,[$tournament->slug,$team->id])." status to <span class='text-warning notify-bold'>pending</span> in ".link_to_route('tournament.show',$tournament->name,$tournament->slug))
                ->withStream(true)
                ->regarding($team)
                ->deliver();
        }

        return redirect()->back()->with('message','Success! Team status changed');
    }

    /**
     * Return match details.
     *
     * @param $slug
     * @param $id
     * @param Request $request
     * @return $this
     */
    public function getTournamentMatch($slug,$id,Request $request)
    {
        $tournament = KTournament::whereSlug($slug)->firstOrFail();
        $match = KMatch::findOrFail($id);

        $games = [];
        for($i=1; $i<=6; $i++)
        {
            if($match->{"game".$i."_id"} != null)
            {
                $game = Game::findOrFail($match->{"game".$i."_id"});
                $game->game_index = $i;
                array_push($games,$game);
            }
        }
        //dd($match);
        return view('tournament.showmatch')->with('tournament',$tournament)->with('match',$match)->with('games',$games);
    }

}
