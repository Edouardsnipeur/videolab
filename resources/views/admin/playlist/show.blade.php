@extends('layouts.backend.app')
@section('title','Manupuler un playlist')
@push('js')
<script src="{{asset('backend/plugins/jquery-validation/jquery.validate.js')}}"></script>
<script src="{{asset('backend/js/pages/forms/form-validation.js')}}"></script>
<script src="{{asset('backend/plugins/multi-select/js/jquery.multi-select.js')}}"></script>
<script src="{{asset('backend/js/pages/forms/advanced-form-elements.js')}}"></script>

@endpush

@push('css')
<link href="{{asset('backend/plugins/multi-select/css/multi-select.css')}}" rel="stylesheet">
@endpush

@section('content')

   <section class="content">
       <div class="row clearfix">
           <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
               <div class="card">
                   <div class="header">
                       <h2>
                           Administrer un playlist
                       </h2>
                   </div>
                   <div class="body">
                       <form action="{{route('admin.playlist.manage')}}" method="post">
                           {{csrf_field()}}
                           <input type="hidden" name="playlist_id" value="{{$playlist->id}}">
                           <select id="optgroup" class="ms" multiple="multiple" name="video[]">
                               @foreach($videos as $video)
                                   <option value="{{$video->id}}"
                                       @foreach($playlist_videos as $playlist_video)
                                           {{$playlist_video->id == $video->id ? 'selected':''}}
                                       @endforeach >{{str_limit($video->name,50)}}
                                   </option>
                               @endforeach
                           </select>

                           <p>&nbsp;</p>
                           <a href="{{route('admin.playlist.index')}}" type="button" class="btn btn-danger m-t-15 waves-effect">Retour</a>
                           <button type="submit" class="btn btn-primary m-t-15 waves-effect">Enregister</button>
                       </form>
                   </div>
               </div>
           </div>
       </div>
   </section>
@endsection
