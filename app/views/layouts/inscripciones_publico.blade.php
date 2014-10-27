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
        @include('layouts.assets')
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">Estás usando un navegador <strong>obsoleto</strong>. Por favor visita <a href="http://browsehappy.com/">actualiza tu navegador</a> para mejorar su experiencia en el sitio.</p>
        <![endif]-->

        <!-- Add your site or application content here -->
        <div class="container">
          <div class="row block">
            <div class="col-md-12">
              <img src="{{ asset('img/LOGO-200x60px.png') }}" width="150"/>
            </div>
          </div>

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
<div class="footer">
      <div class="container">
      <div class="col-md-2"><a href="http://udc.edu.ar" target="_blank"><img src="{{asset('img/UDC-120-37-gray.png')}}"></a></div>
      <div class="col-md-2"><a href="http://www.chubut.gov.ar" target="_blank"><img src="{{asset('http://udc.edu.ar/img/chubut-oficial-125-24-gray.png')}}"></a></div>
      <div class="col-md-8"> <p class="small">Creado por Universidad del Chubut. © 2014 UDC :: Derechos Reservados.<br>
Lewis Jones 248 (9103) - Rawson, Chubut, Patagonia Argentina.</p></div>
      </div>
    </div>
    </body>
</html>
