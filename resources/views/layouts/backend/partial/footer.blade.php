<!-- Jquery Core Js -->
<script src="{{asset('backend/plugins/jquery/jquery.min.js')}}"></script>

<!-- Bootstrap Core Js -->
<script src="{{asset('backend/plugins/bootstrap/js/bootstrap.js')}}"></script>

<!-- Select Plugin Js -->
<script src="{{asset('backend/plugins/bootstrap-select/js/bootstrap-select.js')}}"></script>

<!-- Slimscroll Plugin Js -->
<script src="{{asset('backend/plugins/jquery-slimscroll/jquery.slimscroll.js')}}"></script>

<!-- Waves Effect Plugin Js -->
<script src="{{asset('backend/plugins/node-waves/waves.js')}}"></script>

<!-- Jquery CountTo Plugin Js -->
<script src="{{asset('backend/plugins/jquery-countto/jquery.countTo.js')}}"></script>

@stack('js')

<!-- Custom Js -->
<script src="{{asset('backend/js/admin.js')}}"></script>

<!-- Demo Js -->
<script src="{{asset('backend/js/demo.js')}}"></script>
<script src="{{asset('backend/js/toastr.min.js')}}"></script>

{!! Toastr::message() !!}
<script>
    @if($errors->any())
            @foreach($errors->all() as $error)
        toastr.error('{{$error}}', 'Erreur',{"positionClass":"toast-bottom-right",});
    @endforeach
    @endif
</script>
