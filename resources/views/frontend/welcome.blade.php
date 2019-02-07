@extends('layouts.frontend.app')
@push('js')

@endpush
@section('content')
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <div class="main-grids">
            <div class="top-grids">
                <div class="recommended-info">
                    <h3>Videos recent</h3>
                </div>
                @foreach($recents as $recent)
                <div class="col-md-4 resent-grid recommended-grid slider-top-grids">
                    <div class="resent-grid-img recommended-grid-img">
                        <a href="{{route('single',$recent)}}"><img src="@if($recent->poster=='default.png'){{Storage::disk('public')->url('poster/default.jpg')}}@else{{Storage::disk('public')->url($recent->poster)}} @endif" alt="{{$recent->name}}" /></a>
                        <div class="time">
                            <p>{{$recent->duration}}</p>
                        </div>
                    </div>
                    <div class="resent-grid-info recommended-grid-info">
                        <h3><a href="{{route('single',$recent)}}" class="title title-info">{{str_limit($recent->name,40)}}</a></h3>
                        <ul>
                            <li><p class="author author-info"><a href="#" class="author">{{$recent->user->name}}</a></p></li>
                            <li class="right-list"><p class="views views-info">2,114,200 views</p></li>
                        </ul>
                    </div>
                </div>
                @endforeach
                <div class="clearfix"> </div>
            </div>

            <div class="recommended">
                <div class="recommended-grids">
                    <div class="recommended-info">
                        <h3>Anime</h3>
                    </div>
                    <div  id="top" class="callbacks_container">
                        <script src="{{asset('frontend/js/responsiveslides.min.js')}}"></script>
                        <script>
                            // You can also use "$(window).load(function() {"
                            $(function () {
                                // Slideshow 4
                                $("#slider3").responsiveSlides({
                                    auto: true,
                                    pager: false,
                                    nav: true,
                                    speed: 500,
                                    namespace: "callbacks",
                                    before: function () {
                                        $('.events').append("<li>before event fired.</li>");
                                    },
                                    after: function () {
                                        $('.events').append("<li>after event fired.</li>");
                                    }
                                });

                            });
                        </script>
                        <ul class="rslides" id="slider3">
                            @foreach($animes->chunk(4) as $chunk)
                            <li>
                                <div class="animated-grids">
                                    @foreach($chunk as $anime)
                                        <div class="col-md-3 resent-grid recommended-grid slider-first">
                                            <div class="resent-grid-img recommended-grid-img">
                                                <a href="{{route('single',$anime)}}"><img src="@if($anime->poster=='default.png'){{Storage::disk('public')->url('poster/default.jpg')}}@else{{Storage::disk('public')->url($anime->poster)}} @endif" alt="{{$anime->name}}" /></a>
                                                <div class="time small-time slider-time">
                                                    <p>{{$anime->duration}}</p>
                                                </div>
                                            </div>
                                            <div class="resent-grid-info recommended-grid-info">
                                                <h5><a href="{{route('single',$anime)}}" class="title">{{str_limit($anime->name,50)}}</a></h5>
                                                <div class="slid-bottom-grids">
                                                    <div class="slid-bottom-grid">
                                                        <p class="author author-info"><a href="#" class="author">{{$anime->user->name}}</a></p>
                                                    </div>
                                                    <div class="slid-bottom-grid slid-bottom-right">
                                                        <p class="views views-info">2,114,200 views</p>
                                                    </div>
                                                    <div class="clearfix"> </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="clearfix"> </div>
                                </div>
                            </li>

                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="recommended">
                <div class="recommended-info">
                    <h3>Recommended</h3>
                </div>
                @foreach($randoms->chunk(4) as $chunk)
                    <div class="recommended-grids">
                        @foreach($chunk as $serie)
                            <div class="col-md-3 resent-grid recommended-grid">
                                <div class="resent-grid-img recommended-grid-img">
                                    <a href="{{route('single',$serie)}}"><img src="@if($serie->poster=='default.png'){{Storage::disk('public')->url('poster/default.jpg')}}@else{{Storage::disk('public')->url($serie->poster)}} @endif" alt="{{$serie->name}}" /></a>
                                    <div class="time small-time">
                                        <p>{{$serie->duration}}</p>
                                    </div>
                                </div>
                                <div class="resent-grid-info recommended-grid-info video-info-grid">
                                    <h5><a href="{{route('single',$recent)}}" class="title">{{str_limit($serie->name,50)}}</a></h5>
                                    <ul>
                                        <li><p class="author author-info"><a href="#" class="author">{{$serie->user->name}}</a></p></li>
                                        <li class="right-list"><p class="views views-info">2,114,200 views</p></li>
                                    </ul>
                                </div>
                            </div>
                        @endforeach
                        <div class="clearfix"> </div>
                    </div>
                @endforeach
            </div>
            <div class="recommended">
                <div class="recommended-info">
                    <h3>Variete</h3>
                </div>
                @foreach($series->chunk(4) as $chunk )
                    <div class="recommended-grids">
                        @foreach($chunk as $serie)
                        <div class="col-md-3 resent-grid recommended-grid">
                            <div class="resent-grid-img recommended-grid-img">
                                <a href="{{route('single',$serie)}}"><img src="@if($serie->poster=='default.png'){{Storage::disk('public')->url('poster/default.jpg')}}@else{{Storage::disk('public')->url($serie->poster)}} @endif" alt="{{$serie->name}}" /></a>
                                <div class="time small-time">
                                    <p>{{$serie->duration}}</p>
                                </div>
                            </div>
                            <div class="resent-grid-info recommended-grid-info video-info-grid">
                                <h5><a href="{{route('single',$recent)}}" class="title">{{str_limit($serie->name,50)}}</a></h5>
                                <ul>
                                    <li><p class="author author-info"><a href="#" class="author">{{$serie->user->name}}</a></p></li>
                                    <li class="right-list"><p class="views views-info">2,114,200 views</p></li>
                                </ul>
                            </div>
                        </div>
                        @endforeach
                        <div class="clearfix"> </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection