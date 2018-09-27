



<!--A Design by W3layouts
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE HTML>
<html>

<head>
    <title>Authentification</title>
    <!-- Meta-Tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <meta name="keywords" content="Cube login Form a Responsive Web Template, Bootstrap Web Templates, Flat Web Templates, Android Compatible Web Template, Smartphone Compatible Web Template, Free Webdesigns for Nokia, Samsung, LG, Sony Ericsson, Motorola Web Design">
    <script>
        addEventListener("load", function () {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>
    <!-- //Meta-Tags -->
    <!-- Stylesheets -->
    <link href="{{asset('backend/css/style.css')}}" rel='stylesheet' type='text/css' />
    <!--// Stylesheets -->
    <!--fonts-->
    <!-- Title -->
    <link href="//fonts.googleapis.com/css?family=Eczar:400,500,600,700,800" rel="stylesheet">
    <!-- Body -->
    <link href="//fonts.googleapis.com/css?family=Source+Sans+Pro:200,200i,300,300i,400,400i,600,600i,700,700i,900,900i" rel="stylesheet">
    <!--//fonts-->
</head>

<body>
<h1>Page de creation de compte</h1>
<div class="w3ls-login">
    <!-- form starts here -->
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="w3ls-ribbon">
            <div class="ribbon-wrapper">
                <div class="glow">&nbsp;</div>
                <div class="ribbon-front">
                    <h2>Modification</h2>
                </div>
            </div>
        </div>

        <div class="agile-field-txt">
            <label>
                {{ __('E-Mail Address:') }}</label>
            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

            @if ($errors->has('email'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif

        </div>
        <div class="w3ls-login  w3l-sub">
            <input type="submit" value="Envoyer le lien de modification">
        </div>
    </form>
</div>
<!-- //form ends here -->
<!--copyright-->
<div class="copy-wthree">
    <p>© 2018 Cube login Form . All Rights Reserved | Design by
        <a href="http://w3layouts.com/" target="_blank">W3layouts</a>
    </p>
</div>
<!--//copyright-->
</body>

</html>


