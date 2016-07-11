<!-- Player Individual Data Starts -->
<div class="panel panel-default col-xs-12 no-padding">
    <!-- Default panel contents -->
    <div class="panel-heading"><b>{!! link_to_route('player-detail',$player->name,[$player->name]) !!}</b>{!! Html::image('/images/flags/20/'.$player->country->countryCode.".png",$player->country->countryCode,['title' => $player->country->countryName,'class' => 'right tooltipster']) !!}</div>
    <!-- list -->
    <ul class="list-group col-xs-4">
        <li class="list-group-item">
            <span class="badge">{{ $player->kills }}</span>
            Kills
        </li>
        <li class="list-group-item">
            <span class="badge">{{ $player->deaths }}</span>
            Deaths
        </li>
        <li class="list-group-item">
            <span class="badge">{{ $player->deaths == 0 ? $player->kills : round($player->kills/$player->deaths,2) }}</span>
            Kill / Death Ratio
        </li>
        <li class="list-group-item">
            <span class="badge">{{ $player->team_kills }}</span>
            Team Kills
        </li>
        <li class="list-group-item">
            <span class="badge">{{ $player->kill_streak }}</span>
            Best Killstreak
        </li>
    </ul>

    <ul class="list-group col-xs-4">
        <li class="list-group-item">
            <span class="badge">{{ $player->arrests }}</span>
            Arrests
        </li>
        <li class="list-group-item">
            <span class="badge">{{ $player->arrested }}</span>
            Arrested
        </li>
        <li class="list-group-item">
            <span class="badge">{{ $player->arrested == 0 ? $player->arrests : round($player->arrests/$player->arrested,2) }}</span>
            Arrests / Arrested Ratio
        </li>
        <li class="list-group-item">
            <span class="badge">{{ $player->arrest_streak }}</span>
            Best Arreststreak
        </li>
        <li class="list-group-item">
            <span class="badge">{{ $player->death_streak }}</span>
            Best Deathstreak
        </li>
    </ul>

    <ul class="list-group col-xs-4">
        <li class="list-group-item">
            <span class="badge">{{ App\Server\Utils::getMSbyS($player->time_played,"%dm %ds") }}</span>
            Time Played
        </li>
        <li class="list-group-item">
            <span class="badge">{{ $player->score_per_min }}</span>
            Score / Min
        </li>
        <li class="list-group-item">
            <span class="badge">{{ $player->score }}</span>
            Total Score
        </li>
    </ul>

</div>
<!-- / Player Individual Data Ends -->