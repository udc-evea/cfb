{{ HTML::script('js/cursos.js') }}

<form action="{{ route('cursos.requisitos.store', $curso->id) }}" class="form-horizontal nuevo" data-remote="true" method="post">
    <div class="form-group form-group-sm">
        <label class="control-label col-lg-2 col-sm-4">Nuevo</label>
        <div class="col-sm-4">
            <div class="nuevo input-group">
                <input class="form-control input-sm" name="requisito" id="nuevo_requisito" type="text" placeholder="ingrese" />
                <span class="input-group-btn">
                    <button type="submit" class="accion btn btn-success btn-add btn-sm" data-disable-with="Guardando...">
                        <span class="glyphicon glyphicon-plus"></span>
                    </button>
                </span>
            </div>
        </div>
    </div>
</form>

<div class="form-horizontal">
    <div class="form-group form-group-sm">
        <div class="col-sm-4 col-sm-offset-2 lista-requisitos">
            <ul class="list-unstyled">
                <li class="nuevo hide"></li>
                @foreach($curso->requisitos as $item)
                @include('requisitos.item', array('curso' => $curso, 'req' => $item))
                @endforeach
            </ul>
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
<style type="text/css">
    div.lista-requisitos { margin-top: 10px; }
</style>