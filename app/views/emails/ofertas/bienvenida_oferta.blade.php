<!DOCTYPE html>
<html lang="es-AR">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <p><small>Si no puede ver el correo, haga click <a href="{{ asset($oferta->mail_bienvenida->url()) }}">aquí</a></small></p>
        <img src="{{ asset($oferta->mail_bienvenida->url()) }}"/>
    </body>
</html>