<!DOCTYPE html>
<html lang="es-AR">
    <head>
        
        <link rel="stylesheet" href="{{ asset('css/main.css') }}" media="all">
    </head>
<body>
@if(count($rows)>0)
    <table class="tablaExcel">
        <tr>
            <th colspan="6">
                Anotados en: {{$rows[0]->oferta->nombre}}
            </th>
        </tr>
        <tr>
            <th>Nro.</th>
            <th>Apellido</th>
            <th>Nombre</th>
            <th>Documento</th>
            <th>Fecha nac.</th>
            <th>Localidad</th>
            <th>Email</th>
            <th>Teléfono fijo</th>
            <th>Teléfono celular</th>
        </tr>
    <?php $i=1;?>
    @foreach($rows as $item)
        <tr>
            <td>{{ $i }}</td>
            <td>{{ $item->apellido }}</td>
            <td>{{ $item->nombre }}</td>
            <td>{{ $item->documento }}</td>
            <td>{{ $item->fecha_nacimiento }}</td>
            <td>{{ $item->localidad->localidad }}</td>
            <td>{{ $item->email }}</td>
            <td>{{ $item->telefono_fijo }}</td>
            <td>{{ $item->telefono_celular }}</td>
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