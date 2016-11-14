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
            <h2>Estimado/a {{ $capacPersonal->nombre }} {{ $capacPersonal->apellido }},</h2>
        </div>
        <hr>
        <p>La <b>Universidad del Chubut</b> tiene el agrado de hacerle llegar por este medio <br>
            el Certificado correspondiente al <b>{{ $oferta->nombre }}</b>
            en la cuál has participado como <b>{{ $capacRol->rol }}</b>.</p>
        <hr>
        <p>Esperamos contar nuevamente con tu presencia en nuestra Institución proximamente.</p>
        <br><br>
        <p>Muy Atentamente,</p>
        <p>&nbsp;</p>
        <p>Universidad del Chubut</p>
        <p style="font-size: small"><a href="http://udc.edu.ar" target="_blank"><img src="{{asset('img/UDC-120-37-gray.png')}}" width="60"></a>. © 2015 UDC :: Derechos Reservados.<br>
            Lewis Jones 248 (9103) - Rawson, Chubut, Patagonia Argentina.<br>Tel.: (0280) 448-1866 / 448-1846.</p>
      </body>
</html>