<?php set_time_limit(300); ?>
<!DOCTYPE html>
<html lang="es-AR">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <link rel="stylesheet" href="{{ asset('css/main.css') }}" media="all">
    </head>
    <body>
        <?php 
            $caps = Session::get('capacitadores'); 
            echo 'Capacitador: <br>';
            echo 'Personal_ID: '.$caps[0]->personal_id."<br>";
            echo 'Rol_ID: '.$caps[0]->rol_id."<br>";
            echo 'Oferta_ID: '.$caps[0]->oferta_id."<br>";
            echo "#################<br>";
            echo 'Capacitador: <br>';
            echo 'Personal_ID: '.$caps[1]->personal_id."<br>";
            echo 'Rol_ID: '.$caps[1]->rol_id."<br>";
            echo 'Oferta_ID: '.$caps[1]->oferta_id."<br>";
            echo "#################<br>";
            echo 'Oferta: <br>';
            echo 'Nombre_OF: '.$rows[0]->nombre.'<br>';
            echo 'ID_OF: '.$rows[0]->id.'<br>';
        ?>
        @if(count($rows)>0)
        <table class="tablaExcel">
            <tr>
                <th colspan="16">
                    Anotados en Oferta: 
                </th>
            </tr>
            <tr>
                <th>Nro.</th>
                <!--<th>Apellido</th>
                <th>Nombre</th>
                <th>Documento</th>
                <th>Inscripto</th>
                <th>Pres. Req.</th>
                <th>Email</th>
                <th>Email UDC</th>
                <th>Teléfono</th>
                <th>Fecha nac.</th>
                <th>Localidad</th>
                <th>Años resid.</th>
                <th>Nivel estudios</th>
                <th>Título</th>
                <th>Cómo te enteraste</th>
                <th>Comisión Nro.</th>-->
            </tr>
            <?php $i=1;?>
            @foreach($rows as $item)
                <tr>
                    <td>{{ $i }}</td>

                </tr>
                <?php $i++;?>
            @endforeach
        </table>
    @else
        <table class="tablaExcel">
            <tr>
                <th colspan="6">
                    No hay datos para mostrar
                </th>
            </tr>
            <tr>
                <th>Apellido</th>
                <th>Nombre</th>
                <th>Documento</th>
                <th>Fecha nac.</th>
                <th>Localidad</th>
                <th>Email</th>
                <th>Teléfono fijo</th>
                <th>Teléfono celular</th>
            </tr>
            <tr>
                <td>vacio</td>
                <td>vacio</td>
                <td>vacio</td>
                <td>vacio</td>
                <td>vacio</td>
                <td>vacio</td>
                <td>vacio</td>
                <td>vacio</td>
            </tr>
        </table>
    @endif
    </body>
</html>