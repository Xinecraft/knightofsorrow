{!! Form::open(['route' => 'kossrvadmin.commands','id' => 'adminsrvcommandform','class' => 'form-horizontal form']) !!}
<button id="playerBTbtn" data-type="balanceteams" title="Balance Teams"
        class="adminsrvcommandbtn  btn btn-primary btn-sm">BalanceTeams
</button>
<button id="playerLTbtn" data-type="lockteams" title="Toggle Lock Teams"
        class="adminsrvcommandbtn  btn btn-primary btn-sm">LockTeams
</button>
<button id="playerSAbtn" data-type="switchall" title="Switch All"
        class="adminsrvcommandbtn  btn btn-primary btn-sm">SwitchAll
</button>
<br>
<button id="playerTONbtn" data-type="taseronly true" title="Taseronly On"
        class="adminsrvcommandbtn  btn btn-info btn-sm">Taser On
</button>
<button id="playerTOFFbtn" data-type="taseronly false" title="Taseronly Off"
        class="adminsrvcommandbtn  btn btn-info btn-sm">Taser Off
</button>
<button id="playerCONbtn" data-type="anticamp true" title="Anti-Camp On"
        class="adminsrvcommandbtn  btn btn-warning btn-sm">AntiCamp On
</button>
<button id="playerCOFFbtn" data-type="anticamp false" title="Anti-Camp Off"
        class="adminsrvcommandbtn  btn btn-warning btn-sm">AntiCamp Off
</button>
<br>
<button id="playerFWbtn" data-type="setmap 0" title="Set Map to FoodWall"
        class="adminsrvcommandbtn  btn btn-success btn-sm">Map FW
</button>
<button id="playerABbtn" data-type="setmap 1" title="Set Map to A-Bomb Nightclub"
        class="adminsrvcommandbtn  btn btn-success btn-sm">Map AB
</button>
<button id="playerFFbtn" data-type="setmap 2" title="Set Map to Wolcott Projects"
        class="adminsrvcommandbtn  btn btn-success btn-sm">Map WP
</button>
<br>
<button id="playerRestartbtn" data-type="restart" title="Restart"
        class="adminsrvcommandbtn  btn btn-danger btn-sm">Restart
</button>

<br>
<br>
<div class="col-xs-12" style="border: 2px dashed grey">
    <h5 class="text-center text-bold">SERVER COMMAND</h5>
    <div class="col-xs-8">
        {!! Form::text('sccmd',null,['class' => 'form-control col-xs-5 input-sm', 'placeholder' => 'eg: set AMMod.KZMod KillCampers false']) !!}
    </div>
    <button id="playerNWbtn" data-type="sc" type="submit"
            class="adminsrvcommandbtn btn btn-success btn-sm">Execute
    </button>
</div>

<div id="admincommand-input-group-error" class="help-block"></div>
{!! Form::close() !!}