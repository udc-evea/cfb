<!DOCTYPE html>
<html lang="es-AR">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <div class="row">
            <div class="col-md-12">
                <div class="flash alert alert-warning">
                   <p><small>Si no puede ver el correo, haga click <a href="{{ asset($oferta->mail_bienvenida->url()) }}">aquí</a></small></p>
        <img src="{{ asset($oferta->mail_bienvenida->url()) }}"/>
                </div>
                @endif
                
                @yield('main')
            </div>
          </div>    
            
            
        
    </body>
</html>    
            
        
    </body>
</html>