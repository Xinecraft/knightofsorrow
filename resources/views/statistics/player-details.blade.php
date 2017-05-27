@extends('layouts.main')
@section('meta-desc',"All Statistics of $player->name")
@section('title',$player->name)
@section('styles')
    <style>
        .text-points
        {
            font-weight:normal !important;
            font-style:italic !important;
        }
        .alert-inactive
        {
            padding: 5px;
            margin-bottom: 15px;
            border: 1px solid rgb(255, 0, 0);
             border-radius: 0px !important;
            background: rgba(255, 97, 97, 0.17);
            color: #a70000;
            text-align: center;
        }
        .guagecan{
            width: 8em !important;
            height: auto !important;
        }
    </style>
    @endsection
@section('main-container')
    <div class="col-xs-9">
        @include('partials._statistics-navbar')
        <div class="row well player-detail-summary no-margin">
            <div class="col-xs-3">
                <img class="left img-thumbnail" src="/images/game/chars/50/{{ $player->last_team."_".$player->loadout->body."_".$player->loadout->head }}.jpg">
                {!! $player->ownerWithPicture !!}
            </div>
            <div class="col-xs-6 text-center player-detail-summary-name">
                <div class="name-as-title">
                    {{ $player->name }}
                </div>
                <p class="small pad5">
                    @forelse($player->aliases()->whereNotIn('name',\App\DeletedPlayer::lists('player_name'))->limit(5)->get() as $alias)
                        @unless($player->name == $alias->name)
                            <a href="{{  route('player-detail',$alias->name) }}">{{ $alias->name }}</a>
                        @endunless
                    @empty

                    @endforelse
                </p>
            </div>
            <div class="col-xs-3 text-right">
                {!! Html::image('/images/flags_new/flags-iso/shiny/64/'.$player->country->countryCode.".png",$player->country->countryCode,['title' => $player->country->countryName, 'class'=> 'tooltipster']) !!}
            </div>
        </div>

        @unless((\Carbon\Carbon::now()->timestamp - $player->lastGame->updated_at->timestamp) <= 60*60*24*7)
            <p class="alert alert-danger alert-inactive">
                <b>{{ $player->name }}</b> is not seen playing this week!
            </p>
        @endunless

        <div class="row panel no-margin player-rank-container">
            @foreach(App\Rank::where('id','>',1)->get() as $rank)
                @if($rank->id == $player->rank->id)
                    <div class="colm-2 no-padding tooltipster" title="&lt;div class='text-center text-bold' &gt; {{ $rank->name }} &lt;/div&gt; &lt;br&gt;Points: {{ $rank->description }}">
                        <img class="img-thumbnail" src="/images/game/insignia/{{ $rank->id }}.png" width="65px" style="height: 65px;border:1px solid #d62c1a;">
                        <p class="text-center" style="color: #d62c1a;margin-top: 5px;"><strong>{{ $rank->name }}</strong></p>
                    </div>
                @else
                    <div class="colm-1 no-padding tooltipster" title="&lt;div class='text-center text-bold' &gt; {{ $rank->name }} &lt;/div&gt; &lt;br&gt;Points: {{ $rank->description }}">
                        <img class="img-thumbnail" src="/images/game/insignia/{{ $rank->id }}.png" width="40px" style="height: 40px;">
                    </div>
                @endif
            @endforeach
        </div>

        <div class="row no-margin panel player-stats-container">
            {{-- Loadout Starts --}}
            <div class="col-xs-5 pad10 player-stats-loadout-container">

                <!-- LoadOut -->
                <h5 class="no-margin" style="border-bottom: 2px dashed gray;margin-bottom: 10px !important;color: #2D2D2D;font-weight: bold;">
                    Latest Loadout</h5>

                <div class="col-xs-12 no-padding" style="border: 1px solid;margin-bottom: 10px !important;">
                    <img title="{{ $player->loadoutPa }}" class="tooltipster" src="/images/game/weapons/128/item{{ $player->loadout->primary_weapon }}.jpg" style="width: 100%;height: auto;max-height: 156px">
                    <p class="text-center" style="margin-top: 5px;"><strong>{{ $player->loadoutPw }}</strong></p>
                </div>
                <div class="col-xs-12 no-padding" style="border: 1px solid;margin-bottom: 10px !important;">
                    <img class="tooltipster" title="{{ $player->loadoutSa }}" src="/images/game/weapons/128/item{{ $player->loadout->secondary_weapon }}.jpg" style="width: 100%;height: auto;max-height: 156px">
                    <p class="text-center" style="margin-top: 5px;"><strong>{{ $player->loadoutSw }}</strong></p>
                </div>

                <div class="col-xs-12 no-padding" style="border: 1px solid;margin-bottom: 10px !important;">
                    <div class="col-xs-4 no-padding"><img class="tooltipster" title="{{ $player->loadoutEq1 }}" src="/images/game/weapons/64/item{{ $player->loadout->equip_one }}.jpg" style="width: 100%;"></div>
                    <div class="col-xs-4 no-padding"><img class="tooltipster" title="{{ $player->loadoutEq2 }}" src="/images/game/weapons/64/item{{ $player->loadout->equip_two }}.jpg" style="width: 100%;"></div>
                    <div class="col-xs-4 no-padding"><img class="tooltipster" title="{{ $player->loadoutEq3 }}" src="/images/game/weapons/64/item{{ $player->loadout->equip_three }}.jpg" style="width: 100%;"></div>
                    <div class="col-xs-4 no-padding"><img class="tooltipster" title="{{ $player->loadoutEq4 }}" src="/images/game/weapons/64/item{{ $player->loadout->equip_four }}.jpg" style="width: 100%;"></div>
                    <div class="col-xs-4 no-padding"><img class="tooltipster" title="{{ $player->loadoutEq5 }}" src="/images/game/weapons/64/item{{ $player->loadout->equip_five }}.jpg" style="width: 100%;"></div>
                    <div class="col-xs-4 no-padding"><img class="tooltipster" title="{{ $player->loadoutBr }}" src="/images/game/weapons/64/item{{ $player->loadout->breacher }}.jpg" style="width: 100%;"></div>
                    <p class="text-center" style="margin-top: 5px;width: 100%;float: left;text-align: center;"><strong>Equipments</strong>
                    </p>
                </div>

                <div class="col-xs-12 no-padding" style="margin-bottom: 8px !important">
                    <div class="col-xs-5 no-padding" style="border: 1px solid;"><img class="tooltipster" title="{{ $player->loadoutHead }}" src="/images/game/weapons/128/item{{ $player->loadout->head }}.jpg" style="width: 100%;">
                        <p class="text-center" style="margin-top: 5px;"><strong>{{ $player->loadoutHead }}</strong></p></div>
                    <div class="col-xs-5 right no-padding" style="border: 1px solid"><img class="tooltipster" title="{{ $player->loadoutBody }}" src="/images/game/weapons/128/item{{ $player->loadout->body }}.jpg" style="width: 100%;">
                        <p class="text-center" style="margin-top: 5px;"><strong>{{ $player->loadoutBody }}</strong></p>
                    </div>
                </div>
            </div>
            {{-- / Loadout Ends --}}

            {{-- General Statistics @TODO: add class general-statistics and fix bugs --}}
            <div class="col-xs-7 pad10" style="background-color: #ffffff;margin-top: 5px;border: 1px solid;">
                <h5 class="no-margin" style="border-bottom: 2px dashed gray;margin-bottom: 10px !important;color: #2D2D2D;font-weight: bold;">
                    General Statistics</h5>

                <table class="table table-striped table-condensed borderless no-margin">
                    <tbody>
                    <tr>
                        <td class="col-4">
                        </td>
                        <td class="col-5">
                            Position
                        </td>
                        <td class="col-6 text-right" style="color:#058700"><strong>{{ $player->position }}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-1">
                        </td>
                        <td class="col-2">
                            Score Earned
                        </td>
                        <td class="col-3 text-right">
                            <strong>{{ $player->total_score }}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-4">
                        </td>
                        <td class="col-5">
                            <span class="tooltipster" title="<b>Points are calculated by a secret Algorithm</b><br><br>Kills,Deaths,Arrests,Team Kills all affect points calculation.<br><br>Player ranks are allocated according to points.">Total Points</span>
                        </td>
                        <td class="col-6 text-right"><strong>{{ $player->total_points }}</strong>
                            @unless($playerPoints->isEmpty())
                                {!! $playerPoints->sum('points') < 0 ?  "<span class='text-danger text-points small'>( -".$playerPoints->sum('points')." )</span>" : "<span class='text-green text-points small'>( +".$playerPoints->sum('points')." )</span>" !!}
                            @endunless
                        </td>
                    </tr>

                    <tr>
                        <td class="col-1">
                        </td>
                        <td class="col-2">
                            <span style="border-bottom: 1px dotted darkgrey;" class="tooltipster" title="Available to those who played more than <b>10 hours</b> in server.<br><br>To keep your rating active you should play atleast <b>once every week</b>">Rating</span>
                        </td>
                        <td class="col-3 text-right">
                            <strong>{!! $player->playerRating !!}</strong>
                        </td>
                    </tr>

                    <tr>
                        <td class="col-4">
                        </td>
                        <td class="col-5">
                            Rank
                        </td>
                        <td class="col-6 text-right"><strong>{{ $player->rankName }}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-4">
                        </td>
                        <td class="col-5">
                            Rounds Played
                        </td>
                        <td class="col-6 text-right"><strong>{{ $player->total_round_played }}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-4">
                        </td>
                        <td class="col-5">
                            Rounds Won
                        </td>
                        <td class="col-6 text-right"><strong>{{ $player->game_won }}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-4">
                        </td>
                        <td class="col-5">
                            Rounds Lost
                        </td>
                        <td class="col-6 text-right"><strong>{{ $player->game_lost }}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-4">
                        </td>
                        <td class="col-5">
                            Rounds Tie
                        </td>
                        <td class="col-6 text-right"><strong>{{ $player->game_draw }}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-1">
                        </td>
                        <td class="col-2">
                            Time Played
                        </td>
                        <td class="col-3 text-right">
                            <strong> {{ $player->timePlayed }}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-1">
                        </td>
                        <td class="col-2">
                            Score / Round
                        </td>
                        <td class="col-3 text-right">
                            <strong>{{ $player->scorePerRound }}</strong>
                        </td>
                    </tr>

                    <tr>
                        <td class="col-4">
                        </td>
                        <td class="col-5">
                            Kills
                        </td>
                        <td class="col-6 text-right"><strong>{{ $player->total_kills }}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-4">
                        </td>
                        <td class="col-5">
                            Deaths
                        </td>
                        <td class="col-6 text-right"><strong>{{ $player->total_deaths }}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-4">
                        </td>
                        <td class="col-5">
                            Suicides
                        </td>
                        <td class="col-6 text-right"><strong>{{ $player->total_suicides }}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-4">
                        </td>
                        <td class="col-5">
                            Arrests
                        </td>
                        <td class="col-6 text-right"><strong>{{ $player->total_arrests }}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-4">
                        </td>
                        <td class="col-5">
                            Arrested
                        </td>
                        <td class="col-6 text-right"><strong>{{ $player->total_arrested }}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-4">
                        </td>
                        <td class="col-5">
                            Team Kills
                        </td>
                        <td class="col-6 text-right"><strong>{{ $player->total_team_kills }}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-4">
                        </td>
                        <td class="col-5">
                            Highest Score
                        </td>
                        <td class="col-6 text-right"><strong>{{ $player->highest_score }}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-4">
                        </td>
                        <td class="col-5">
                            Best Kill Streak
                        </td>
                        <td class="col-6 text-right"><strong>{{ $player->best_killstreak }}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-4">
                        </td>
                        <td class="col-5">
                            Best Arrest Streak
                        </td>
                        <td class="col-6 text-right"><strong>{{ $player->best_arreststreak }}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-4">
                        </td>
                        <td class="col-5">
                            Best Death Streak
                        </td>
                        <td class="col-6 text-right"><strong>{{ $player->best_deathstreak }}</strong>
                        </td>
                    </tr>

                    <tr>
                        <td class="col-4">
                        </td>
                        <td class="col-5">
                            Ammo Fired
                        </td>
                        <td class="col-6 text-right"><strong>{{ $player->totalAmmoFired }}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-4">
                        </td>
                        <td class="col-5">
                            Accuracy
                        </td>
                        <td class="col-6 text-right"><strong>{{ $player->weaponAccuracy }}%</strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-4">
                        </td>
                        <td class="col-5">
                            Longest Kill
                        </td>
                        <td class="col-6 text-right"><strong>{{ round($player->longestKillDistance/100) }}m</strong>
                        </td>
                    </tr>

                    <tr>
                        <td class="col-4">
                        </td>
                        <td class="col-5">
                            First Seen
                        </td>
                        <td class="col-6 text-right"><strong> {!! link_to_route('round-detail',$player->firstGame->created_at->diffForHumans(),[$player->first_game_id]) !!} </strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-4">
                        </td>
                        <td class="col-5">
                            Last Seen
                        </td>
                        <td class="col-6 text-right"><strong>{!! link_to_route('round-detail',$player->lastGame->created_at->diffForHumans(),[$player->last_game_id]) !!}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-4">
                        </td>
                        <th class="col-5">
                            Owner
                        </th>
                        <td class="col-6 text-right"><strong>{!! $player->owner !!}</strong>
                        </td>
                    </tr>

                    @if(Auth::check() && Auth::user()->isAdmin())
                    <tr>
                        <td class="col-4">
                        </td>
                        <th class="col-5">
                            Last IP Address
                        </th>
                        <td class="col-6 text-right">{!! $player->last_ip_address !!}
                            <a style='color:purple' title="View IP History" class='tooltipster fancybox livepfancy fancybox.ajax' href='/viewiphistory?player={{ $player->name }}'><i class='fa fa-cog'></i></a>
                        </td>
                    </tr>
                        <tr>
                            <td class="col-4">
                            </td>
                            <th class="col-5 text-danger">
                                Delete Player
                            </th>
                            <td class="col-6 text-right">
                                <a class="btn btn-xs btn-danger" href="{{ route('player-delete',$player->name) }}">Delete</a>
                            </td>
                        </tr>
                    @endif

                    </tbody>
                </table>

            </div>
            <!-- / General Stats Ends -->

            <!-- Gauge Statistics -->
            <div class="col-xs-12 pad10" style="background-color: #ffffff;margin-top: 5px;border: 1px solid;">
                <div class="col-xs-2 no-margin no-padding">
                    <p class="no-margin text-center gaugeheading">Score / Min</p>
                    <canvas class="guagecan" id="gauge-spm" style="width: 8em" data-spm="{{ $player->score_per_min }}"></canvas>
                    <h4 class="font-dsdigital no-margin text-center">{{ $player->score_per_min }}</h4>
                </div>
                <div class="col-xs-2 no-margin no-padding">
                    <p class="no-margin text-center gaugeheading tooltipster" title="<b>Win / Lost Ratio</b>">W/L Ratio</p>
                    <canvas class="guagecan" id="gauge-wlr" style="width: 8em" data-wlr="{{ $player->winLostRatio }}"></canvas>
                    <h4 class="font-dsdigital no-margin text-center">{{ $player->winLostRatio }}</h4>
                </div>

                <div class="col-xs-2 no-margin no-padding">
                    <p class="no-margin text-center gaugeheading">Accuracy</p>
                    <canvas class="guagecan" id="gauge-acr" style="width: 8em" data-acr="{{ $player->weaponAccuracy }}"></canvas>
                    <h4 class="font-dsdigital no-margin text-center">{{ $player->weaponAccuracy }}%</h4>
                </div>
                <div class="col-xs-2 no-margin no-padding">
                    <p class="no-margin text-center gaugeheading tooltipster" title="<b>Kill / Death Ratio</b>">K/D Ratio</p>
                    <canvas class="guagecan" id="gauge-kdr" style="width: 8em" data-kdr="{{ $player->killdeath_ratio }}"></canvas>
                    <h4 class="font-dsdigital no-margin text-center">{{ $player->killdeath_ratio }}</h4>
                </div>
                <div class="col-xs-2 no-margin no-padding">
                    <p class="no-margin text-center gaugeheading tooltipster" title="<b>Arrest / Arrested Ratio</b>">A/A Ratio</p>
                    <canvas class="guagecan" id="gauge-aar" style="width: 8em" data-aar="{{ $player->arr_ratio }}"></canvas>
                    <h4 class="font-dsdigital no-margin text-center">{{ $player->arr_ratio }}</h4>
                </div>

                <div class="col-xs-2 no-margin no-padding">
                    <p class="no-margin text-center gaugeheading">Score percentile</p>
                    <canvas class="guagecan" id="gauge-spt" style="width: 8em" data-spt="{{ $player->score_percentile }}"></canvas>
                    <h4 class="font-dsdigital no-margin text-center">{{ $player->score_percentile }}</h4>
                </div>
            </div>
            <!-- / Gauge Stats Ends -->
        </div>

        <div class="row no-margin well player-weapons-detail">

            <h5 style="padding-bottom: 5px;border-bottom: 2px dashed gray;color: #050505"><strong>Weapons &amp; Equipments</strong></h5>
            <!--Tab Starts-->
            <div role="tabpanel" style="margin-top: 10px">

                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a class="ainorange" href="#primary" aria-controls="primary" role="tab" data-toggle="tab">Primary Weapon</a></li>
                    <li role="presentation"><a class="ainorange" href="#secondary" aria-controls="secondary" role="tab" data-toggle="tab">Secondary Weapon</a></li>
                    <li role="presentation"><a class="ainorange" href="#tactical" aria-controls="tactical" role="tab" data-toggle="tab">Tactical</a></li>
                    <li role="presentation"><a class="ainorange" href="#others" aria-controls="others" role="tab" data-toggle="tab">Breaching &amp; Others</a></li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content" style="background-color: #ffffff;border-left: 1px solid #ddd;border-bottom: 1px solid #ddd;border-right: 1px solid #ddd;">
                    @forelse($weaponFamilies as $weaponFamily)
                        @if($weaponFamily->first() != null && $weaponFamily->first()->family == 'Primary')
                            <div role="tabpanel" class="tab-pane active" id="primary">
                                <table class="table table-bordered commontable weapontable">
                                    <thead>
                                    <tr>
                                        <td>Weapon</td>
                                        <td>Kills</td>
                                        <td>Time Used</td>
                                        <td>Kills / Min</td>
                                        <td class="text-right">Accuracy</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($weaponFamily as $weapon)
                                    <tr>
                                        <th class="col-xs-2"><img class="weapontableimg" src="/images/game/weapons/64/item{{ $weapon->id }}.jpg">
                                        <p class="no-margin padding5">{{ $weapon->name }}</p>
                                        </th>
                                        <th class="col-xs-1">{{ $weapon->kills }}</th>
                                        <th class="col-xs-1">{{ $weapon->time_used }}</th>
                                        <th class="col-xs-1">{{ $weapon->kills_per_min }}</th>
                                        <th class="col-xs-1">{{ $weapon->accuracy }}%</th>
                                    </tr>
                                    @empty
                                        <th>Its Lone here.</th>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        @elseif($weaponFamily->first() != null && $weaponFamily->first()->family == 'Secondary')
                            <div role="tabpanel" class="tab-pane" id="secondary">
                                <table class="table table-bordered commontable weapontable">
                                    <thead><tr>
                                        <td>Weapon</td>
                                        <td>Kills</td>
                                        <td>Time Used</td>
                                        <td>Kills / Min</td>
                                        <td class="text-right">Accuracy</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($weaponFamily as $weapon)
                                        <tr>
                                            <th class="col-xs-2"><img class="weapontableimg" src="/images/game/weapons/64/item{{ $weapon->id }}.jpg">
                                                <p class="no-margin padding5">{{ $weapon->name }}</p>
                                            </th>
                                            <th class="col-xs-1">{{ $weapon->kills }}</th>
                                            <th class="col-xs-1">{{ $weapon->time_used }}</th>
                                            <th class="col-xs-1">{{ $weapon->kills_per_min }}</th>
                                            <th class="col-xs-1">{{ $weapon->accuracy }}%</th>
                                        </tr>
                                    @empty
                                        <th>Its Lone here.</th>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        @elseif($weaponFamily->first() != null && $weaponFamily->first()->family == 'Tactical')
                            <div role="tabpanel" class="tab-pane" id="tactical">
                                <table class="table table-bordered commontable weapontable">
                                    <thead><tr>
                                        <td>Weapon</td>
                                        <td>Stuns</td>
                                        <td>Time Used</td>
                                        <td>Stuns / Min</td>
                                        <td class="text-right">Accuracy</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($weaponFamily as $weapon)
                                        <tr>
                                            <th class="col-xs-2"><img class="weapontableimg" src="/images/game/weapons/64/item{{ $weapon->id }}.jpg">
                                                <p class="no-margin padding5">{{ $weapon->name }}</p>
                                            </th>
                                            <th class="col-xs-1">{{ $weapon->shots_fired }}</th>
                                            <th class="col-xs-1">{{ $weapon->time_used }}</th>
                                            <th class="col-xs-1">{{ $weapon->stuns_per_min }}</th>
                                            <th class="col-xs-1">{{ $weapon->accuracy }}%</th>
                                        </tr>
                                    @empty
                                        <th>Its Lone here.</th>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        @elseif($weaponFamily->first() != null && $weaponFamily->first()->family == 'Others')
                            <div role="tabpanel" class="tab-pane" id="others">
                                <table class="table table-bordered commontable weapontable">
                                    <thead>
                                    <tr>
                                        <td>Weapon</td>
                                        <td>Kills</td>
                                        <td>Time Used</td>
                                        <td>Kills / Min</td>
                                        <td class="text-right">Accuracy</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($weaponFamily as $weapon)
                                        @unless($weapon->id == 32 || $weapon->id == 33)
                                        <tr>
                                            <th class="col-xs-2"><img class="weapontableimg" src="/images/game/weapons/64/item{{ $weapon->id }}.jpg">
                                                <p class="no-margin padding5">{{ $weapon->name }}</p>
                                            </th>
                                            <th class="col-xs-1">{{ $weapon->kills }}</th>
                                            <th class="col-xs-1">{{ $weapon->time_used }}</th>
                                            <th class="col-xs-1">{{ $weapon->kills_per_min }}</th>
                                            <th class="col-xs-1">{{ $weapon->accuracy }}%</th>
                                        </tr>
                                        @endunless
                                    @empty
                                        <th>Its Lone here.</th>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        @endif

                    @empty
                        Its Empty
                    @endforelse
                </div>

            </div>
            <!--/Tab Ends-->
        </div>


        <div class="row no-margin player-round-reports" style="margin-bottom: 10px !important;">
            <div class="col-xs-12 panel panel-default no-padding no-margin no-left-padding">
                <div class="panel-heading">
                    <small class="pull-right"><i><b><a href="{{ route('player-rounds',$player->name) }}">» view all</a></b></i></small>
                    <span class="info-title">Last Rounds Played</span>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-hover no-margin">
                        <thead><tr>
                            <th class="col-xs-1">Round</th>
                            <th class="col-xs-2">Time</th>
                            <th class="col-xs-1">Swat</th>
                            <th class="col-xs-2">Suspects</th>
                            <th>Map</th>
                            <th class="col-xs-2 text-right">Date</th>
                        </tr></thead>
                        <tbody id="data-items" class="roundstabledata">
                        @forelse($latestGames as $round)
                            <tr class="item pointer-cursor" data-id="{{ $round->id }}">
                                <td class="color-main text-bold">{!! link_to_route('round-detail',$round->index,[$round->id]) !!}</td>
                                <td class="text-muted">{{ $round->time }}</td>
                                <td>{!! $round->swatScoreWithColor !!}</td>
                                <td>{!! $round->suspectsScoreWithColor !!}</td>
                                <td>{{ $round->mapName }}</td>
                                <td class="text-right tooltipster" title="{{ $round->timeDDTS }}">{{ $round->timeAgo }}</td>
                            </tr>
                         @empty
                            <th>Its lone here.</th>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @unless($playerPoints->isEmpty())
            <div class="row no-margin player-round-reports" style="margin-bottom: 10px !important;">
                <div class="col-xs-12 panel panel-default no-padding no-margin no-left-padding">
                    <div class="panel-heading"><span class="info-title">Points Awarded {!! $playerPoints->sum('points') < 0 ?  "<span class='text-danger'>( -".$playerPoints->sum('points')." )</span>" : "<span class='text-green'>( +".$playerPoints->sum('points')." )</span>" !!}</span></div>
                    <div class="panel-body">
                        <table class="table table-striped table-hover no-margin">
                            <thead>
                            <tr>
                                <th class="col-xs-2">Points</th>
                                <th class="col-xs-5">Reason</th>
                                <th class="col-xs-2">Awarded By</th>
                                <th class="col-xs-2 text-right">Awarded At</th>
                                @if(Auth::check() && Auth::user()->isAdmin())
                                    <th class="col-xs-1"></th>
                                @endif
                            </tr>
                            </thead>
                            <tbody id="data-items" class="roundstabledata">
                            @forelse($playerPoints as $player)
                                <tr class="item">
                                    <td class="text-bold">{!! $player->points < 0 ?  "<span class='text-danger'>".$player->points."</span>" : "<span class='text-green'>".$player->points."</span>" !!}</td>
                                    <td class="tooltipster" title="{{ $player->reason }}">{{ str_limit($player->reason,25) }}</td>
                                    <td class="color-main text-bold">
                                        <a class="" style="margin-right:1em" href="{{ route('user.show',$player->admin->username) }}">
                                            <strong class="">{{ $player->admin->displayName() }}</strong>
                                        </a>
                                    </td>
                                    <td class="text-right">{{ $player->created_at->diffForHumans() }}</td>
                                    @if(Auth::check() && Auth::user()->isAdmin())
                                        <td>
                                            {!! Form::open(['route' => ['delete-playerpoints',urlencode($player->id)]]) !!}
                                            {!! Form::hidden('p_id',$player->id) !!}
                                            <button class="btn btn-xs btn-danger confirm tooltipster" title="Delete" type="submit">Delete</button>
                                            {!! Form::close() !!}
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <h1>Nothing in here :(</h1>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endunless

    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            makeGauge('gauge-spm', $('#gauge-spm').data('spm'), 5.00);
            makeGauge('gauge-wlr', $('#gauge-wlr').data('wlr'), 3.56);
            makeGauge('gauge-acr', $('#gauge-acr').data('acr'), 100.00);
            makeGauge('gauge-kdr', $('#gauge-kdr').data('kdr'), 5.00);
            makeGauge('gauge-aar', $('#gauge-aar').data('aar'), 3.56);
            makeGauge('gauge-spt', $('#gauge-spt').data('spt'), 25.00);

            $('.fancybox').fancybox();
        })
    </script>
@endsection