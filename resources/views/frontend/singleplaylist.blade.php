@extends('layouts.frontend.app')

@section('title',$playlists[0]->name)

@section('content')

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <div class="show-top-grids">
        <div class="col-sm-8 single-left">
            <div class="song">
                <div class="video-grid">

                    <div id="jp_container_1" class="jp-video jp-video-360p" role="application" aria-label="media player">
                        <div class="jp-type-playlist">
                            <div id="jquery_jplayer_1" class="jp-jplayer"></div>
                            <div class="jp-gui">
                                <div class="jp-video-play">
                                    <button class="jp-video-play-icon" role="button" tabindex="0">play</button>
                                </div>
                                <div class="jp-interface">
                                    <div class="jp-progress">
                                        <div class="jp-seek-bar">
                                            <div class="jp-play-bar"></div>
                                        </div>
                                    </div>
                                    <div class="jp-current-time" role="timer" aria-label="time">&nbsp;</div>
                                    <div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div>
                                    <div class="jp-details">
                                        <div class="jp-title" aria-label="title">&nbsp;</div>
                                    </div>
                                    <div class="jp-controls-holder">
                                        <div class="jp-volume-controls">
                                            <button class="jp-mute" role="button" tabindex="0">mute</button>
                                            <button class="jp-volume-max" role="button" tabindex="0">max volume</button>
                                            <div class="jp-volume-bar">
                                                <div class="jp-volume-bar-value"></div>
                                            </div>
                                        </div>
                                        <div class="jp-controls">
                                            <button class="jp-previous" role="button" tabindex="0">previous</button>
                                            <button class="jp-play" role="button" tabindex="0">play</button>
                                            <button class="jp-stop" role="button" tabindex="0">stop</button>
                                            <button class="jp-next" role="button" tabindex="0">next</button>
                                        </div>
                                        <div class="jp-toggles">
                                            <button class="jp-repeat" role="button" tabindex="0">repeat</button>
                                            <button class="jp-shuffle" role="button" tabindex="0">shuffle</button>
                                            <button class="jp-full-screen" role="button" tabindex="0">full screen</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="jp-playlist">
                                <ul>
                                    <!-- The method Playlist.displayPlaylist() uses this unordered list -->
                                    <li></li>
                                </ul>
                            </div>
                            <div class="jp-no-solution">
                                <span>Update Required</span>
                                To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="clearfix"> </div>
            <div class="published">
                <!--script src="jquery.min.js"></script-->
                <script>
                    $(document).ready(function () {
                        size_li = $("#myList li").size();
                        x=1;
                        $('#myList li:lt('+x+')').show();
                        $('#loadMore').click(function () {
                            x= (x+1 <= size_li) ? x+1 : size_li;
                            $('#myList li:lt('+x+')').show();
                        });
                        $('#showLess').click(function () {
                            x=(x-1<0) ? 1 : x-1;
                            $('#myList li').not(':lt('+x+')').hide();
                        });
                    });
                </script>
                @if($video)
                    <div class="load_more">
                        <ul id="myList">
                            <li>
                                <h4>Publier le  {{date('d/m/Y',strtotime($video->created_at))}}</h4>
                                <p>{{$video->description}}</p>
                            </li>
                        </ul>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-md-4 single-right">
            <h3>Recommandation</h3>
            <div class="single-grid-right">
                @foreach($videos as $v)
                    <div class="single-right-grids">
                    <div class="col-md-4 single-right-grid-left">
                        <a href="{{route('single',$v)}}"><img src="@if($v->poster=='default.png'){{Storage::disk('public')->url('poster/default.jpg')}}@else{{Storage::disk('public')->url($v->poster)}} @endif" alt="{{$v->name}}"/></a>
                    </div>
                    <div class="col-md-8 single-right-grid-right">
                        <a href="{{route('single',$v)}}" class="title"> {{str_limit($v->name,25)}}</a>
                        <p class="author"><a href="#" class="author">{{$v->user->name}}</a></p>
                        <p class="views">2,114,200 views</p>
                    </div>
                    <div class="clearfix"> </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="clearfix"> </div>
    </div>
</div>
<div class="clearfix"> </div>

@endsection

@push('js')

<link href="{{asset('frontend/skin/pink.flag/css/jplayer.pink.flag.min.css')}}" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{{asset('frontend/js/jquery-1.11.1.min.js')}}"></script>
<script type="text/javascript" src="{{asset('frontend/jplayer/jquery.jplayer.min.js')}}"></script>
<script type="text/javascript" src="{{asset('frontend/dist/add-on/jplayer.playlist.min.js')}}"></script>
<script type="text/javascript">
    //<![CDATA[
    $(document).ready(function(){

            new jPlayerPlaylist({
                jPlayer: "#jquery_jplayer_1",
                cssSelectorAncestor: "#jp_container_1"
            }, [
                @foreach($playlists[0]->videos as $v)
                    @if($v->approuved)
                        {
                            title: "{{str_limit($v->name,600)}}",
                            m4v: "{{Storage::disk('public')->url($v->unique_name)}}"
                        },
                    @endif
                @endforeach
            ], {
            size: {
                width: "100%",
                height: "360px",
                cssClass: "jp-video-360p"
            },
                swfPath: "frontend/jplayer",
                supplied: "webmv, ogv, m4v",
                useStateClassSkin: true,
                autoBlur: false,
                smoothPlayBar: true,
                keyEnabled: true,
                remainingDuration: true,
                toggleDuration: true
            });
    });
    //]]>
</script>
@endpush