@extends('layouts.backend.app')
@section('title','playlist')



@push('css')
<!-- JQuery DataTable Css -->
<link href="{{asset('backend/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css')}}" rel="stylesheet">
@endpush

@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">

                <a class="btn btn-primary waves-effect" href="{{route('admin.playlist.create')}}">
                    <i class="material-icons">add</i>
                    <span>Creer un playlist</span>
                </a>

            </div>
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                playlists<span class="badge bg-blue">{{$playlist->count()}}</span>
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="javascript:void(0);">Action</a></li>
                                        <li><a href="javascript:void(0);">Another action</a></li>
                                        <li><a href="javascript:void(0);">Something else here</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nom</th>
                                        <th>Nombre de video</th>
                                        <th>Creer le:</th>
                                        <th>Modifier le:</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nom</th>
                                        <th>Nombre d'articles</th>
                                        <th>Creer le:</th>
                                        <th>Modifier le:</th>
                                        <th>Action</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    @foreach($playlist as $k => $v)
                                        <tr>
                                            <td>{{$k+1}}</td>
                                            <td>{{$v->name}}</td>
                                            <td>{{$v->videos->count()}}</td>
                                            <td>{{$v->created_at}}</td>
                                            <td>{{$v->updated_at}}</td>
                                            <td class="text-center">
                                                <a class="btn btn-primary" href="{{route('admin.playlist.show',$v)}}">
                                                    <i class="material-icons">menu</i>
                                                </a>
                                                <a class="btn btn-primary" href="{{route('admin.playlist.edit',$v)}}">
                                                    <i class="material-icons">edit</i>
                                                </a>

                                                <button class="btn btn-danger" onclick="deleteplaylist({{$v->id}})">

                                                    <i class="material-icons">delete</i>
                                                </button>

                                                <form action="{{route('admin.playlist.destroy',$v)}}" id="form-data-{{$v->id}}" method="post">
                                                    {{csrf_field()}}
                                                    <input type="hidden" name="_method" value="DELETE">
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Exportable Table -->
        </div>
    </section>



@endsection
@push('js')
<script src="{{asset('backend/plugins/jquery-datatable/jquery.dataTables.js')}}"></script>
<script src="{{asset('backend/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js')}}"></script>
<script src="{{asset('backend/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('backend/plugins/jquery-datatable/extensions/export/buttons.flash.min.js')}}"></script>
<script src="{{asset('backend/plugins/jquery-datatable/extensions/export/jszip.min.js')}}"></script>
<script src="{{asset('backend/plugins/jquery-datatable/extensions/export/pdfmake.min.js')}}"></script>
<script src="{{asset('backend/plugins/jquery-datatable/extensions/export/vfs_fonts.js')}}"></script>
<script src="{{asset('backend/plugins/jquery-datatable/extensions/export/buttons.html5.min.js')}}"></script>
<script src="{{asset('backend/plugins/jquery-datatable/extensions/export/buttons.print.min.js')}}"></script>
<script src="{{asset('backend/js/pages/tables/jquery-datatable.js')}}"></script>
<script src="{{asset('backend/js/sweetalert2.all.js')}}"></script>

<script>
    function deleteplaylist($id) {
        const swalWithBootstrapButtons = swal.mixin({
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false,
        })

        swalWithBootstrapButtons({
            title: 'Etes vous sure?',
            text: "Cette action est irreversible!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Oui, Supprimer le!',
            cancelButtonText: 'Non, Annuler!',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
            event.preventDefault();
            document.getElementById('form-data-'+$id).submit();

        } else if (
            // Read more about handling dismissals
        result.dismiss === swal.DismissReason.cancel
        ) {
            swalWithBootstrapButtons(
                'Cancelled',
                'Your imaginary file is safe :)',
                'error'
            )
        }
    })
    }
    
</script>
@endpush