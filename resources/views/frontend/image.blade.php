@extends('layouts.frontend.app')

@section('content')


    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

        <form action="{{route('video.upload')}}"  method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <input type="file"  name="image" value="" />
            <a href="{{route('video.upload')}}" type="button" class="btn btn-danger m-t-15 waves-effect">Retour</a>
            <button type="submit" class="btn btn-primary m-t-15 waves-effect">Enregistrer</button>
        </form>
    </div>

@endsection