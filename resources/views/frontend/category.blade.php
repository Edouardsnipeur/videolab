
@extends('layouts.frontend.app')
@push('js')
<script>

    // This is my view more button
    $(document).on('click', '#view-more-video', function(){

        $('#view-more-video').hide();
        $('#load').show();



        $("<div>").load($(this).data("url") + "#video", function() {

            $("#video").append($(this).find("#video").html());
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
                    <h3>Les dernieres Videos {{$category->name}}</h3>
                </div>
                <div class="clearfix"> </div>
            </div>
            <div class="recommended" id="video">
                @foreach($videos->chunk(6) as $chunk)

                    <div class="recommended-grids english-grid">
                        @foreach($chunk as $video)
                            <div class="col-md-2 resent-grid recommended-grid sports-recommended-grid">
                                <div class="resent-grid-img recommended-grid-img">
                                    <a href="{{route('single',$video)}}"><img src="{{Storage::disk('public')->url('poster/default.jpg')}}" alt="" /></a>
                                    <div class="time small-time sports-tome">
                                        <p>{{$video->duration}}</p>
                                    </div>
                                </div>
                                <div class="resent-grid-info recommended-grid-info">
                                    <h5><a href="{{route('single',$video)}}" class="title">{{str_limit($video->name,30)}}</a></h5>
                                    <p class="author"><a href="#" class="author">{{$video->user->name}}</a></p>
                                    <p class="views">2,114,200 views</p>
                                </div>
                            </div>
                        @endforeach
                        <div class="clearfix"> </div>
                    </div>
                    @if($loop->last)
                        @if($videos->hasMorePages() == 1)

                            <div class="text-center">
                                <img src="{{asset('frontend/images/twitter.png')}}" alt="" style="display: none" id="load"/>
                                <button id="view-more-video" class="form-control btn btn-primary" data-url="{{$videos->nextPageUrl()}}">
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