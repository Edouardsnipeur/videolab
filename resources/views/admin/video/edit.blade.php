@extends('layouts.backend.app')
@section('title','Modifier video')

@push('css')
<link href="{{asset('backend/css/update.self.css')}}" rel="stylesheet">
<link href="{{asset('backend/plugins/bootstrap-select/css/bootstrap-select.css')}}" rel="stylesheet" />
<link href="{{asset('backend/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css')}}" rel="stylesheet">
<link href="{{asset('backend/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet" />
@endpush

@push('js')
<script src="{{asset('backend/plugins/bootstrap-select/js/bootstrap-select.js')}}"></script>
<script src="{{asset('backend/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js')}}"></script>
<!-- Jquery Validation Plugin Css -->
<script src="{{asset('backend/plugins/jquery-validation/jquery.validate.js')}}"></script>
<script src="{{asset('backend/js/pages/forms/form-validation.js')}}"></script>
<script src="{{asset('backend/plugins/jquery-form/jquery.form.min.js')}}"></script>

@endpush
@section('content')

   <section class="content">
       @if($errors->any())

               <div class="alert alert-warning alert-dismissible" role="alert">
                   <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                   @foreach($errors->all() as $error)
                   <li>{{$error}}</li>
                   @endforeach
               </div>

       @endif

       <div class="row clearfix">
           <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
               <div class="card">
                   <div class="header">
                       <h2>
                           Modifier une video
                       </h2>
                   </div>
                   <div class="body">
                       <form action="{{route('admin.video.update',$video)}}"  method="post" enctype="multipart/form-data" ID="form_validation">
                           {{csrf_field()}}
                           <input type="hidden" name="_method" value="PUT">
                           <div class="form-group form-float">
                               <div class="form-line">
                                   <input type="text" id="name" class="form-control" name="name" value="{{isset($video->name)?$video->name:$old->name}}" required/>
                                   <label class="form-label">Nom du video</label>
                               </div>
                           </div>
                           <div class="row clearfix">
                               <div class="col-md-6">
                                   <div class="form-group form-float">
                                       <p>
                                           <b>Categories</b>
                                       </p>
                                       <select class="form-control show-tick" name="category">
                                           @foreach($category as $v)
                                                <option value="{{$v->id}}" class="{{($v->id==$video->id)?'selected':''}}">{{$v->name}}</option>
                                           @endforeach
                                       </select>
                                   </div>
                               </div>
                               <div class="col-md-6">

                                   <div class="form-group demo-tagsinput-area">
                                       <div class="form-line">
                                           <input type="text" name="tag[]" class="form-control" data-role="tagsinput" placeholder="">
                                           <div class="help-info">Veuillez taper sur enter apres chaque TAG</div>
                                       </div>
                                   </div>

                               </div>
                           </div>


                           <div class="form-group form-float">
                               <div class="form-line">
                                   <textarea rows="4" id="desc" name="desc" value="{{$video->description}}" class="form-control no-resize" placeholder="Veuillez saisir la description..."></textarea>
                               </div>
                           </div>
                           <a href="{{route('admin.video.index')}}" type="button" class="btn btn-danger m-t-15 waves-effect">Retour</a>
                           <button type="submit" class="btn btn-primary m-t-15 waves-effect">Enregister</button>
                       </form>
                   </div>
               </div>
           </div>
       </div>
   </section>
@endsection
