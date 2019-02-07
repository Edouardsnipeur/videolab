<section>
    <!-- Left Sidebar -->
    <aside id="leftsidebar" class="sidebar">
        <!-- User Info -->
        <div class="user-info">
            <div class="image">
                <img src="{{asset('backend/images/user.png')}}" width="48" height="48" alt="User" />
            </div>
            <div class="info-container">
                <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{\Illuminate\Support\Facades\Auth::user()->name}}</div>
                <div class="email">{{\Illuminate\Support\Facades\Auth::user()->email}}</div>
                <div class="btn-group user-helper-dropdown">
                    <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                    <ul class="dropdown-menu pull-right">
                        <li><a href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                <i class="material-icons">input</i>Sign Out</a>
                        </li>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </ul>
                </div>
            </div>
        </div>
        <!-- #User Info -->
        <!-- Menu -->
        <div class="menu">
            <ul class="list">
                <li class="header">MAIN NAVIGATION</li>
                @if(\Illuminate\Support\Facades\Auth::user()->role==1)
                    <li class="{{Request::is('admin/dashboard*')?'active':''}}">
                        <a href="{{route('admin.dashboard')}}">
                            <i class="material-icons">dashboard</i>
                            <span>DASHBOARD</span>
                        </a>
                    </li>
                    <li class="{{Request::is('admin/category*')?'active':''}}">
                        <a href="{{route('admin.category.index')}}">
                            <i class="material-icons">group</i>
                            <span>CATEGORIES</span>
                        </a>
                    </li>
                    <li class="{{Request::is('admin/playlist*')?'active':''}}">
                        <a href="{{route('admin.playlist.index')}}">
                            <i class="material-icons">playlist_play</i>
                            <span>PLAYLISTS</span>
                        </a>
                    </li>
                    <li class="{{Request::is('admin/video*')?'active':''}}">
                        <a href="{{route('admin.video.index')}}">
                            <i class="material-icons">video_library</i>
                            <span>VIDEOS</span>
                        </a>
                    </li>
                    <li class="{{Request::is('admin/pending')?'active':''}}">
                        <a href="{{route('admin.pending')}}">
                            <i class="material-icons">library_books</i>
                            <span>NON APPROUVER</span>
                        </a>
                    </li>
                    <li class="{{Request::is('admin/user*')?'active':''}}">
                        <a href="{{route('admin.user.index')}}">
                            <i class="material-icons">playlist_play</i>
                            <span>UTILISATEURS</span>
                        </a>
                    </li>

                @else


                    <li class="{{Request::is('user/dashboard*')?'active':''}}">
                        <a href="{{route('user.dashboard')}}">
                            <i class="material-icons">dashboard</i>
                            <span>DASHBOARD</span>
                        </a>
                    </li>
                    <li class="{{Request::is('user/playlist*')?'active':''}}">
                        <a href="{{route('user.playlist.index')}}">
                            <i class="material-icons">playlist_play</i>
                            <span>PLAYLISTS</span>
                        </a>
                    </li>
                    <li class="{{Request::is('user/video*')?'active':''}}">
                        <a href="{{route('user.video.index')}}">
                            <i class="material-icons">video_library</i>
                            <span>VIDEOS</span>
                        </a>
                    </li>
                @endif
            </ul>

        </div>
        <!-- #Menu -->
        <!-- Footer -->
        <div class="legal">
            <div class="copyright">
                &copy; 2016 - 2017 <a href="javascript:void(0);">VideoLabs</a>.
            </div>
            <div class="version">
                <b>Version: </b> 1.0.5
            </div>
        </div>
        <!-- #Footer -->
    </aside>
    <!-- #END# Left Sidebar -->
</section>
