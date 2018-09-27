@extends('layouts.backend.app')
@section('title','Uploader video')

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
<script type="text/javascript">

    $(document).ready(function(){
        var progression=$('#progression');
        var progression_percent=$('#progress_percent')
        var submit=$('#submit')
        $('input[type="file"]').change(function(e){

            var fileName = e.target.files[0].name;
            $('#update_id').html(fileName);
            $('#name').val(fileName);
            $('#desc').val(fileName);
            //$('.upload-file').html(progress);
            $('#progress').show();
            $('#upload_video_id').hide();


        });
        $('#cancel').click(function (e) {
            e.preventDefault();
            $('#progress').hide();
            $('#upload_video_id').show();
            $('#form_validation').reset();
            $('#update_id').html('Select files to upload');

        })


        $('#upload_more').click(function (e) {
            e.preventDefault();
            $('#progress').hide();
            $('#upload_success').hide();
            progression.width('0%');
            $('#upload_video_id').show();
            $('#upload_more').hide();
            $('#cancel').show();
            //$('#form_validation').reset();
            $('#update_id').html('Select files to upload');

        })

        $('#form_validatio').on('submit',function (e) {
            e.preventDefault();
            $(this).ajaxSubmit({
               beforeSend:function () {
                    progression.width('0%');
                    progression_percent.html('0%')

                },
                uploadProgress:function (event,position,total,pourcentage) {
                    progression.width(pourcentage+'%');
                    progression_percent.html(pourcentage+'%')
                    //submit.disable();
                },
                //resetForm:true,
                success:function () {
                    $('#upload_success').show();
                    $('#cancel').hide();
                    $('#upload_more').show();
                }
            });
        })

    });

</script>
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
           <div class="alert bg-green alert-dismissible" role="alert" id="upload_success" style="display: none">
               <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               Votre video a bien ete uploader!!! :)
           </div>

       <div class="row clearfix">
           <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
               <div class="card">
                   <div class="header">
                       <h2>
                           Uploader une video
                       </h2>
                   </div>
                   <div class="body">
                       <form action="{{route('user.video.store')}}"  method="post" enctype="multipart/form-data" ID="form_validation">
                           {{csrf_field()}}
                           <div class="form-float">
                               <div class="upload-right">
                                   <div class="upload-file">
                                       <div class="row clearfix" id="progress" style="display: none" >
                                           <div class="col-sm-10" id="progrss_class">
                                               <div class="progress">
                                                   <div class="progress-bar progress-bar-success progress-bar-striped active" id="progression" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                                       <span id="progress_percent" >0% Complete (success)</span>
                                                   </div>
                                               </div>
                                           </div>
                                           <div class="col-sm-2">
                                               <button type="button" class="btn btn-danger  waves-effect  waves-float" id="cancel">
                                                   <i class="material-icons">cancel</i> Annuler
                                               </button>
                                           </div>
                                           <div class="col-sm-2" id="upload_more" style="display: none">
                                               <button type="button" class="btn btn-teal  waves-effect  waves-float" id="cancel">
                                                   <i class="material-icons">more</i> uploader autre
                                               </button>
                                           </div>
                                       </div>
                                       <div id="upload_video_id" class="form-group">
                                           <div class="services-icon" >
                                               <span class="glyphicon glyphicon-open" aria-hidden="true"></span>
                                           </div>
                                           <input name="video" type="file" value="Choose file.." accept="video/*" required>
                                       </div>
                                   </div>
                                   <div class="upload-info">
                                       <h5 id="update_id">Select files to upload</h5>
                                   </div>
                               </div>
                           </div>


                               <div class="form-group form-float">
                                   <div class="form-line">
                                       <input type="text" id="name" class="form-control" name="name" value="{{isset($video->name)?$video->name:''}}" required/>
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
                                                   <option value="{{$v->id}}">{{$v->name}}</option>
                                               @endforeach
                                           </select>
                                       </div>
                                   </div>
                                   <div class="col-md-6">

                                       <div class="form-group demo-tagsinput-area">
                                           <div class="form-line">
                                               <input type="text" name="tag" class="form-control" data-role="tagsinput" placeholder="">
                                               <div class="help-info">Veuillez taper sur enter apres chaque TAG</div>
                                           </div>
                                       </div>

                                   </div>
                               </div>


                               <div class="form-group form-float">
                                   <div class="form-line">
                                       <textarea rows="4" id="desc" name="desc" class="form-control no-resize" placeholder="Veuillez saisir la description..."></textarea>
                                   </div>
                               </div>
                               <a href="{{route('user.video.index')}}" type="button" class="btn btn-danger m-t-15 waves-effect">Retour</a>
                               <button type="submit" id="submit" class="btn btn-primary m-t-15 waves-effect">Upload et Publier</button>
                           </form>



                   </div>
               </div>
           </div>
       </div>
   </section>
@endsection
