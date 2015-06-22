<!DOCTYPE html>
<html lang="es-AR">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <div class="row">
            <div class="col-md-12">
             <img src="{{ asset('img/LOGO-200x60px.png') }}" width="150"/>
                <div class="flash alert alert-warning">
                   <p><small>Si no puede ver el correo, haga click <a href="{{ asset($oferta->mail_bienvenida->url()) }}">aquí</a></small></p>
                   <a href="{{ $oferta->url_imagen_mail }}"><img src="{{ asset($oferta->mail_bienvenida->url()) }}"/></a>
                </div>
                @yield('main')
            </div>
          </div>                                
    </body>
</html>            