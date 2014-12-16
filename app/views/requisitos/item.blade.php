<li>
	@if ($req->obligatorio)
	<span><strong>
	@else
	<span class="text-muted">
	@endif
	{{ $req->requisito }}
	@if ($req->obligatorio)
	</strong>
	@endif
	</span>
        <a href="{{ route('ofertas.requisitos.destroy', array($oferta->id, $req->id)) }}" data-method="delete" data-remote="true" class="btn btn-xs accion_borrar"><i class="glyphicon glyphicon-remove"></i></a>
</li>