@extends('layouts.backend.app')
@section('title','Creer tag')
@push('js')
<script src="{{asset('backend/plugins/iconpicker/simple-iconpicker.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.icon_input').iconpicker(".icon_input");
    });

</script>
@endpush

@push('css')

<link href="{{asset('backend/plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
<link href="{{asset('backend/plugins/iconpicker/simple-iconpicker.min.css')}}" rel="stylesheet">


@endpush
@section('content')

    <section class="content">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Ajouter une Categorie
                        </h2>
                    </div>
                    <div class="body">
                        <form action="{{isset($category)?route('admin.category.update',$category):route('admin.category.store')}}"  method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                            @if(isset($category))
                                <input type="hidden" name="_method" value="PUT">
                            @endif
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" id="name" class="form-control" name="name" value="{{isset($category->name)?$category->name:''}}">
                                    <label class="form-label">Nom du Categorie</label>
                                </div>
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text"  class="form-control icon_input" name="image" value="{{isset($category->image)?$category->image:''}}" />
                                </div>
                            </div>
                            <a href="{{route('admin.category.index')}}" type="button" class="btn btn-danger m-t-15 waves-effect">Retour</a>
                            <button type="submit" class="btn btn-primary m-t-15 waves-effect">Enregistrer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
