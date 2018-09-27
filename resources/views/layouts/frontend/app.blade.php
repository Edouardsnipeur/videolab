<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('layouts.frontend.partial.head')
<body>
@include('layouts.frontend.partial.header')
@include('layouts.frontend.partial.sidebar')



@yield('content')




@include('layouts.frontend.partial.footer')
</body>
</html>