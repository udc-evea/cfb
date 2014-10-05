{{ HTML::script('js/cursos.js') }}

{{ Former::horizontal_open()
        ->secure()
        ->rules(['requisito' => 'required'])
        ->method('post')
        ->route('cursos.requisitos.store', $curso->id)
        ->addClass('nuevo')
        ->data_remote('true')
}}
{{ Former::sm_text('requisito')->required()->label('Descripción') }}
<input type="hidden" name="obligatorio" value="0"/>
{{ Former::checkbox('obligatorio')->label('Obligatorio')->check()->addClass('checkbox') }}
{{ Former::actions(Former::sm_primary_submit('Guardar'))}}
{{ Former::close() }}

<div class="form-horizontal">
    <div class="form-group form-group-sm">
        <div class="col-sm-4 col-sm-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                   <ul class="list-unstyled requisitos">
                        <li class="nuevo hide"></li>
                        @foreach($curso->requisitos as $item)
                        @include('requisitos.item', array('curso' => $curso, 'req' => $item))
                        @endforeach
                    </ul>
                </div>
            </div> 
        </div>
    </div>
    <hr>
    <div class="form-group form-group-lg">
        <div class="col-sm-6 col-sm-offset-2">
            <div class="input-group">
                <a href="{{ route('cursos.index') }}" class="form-control btn btn-link btn-lg">Volver</a>
            </div>
        </div>
    </div>
</div>


<script>
    $(function(){
       CursosModule.init({{ $curso->id }}); 
    });
</script>