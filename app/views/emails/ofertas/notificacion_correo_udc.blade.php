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
        <h2>¡Correo Institucional creado!</h2>
        <p>Te queremos notificar que se ha creado tu Correo Institucional de la Universidad del Chubut.</p>
        <p>Los datos son:</p>
        <ul>
            <li>Usuario: {{ $inscripcion->email_institucional }}</li>
            <li>Clave: {{ $inscripcion->documento }}</li>
        </ul>
        <br>
        <p>Atentamente,</p>
        <p>&nbsp;</p>
        <p>Universidad del Chubut</p>
        <p style="font-size: small"><a href="http://udc.edu.ar" target="_blank"><img src="{{asset('img/UDC-120-37-gray.png')}}" width="60"></a>. © 2014 UDC :: Derechos Reservados.<br>
Lewis Jones 248 (9103) - Rawson, Chubut, Patagonia Argentina.</p>
      </body>
</html>