
@extends('layouts.frontend.app')
@push('js')
<script>

    // This is my view more button
    $(document).on('click', '#view-more-playlist', function(){

        $('#view-more-playlist').hide();
        $('#load').show();



        $("<div>").load($(this).data("url") + "#playlist", function() {

            $("#playlist").append($(this).find("#playlist").html());
        });

        $(this).parent().remove();

    });

</script>


@endpush
@section('content')


    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <div class="main-grids">
            <div class="recommended-info">
                <div class="heading">
                    <h3>Les Playlists</h3>
                </div>
                <div class="clearfix"> </div>
            </div>
            <div class="recommended" id="playlist">
                @foreach($playlists->chunk(6) as $chunk)

                    <div class="recommended-grids english-grid">
                        @foreach($chunk as $playlist)
                            @if($playlist->videos->count()>0)
                                <div class="col-md-2 resent-grid recommended-grid sports-recommended-grid">
                                    <div class="resent-grid-img recommended-grid-img">
                                        <a href="{{route('playlistsingle',$playlist)}}">
                                            @if($playlist->image=='default.jpg')
                                                <img src="{{Storage::disk('public')->url('poster/default.jpg')}}" alt="" />
                                            @else
                                                <img src="{{Storage::disk('public')->url('playlist/image/'.$playlist->image)}}" alt="" />
                                            @endif
                                        </a>
                                        <div class="time small-time sports-tome">
                                            <p>{{$playlist->videos->count()}} Videos</p>
                                        </div>
                                    </div>
                                    <div class="resent-grid-info recommended-grid-info">
                                        <h5><a href="{{route('playlistsingle',$playlist)}}" class="title">{{str_limit($playlist->name,30)}}</a></h5>
                                        <p class="author"><a href="#" class="author">{{$playlist->user->name}}</a></p>
                                        <p class="views">2,114,200 views</p>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        <div class="clearfix"> </div>
                    </div>
                    @if($loop->last)
                        @if($playlists->hasMorePages() == 1)

                            <div class="text-center">
                                <img src="{{asset('frontend/images/twitter.png')}}" alt="" style="display: none" id="load"/>
                                <button id="view-more-playlist" class="form-control btn btn-primary" data-url="{{$playlists->nextPageUrl()}}">
                                    View More
                                </button>
                            </div>
                        @endif
                    @endif

                @endforeach



            </div>
        </div>
    </div>
@endsection