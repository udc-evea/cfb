<!DOCTYPE html>
<html lang="es-AR">
    <head>
        <meta charset="iso-8859-1">
    </head>
<body>
<table>
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
        <td>{{ $item->localidad }}</td>
        <td>{{ $item->localidad_anios_residencia }}</td>
        <td>{{ $item->nivel_estudios }}</td>
        <td>{{ $item->titulo_obtenido }}</td>
        <td>{{ $item->email }}</td>
        <td>{{ $item->telefono }}</td>
        <td>{{ $item->rel_como_te_enteraste }}</td>
    </tr>
@endforeach
</table>
</body>