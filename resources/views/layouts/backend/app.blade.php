<!DOCTYPE html>
<html>
@include('layouts.backend.partial.head')

<body class="theme-{{session('theme', 'indigo')}}">
@include('layouts.backend.partial.loader')
<!-- Overlay For Sidebars -->
<div class="overlay"></div>
<!-- #END# Overlay For Sidebars -->
@include('layouts.backend.partial.topbar')


@include('layouts.backend.partial.sidebar')
@include('layouts.backend.partial.rightside')



@yield('content')

@include('layouts.backend.partial.footer')
</body>

</html>