<li>
	<a href="#" data-type="text" data-pk="{{ $req->id }}" data-url="{{ route('cursos.requisitos.update', array($curso->id)) }}" data-title="Ingrese requisito">{{ $req->requisito }}</a> 
	<a href="{{ route('cursos.requisitos.destroy', array($curso->id, $req->id)) }}" data-method="delete" data-remote="true" class="btn btn-xs accion_borrar"><span class="glyphicon glyphicon-remove"></span></a>
</li>