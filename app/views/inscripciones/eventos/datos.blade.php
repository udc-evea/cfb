    <div class="container">
        <br>
        @if (count($preinscripciones))
        <div id="datosPreinscriptos">
            <input class="search" placeholder="Buscar por Nro. o Apellido" id="inputBuscarEvDatosIndex"/>
            <button class="sort" data-sort="nrodatos" >Por Nro.</button>
            <button class="sort" data-sort="apellidodatos" >Por Apellido</button>
                <table class="table table-condensed" style="border-top: 2px black solid; border-bottom: 2px black solid">
                    <thead>
                        <tr>
                            <th>Nro.</th>
                            <th>Apellidos y Nombres</th>
                            <!-- <th>Nombre</th> -->
                            @if($perfil != "Colaborador")
                                <th>Documento</th>
                            @endif
                            <th>Localidad</th>
                            <th>Email Personal</th>
                            @if(!$oferta->estaFinalizada())
                                <th>Acciones</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="list">
                        <?php $i = 1; ?>
                        @foreach ($preinscripciones as $inscripcion)                            
                            <tr>
                                <td class="nrodatos">{{ $i }}</td>
                                <td class="apellidodatos">{{ $inscripcion->apellido }}, {{ $inscripcion->nombre }}</td>
                                <!-- <td>{{ $inscripcion->nombre }}</td> -->
                                @if($perfil != "Colaborador")
                                    <td>{{{ $inscripcion->tipoydoc }}}</td>
                                @endif
                                <td>{{ $inscripcion->localidad->la_localidad }}</td>
                                <td>{{ $inscripcion->email }}</td>
                                @if(!$oferta->estaFinalizada())
                                <td>
                                    {{ link_to_route('ofertas.inscripciones.edit', '', array($oferta->id, $inscripcion->id), array('class' => 'btn btn-xs btn-info glyphicon glyphicon-edit', 'title'=>'Editar datos del inscripto')) }}
                                    <!-- <a href="{{route('ofertas.inscripciones.imprimir', [$oferta->id, $inscripcion->id])}}" class="btn btn-default" title="Imprimir formulario de inscripcion"><i class="fa fa-file-pdf-o"></i></a> -->
                                    @if($perfil == "Administrador")
                                        {{ Form::open(array('class' => 'confirm-delete', 'style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('ofertas.inscripciones.destroy', $oferta->id, $inscripcion->id))) }}
                                            <input id='mjeBorrar' value="¿Está seguro que desea borrar el preinscriptos de esta Oferta?" type="hidden" />
                                            {{ Form::submit('Borrar', array('class' => 'btn btn-xs btn-danger','title'=>'Eliminar Inscripto')) }}
                                        {{ Form::close() }}
                                    @endif
                                </td>
                                @endif
                            </tr>
                            <?php $i++; ?>
                        @endforeach
                    </tbody>
                </table>
        </div>
        @else
            <?php $imperror = Session::get('imperror');?>
            @if($imperror != '')
            <div class="alert alert-danger">
                {{$imperror}}
                <?php Session::remove('imperror') ?>
            </div>
            @else
                <h2>Aún no hay inscriptos en esta oferta.</h2>
                <p><a href="{{ URL::action('ofertas.inscripciones.create', $oferta->id) }}" class="btn-btn-link">Formulario de inscripción</a> | <a href="{{ URL::route('ofertas.index') }}">Lista de ofertas</a></p>
            @endif             
        @endif
        <div id="fondo">
            <a class='btn btn-primary' href="{{ URL::route('ofertas.index') }}" title="Volver al listado de Ofertas" >Volver</a>
        </div>
    </div>


<script>    
    var options = {
      valueNames: [ 'apellidodatos', 'nrodatos' ]
    };
    var datosPreinscriptosList = new List('datosPreinscriptos', options);
</script>