<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    {{--<meta name="viewport" content="width=device-width, initial-scale=1">--}}
    <meta name="description" content="@yield('meta-desc','Swat4 Servers and Community with ranking and more fun')">
    <meta name="author" content="Zishan Ansari">

    <!--Chrome, Firefox OS and Opera -->
    <meta name="theme-color" content="#C60D00">
    <!-- Windows Phone -->
    <meta name="msapplication-navbutton-color" content="#C60D00">
    <!-- iOS Safari -->
    <meta name="apple-mobile-web-app-status-bar-style" content="#C60D00">

    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title','SWAT 4 Servers & Community') &squf; KNIGHT of SORROW</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
    <link href='https://fonts.googleapis.com/css?family=Passion+One' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{{ elixir('css/all.css') }}">
    @yield('styles')
    <style>
        @media (min-width: 768px) {
            .container {
                width: 970px;
            }
        }
        @media (min-width: 992px) {
            .container {
                width: 970px;
            }
        }
        @media (min-width: 1200px) {
            .container {
                width: 1170px;
            }
        }
    </style>
    {{--<link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">--}}
    {{--<link href="http://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">--}}
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <!--<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>-->
    {{-- <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>--}}
    <![endif]-->
</head>
<body>
@include('partials._navbar')
@yield('before-container')

@include('partials._quickerrors')

<div class="main container">

    @if(!Request::is('tournament*'))
        @include('partials._sidebar')
    @else
        <span class="messageLog"></span>
    @endif

@yield('main-container')

</div> {{--Main Container Ends --}}

@include('partials._footer')

<script src="//js.pusher.com/2.2/pusher.min.js"></script>
<script src="{{ elixir('js/all.js') }}"></script>
<!--<script src="/js/snowfall.jquery.min.js"></script>-->
@yield('scripts')
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-85509636-1', 'auto');
    ga('send', 'pageview');

    //$(document).snowfall({flakeCount : 150, maxSpeed : 4, maxSize : 4, round : true});
</script>
</body>
</html>
