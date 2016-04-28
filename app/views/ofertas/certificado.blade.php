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
            #nombreCapacitador{
                position: absolute;
                top: 250px;
                text-align: center;
                alignment-adjust: central;
                width: 100%;
            }
            #dniCapacitador{
                position: absolute;
                top: 290px;
                text-align: center;
                alignment-adjust: central;
                width: 100%;
            }
            #rolCapacitador{
                position: absolute;
                top: 323px;
                left: 220px;
                text-align: center;
                alignment-adjust: central;
                width: 100%;
            }
            #nombreOferta{
                position: absolute;
                top: 355px;
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
        <h2 id="nombreCapacitador"><span><?php echo strtoupper($capacPersonal->nombre.", ".$capacPersonal->apellido); ?></span></h2>
        <h2 id="dniCapacitador"><span><?php echo $capacPersonal->dni;?></span></h2>
        <h2 id="rolCapacitador"><span><?php echo strtolower($capacRol->rol);?></span></h2>
        <h2 id="nombreOferta"><span><?php echo $rows->nombre;?></span></h2>
        <h2 id="resolucion"><?php echo $rows->resolucion_nro;?></h2>
        <h2 id="cantidadHorasReloj"><?php echo $rows->duracion_hs;?></h2>
        <h2 id="diaHoy"><?php echo date('d')?></h2>
        <h2 id="mesHoy"><?php echo strtoupper($aux) ?></h2>
    </div>
    
</body>
</html>