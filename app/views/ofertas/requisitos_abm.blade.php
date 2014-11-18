<?php $index_params = $oferta->esCarrera ? ['tab' => 2] : [];?>

{{ HTML::script('js/ofertas.js') }}

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
</div>


<script>
    $(function(){
       OfertasModule.init({{ $oferta->id }}); 
    });
</script>