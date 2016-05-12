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
                font-size: 16pt;
                color: blue;
            }
            body p *{
                
                font-size: 16pt;
                color: blue;
            }
            .certificado{
                //border: 1px solid black;
                width: 1085px;
                height: 735px;
                position: relative;
            }
            #nombreCapacitador{
                position: absolute;
                top: 180px;
                text-align: center;                
                alignment-adjust: central;
                width: 100%;
                font-size: 20pt;
            }
            #dniCapacitador{
                position: absolute;
                top: 227px;
                text-align: center;
                alignment-adjust: central;
                width: 100%;
                font-size: 20pt;
            }
            #rolCapacitador{
                position: absolute;
                top: 265px;
                left: 220px;
                text-align: center;
                alignment-adjust: central;
                width: 100%;
            }
            #nombreOferta{
                position: absolute;
                top: 300px;
                text-align: center;
                alignment-adjust: central;
                width: 100%;
            }
            #resolucion{
                position: absolute;
                top: 337px;
                padding-right: 100px;
                text-align: center;
                width: 100%;
                font-size: 16pt;
                color: blue;
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
                top: 372px;
                text-align: center;
                width: 100%;
            }
            #mesHoy{
                position: absolute;
                top: 372px;
                padding-left: 430px;
                text-align: center;
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
        $meses = array(
                '01' => 'Enero','02' => 'Febrero','03' => 'Marzo',
                '04' => 'Abril','05' => 'Mayo','06' => 'Junio',
                '07' => 'Julio','08' => 'Agosto','09' => 'Septiembre',
                '10' => 'Octubre','11' => 'Noviembre','12' => 'Diciembre',
                );
        $aux = array_get($meses, date('m'));
    ?> 
    <div class="certificado">
        <img src="{{ asset($rows->cert_base_cap->url()) }}" alt="Certificado base" style="width: 1085px;height: 735px;"/>
        <p id="nombreCapacitador"><span><?php echo strtoupper($capacPersonal->nombre.", ".$capacPersonal->apellido); ?></span></p>
        <p id="dniCapacitador"><span><?php echo number_format($capacPersonal->dni, 0, ',', '.');?></span></p>
        <p id="rolCapacitador"><span><?php echo strtolower($capacRol->rol);?></span></p>
        <p id="nombreOferta"><span><?php echo strtoupper($rows->nombre);?></span></p>
        <p id="resolucion"><?php echo $rows->resolucion_nro;?></p>
        <p id="cantidadHorasReloj"><?php echo $rows->duracion_hs;?></p>
        <p id="diaHoy"><?php echo date('d')?></p>
        <p id="mesHoy"><?php echo strtoupper($aux) ?></p>
    </div>
    
</body>
</html>