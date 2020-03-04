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
            <h2>Estimado/a {{ $rows->nombre }} {{ $rows->apellido }},</h2>
        </div>
        <hr>
        <p>La Universidad del Chubut tiene el agrado de hacerle llegar por este medio
            el Certificado correspondiente a la actividad <b>{{ $oferta->nombre }}</b> 
            realizada en nuestra institucion.</p>
        <hr>
        <p>Agradecemos su participación y esperamos contar con su presencia en
            nuevas propuestas.</p>
        <br><br>
        <p>Saludamos atentamente.</p>
        <p>Universidad del Chubut</p>
        <p style="font-size: small"><a href="http://udc.edu.ar" target="_blank"><img src="{{asset('img/UDC-120-37-gray.png')}}" width="60"></a>. © 2015 UDC :: Derechos Reservados.<br>
            Lewis Jones 248 (9103) - Rawson, Chubut, Patagonia Argentina.<br>Tel.: (0280) 448-1866 / 448-1846.</p>
      </body>
</html>