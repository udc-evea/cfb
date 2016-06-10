<?php set_time_limit(300); ?>
<!DOCTYPE html>
<html lang="es-AR">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <link rel="stylesheet" href="{{ asset('css/personales.css') }}" media="all">
    </head>
<body>
@if(count($rows)>0)
    <table>
        <tr>
            <th colspan='8' id="tituloHoja">
                {{ Session::get('titulo') }} a la Carrera: {{$rows[0]->oferta->nombre}}
            </th>
        </tr>
        <tr id="cabeceraPlanilla">
            <th>Nro.</th>
            <th>Ape. y Nom.</th>
            <th>Documento</th>
            <th>Fecha nac.</th>
            <th>Localidad</th>
            <th>Emails</th>
            <th>Teléfono fijo</th>
            <th>Teléfono celular</th>
        </tr>
    <?php $i=1;?>
    @foreach($rows as $item)
        <tr id="filaPlanilla">
            <td>{{ $i }}</td>
            <td class='row-fluid'>{{ $item->apellido }}, {{ $item->nombre }}</td>
            <td>{{ $item->documento }}</td>
            <td>{{ $item->fecha_nacimiento }}</td>
            <td>{{ $item->localidad->localidad }}</td>
            <td class='row-fluid'>{{ $item->email }} / {{ $item->email_institucional }}</td>
            <td>{{ $item->telefono_fijo }}</td>
            <td>{{ $item->telefono_celular }}</td>
        </tr>
        <?php $i++;?>
    @endforeach
    </table>
@else
    <table class="tablaExcel">
        <tr>
            <th colspan=8>
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