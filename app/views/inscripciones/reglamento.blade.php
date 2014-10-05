<!-- Modal -->
<div class="modal fade" id="modal_reglamento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Reglamento: {{ $curso->nombre }}</h4>
      </div>
      <div class="modal-body modal-fixed-height">
        {{ nl2br($curso->terminos) }}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<style>
  div.modal-body.modal-fixed-height {
    overflow-y: scroll;
    max-height: 400px;  
  }
</style>