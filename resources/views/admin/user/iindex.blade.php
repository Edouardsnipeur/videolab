@extends('layouts.backend.app')
@section('title','playlist')



@push('css')
<!-- JQuery DataTable Css -->
<link href="{{asset('backend/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css')}}" rel="stylesheet">
@endpush

@section('content')

    <section class="content">
        <div class="container-fluid">
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Utilisateurs<span class="badge bg-blue">{{$users->count()}}</span>
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nom</th>
                                        <th>Role</th>
                                        <th>Email</th>
                                        <th>Videos</th>
                                        <th>Playlist</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nom</th>
                                        <th>Role</th>
                                        <th>Email</th>
                                        <th>Videos</th>
                                        <th>Playlist</th>
                                        <th>Action</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    @foreach($users as $k => $v)
                                        <tr>
                                            <td>{{$k+1}}</td>
                                            <td>{{str_limit($v->name,40,'...')}}</td>
                                            <td>{{$v->email}}</td>
                                            <td>{{$v->videos->count()}}</td>
                                            <td>{{$v->playlists->count()}}</td>
                                            <td class="text-center">

                                                <button class="btn btn-primary" onclick="setAdmin({{$v->id}})">
                                                    <i class="material-icons">visibility</i>
                                                    <span>Rendre Admin</span>
                                                </button>
                                                <form action="{{route('admin.user.update',$v)}}" id="form-update-{{$v->id}}" method="post">
                                                    {{csrf_field()}}
                                                    <input type="hidden" name="_method" value="PUT">

                                                </form>

                                                @if(\Illuminate\Support\Facades\Auth::user()->superAdmin)
                                                    <button class="btn btn-danger" onclick="deleteuser({{$v->id}})">

                                                        <i class="material-icons">delete</i>
                                                    </button>

                                                    <form action="{{route('admin.user.destroy',$v)}}" id="form-data-{{$v->id}}" method="post">
                                                        {{csrf_field()}}
                                                        <input type="hidden" name="_method" value="DELETE">

                                                    </form>
                                                @endif
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
    function deleteuser(id) {
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
            document.getElementById('form-data-'+id).submit();

        }
    else if (
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

    function setAdmin(id) {
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
            document.getElementById('form-update-'+id).submit();

        }
    else if (
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