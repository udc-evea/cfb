<!DOCTYPE html>
<html lang="es-AR">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <style>
            body{
                border: 1px solid red;
                margin: -30px;
                width: 100%;
                height: 760px;
            }
            .certificado{
                border: 1px solid black;
                width: 1085px;
                height: 735px;
                position: relative;
                //display: inline;
            }
            .nombreAlumno{
                padding-left: 500px;
            }
            #nombreAlumno{
                position: absolute;
                top: 250px;
                text-align: center;
                alignment-adjust: central;
                width: 100%;
            }
            #dniAlumno{
                position: absolute;
                top: 290px;
                text-align: center;
                alignment-adjust: central;
                width: 100%;
            }
            #nombreOferta{
                position: absolute;
                top: 323px;
                text-align: center;
                alignment-adjust: central;
                width: 100%;
            }
            #resolucion{
                position: absolute;
                top: 395px;
                padding-right: 100px;
                text-align: center;
                width: 100%;
            }
            #cantidadHorasReloj{
                position: absolute;
                top: 395px;
                padding-left: 548px;
                text-align: center;                
                width: 100%;
            }
            #diaHoy{
                position: absolute;
                top: 430px;
                text-align: center;
                width: 100%;
            }
            #mesHoy{
                position: absolute;
                top: 430px;
                padding-left: 430px;
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
    <!--<div class='row-fluid'>
        <?php 
            //echo $rows->apellido.", ".$rows->nombre."<br>";
            //echo $rows->oferta->cert_base_alum_file_name."<br>";
            //echo $rows->oferta->cert_base_alum->url()."<br>";
        ?>
    </div> -->
    <div class="certificado">
        <img src="{{ asset($rows->oferta->cert_base_alum->url()) }}" alt="Certificado base" style="width: 1085px;height: 735px;"/>
        <h2 id="nombreAlumno"><span><?php echo strtoupper($rows->apellido.", ".$rows->nombre);?></span></h2>
        <h2 id="dniAlumno"><span><?php echo $rows->documento;?></span></h2>
        <h2 id="nombreOferta"><span><?php echo $rows->oferta->nombre;?></span></h2>
        <h2 id="resolucion"><span><?php echo $rows->oferta->resolucion_nro;?></span></h2>
        <h2 id="cantidadHorasReloj"><span><?php echo $rows->oferta->duracion_hs;?></span></h2>
        <h2 id="diaHoy"><span><?php echo date('d')?></span></h2>
        <h2 id="mesHoy"><span><?php echo strtoupper($aux) ?></span></h2>
    </div>
    
</body>
</html>