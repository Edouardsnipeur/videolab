@extends('layouts.backend.app')
@section('title','video')



@push('css')
<!-- JQuery DataTable Css -->
<link href="{{asset('backend/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css')}}" rel="stylesheet">
@endpush

@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">

                <a class="btn btn-primary waves-effect" href="{{route('admin.video.create')}}">
                    <i class="material-icons">file_upload</i>
                    <span>Upoader une Video</span>
                </a>

            </div>
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                video<span class="badge bg-blue">{{$video->count()}}</span>
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nom</th>
                                        <th>Category</th>
                                        <th>Creer le:</th>
                                        <th>Approuver</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nom</th>
                                        <th>Category</th>
                                        <th>Creer le:</th>
                                        <th>Approuver</th>
                                        <th>Action</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    @foreach($video as $k => $v)
                                        <tr>
                                            <td>{{$k+1}}</td>
                                            <td>{{str_limit($v->name,40,'...')}}</td>
                                            <td>{{$v->category->name}}</td>
                                            <td>{{date('d-m-Y',strtotime($v->created_at))}}</td>
                                            <td>
                                                @if($v->approuved==true)
                                                    <span class="badge bg-blue">
                                                        Approuver
                                                    </span>
                                                @else
                                                    <span class="badge bg-pink">
                                                        En entente
                                                    </span>
                                                @endif

                                            </td>
                                            <td class="text-center">
                                                <a class="btn btn-primary" href="{{route('single',$v->id)}}" target="_blank">
                                                    <i class="material-icons">visibility</i>
                                                </a>
                                                <a class="btn btn-primary" href="{{route('admin.video.edit',$v)}}">
                                                    <i class="material-icons">edit</i>
                                                </a>
                                                <button class="btn btn-danger" onclick="deletevideo({{$v->id}})">

                                                    <i class="material-icons">delete</i>
                                                </button>

                                                <form action="{{route('admin.video.destroy',$v)}}" id="form-data-{{$v->id}}" method="post">
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
    function deletevideo(id) {
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
    
</script>
@endpush