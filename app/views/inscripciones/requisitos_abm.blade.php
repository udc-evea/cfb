<div class="form-horizontal">
    <div class="form-group form-group-sm">
        <div class="col-sm-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <table class="table table-hover table-condensed">
                        <thead>
                            <tr>
                                <th>Requisito</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($requisitos as $requisito)
                            <tr>
                                <td>
                                    @unless($requisito->obligatorio)
                                    <span class="text-muted">{{ $requisito->requisito }}</span>
                                    @else
                                    <strong>{{ $requisito->requisito }}</strong>
                                    @endunless
                                </td>
                                <td class="area_requisito">
                                    @include('requisitos.itempresentado')
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div> 
        </div>
    </div>
    <hr>
    <div class="form-group form-group-lg">
        <div class="col-sm-6">
            <div class="input-group">
                <a href="{{ route('ofertas.index') }}" class="form-control btn btn-link btn-lg">Volver</a>
            </div>
        </div>
    </div>
</div>