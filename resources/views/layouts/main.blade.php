<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('meta-desc','Swat4 Servers and Community')">
    <meta name="author" content="Zishan Ansari">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>KnightofSorrow.tk - @yield('title','Swat4 Servers & Community')</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ elixir('css/all.css') }}">
    @yield('styles')
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

@include('partials._quickerrors')

<div class="main container">
@include('partials._sidebar')


@yield('main-container')

</div> {{--Main Container Ends --}}

@include('partials._footer')

<script src="//js.pusher.com/2.2/pusher.min.js"></script>
<script src="{{ elixir('js/all.js') }}"></script>
@yield('scripts')
</body>
</html>
