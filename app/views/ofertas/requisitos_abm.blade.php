<?php $index_params = []; ?>
@if($oferta->esCarrera)
<?php $index_params['tab'] = 'carreras'; ?>
@elseif($oferta->esEvento)
<?php $index_params['tab'] = 'eventos'; ?>
@endif

{{ HTML::script('js/ofertas.js') }}
<div class="row">
    <div class="col-sm-8 col-sm-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><strong>Definir nuevo</strong></h3>
            </div>
            <div class="panel-body">
                {{ Former::horizontal_open()
                    ->secure()
                    ->rules(['requisito' => 'required'])
                    ->method('post')
                    ->route('ofertas.requisitos.store', $oferta->id)
                    ->addClass('nuevo')
                    ->data_remote('true')
                }}
                {{ Former::sm_text('requisito')->required()->label('Descripción') }}
                <input type="hidden" name="obligatorio" value="0"/>
                {{ Former::checkbox('obligatorio')->label('Obligatorio')->check()->addClass('checkbox')->style('visibility: visible; margin-left: 3px') }}
                {{ Former::actions(Former::sm_primary_submit('Guardar'))}}
                {{ Former::close() }}
            </div>
        </div>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><strong>Definidos</strong></h3>
            </div>
            <div class="panel-body">
                <ul class="list-unstyled requisitos">
                    <li class="nuevo hide"></li>
                    @foreach($oferta->requisitos as $item)
                        @include('requisitos.item', array('oferta' => $oferta, 'req' => $item))
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
            <a href="{{ route('ofertas.index', $index_params) }}" class="form-control btn btn-link btn-lg">Volver</a>
        </div>
    </div>
</div>

<script>
    $(function(){
    OfertasModule.init({{ $oferta->id }});
    });
</script>