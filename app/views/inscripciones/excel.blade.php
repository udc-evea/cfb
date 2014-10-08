<!DOCTYPE html>
<html lang="es-AR">
    <head>
        <meta charset="utf-8">
    </head>
<body>
<table>
    <tr>
        <th colspan="6">
            Inscriptos al curso: {{$rows[0]->curso->nombre}}
        </th>
    </tr>
    <tr>
        <th>Apellido</th>
        <th>Nombre</th>
        <th>Documento</th>
        <th>Localidad</th>
        <th>Email</th>
        <th>Teléfono</th>


@foreach($rows as $item)
    <tr>
        <td>{{ $item->apellido }}</td>
        <td>{{ $item->nombre }}</td>
        <td>{{ $item->documento }}</td>
        <td>{{ $item->localidad }}</td>
        <td>{{ $item->email }}</td>
        <td>{{ $item->telefono }}</td>
    </tr>
@endforeach
</table>
</body>