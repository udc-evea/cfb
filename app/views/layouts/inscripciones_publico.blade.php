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

        <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('bootstrap-extras/datepicker/css/datepicker3.css') }}">
        
        <script src="{{ asset('js/modernizr-2.6.2.min.js') }}"></script>
        <script src="{{ asset('js/jquery-2.1.1.min.js') }}"></script>
        <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('bootstrap-extras/bootbox.min.js') }}"></script>
        <script src="{{ asset('bootstrap-extras/datepicker/js/bootstrap-datepicker.js') }}"></script>
        <script src="{{ asset('bootstrap-extras/datepicker/js/locales/bootstrap-datepicker.es.js') }}"></script>
        <script src="{{ asset('js/rails.js') }}"></script>
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
        {{ HTML::script('js/main.js') }}
    </body>
</html>
