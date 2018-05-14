<!DOCTYPE html>
<html lang="es-AR">
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'/>
        <link rel="shortcut icon" href="{{ asset('public/favicon.png') }}" type="image/x-icon">
        <!--<link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>-->
        <style>
            
            body {
                //border: 1px solid red;
                font-family: 'Raleway';
                margin: -30px;
                width: 100%;
                height: 760px;
            }
            .certificado{
                //border: 1px solid black;
                width: 1085px;
                height: 735px;
                position: relative;
            }
            #textoCertificado{
                //border: solid 2px green;
                position: absolute;
                width: 100%;
                top: 170px;
                color: black;
                text-align: center;
                font-size: 18pt;
            }
            p{
                //font-family: "Segoe UI" !Important;
                //font-family: 'Raleway';
                line-height: 12px;
            }
            #cuv{
                position: absolute;
                top: 680px;
                left: 100px;
                font-size: 9pt !important;
                text-align: left;
            }
            #cuvhelp{
                position: absolute;
                top: 700px;
                left: 100px;
                font-size: 9pt !important;
                text-align: left;
            }
            #cuvqr{
                position: absolute;
                top: 650px;                
                text-align: right;
                right: 50px;
                width: 100%;
            }
        </style>
    </head>
<body>
    <?php
        //$rows son los datos de la Oferta, Ej.: $rows->nombre;
        $cap = Session::get('cap');
        $capacRol = RolCapacitador::find($cap->rol_id);
        $capacPersonal = Personal::find($cap->personal_id);
        //guardo en un array todos los meses - sirve para luego buscar el mes actual en string
        $meses = array('01' => 'enero','02' => 'febrero','03' => 'marzo','04' => 'abril',
                '05' => 'mayo','06' => 'junio','07' => 'julio','08' => 'agosto',
                '09' => 'septiembre','10' => 'octubre','11' => 'noviembre','12' => 'diciembre',);
        $mes_actual = array_get($meses, date('m'));
        //código para generar la imagen del código QR se guarda en public/images/qrcodes
        $renderer = new \BaconQrCode\Renderer\Image\Png();
        $renderer->setHeight(256);
        $renderer->setWidth(256);
        $writer = new \BaconQrCode\Writer($renderer);        
        $dir_to_save = "img/qrcodes/";
        if(!is_dir($dir_to_save)){
            mkdir($dir_to_save);
        }
        $filename = "of_".$rows->id; $filename .= "_cap_".$capacPersonal->id; $filename .= ".png";
        $mje = URL::to("/verificar-certificado?cuv=").$cap->codigo_verificacion;
        $writer->writeFile($mje,$dir_to_save.$filename);
        //compruebo los caracteres del apellido y nombre
        $capacPersonal->apellido = HomeController::arreglarCaracteres($capacPersonal->apellido);
        //compruebo si es hombre, mujer o sin espedificar
        $pronombre = "el/la";
        if($capacPersonal->sexo_id == 1){
           $pronombre = "el";
        }elseif($capacPersonal->sexo_id == 2){
           $pronombre = "la";
        }
    ?>  
    
    <div class="certificado">
        <img src="{{ asset($rows->cert_base_cap->url()) }}" alt="Certificado base" style="width: 1085px;height: 760px;"/>
        <div id='textoCertificado'>
            <p>La <b>Universidad del Chubut</b>&nbsp; certifica que</p>
            <?php if($capacPersonal->titulacion_id != 1):?>
                <p>{{$pronombre}}<b style="font-size: 20pt">
                    <?php echo $capacPersonal->getTitulacionPersonalAbreviada().". ";?>
                    <?php echo $capacPersonal->nombre." ".strtoupper($capacPersonal->apellido);?></b></p>
            <?php else:?>
                <p><b style="font-size: 20pt"><?php echo $capacPersonal->nombre." ".strtoupper($capacPersonal->apellido);?></b></p>
            <?php endif;?>
            <?php if(ctype_digit($capacPersonal->dni)):?>
                <p>D.N.I. <?php echo number_format($capacPersonal->dni, 0, ',', '.');?></p>
            <?php else:?>
                <p>D.N.I. <?php echo $capacPersonal->dni;?></p>
            <?php endif;?>
            <!--<p>D.N.I. <?php //echo $capacPersonal->dni?></p>-->
            <p>ha participado en calidad de <?php echo strtolower($capacRol->rol);?>, en el</p>
            @if(strlen($rows->nombre) < 30)
                <p><b style="font-size: 22pt"><?php echo $rows->nombre;?></b></p>
            @elseif(strlen($rows->nombre) < 60)
                <p><b style="font-size: 18pt"><?php echo $rows->nombre;?></b></p>
            @else
                <p><b style="font-size: 14pt"><?php echo $rows->nombre;?></b></p>
            @endif
            <?php $ConHoras = (($rows->duracion_hs != null)&&($rows->duracion_hs != 0));?>
            <?php if(($rows->resolucion_nro != null)&&($ConHoras==true)):?>
                <p>según <?php echo $rows->resolucion_nro;?>, con una acreditación de 
                   <?php echo $rows->duracion_hs;?> horas reloj.</p>
            <?php elseif(($rows->resolucion_nro == null)&&($ConHoras==true)):?>
                <p>con una acreditación de <?php echo $rows->duracion_hs;?> horas reloj.</p>
            <?php elseif(($rows->resolucion_nro != null)&&($ConHoras==false)):?>
                <p>según <?php echo $rows->resolucion_nro;?>.</p>
            <?php endif;?>
            <?php
                $dia = date('d');
                $mes = date('m');
                $anio = date('Y');
                if($rows->fecha_fin_oferta != null){
                    $fecha = explode('/',$rows->fecha_fin_oferta);
                    $dia = $fecha[0];
                    $mes = $fecha[1];
                    $anio = $fecha[2];
                }
            ?>
            <div style="font-size: 16pt">
                <p>Se extiende el presente certificado al <?php echo $dia; ?> de
                    <?php echo array_get($meses, $mes) ?> de {{$anio}}</p>
                <p>en la ciudad de Rawson, Provincia del Chubut.</p>            
            </div>
        </div>
            <p id="cuv">Código Único de Validación (CUV): <b>&nbsp;<?php echo "&nbsp;&nbsp;&nbsp;".$cap->codigo_verificacion ?></b>.</p>
            <p id="cuvhelp">Para verificar el certificado accedé a <?php echo URL::to('http://udc.edu.ar/cuv');?> o escaneá el código QR con tu celular.</p>
            <!--<p id="cuvhelp">Para verificar el certificado accedé a <?php //echo URL::to('/verificar-certificado');?> o escaneá el código QR con tu celular</p>-->
            <div id='cuvqr'><img src="<?php echo $dir_to_save.$filename ?>" alt="Código QR" style="width: 100px;height: 100px;"/></div>
    </div>
</body>
</html>