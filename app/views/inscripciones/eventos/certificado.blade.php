<!DOCTYPE html>
<html lang="es-AR">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <style>
            body {
                //border: 1px solid red;
                margin: -30px;
                width: 100%;
                height: 760px;
                font-family: "Segoe UI" !Important;
            }
            .certificado{
                //border: 1px solid black;
                //font-family: "Segoe UI" !Important;
                width: 1085px;
                height: 735px;
                position: relative;
            }
            #textoCertificado{
                //border: solid 2px green;
                position: absolute;
                width: 100%;
                top: 140px;
                color: black;
                text-align: center;
                //font-family: "Segoe UI" !Important;
                font-size: 16pt;
            }
            #cuv{
                position: absolute;
                top: 680px;
                left: 100px;
                font-size: 10pt !important;
                text-align: left;
            }
            #cuvhelp{
                position: absolute;
                top: 700px;
                left: 100px;
                font-size: 10pt !important;
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
        //guardo en un array todos los meses - sirve para luego buscar el mes actual en string
        $meses = array('01' => 'Enero','02' => 'Febrero','03' => 'Marzo','04' => 'Abril',
                '05' => 'Mayo','06' => 'Junio','07' => 'Julio','08' => 'Agosto',
                '09' => 'Septiembre','10' => 'Octubre','11' => 'Noviembre','12' => 'Diciembre',);
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
        $filename = "ev_".$rows->oferta->id; $filename .= "_insc_".$rows->id; $filename .= ".png";
        $mje = URL::to("/verificar-certificado?cuv=").$rows->codigo_verificacion;        
        $writer->writeFile($mje,$dir_to_save.$filename);
        //compruebo los caracteres del apellido y nombre
        $apellidoBien = HomeController::arreglarCaracteres($rows->apellido);
    ?>    
           
    <div class="certificado">
        <img src="{{ asset($rows->oferta->cert_base_alum->url()) }}" alt="Certificado base" style="width: 1085px;height: 760px;"/>        
        <div id='textoCertificado'>
            <p>La UNIVERSIDAD DEL CHUBUT certifica que</p>
            <p><span><?php echo strtoupper($apellidoBien).", ".$rows->nombre;?></span></p>
            <p>D.N.I. <span><?php echo number_format($rows->documento, 0, ',', '.');?>,</span></p>
            <p>asistió a <span><?php echo $rows->oferta->nombre;?></span></p>
            <br>
            <p>Se extiende el presente certificado a los 
                <span><?php echo date('d')?></span> días del mes de 
                <span><?php echo $mes_actual ?></span> de 2016</p>
            <p>en la ciudad de Rawson, Provincia del Chubut.</p>            
        </div>
            <p id="cuv">Código Único de Verificación (CUV): <span><?php echo $rows->codigo_verificacion ?></span></p>
            <p id="cuvhelp">Para verificar el certificado accedé a <?php echo URL::to('/verificar-certificado');?> o escaneá el código QR con tu celular</p>
            <div id='cuvqr'><img src="<?php echo $dir_to_save.$filename ?>" alt="Código QR" style="width: 100px;height: 100px;"/></div>
    </div>
    
</body>
</html>