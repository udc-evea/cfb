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
            }
            body p *{
                font-family: "Segoe UI" !Important;
                font-size: 16pt;
                color: blue;
            }
            .certificado{
                //border: 1px solid black;
                width: 1085px;
                height: 735px;
                position: relative;
            }
            #nombreAlumno{
                position: absolute;
                top: 180px;
                text-align: center;                
                alignment-adjust: central;
                width: 100%;
                font-size: 20pt;
            }
            #dniAlumno{
                position: absolute;
                top: 230px;
                text-align: center;
                alignment-adjust: central;
                width: 100%;
                font-size: 20pt;
            }
            #nombreOferta{
                position: absolute;
                top: 265px;
                text-align: center;
                alignment-adjust: central;
                width: 100%;
            }
            #resolucion{
                position: absolute;
                top: 335px;
                padding-right: 100px;
                text-align: center;
                width: 100%;
            }
            #cantidadHorasReloj{
                position: absolute;
                top: 335px;
                padding-left: 548px;
                text-align: center;                
                width: 100%;
            }
            #diaHoy{
                position: absolute;
                top: 370px;
                text-align: center;
                width: 100%;
            }
            #mesHoy{
                position: absolute;
                top: 370px;
                padding-left: 430px;
                text-align: center;
                width: 100%;
            }
            #cuv{
                position: absolute;
                top: 650px;
                padding-right: 260px;
                font-size: 10pt !important;
                text-align: center;
                width: 100%;
            }
        </style>
    </head>
<body>
    <?php
        $meses = array(
                '01' => 'Enero',
                '02' => 'Febrero',
                '03' => 'Marzo',
                '04' => 'Abril',
                '05' => 'Mayo',
                '06' => 'Junio',
                '07' => 'Julio',
                '08' => 'Agosto',
                '09' => 'Septiembre',
                '10' => 'Octubre',
                '11' => 'Noviembre',
                '12' => 'Diciembre',
                );
        $aux = array_get($meses, date('m'));
    ?>    
    <div class="certificado">
        <img src="{{ asset($rows->oferta->cert_base_alum->url()) }}" alt="Certificado base" style="width: 1085px;height: 735px;"/>
        <p id="nombreAlumno"><span><?php echo $rows->apellido.", ".$rows->nombre;?></span></p>
        <p id="dniAlumno"><span><?php echo number_format($rows->documento, 0, ',', '.');?></span></p>
        <p id="nombreOferta"><span><?php echo strtoupper($rows->oferta->nombre);?></span></p>
        <p id="resolucion"><span><?php echo $rows->oferta->resolucion_nro;?></span></p>
        <p id="cantidadHorasReloj"><span><?php echo $rows->oferta->duracion_hs;?></span></p>
        <p id="diaHoy"><span><?php echo date('d')?></span></p>
        <p id="mesHoy"><span><?php echo strtoupper($aux) ?></span></p>
        <p id="cuv"><span><?php echo $rows->codigo_verificacion ?></span></p>
    </div>
    
</body>
</html>