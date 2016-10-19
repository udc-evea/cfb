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
        <div style="text-align: center">
            <h2>Estimado/a {{ $inscripcion->nombre }} {{ $inscripcion->apellido }}, <br>
                te damos la bienvenida a la Universidad del Chubut</h2>
        </div>
        <hr>
        <p>Informamos que has sido seleccionado entre todos los postulantes para poder
            participar de la Oferta <b>{{ $oferta->nombre }}</b></p>
        <h3>Próximamente recibirás los datos de la cuenta institucional necesaria para dicha Oferta.</h3>
        <br>
        <div>
            <h3>Si ya tienes una cuenta institucional creada, te compartimos los enlaces para que puedas acceder a tus espacios: </h3>
            <ul>
                <li>Acceso a la plataforma educativa <strong>Classroom</strong>: <a href="http://classroom.google.com">http://classroom.google.com</a></li>
                <li>Acceso a tu correo institucional: <a href="http://mail.google.com">http://mail.google.com</a></li>
            </ul>
        </div>    
        <p>
            Hemos preparado un Tutorial para el ingreso a Classroom (utilizado por la UDC
            para algunas de sus especialidades virtuales), que podes consultar 
            <a href="https://docs.google.com/document/d/1Mn1YdRtm-Hy1_jdjEsNZS6TiRMr8Uf7qIWQq6eDa0iQ/edit?usp=sharing">aquí</a>
            (dale click al enlace para ver el Tutorial),<br>
            Además esta disponible el Reglamento para el uso de Correos Institucionales, accesible en
            <a href="https://docs.google.com/document/d/1Rkzno1tJI2fLfJEWvcd-bl3wkGpXz1npktX_QZbFWE0/edit?usp=sharing">este otro enlace</a>.
        </p>
        <p>Muy Atentamente,</p>
        <p>&nbsp;</p>
        <p>Universidad del Chubut</p>
        <p style="font-size: small"><a href="http://udc.edu.ar" target="_blank"><img src="{{asset('img/UDC-120-37-gray.png')}}" width="60"></a>. © 2015 UDC :: Derechos Reservados.<br>
            Lewis Jones 248 (9103) - Rawson, Chubut, Patagonia Argentina.<br>Tel.: (0280) 448-1866 / 448-1846.</p>
      </body>
</html>