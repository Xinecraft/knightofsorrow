<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Zishan Ansari">
    <title>KnightofSorrow.tk - Swat4 Server and Community</title>
    <!-- Bootstrap Core CSS - Uses Bootswatch Flatly Theme: http://bootswatch.com/flatly/ -->
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('components/tooltipster/css/tooltipster.css') }}" />
    <!-- Custom CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="{{ asset('font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
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

<div class="main container">
@include('partials._sidebar')


@yield('main-container')

</div> {{--Main Container Ends --}}

{!! Html::script('js/jquery.js') !!}
{!! Html::script('js/bootstrap.min.js') !!}
{!! Html::script('components/tooltipster/js/jquery.tooltipster.min.js') !!}
{!! Html::script('js/jquery.infinitescroll.min.js') !!}
{!! Html::script('js/main.js') !!}
{!! Html::script('js/gauge.min.js') !!}
@yield('scripts')
</body>
</html>
