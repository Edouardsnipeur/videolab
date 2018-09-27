<div class="col-sm-3 col-md-2 sidebar">
    <div class="top-navigation">
        <div class="t-menu">MENU</div>
        <div class="t-img">
            <img src="{{asset('frontend/images/lines.png')}}" alt="" />
        </div>
        <div class="clearfix"> </div>
    </div>
    <div class="drop-navigation drop-navigation">
        <ul class="nav nav-sidebar">
            <li class="{{Request::is('/')?'active':''}}">
                <a href="{{route('home')}}" class="home-icon">
                    <span class="glyphicon glyphicon-home" aria-hidden="true">
                    </span>Home
                </a>
            </li>
            @foreach($categories as $category)
                <li class="{{Request::is('category/'.$category->id)?'active':''}}">
                    <a href="{{route('category',$category->id)}}" class="home-icon">
                        <i class="fa {{$category->image}}"></i>
                        {{$category->name}}
                    </a>
                </li>
            @endforeach
            <li class="{{Request::is('/playlist*')?'active':''}}">
                <a href="{{route('playlist')}}" class="home-icon">
                    <i class="fa fa-fast-forward"></i>
                    </span>Playlists
                </a>
            </li>
        </ul>
        <!-- script-for-menu -->
        <script>
            $( ".top-navigation" ).click(function() {
                $( ".drop-navigation" ).slideToggle( 300, function() {
                    // Animation complete.
                });
            });
        </script>
        <div class="side-bottom">
            <div class="copyright">
                <p>Copyright © 2015 My Play. All Rights Reserved | Design by <a href="http://w3layouts.com/">W3layouts</a></p>
            </div>
        </div>
    </div>
</div>