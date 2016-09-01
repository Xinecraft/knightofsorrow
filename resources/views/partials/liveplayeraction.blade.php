{!! Form::open(['route' => 'kosadmin.commands','id' => 'admincommandform']) !!}
<div id="inline1" style="width:400px;">
    <input type="hidden" value="{{ $player }}" name="selected_player">
    <input type="hidden" value="" name="action">
    <button id="playerMutebtn" data-type="forcemute"
            class="admincommandbtn btn btn-default btn-sm">Mute
    </button>
    <button id="playerKickbtn" data-type="kick"
            class="admincommandbtn btn btn-warning btn-sm">Kick
    </button>
    <button id="playerBanbtn" data-type="kickban"
            class="admincommandbtn btn btn-danger btn-sm">Ban
    </button>
    <button id="playerViewbtn" data-type="forceview"
            class="admincommandbtn btn btn-info btn-sm">View
    </button>
    <button id="playerSpecbtn" data-type="forcespec"
            class="admincommandbtn btn btn-info btn-sm">Spectate
    </button>
    <button id="playerJoinbtn" data-type="forcejoin"
            class="admincommandbtn btn btn-info btn-sm">Join
    </button>
    <button id="playerSTbtn" data-type="switchteam"
            class="admincommandbtn btn btn-primary btn-sm">Switch Team
    </button>
    <button id="playerLLbtn" data-type="forcelesslethal"
            class="admincommandbtn btn btn-primary btn-sm">Less Lethal
    </button>
    <button id="playerNWbtn" data-type="forcenoweapons"
            class="admincommandbtn btn btn-primary btn-sm">No Weapons
    </button>
</div>
{!! Form::close() !!}