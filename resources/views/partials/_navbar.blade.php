<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">KnightofSorrow.tk</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="{{ set_active(['/','home']) }}"><a href="{{ route('home') }}">Home</a></li>
                <li class="{{ set_active(['statistics*']) }}">{!! link_to_route('statistics-home','Statistics') !!}</li>
                <li><a href="#contact">Contact</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                    @if(Auth::guest())
                        <li class="{{ set_active(['auth/login']) }}"><a class="login" href="{{ url('/auth/login') }}">Login</a></li>
                        <li class="{{ set_active(['auth/register']) }}"><a href="{{ url('/auth/register') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <img class="img" src="//gravatar.com/avatar/{{ Auth::user()->getGravatarId() }}?d=mm&s=20" width="20" height="20" />
                            {{ Auth::user()->name }} <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/auth/logout') }}">Profile</a></li>
                                <li><a href="{{ url('/auth/logout') }}">New Feed</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="{{ url('/auth/logout') }}">Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            <form class="navbar-form navbar-right" role="search" action='/search/'>
                <div class="form-group">
                    <input type="text" id="navsearch" name='q' class="form-control" placeholder="Search Users" autocomplete="off">
                </div>
                {{--<button type="submit" class="btn btn-default">Search</button>--}}
            </form>
        </div><!--/.nav-collapse -->
    </div>
</nav>