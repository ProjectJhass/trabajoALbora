<div class="modal fade" id="historialCalificado" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Personal evaluado</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="fas fa-times-circle" style="color: #ff0000; font-size: 25px"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="historialPersonalEvaluado">
                    <div class="row">
                        <input type="hidden" id="idDepartamentoHistorial" name="idDepartamento">
                        <div class="col-md-4">
                            <label for="exampleInputEmail1" class="form-label">Ingrese la Fecha:</label>
                            <select id="fecha" name="fecha" required class="form-control ">
                                <option value="<?php echo date('Y'); ?>" selected><?php echo date('Y'); ?></option>
                                <?php
                                for ($i = 2020; $i <= 2099; $i++) {
                                    echo "<option value='$i'>$i</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-4 mt-1 mb-3 text-start pt-1">
                            <button type="button" class="btn btn-danger mt-4" onclick="historialPersonalEvaluado()"><i
                                    class="fas fa-search"></i></button>
                        </div>
                    </div>
                </form>
                <hr>
                <div id="tablaHistorialPersonalEvaluado"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
