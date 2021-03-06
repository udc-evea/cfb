<!DOCTYPE html>
<html lang='es-AR'>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'/>        
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
                top: 645px;                
                text-align: right;
                right: 50px;
                width: 100%;
            }
        </style>
    </head>    
<body>
    <?php
        //$oferta = Session::get('oferta');
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
        $filename = "of_".$rows->oferta->id; $filename .= "_insc_".$rows->id; $filename .= ".png";
        $mje = URL::to("/verificar-certificado?cuv=").$rows->codigo_verificacion;
        $writer->writeFile($mje,$dir_to_save.$filename);
        //compruebo los caracteres del apellido y nombre
        $apellidoBien = HomeController::arreglarCaracteres($rows->apellido);
        $imagenFondoCertificado = $rows->oferta->cert_base_alum_file_name;
        if ($rows->oferta->id < 10){
            $idOferta = "00".$rows->oferta->id;
        }elseif($rows->oferta->id < 100){
            $idOferta = "0".$rows->oferta->id;
        }else{
            $idOferta = $rows->oferta->id;
        }
        $urlImagen = public_path(); $urlImagen .= "/system/Oferta/cert_base_alums/000/000/"; $urlImagen .= $idOferta; $urlImagen .= "/original/"; $urlImagen .= $imagenFondoCertificado;
        /* obtengo la cantidad de horas de duración del curso */
        $duracion_hs = number_format($rows->oferta->duracion_hs, 1, ",", ".");
        $hs = (string)number_format($rows->oferta->duracion_hs, 1, ",", ".");
        $s_hs = explode(",",$hs);
        if($s_hs[1] == "0"){
            $duracion_hs = $s_hs[0];
        }        
    ?>    
    <div class="certificado">
        <!--<img src="{{ asset($rows->oferta->cert_base_alum->url()) }}" alt="Certificado base" style="width: 1085px;height: 760px;"/>-->
        <img src="<?php echo $urlImagen ?>" alt="Certificado base aprobados" style="width: 1085px;height: 760px;"/>
        <div id='textoCertificado'>
            <p style="padding-top: -20px">La <b>Universidad del Chubut </b>&nbsp; certifica que</p>
            <!--<img src="<?php //echo $urlImagen ?>" width="150"/>-->
            <?php 
                $nomyape = $rows->nombre." ".strtoupper($apellidoBien);
                $nombreOferta = $rows->oferta->nombre;
            ?>
            <?php if(strlen($nomyape) < 30):?>
                <p style="font-size: 20pt; margin-top: -5px"><b>{{$nomyape.", "}}&nbsp;&nbsp;</b>  &nbsp;D.N.I.
            <?php else:?>
                <p style="font-size: 18pt; margin-top: -5px"><b>{{$nomyape.", "}}&nbsp;&nbsp;</b>  &nbsp;D.N.I.
            <?php endif?>
            <?php if(ctype_digit($rows->documento)):?>
                <?php echo number_format($rows->documento, 0, ',', '.').",";?>                    
                <?php $dni = number_format($rows->documento, 0, ',', '.');?>
            <?php else:?>
                <?php echo $rows->documento.",";?> 
                <?php $dni = $rows->documento;?>
            <?php endif;?> 
                </p>
            <!--<p>cursó y aprobó <p>-->
            <p style="margin-top: -5px">{{ $rows->oferta->condicion_en_certificado }}</p>
            <!-- Nombre de la Oferta/Evento -->
            <?php if(strlen($nombreOferta) < 60){$interlineado="18px";}else{$interlineado="20px";}?>
            <div class="row-fluid" style="padding: -30px 90px 0px 30px; margin-top: -10px">
                <p style="font-size: 20pt; line-height: {{$interlineado}}"><b>{{$nombreOferta}}</b></p>
            </div>
            <?php $fechaInicio = explode('/',$rows->oferta->fecha_inicio_oferta);
                $fechaFin = explode('/',$rows->oferta->fecha_fin_oferta);
                $mismoMes = $fechaInicio[1] == $fechaFin[1];
                $mismoAño = $fechaInicio[2] == $fechaFin[2];
            ?>
            <?php if($rows->oferta->lugar != null):?>
                <?php if (strlen($rows->oferta->lugar)>15):?>
                    <?php if($mismoAño):?>
                        <p style="padding-top: -25px">realizado en {{$rows->oferta->lugar}}<p><p>
                    <?php else:?>
                        <p style="padding-top: -25px; padding-left: -50px">realizado en {{$rows->oferta->lugar}}<p><p>
                    <?php endif;?>
                <?php else:?>
                    <?php if($mismoAño):?>
                        <p style="padding-top: -25px">realizado en {{$rows->oferta->lugar}}
                    <?php else:?>
                        <p style="padding-top: -25px; padding-left: -50px">realizado en {{$rows->oferta->lugar}}
                    <?php endif;?>
                <?php endif;?>
            <?php endif;?>
            <?php if(($rows->oferta->fecha_inicio_oferta != '30/11/-0001')&&($rows->oferta->fecha_fin_oferta != '30/11/-0001')):?>
                <?php if($rows->oferta->lugar == null):?>                    
                    <?php if($mismoAño):?>
                        <p style="padding-top: -24px">realizado
                    <?php else:?>
                        <p style="padding-top: -25px; padding-left: -50px">realizado
                    <?php endif;?>
                <?php endif;?>
                <?php if($rows->oferta->fecha_inicio_oferta == $rows->oferta->fecha_fin_oferta):?>
                    el día {{$fechaInicio[0]}} 
                    de {{array_get($meses,$fechaInicio[1])}} de {{$fechaInicio[2]}}
                <?php elseif(($mismoMes) && ($mismoAño)):?>
                    del {{$fechaInicio[0]}} al 
                    {{$fechaFin[0]}} de {{array_get($meses,$fechaFin[1])}} de {{$fechaFin[2]}}
                <?php elseif($mismoAño):?>
                    del {{$fechaInicio[0]}} de {{array_get($meses,$fechaInicio[1])}} al 
                    {{$fechaFin[0]}} de {{array_get($meses,$fechaFin[1])}} de {{$fechaFin[2]}}
                <?php else:?>
                    del {{$fechaInicio[0]}} de {{array_get($meses, $fechaInicio[1])}} de {{$fechaInicio[2]}} 
                    al {{$fechaFin[0]}} de {{array_get($meses,$fechaFin[1])}} de {{$fechaFin[2]}}
                <?php endif;?>
            <?php endif;?>
            </p>
            <?php $ConHoras = (($rows->oferta->duracion_hs != null)&&($rows->oferta->duracion_hs != 0));?>
            <?php if(($rows->oferta->resolucion_nro != null)&&($ConHoras==true)):?>
                <?php if(strlen($rows->oferta->resolucion_nro) < 50){$interlineado="18px";}else{$interlineado="25px";}?>
                <div class="row-fluid" style="padding: -30px 90px 0px 30px; margin-top: -10px">
                    <p style="font-size: 20pt; line-height: {{$interlineado}}">según <b><?php echo $rows->oferta->resolucion_nro;?></b>,</p>
                    <p> con una acreditación de <?php echo $duracion_hs;?> horas reloj.</p>
                </div>                
            <?php elseif(($rows->oferta->resolucion_nro == null)&&($ConHoras==true)):?>
                <p> con una acreditación de <?php echo $duracion_hs;?> horas reloj.</p>
            <?php elseif(($rows->oferta->resolucion_nro != null)&&($ConHoras==false)):?>
                <?php if(strlen($rows->oferta->resolucion_nro) < 50){$interlineado="18px";}else{$interlineado="25px";}?>
                <div class="row-fluid" style="padding: -30px 90px 0px 30px; margin-top: -10px">
                    <p style="font-size: 20pt; line-height: {{$interlineado}}">según <b><?php echo $rows->oferta->resolucion_nro;?></b>.</p>                   
                </div>
            <?php endif;?>
            <?php
                $dia = date('d');
                $mes = date('m');
                $anio = date('Y');
                if($rows->oferta->fecha_fin_oferta != null){
                    $fecha = explode('/',$rows->oferta->fecha_expedicion_cert);
                    $dia = $fecha[0];
                    $mes = $fecha[1];
                    $anio = $fecha[2];
                }
            ?>
            <div style="font-size: 16pt; padding-top: -25px">
                <p>Se extiende el presente certificado al <?php echo $dia; ?> de
                    <?php echo array_get($meses, $mes) ?> de {{$anio}}</p>
                <p>en la ciudad de Rawson, Provincia del Chubut.</p>
            </div>
        </div>
            <p id="cuv">Código Único de Validación (CUV): <b>&nbsp;<?php echo "&nbsp;&nbsp;&nbsp;".$rows->codigo_verificacion ?></b>.</p>
            <p id="cuvhelp">Para verificar el certificado accedé a <?php echo URL::to('http://udc.edu.ar/cuv');?> o escaneá el código QR con tu celular.</p>
            <!--<p id="cuvhelp">Para verificar el certificado accedé a <?php //echo URL::to('/verificar-certificado');?> o escaneá el código QR con tu celular</p>-->
            <div id='cuvqr'><img src="<?php echo $dir_to_save.$filename ?>" alt="Código QR" style="width: 100px;height: 100px;"/></div>
    </div>
</body>
</html>