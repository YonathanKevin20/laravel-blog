<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{ config('app.name','blog') }}</title>

    <link rel="shorcut icon" href="{{ asset('icon.ico') }}">

    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('css/bootstrap4.min.css') }}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('css/blog-home.css') }}" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="{{ asset('font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    	<div class="container">
    		<a class="navbar-brand" href="{{ route('post.paginate') }}">{{ config('app.name','blog') }}</a>
    		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
    			<span class="navbar-toggler-icon"></span>
    		</button>
    		<div class="collapse navbar-collapse" id="navbarResponsive">
    			<ul class="navbar-nav ml-auto">
    				<li class="nav-item">
    					<a class="nav-link" href="/">Home
    						<span class="sr-only">(current)</span>
    					</a>
    				</li>
                    @guest
    				    <li class="nav-item">
    					   <a class="nav-link" href="{{ route('login') }}">Login</a>
    				    </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link">Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}
                            </form>
                        </li>
                    @endguest
    			</ul>
    		</div>
    	</div>
    </nav>

    <!-- Page Content -->
    <div class="container">
    	<div class="row">
            @yield('content')
    	</div>
    </div>

    <div class="container-fluid" style="padding: 0;">
        @include('layouts._subscribe')
    </div>

    <!-- Footer -->
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white"></p>
        </div>
    </footer>

    <!-- jQuery -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="{{ asset('js/bootstrap4.min.js') }}"></script>
</body>

</html>