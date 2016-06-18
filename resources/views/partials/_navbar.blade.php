<nav class="navbar navbar-inverse navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            {{--<a class="navbar-brand" href="#"><img src="{{ public_path('images').DIRECTORY_SEPARATOR.'mailogo.png' }}" alt="" height="34" style="height: 34px;"></a>--}}
            <a class="navbar-brand" href="{{ route('home') }}"><img src="{{ url('images/mainlogo.png') }}" alt=""
                                                                    height="34" style="height: 34px;"></a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="{{ set_active(['statistics*']) }}">{!! link_to_route('statistics-home','Statistics') !!}</li>
                <li class="{{ set_active(['rules*']) }}"><a href="{{ route('rules') }}">Rules</a></li>
                @if(Auth::check())
                    <li class="{{ set_active(['feeds*']) }}">{!! link_to_route('feeds-home','Feedline') !!}</li>
                @endif

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        More <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li>{!! link_to_route('servers.list','Servers') !!}</li>
                        <li><a href="{{ route('news.index') }}">News</a></li>
                        <li><a href="{{ route('chat.index') }}">Chat History</a></li>
                        <li><a href="">Clans</a></li>
                        <li><a href="">Forums</a></li>
                        {{--<li><a href="{{ route('rules') }}">Rules</a></li>--}}
                    </ul>
                </li>

                @if(Auth::check() && Auth::user()->receivedMessagesUnseen()->count() > 0)
                    <li class="text-bold {{ set_active(['messages*']) }}">{!! link_to_route('messages.index',Auth::user()->receivedMessagesUnseen()->count()." new messages") !!} </li>
                @endif

            </ul>

            <ul class="nav navbar-nav navbar-right">
                @if(Auth::guest())
                    <li class="{{ set_active(['auth/login']) }}"><a class="login"
                                                                    href="{{ url('/auth/login') }}">Login</a></li>
                    <li class="{{ set_active(['auth/register']) }}"><a href="{{ url('/auth/register') }}">Register</a>
                    </li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <img class="img" src="{{ Auth::user()->getGravatarLink(20) }}" width="15" height="15"/>
                            {{ Auth::user()->displayName() }} <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ route('feeds-home') }}">My Feedline</a></li>
                            <li><a href="{{ url('/profile') }}">My Profile</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{ route('messages.index') }}">Messages</a></li>

                            @if(Auth::check() && Auth::user()->isSubAdmin())
                                <li role="separator" class="divider"></li>
                                <li><a href="{{ route('user.viewkeys') }}">Server Passwords</a></li>
                                @if(Auth::user()->isAdmin())
                                    <li><a href="{{ route('news.create') }}">Create News</a></li>
                                    <li><a href="{{ route('servers.new') }}">Add Server</a></li>
                                @endif
                            @endif

                            <li role="separator" class="divider"></li>
                            <li>{!! link_to_route('user.setting','Setting') !!}</li>
                            <li><a href="{{ url('/auth/logout') }}">Logout</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
            <form class="navbar-form navbar-right" role="search" action='/search/'>
                <div class="form-group">
                    <input type="text" id="navsearch" name='q' class="form-control" placeholder="Search Users"
                           autocomplete="off">
                </div>
                {{--<button type="submit" class="btn btn-default">Search</button>--}}
            </form>
        </div><!--/.nav-collapse -->


    </div>
</nav>