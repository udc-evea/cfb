<!DOCTYPE html>
<html lang="es-AR">
    <head>
        <meta charset="utf-8">
    </head>
<body>
@if(count($rows)>0)
    <table class="tablaExcel">
        <tr>
            <th colspan="6">
                Inscriptos en: {{$rows[0]->oferta->nombre}}
            </th>
        </tr>
        <tr>
            <th>Apellido</th>
            <th>Nombre</th>
            <th>Documento</th>
            <th>Fecha nac.</th>
            <th>Localidad</th>
            <th>Años resid.</th>
            <th>Nivel estudios</th>
            <th>Título</th>
            <th>Email</th>
            <th>Teléfono</th>
            <th>Cómo te enteraste</th>


    @foreach($rows as $item)
        <tr>
            <td>{{ $item->apellido }}</td>
            <td>{{ $item->nombre }}</td>
            <td>{{ $item->tipo_documento }}-{{ $item->documento }}</td>
            <td>{{ $item->fecha_nacimiento }}</td>
            <td>{{ $item->localidad->la_localidad }}</td>
            <td>{{ $item->localidad_anios_residencia }}</td>
            <td>{{ $item->nivel_estudios->nivel_estudios }}</td>
            <td>{{ $item->titulo_obtenido }}</td>
            <td>{{ $item->email }}</td>
            <td>{{ $item->telefono }}</td>
            <td>{{ $item->rel_como_te_enteraste }}</td>
        </tr>
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