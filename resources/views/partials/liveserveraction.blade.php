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
<button id="playerRestartbtn" data-type="restart" title="Restart"
        class="adminsrvcommandbtn  btn btn-danger btn-sm">Restart
</button>

<div id="admincommand-input-group-error" class="help-block"></div>
{!! Form::close() !!}