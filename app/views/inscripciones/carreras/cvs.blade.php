<!DOCTYPE html>
<html lang="es-AR">
    <head>
        <meta charset="utf-8">
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
        <th>Email</th>
        <th>Teléfono fijo</th>
        <th>Teléfono celular</th>

@foreach($rows as $item)
    <tr>
        <td>{{ $item->apellido }}</td>
        <td>{{ $item->nombre }}</td>
        <td>{{ $item->tipo_documento }}-{{ $item->documento }}</td>
        <td>{{ $item->fecha_nacimiento }}</td>
        <td>{{ $item->localidad->localidad }}</td>
        <td>{{ $item->email }}</td>
        <td>{{ $item->telefono_fijo }}</td>
        <td>{{ $item->telefono_celular }}</td>
    </tr>
@endforeach
</table>
</body>