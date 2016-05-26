<?php set_time_limit(300); ?>
<!DOCTYPE html>
<html lang="es-AR">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <link rel="stylesheet" href="{{ asset('css/main.css') }}" media="all">
    </head>
<body>
@if(count($rows)>0)
    <table class="tablaExcel">
        <tr>
            <th colspan="16">
                Anotados en Oferta: {{$rows[0]->oferta->nombre}}
            </th>
        </tr>
        <tr>
            <th>Nro.</th>
            <th>Apellido</th>
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
            <th>Comisión Nro.</th>
        </tr>
    <?php $i=1;?>
    @foreach($rows as $item)
        <tr>
            <td>{{ $i }}</td>
            <td>{{ $item->apellido }}</td>
            <td>{{ $item->nombre }}</td>
            <td>{{ $item->documento }}</td>
            <td>                
                @if($item->getEsInscripto())
                    <p>Si</p>
                @else
                    <p>No</p>
                @endif
            </td>
            <td>                
                @if($item->getRequisitosCompletos())
                    <p>Si</p>
                @else
                    <p>No</p>
                @endif
            </td>
            <td>{{ $item->email }}</td>
            <td>{{ $item->email_institucional }}</td>
            <td>{{ $item->telefono }}</td>
            <td>{{ $item->fecha_nacimiento }}</td>
            <td>{{ $item->localidad->la_localidad }}</td>
            <td>{{ $item->localidad_anios_residencia }}</td>
            <td>{{ $item->nivel_estudios->nivel_estudios }}</td>
            <td>{{ $item->titulo_obtenido }}</td>
            <td>{{ $item->rel_como_te_enteraste }}</td>
            @if($item->getEsInscripto())
                @if($item->getComisionNro() == 0)
                    <td>Sin Comision</td>
                @else
                    <td>Comision nro {{ $item->getComisionNro() }}</td>
                @endif
            @else
                <td>No Corresponde</td>
            @endif
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