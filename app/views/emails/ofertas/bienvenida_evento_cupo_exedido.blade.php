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
     <?php 
        if($oferta->getEsOfertaAttribute()){
         $tipoOferta = "a la Oferta";
        }elseif($oferta->getEsCarreraAttribute()){
           $tipoOferta = "a la Carrera";
        }else{
           $tipoOferta = "al Evento";
        }
     ?>
    <div>
        <h2>¡Preinscripción Exitosa!</h2>
        <p>Gracias por tu interés {{ $insc->nombre }} {{ $insc->apellido }}, has completado la preinscripción <?php echo $tipoOferta ?> <strong>{{ $oferta->nombre }}</strong>.</p>
        <p>Tu solicitud quedará momentáneamente en lista de espera mientras analizamos
            todas las postulaciones. En breve informaremos quiénes participan hasta completar el cupo.</p>
        <br>
        <p>Nos pondremos nuevamente en contacto con vos para confirmar tu inscripción.</p><br>
        <p>Atentamente,</p>
        <p>&nbsp;</p>
        <p>Universidad del Chubut</p>
        <p style="font-size: small"><a href="http://udc.edu.ar" target="_blank"><img src="{{asset('img/UDC-120-37-gray.png')}}" width="60"></a>. © 2015 UDC :: Derechos Reservados.<br>
Lewis Jones 248 (9103) - Rawson, Chubut, Patagonia Argentina.<br>Tel.: (0280) 448-1866 / 448-1846.</p>
      </div>
  </body>
</html>