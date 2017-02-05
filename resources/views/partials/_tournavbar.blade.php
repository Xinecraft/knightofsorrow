<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="{{ set_active(['tournament']) }}">{!! link_to_route('tournament.index','Home') !!}</li>
                <li class="{{ set_active(['tournament/calendar']) }}">{!! link_to_route('tournament.calendar','Calendar') !!}</li>
                <li class="{{ set_active(['tournament/ranking*']) }}">{!! link_to_route('tournament.ranking.teams','Ranking') !!}</li>
                <li class="{{ set_active(['tournament/guidelines*']) }}">{!! link_to_route('tournament.guidelines','Rules') !!}</li>
                <li class="{{ set_active(['tournament/livestream*']) }}">{!! link_to_route('tournament.stream','Stream') !!}</li>
                <li class="{{ set_active(['tournament/worldclock*']) }}">{!! link_to_route('tournament.wc','World Clock') !!}</li>
				<li class=""><a href="https://www.youtube.com/channel/UCWMOnI1wWm6FuNf45RG-JkA" target="_blank">Videos</a></li>
                {{--<li class="{{ set_active(['statistics/charts*']) }}">{!! link_to_route('chart-reports','Charts') !!}</li>--}}
                {{--<li class="{{ set_active_or_disabled(['statistics/player/*']) }}"><a>Player Details</a></li>--}}
			</ul>

            @if(Request::route()->getName() == "tournament.show")
            <ul class="navbar-right nav navbar-nav">
                <li class="active"><a>{{ $tournament->name }}</a></li>
            </ul>
            @elseif(Request::route()->getName() == "tournament.ranking.single" || Request::route()->getName() == "tournament.ranking.teams")
                <ul class="navbar-right nav navbar-nav">
                    <li class="{{ set_active(['tournament/ranking/single']) }}">{!! link_to_route('tournament.ranking.single','Player Ranking') !!}</li>
                    <li class="{{ set_active(['tournament/ranking/teams']) }}">{!! link_to_route('tournament.ranking.teams','Team Ranking') !!}</li>
                </ul>
                @endif
                <!-- <form class="navbar-form navbar-right no-padding" role="search" method="get" name="search">
                    <div class="form-group">
                        <input type="text" class="form-control" name="search" placeholder="Search Player">
                    </div>
                    <button type="submit" class="btn btn-default">Go</button>
                </form> -->
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>