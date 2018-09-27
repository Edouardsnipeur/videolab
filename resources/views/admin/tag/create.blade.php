@extends('layouts.backend.app')
@section('title','Creer tag')

@section('content')

   <section class="content">
       <div class="row clearfix">
           <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
               <div class="card">
                   <div class="header">
                       <h2>
                           Ajouter un TAG
                       </h2>
                   </div>
                   <div class="body">
                       <form action="{{isset($tag)?route('admin.tag.update',$tag):route('admin.tag.store')}}"  method="post">
                           {{csrf_field()}}
                           @if(isset($tag))
                               <input type="hidden" name="_method" value="PUT">
                           @endif
                           <div class="form-group form-float">
                               <div class="form-line">
                                   <input type="text" id="name" class="form-control" name="name" value="{{isset($tag->name)?$tag->name:''}}">
                                   <label class="form-label">Nom du Tag</label>
                               </div>
                           </div>
                           <a href="{{route('admin.tag.index')}}" type="button" class="btn btn-danger m-t-15 waves-effect">Retour</a>
                           <button type="submit" class="btn btn-primary m-t-15 waves-effect">Enregistrer</button>
                       </form>
                   </div>
               </div>
           </div>
       </div>
   </section>
@endsection
