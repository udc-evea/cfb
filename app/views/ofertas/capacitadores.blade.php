<?php set_time_limit(300); ?>
<!DOCTYPE html>
<html lang="es-AR">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <link rel="stylesheet" href="{{ asset('css/personales.css') }}" media="all">
    </head>
    <body>
        <?php $caps = Session::get('capacitadores');?>
        @if(count($caps)>0)        
        <table>
            <tr>
                <th colspan='5' id="tituloHoja">Capacitadores de la Oferta: {{ $rows[0]->nombre }}<th>
            </tr>
            <tr id="cabeceraPlanilla">
                <th>Nro.</th>
                <th>Apellido</th>
                <th>Documento</th>
                <th>Email</th>
                <th>Rol en la Oferta</th>
                <!--<th>Inscripto</th>
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
            @foreach($caps as $cap)
                <tr id="filaPlanilla">
                    <td>{{ $i }}</td>
                    <td>{{ $cap['personal']['apellido'] }}, {{ $cap['personal']['nombre'] }}</td>
                    <td>{{ $cap['personal']['dni'] }}</td>
                    <td>{{ $cap['personal']['email'] }}</td>
                    <td>{{ $cap['rol']['rol'] }}</td>
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