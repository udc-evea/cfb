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
        <h2>Estimado {{ $inscripcion->nombre }} {{ $inscripcion->apellido }}, bienvenido a la 
            <strong>Universidad del Chubut</strong>
        </h2>        
        <p>Informamos que se ha creado su Correo Institucional necesario para el 
            ingreso al entorno virtual de enseñanza aprendizaje de la UDC</p>
        <p>Los datos requeridos para el ingreso son:</p>
        <ul>
            <li><strong>Usuario: </strong>{{ $inscripcion->email_institucional }}</li>
            <li><strong>Contraseña: </strong>{{ $inscripcion->documento }}</li>
        </ul>
        <br>
        <p>Compartimos un videotutorial para el ingreso a la cuenta UDC, haga clic 
            <a href="http://udc-cfb.wix.com/tutorial-classroom#!tutoriales/c14i3">aquí</a>
            para verlo, y el reglamento para el uso de correos institucionales, haga clic 
            <a href="https://docs.google.com/document/d/17xRTFxXfgjPw6HzaKDOS_vN1JW5BP43dxhsI_xL9yWI/edit?usp=sharing">aquí</a> para verlo.
        </p>
        <p>Atentamente,</p>
        <p>&nbsp;</p>
        <p>Universidad del Chubut</p>
        <p style="font-size: small"><a href="http://udc.edu.ar" target="_blank"><img src="{{asset('img/UDC-120-37-gray.png')}}" width="60"></a>. © 2015 UDC :: Derechos Reservados.<br>
            Lewis Jones 248 (9103) - Rawson, Chubut, Patagonia Argentina.<br>Tel.: (0280) 448-1866 / 448-1846.</p>
      </body>
</html>