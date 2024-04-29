<div class="modal fade" id="editarImagenMaquina" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Editar Imagen</h5>
                <a type="button" data-dismiss="modal">
                    <i class="fas fa-times-circle" style="color: #ff0000; font-size: 25px"></i>
                </a>
            </div>
            <div class="modal-body">
                <form id="formActualizarImagen">
                    @csrf
                    <input type="hidden" value="" name="idMaquina" id="idMaquina">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="customFileLang" name="imgMaquina" lang="es">
                        <label class="custom-file-label" for="customFileLang">Seleccionar Imagen</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-danger" onclick="editarImagenMaquina()"><i class="fas fa-save"></i> Guardar</button>
            </div>
        </div>
    </div>
</div>

