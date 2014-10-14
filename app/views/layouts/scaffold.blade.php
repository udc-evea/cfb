<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>@yield('title', 'UDC-CFB')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
        <link rel="shortcut icon" href="/favicon.png?v=2">
        <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{asset('font-awesome/css/font-awesome.min.css')}}">
        <link rel="stylesheet" href="{{ asset('jquery-ui-1.11.1.custom/jquery-ui.min.css') }}">
        {{ HTML::style('css/main.css') }}

        <script src="{{ asset('js/modernizr-2.6.2.min.js') }}"></script>
        <script src="{{ asset('js/jquery-2.1.1.min.js') }}"></script>
        <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('bootstrap-extras/bootbox.min.js') }}"></script>
        <script src="{{ asset('jquery-ui-1.11.1.custom/jquery-ui.min.js') }}"></script>

        <script src="{{ asset('js/rails.js') }}"></script>
        {{ HTML::script('js/main.js') }}
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">Estás usando un navegador <strong>obsoleto</strong>. Por favor visita <a href="http://browsehappy.com/">actualiza tu navegador</a> para mejorar su experiencia en el sitio.</p>
        <![endif]-->

        <!-- Add your site or application content here -->
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
                @if (Session::has('message'))
                <div class="flash alert alert-warning">
                    <p><span class="glyphicon glyphicon-warning-sign"></span> {{ Session::get('message') }}</p>
                </div>
                @endif
                
                @yield('main')
            </div>
          </div>
        </div>
    </body>
</html>
