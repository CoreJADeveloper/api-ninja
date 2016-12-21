<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel - API management</title>

    <!-- Fonts -->
    <link href="{{URL::asset('assets/font-awesome/css/font-awesome.min.css')}}" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link href="{{URL::asset('assets/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/flat-ui/dist/css/flat-ui.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/chosen/css/chosen.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{URL::asset('assets/css/style.css')}}">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    <style>
    </style>
</head>
<body id="app-layout">
<div id="loading-ajax" class="spinner hide" >
    <img id="img-spinner" src="{{URL::asset('assets/images/spinner.gif')}}" alt="Loading"/>
</div>
<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
                API Management
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                @if (Auth::guest())
                    {{--<li><a href="{{ url('/home') }}">Home</a></li>--}}
                @else
                    <li><a href="{{ url('/category') }}">Categories</a></li>
                    <li><a href="{{ url('/parameter') }}">Parameters</a></li>
                    <li><a href="{{ url('/object') }}">Objects</a></li>
                    <li><a href="{{ url('/collection') }}">Collections</a></li>
                    <li><a href="{{ url('/categoriescollection') }}">Categories Collections</a></li>
                @endif
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li><a href="{{ url('/login') }}">Login</a></li>
                    <li><a href="{{ url('/register') }}">Register</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/control-panel') }}"><i class="fa fa-btn fa-home"></i>Control Panel</a></li>
                            <li><a href="{{ url('/settings') }}"><i class="fa fa-btn fa-cog"></i>Settings</a></li>
                            <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>

@yield('content')
@yield('control-panel-content')
@yield('settings-content')
@yield('category')
@yield('parameter')
@yield('object')
@yield('collection')

<!-- JavaScripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="{{URL::asset('assets/chosen/js/chosen.jquery.min.js')}}"></script>
{{--<script href="{{URL::asset('assets/flat-ui/dist/js/flat-ui.min.js')}}"></script>--}}
{{--<script href="{{URL::asset('assets/flat-ui/js/radiocheck.js')}}"></script>--}}
<script src="{{URL::asset('assets/js/script.js')}}"></script>
{{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
</body>
</html>
