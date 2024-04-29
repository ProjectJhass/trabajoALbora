<div class="modal fade" id="modalComentarios" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Agregar Comentarios</h5>
                <a type="button" data-dismiss="modal">
                    <i class="fas fa-times-circle" style="color: #ff0000; font-size: 25px"></i>
                </a>
            </div>
            <div class="modal-body">
                <form id="agregarComaentarios">
                    @csrf
                    <input type="hidden" id="id_maquina" name="id_maquina" value="">
                    <div class="form-group">
                        <label>Agregue el comentario</label>
                        <textarea class="form-control" rows="3" id="comentario" name="comentario" placeholder="escribir ..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">cerrar</button>
                <button type="button" class="btn btn-danger" onclick="guardarComentario()">
                    <i class="fas fa-save"></i> Guardar
                </button>
            </div>
        </div>
    </div>
</div>
