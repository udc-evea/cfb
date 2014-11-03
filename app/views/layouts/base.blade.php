<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>@yield('title', 'UDC-CFB')</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        @include('layouts.assets')
    </head>
    <body>
        <div id="container" class="container">
            <div class="row">
                <div class="col-md-12">
                    @yield('main')
                </div>
            </div>
        </div>
        <div class="footer">
      <div class="container">
      <div class="col-md-2"><a href="http://udc.edu.ar" target="_blank"><img src="{{asset('img/UDC-120-37-gray.png')}}"></a></div>
      <div class="col-md-2"><a href="http://www.chubut.gov.ar" target="_blank"><img src="{{asset('img/chubut-oficial-125-24-gray.png')}}"></a></div>
      <div class="col-md-8"> <p class="small">Creado por Universidad del Chubut. © 2014 UDC :: Derechos Reservados.<br>
Lewis Jones 248 (9103) - Rawson, Chubut, Patagonia Argentina.</p></div>
      </div>
    </div>
    </body>
</html>