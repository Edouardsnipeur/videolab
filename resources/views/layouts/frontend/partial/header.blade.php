<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('/') }}"><h1><img src="{{asset('frontend/images/logo.png')}}" alt="" /></h1></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <div class="top-search">
                <form class="navbar-form navbar-right" action="{{route('search')}}">
                    <input type="text" name="search" class="form-control" placeholder="Search...">
                    <input type="submit" value=""  >
                </form>
            </div>
            <div class="header-top-right">
                @if(\Illuminate\Support\Facades\Auth::check())
                    <div class="signin">
                        <a href="{{route('login')}}" class="play-icon popup-with-zoom-anim" target="_blank">DashBoard</a>
                    </div>
                    <div class="signin">
                        <a href="{{ route('logout') }}" class="play-icon popup-with-zoom-anim"
                           onclick="event.preventDefault();
                          document.getElementById('logout-form').submit();">
                           {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                    <div class="clearfix"> </div>

                @else

                    <div class="signin">
                        <a href="{{route('login')}}" class="play-icon popup-with-zoom-anim">Login</a>
                    </div>
                    <div class="signin">
                        <a href="{{route('register')}}" class="play-icon popup-with-zoom-anim">Sign Up</a>
                    </div>
                    <div class="clearfix"> </div>
                @endif
            </div>
        </div>
        <div class="clearfix"> </div>
    </div>
</nav>