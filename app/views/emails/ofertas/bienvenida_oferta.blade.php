<!DOCTYPE html>
<html lang="es-AR">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <div class="row">
            <div class="col-md-12">
              <img src="{{ asset('img/LOGO-200x60px.png') }}" width="150"/>
            </div>
        </div>
        <div class="row">            
             <div class="alert alert-warning">
                <p><small>Si no puede ver el correo, haga click <a href="{{ asset($oferta->mail_bienvenida->url()) }}">aquí</a></small></p>
                <a href="{{ $oferta->url_imagen_mail }}"><img src="{{ asset($oferta->mail_bienvenida->url()) }}"/></a>
             </div>
            <!-- <div class="row">
                <p><?php //echo 'Dir.: '.$oferta->mail_bienvenida->url()?></p>
                <img src="{{ asset($oferta->mail_bienvenida->url()) }}"/>
            </div> -->
        </div>
        <p>Universidad del Chubut</p>
        <p style="font-size: small"><a href="http://udc.edu.ar" target="_blank"><img src="{{asset('img/UDC-120-37-gray.png')}}" width="60"></a>. © 2015 UDC :: Derechos Reservados.<br>
            Lewis Jones 248 (9103) - Rawson, Chubut, Patagonia Argentina.<br>Tel.: (0280) 448-1866 / 448-1846.</p>
    </body>
</html>            