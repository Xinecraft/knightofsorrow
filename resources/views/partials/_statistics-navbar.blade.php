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
                <li class="{{ set_active(['statistics','statistics/top-players*']) }}">{!! link_to_route('top-players','Players') !!}</li>
                <li class="{{ set_active(['statistics/round-reports*']) }}">{!! link_to_route('round-reports','Rounds') !!}</li>
                <li class="{{ set_active(['statistics/countries*','statistics/country*']) }}">{!! link_to_route('countries-list','Countries') !!}</li>
                {{--<li class="{{ set_active(['statistics/charts*']) }}">{!! link_to_route('chart-reports','Charts') !!}</li>--}}
                <li class="{{ set_active(['statistics/top-10*']) }}">{!! link_to_route('top10','Top 10') !!}</li>
                {{--<li class="{{ set_active_or_disabled(['statistics/player/*']) }}"><a>Player Details</a></li>--}}
                <li class="{{ set_active(['statistics/war-round-reports*']) }}">{!! link_to_route('war-round-reports','War Server') !!}</li>
            </ul>
            <ul class="navbar-right nav navbar-nav">
                <li class="{{ set_active_or_disabled(['statistics/player/*']) }}"><a>Player Details</a></li>
            </ul>
            <!-- <form class="navbar-form navbar-right no-padding" role="search" method="get" name="search">
                <div class="form-group">
                    <input type="text" class="form-control" name="search" placeholder="Search Player">
                </div>
                <button type="submit" class="btn btn-default">Go</button>
            </form> -->
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
