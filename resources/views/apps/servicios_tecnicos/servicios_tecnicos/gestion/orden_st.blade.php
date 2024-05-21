@extends('apps.servicios_tecnicos.plantilla.app')
@section('head')
@endsection
@section(!empty($seccion) ? $seccion : 'analytics')
    active
@endsection
@section('body')
    @if ($errors->any())
        <div class="text-center" id="alert-status-carta">
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        </div>
        <script>
            setTimeout(() => {
                document.getElementById('alert-status-carta').hidden = true;
            }, 3000);
        </script>
    @endif
    <div id="div-form-info-ost">
        @php
            echo $form;
        @endphp
    </div>

    <!-- Modal Actualizar información visita/evidencias -->
    <div class="modal fade" id="ModalUpdateVisitaEvidencias" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel4">Actualizar información de visita/evidencias</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form-update-evidencias-visita" autocomplete="off" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6 mb-3" hidden>
                                <label for="">id</label>
                                <input type="text" class="form-control" name="id_ev_ost" id="id_ev_ost">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="">Observaciones</label>
                                <textarea class="form-control" name="observaciones_visita" id="observaciones_visita" cols="30" rows="2"></textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="nameExLarge" class="form-label">Evidencias</label>
                                <input type="file" class="form-control" multiple name="evidencias_visita[]" id="evidencias_visita">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cerrar ventana</button>
                    <button type="button" class="btn btn-danger" onclick="formUpdateEvidenciasOrdenSt()">Actualizar orden de servicio</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Actualizar valoracion fabrica -->
    <div class="modal fade" id="ModalUpdateValoracionFab" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel4">Actualizar valoración por parte de fábrica</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form-update-valoracion-fabrica" autocomplete="off" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6 mb-3" hidden>
                                <label for="">id</label>
                                <input type="text" class="form-control" name="id_ost_fab" id="id_ost_fab">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Concepto</label>
                                <select class="form-control" onchange="updateInputsValoracionFab(this.value)" name="concepto_valoracion"
                                    id="concepto_valoracion">
                                    <option value="">Seleccionar...</option>
                                    <option value="Garantia">Garantía</option>
                                    <option value="Valoracion">Para valoración</option>
                                    <option value="No garantia">No garantía</option>
                                    <option value="No garantia por tiempo">No garantía por tiempo</option>
                                    {{-- <option value="st_interno">Servicio bodega</option> --}}
                                </select>
                            </div>
                            <div class="col-md-6 mb-3" id="input-fab-obs">
                                <label for="">Observaciones</label>
                                <input type="text" class="form-control" name="observaciones_valoracion" id="observaciones_valoracion">
                            </div>
                        </div>
                        <div class="row" id="input-fab-carta" hidden>
                            <div class="divider">
                                <div class="divider-text">Emitir carta de <strong>No garantía</strong></div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="">Diagnóstico del servicio</label>
                                <textarea class="form-control" name="diagnostico_carta_fab" id="diagnostico_carta_fab" cols="30" rows="2"></textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="">Solución del problema</label>
                                <textarea class="form-control" name="solucion_carta_fab" id="solucion_carta_fab" cols="30" rows="2"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cerrar ventana</button>
                    <button type="button" class="btn btn-danger" onclick="formValoracionFabricaSt()">Actualizar orden de servicio</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Agregar comentarios generales -->
    <div class="modal fade" id="ModalActualizarInfoValoracionFab" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel4">Actualizar concepto y valoración de fábrica</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form autocomplete="off" id="form_val_update_ger" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6 mb-3" hidden>
                                <label for="">id</label>
                                <input type="text" class="form-control" name="id_ost_val" id="id_ost_val">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="">Concepto</label>
                                <select class="form-control" name="concepto_valoracion_ger" id="concepto_valoracion_ger">
                                    <option value="">Seleccionar...</option>
                                    <option value="Liberalidad de la empresa">Liberalidad de la empresa</option>
                                    <option value="Valoracion">Para valoración</option>
                                    <option value="Garantia">Garantía</option>
                                </select>
                            </div>
                            <div class="col-md-12 mb-3" id="input-fab-obs">
                                <label for="">Observaciones</label>
                                <textarea class="form-control" name="obs_val_ger" id="obs_val_ger" cols="30" rows="3"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cerrar ventana</button>
                    <button type="button" class="btn btn-danger" onclick="formUpdateInfoConceptoFabrica()">Actualizar orden de servicio</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Agregar comentarios generales -->
    <div class="modal fade" id="ModalAgregarComentariosGenerales" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel4">Agregar comentarios adicionales</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form autocomplete="off" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6 mb-3" hidden>
                                <label for="">id</label>
                                <input type="text" class="form-control" name="id_ost_general" id="id_ost_general">
                            </div>
                            <div class="col-md-12 mb-3" id="input-fab-obs">
                                <label for="">Observaciones</label>
                                <textarea class="form-control" name="observaciones_general" id="observaciones_general" cols="30" rows="2"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cerrar ventana</button>
                    <button type="button" class="btn btn-danger" onclick="addComentariosGenerales()">Agregar comentarios adicionales</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal definir orden de servicio -->
    <div class="modal fade" id="ModalDefinirOrdenDeServicio" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel4">Definir orden de servicio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formDefinirOrdenServicioTecnico" autocomplete="off" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6 mb-3" hidden>
                                <label for="">id</label>
                                <input type="text" class="form-control" name="id_ost_definir" id="id_ost_definir">
                            </div>
                            <div class="col-md-12 mb-3" id="input-fab-obs">
                                <label for="">Observaciones</label>
                                <textarea class="form-control" name="observaciones_definir" id="observaciones_definir" cols="30" rows="2"></textarea>
                            </div>
                            <div class="col-md-12 mb-3" id="input-fab-obs">
                                <label for="">Evidencia de documento firmado por el cliente</label>
                                <input type="file" class="form-control" name="evidencias_doc_definir" id="evidencias_doc_definir">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cerrar ventana</button>
                    <button type="button" class="btn btn-danger" onclick="formDefinirOrdenServicio()">Definir y cerrar orden de servicio</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Actualizar información de recogida-->
    <div class="modal fade" id="ModalUpdateDatosRecogida" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel4">Actualizar datos de recogida</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form-update-data-recogida" autocomplete="off" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6 mb-3" hidden>
                                <label for="">id</label>
                                <input type="text" class="form-control" name="id_st_recogida" id="id_st_recogida">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="">Elementos recogidos</label>
                                <textarea class="form-control" name="elementos_recogidos" id="elementos_recogidos" cols="30" rows="2"></textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="">Observaciones</label>
                                <textarea class="form-control" name="observaciones_recogida" id="observaciones_recogida" cols="30" rows="2"></textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="nameExLarge" class="form-label">Evidencias</label>
                                <input type="file" class="form-control" multiple name="evidencias_recogidas[]" id="evidencias_recogidas">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cerrar ventana</button>
                    <button type="button" class="btn btn-danger" onclick="formUpdateDataRecogidaSt()">Actualizar recogida OST</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Actualizar OST ingreso a taller-->
    <div class="modal fade" id="ModalIngresoTallerOst" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel4">Actualizar orden de servicio ** Taller **</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form-update-ingreso-taller" autocomplete="off" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6 mb-3" id="dataEnvioTercerosSt" hidden>
                                <input class="form-check-input" type="checkbox" value="tercero" name="send_terceros" id="send_terceros" />
                                <label class="form-check-label" for="send_terceros">Envío de mercancía a terceros</label>
                            </div>
                            <div class="col-md-6 mb-3" hidden>
                                <label for="">id</label>
                                <input type="text" class="form-control" name="id_st_taller" id="id_st_taller">
                            </div>
                            <div class="col-md-6 mb-3" hidden>
                                <label for="">accion</label>
                                <input type="text" class="form-control" name="accion_taller" id="accion_taller">
                            </div>
                            <div class="col-md-4 mb-3" id="orden_taller_id">
                                <label for="">id orden taller <small>(solo si la orden de taller es manual)</small></label>
                                <input type="text" class="form-control" name="id_orden_taller" id="id_orden_taller">
                            </div>
                            <div class="col-md-12 mb-3" id="div_concepto_valoracion_hs" hidden>
                                <label for="">Concepto</label>
                                <select class="form-control" name="concepto_valoracion_hs" id="concepto_valoracion_hs">
                                    <option value="" selected>Seleccionar...</option>
                                    <option value="Cobrable">Cobrable</option>
                                    <option value="Garantia">Garantía</option>
                                    <option value="No garantia">No garantía</option>
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="">Observaciones</label>
                                <textarea class="form-control" name="estado_articulo" id="estado_articulo" cols="30" rows="2"></textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="nameExLarge" class="form-label">Evidencias</label>
                                <input type="file" class="form-control" multiple name="evidencias_ingreso_taller[]" id="evidencias_ingreso_taller">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cerrar ventana</button>
                    <button type="button" class="btn btn-danger" onclick="formUpdateIngresoTallerSt()">Actualizar OST ** Taller **</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Agregar seguimiento de taller-->
    <div class="modal fade" id="ModalSeguimientoReparacionTaller" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel4">Registrar seguimiento de taller</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form-add-seguimiento-en-taller" autocomplete="off" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6 mb-3" hidden>
                                <label for="">id</label>
                                <input type="text" class="form-control" name="id_st_reparacion" id="id_st_reparacion">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="">Seguimiento en taller</label>
                                <textarea class="form-control" name="obs_seguimiento_t" id="obs_seguimiento_t" cols="30" rows="2"></textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="nameExLarge" class="form-label">Evidencias <small>(opcional)</small></label>
                                <input type="file" class="form-control" multiple name="evidencias_seguimiento_t[]" id="evidencias_seguimiento_t">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cerrar ventana</button>
                    <button type="button" class="btn btn-danger" onclick="formAddSeguimientoTaller()">Agregar seguimiento de taller</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Respuesta a OST reparado -->
    <div class="modal fade" id="ModalEmitirCartaStReparado" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel4">Emitir respuesta a OST reparado </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form-emitir-carta-solucion" autocomplete="off" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6 mb-3" hidden>
                                <label for="">id</label>
                                <input type="text" class="form-control" name="id_ost_carta" id="id_ost_carta">
                            </div>
                            <div class="col-md-12 mb-3" id="info_concepto_carta" hidden>
                                <label for="">Concepto</label>
                                <select class="form-control" name="concepto_carta" id="concepto_carta">
                                    <option value="">Seleccionar...</option>
                                    <option value="Garantia">Garantía</option>
                                    <option value="Liberalidad de la empresa">Liberalidad de la empresa</option>
                                    <option value="No garantia">No garantía</option>
                                    <option value="Cobrable">Cobrable</option>

                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="">Diagnóstico del servicio</label>
                                <textarea class="form-control" name="diagnostico_carta" id="diagnostico_carta" cols="30" rows="2"></textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="">Solución del problema</label>
                                <textarea class="form-control" name="solucion_carta" id="solucion_carta" cols="30" rows="2"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cerrar ventana</button>
                    <button type="button" class="btn btn-danger" onclick="formEmitirCartaRespuesta()">Emitir carta a la orden de servicio</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script>
        consultarInformacionEvidencias = (seccion, id_st, estado) => {
            if (id_st.length > 0) {
                var data = $.ajax({
                    url: "{{ route('evidencias.ost') }}",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        seccion,
                        id_st,
                        estado
                    },
                })
                data.done((res) => {
                    if (estado != 'definido') {
                        if (res.evidencias.includes('<p>') && seccion == 'visita') {
                            document.getElementById('update' + id_st).hidden = false;
                        } else {
                            document.getElementById('update' + id_st).hidden = true;
                        }
                    }
                    document.getElementById("img-evidencias-ost").innerHTML = res.evidencias
                })
                data.fail(() => {
                    document.getElementById("img-evidencias-ost").innerHTML = "<p>Error interno, vuelve a intentar</p>";
                })
            }
        }

        EliminarInfoEvidenciaOst = (seccion, id, id_st) => {
            if (id.length > 0) {
                var data = $.ajax({
                    url: "{{ route('delete.evidencia') }}",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        seccion,
                        id
                    },
                })
                data.done((res) => {
                    notificacion("Bien, Archivo eliminado", "success", 2000);
                    if (res.evidencias.includes('<p>') && seccion == 'visita') {
                        document.getElementById('update' + id_st).hidden = false;
                    } else {
                        document.getElementById('update' + id_st).hidden = true;
                    }
                    document.getElementById("img-evidencias-ost").innerHTML = res.evidencias
                })
                data.fail(() => {
                    notificacion("¡UPS! Hubo un error interno, vuelve a intentarlo", "error", 5000);
                })
            }
        }

        updateOrdenStVisitaEvidencias = (id_st) => {
            $('#ModalUpdateVisitaEvidencias').modal('show')
            $('#id_ev_ost').val(id_st)
        }

        formUpdateEvidenciasOrdenSt = () => {
            notificacion("Actualizando información de visita...", "info", 10000);
            var formulario = new FormData(document.getElementById('form-update-evidencias-visita'));
            formulario.append('valor', 'valor');
            var datos = $.ajax({
                url: "{{ route('update.evidencia.visita') }}",
                type: "post",
                dataType: "json",
                data: formulario,
                cache: false,
                contentType: false,
                processData: false
            });
            datos.done((res) => {
                notificacion("La orden de servicio ha sido actualizada", "success", 3000);
                document.getElementById('form-update-evidencias-visita').reset()
                document.getElementById('div-form-info-ost').innerHTML = res.form
            })
            datos.fail(() => {
                notificacion("ERROR! Completa todos los campos y vuelve a intentar", "error", 3000);
            })
        }

        modalAddComentariosAdicionales = (id_ost) => {
            $('#ModalAgregarComentariosGenerales').modal('show')
            $('#id_ost_general').val(id_ost)
        }

        addComentariosGenerales = () => {
            var id_ost = $('#id_ost_general').val()
            var comentario = $('#observaciones_general').val()

            if (id_ost.length > 0) {
                var data = $.ajax({
                    url: "{{ route('add.comment.general') }}",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        id_ost,
                        comentario
                    },
                })
                data.done((res) => {
                    notificacion("Comentario agregado exitosamente", "success", 2000);
                    $('#observaciones_general').val('')
                    document.getElementById('input-fab-carta').hidden = true
                    document.getElementById('div-form-info-ost').innerHTML = res.form
                })
                data.fail(() => {
                    notificacion("¡UPS! Hubo un error interno, vuelve a intentarlo", "error", 5000);
                })
            }
        }

        modalValoracionFabrica = (id_st) => {
            $('#ModalUpdateValoracionFab').modal('show')
            $('#id_ost_fab').val(id_st)
        }

        updateInputsValoracionFab = (valor) => {
            if (valor.includes('No garantia')) {
                document.getElementById('input-fab-carta').hidden = false
                document.getElementById('input-fab-obs').hidden = true
            } else {
                document.getElementById('input-fab-carta').hidden = true
                document.getElementById('input-fab-obs').hidden = false
            }
        }

        formValoracionFabricaSt = () => {
            notificacion("Actualizando valoración a la orden de servicio...", "info", 10000);
            var formulario = new FormData(document.getElementById('form-update-valoracion-fabrica'));
            formulario.append('valor', 'valor');
            var datos = $.ajax({
                url: "{{ route('add.valoracion.fabrica') }}",
                type: "post",
                dataType: "json",
                data: formulario,
                cache: false,
                contentType: false,
                processData: false
            });
            datos.done((res) => {
                notificacion("La orden de servicio ha sido actualizada exitosamente", "success", 3000);
                document.getElementById('form-update-valoracion-fabrica').reset()
                document.getElementById('div-form-info-ost').innerHTML = res.form
            })
            datos.fail(() => {
                notificacion("ERROR! Revisa los campos vacios y vuelve a intentarlo", "error", 5000);
            })
        }

        modalDefinirOrdenServicio = (id_st) => {
            $('#ModalDefinirOrdenDeServicio').modal('show')
            $('#id_ost_definir').val(id_st)
        }

        formDefinirOrdenServicio = () => {
            notificacion("Definiendo orden de servicio...", "info", 10000);
            var formulario = new FormData(document.getElementById('formDefinirOrdenServicioTecnico'));
            formulario.append('valor', 'valor');
            var datos = $.ajax({
                url: "{{ route('definir.ost') }}",
                type: "post",
                dataType: "json",
                data: formulario,
                cache: false,
                contentType: false,
                processData: false
            });
            datos.done((res) => {
                notificacion("La orden de servicio ha sido actualizada exitosamente", "success", 3000);
                document.getElementById('formDefinirOrdenServicioTecnico').reset()
                document.getElementById('div-form-info-ost').innerHTML = res.form
            })
            datos.fail(() => {
                notificacion("ERROR! Revisa los campos vacios y vuelve a intentarlo", "error", 5000);
            })
        }

        formUpdateDefinirOrdenServicio = () => {
            notificacion("Cargando documento a orden de servicio...", "info", 10000);
            var formulario = new FormData(document.getElementById('form-update-definir-ost'));
            formulario.append('valor', 'valor');
            var datos = $.ajax({
                url: "{{ route('update.definir.ost') }}",
                type: "post",
                dataType: "json",
                data: formulario,
                cache: false,
                contentType: false,
                processData: false
            });
            datos.done((res) => {
                notificacion("La orden de servicio ha sido actualizada exitosamente", "success", 3000);
                document.getElementById('div-form-info-ost').innerHTML = res.form
            })
            datos.fail(() => {
                notificacion("ERROR! Revisa los campos vacios y vuelve a intentarlo", "error", 5000);
            })
        }

        cargarInfoEvidenciasOstN = () => {
            notificacion("Agregando información de evidencias", "info", 10000);
            var formulario = new FormData(document.getElementById('form-new-evidencias-ost'));
            formulario.append('valor', 'valor');
            var datos = $.ajax({
                url: "{{ route('add.evid.adic') }}",
                type: "post",
                dataType: "json",
                data: formulario,
                cache: false,
                contentType: false,
                processData: false
            });
            datos.done((res) => {
                notificacion("Evidencias cargadas exitosamente", "success", 3000);
                document.getElementById('img-evidencias-ost').innerHTML = res.evidencias
            })
            datos.fail(() => {
                notificacion("ERROR! Revisa los campos y vuelve a intentarlo", "error", 5000);
            })
        }

        modalUpdateValoracionGerOst = (id_st) => {
            $('#ModalActualizarInfoValoracionFab').modal('show')
            $('#id_ost_val').val(id_st)
        }

        formUpdateInfoConceptoFabrica = () => {
            notificacion("Actualizando concepto y valoración...", "info", 10000);
            var formulario = new FormData(document.getElementById('form_val_update_ger'));
            formulario.append('valor', 'valor');
            var datos = $.ajax({
                url: "{{ route('update.concepto.fab') }}",
                type: "post",
                dataType: "json",
                data: formulario,
                cache: false,
                contentType: false,
                processData: false
            });
            datos.done((res) => {
                notificacion("Concepto y valoración actualizado", "success", 3000);
                document.getElementById('form_val_update_ger').reset()
                document.getElementById('div-form-info-ost').innerHTML = res.form
            })
            datos.fail(() => {
                notificacion("ERROR! Revisa los campos vacios y vuelve a intentarlo", "error", 5000);
            })
        }

        modalUpdateDataRecogida = (id_st) => {
            $('#ModalUpdateDatosRecogida').modal('show')
            $('#id_st_recogida').val(id_st)
        }

        formUpdateDataRecogidaSt = () => {
            notificacion("Actualizando información de recogida", "info", 10000);
            var formulario = new FormData(document.getElementById('form-update-data-recogida'));
            formulario.append('valor', 'valor');
            var datos = $.ajax({
                url: "{{ route('update.recogida.item') }}",
                type: "post",
                dataType: "json",
                data: formulario,
                cache: false,
                contentType: false,
                processData: false
            });
            datos.done((res) => {
                notificacion("Información de recogida actualizado satisfactoriamente", "success", 3000);
                document.getElementById('form-update-data-recogida').reset()
                document.getElementById('div-form-info-ost').innerHTML = res.form
            })
            datos.fail(() => {
                notificacion("ERROR! Revisa los campos y vuelve a intentarlo", "error", 5000);
            })
        }

        modalIngresarOstTaller = (id_st, accion, articulo, almacen) => {
            var $ordenTallerElement = $('#orden_taller_id');
            var articulo_ = articulo.toLowerCase();
            var mostrarOrdenTaller = articulo_.includes("colchon") || articulo_.includes("protec") || articulo_.includes("almoha");

            if (accion == '1-ingreso') {
                $ordenTallerElement.prop('hidden', !mostrarOrdenTaller);
                document.getElementById('dataEnvioTercerosSt').hidden = false;

                if (almacen == "HAPPYSLEEP") {
                    document.getElementById("div_concepto_valoracion_hs").hidden = false;
                } else {
                    document.getElementById("div_concepto_valoracion_hs").hidden = true;
                }

            } else {
                document.getElementById("div_concepto_valoracion_hs").hidden = true;
                $ordenTallerElement.prop('hidden', true);
                document.getElementById('dataEnvioTercerosSt').hidden = true;
            }

            $('#ModalIngresoTallerOst').modal('show');
            $('#id_st_taller').val(id_st);
            $('#accion_taller').val(accion);
        };

        formUpdateIngresoTallerSt = () => {
            notificacion("Actualizando información de taller", "info", 10000);
            var formulario = new FormData(document.getElementById('form-update-ingreso-taller'));
            formulario.append('valor', 'valor');
            var datos = $.ajax({
                url: "{{ route('update.ingreso.taller') }}",
                type: "post",
                dataType: "json",
                data: formulario,
                cache: false,
                contentType: false,
                processData: false
            });
            datos.done((res) => {
                if (res.status == true) {
                    notificacion("Ingreso a taller actualizado satisfactoriamente", "success", 3000);
                    document.getElementById('form-update-ingreso-taller').reset()
                    document.getElementById('div-form-info-ost').innerHTML = res.form
                } else {
                    notificacion("ERROR! " + res.error, "error", 8000);
                }
            })
            datos.fail(() => {
                notificacion("ERROR! Revisa los campos y vuelve a intentarlo", "error", 5000);
            })
        }

        modalSeguimientoReparacionSt = (id_st) => {
            $('#ModalSeguimientoReparacionTaller').modal('show')
            $('#id_st_reparacion').val(id_st)
        }

        formAddSeguimientoTaller = () => {
            notificacion("Agregando seguimiento de taller", "info", 10000);
            var formulario = new FormData(document.getElementById('form-add-seguimiento-en-taller'));
            formulario.append('valor', 'valor');
            var datos = $.ajax({
                url: "{{ route('add.seg.taller') }}",
                type: "post",
                dataType: "json",
                data: formulario,
                cache: false,
                contentType: false,
                processData: false
            });
            datos.done((res) => {
                notificacion("Seguimiento agregado exitosamente", "success", 3000);
                document.getElementById('form-add-seguimiento-en-taller').reset()
                document.getElementById('div-form-info-ost').innerHTML = res.form
            })
            datos.fail(() => {
                notificacion("ERROR! Revisa los campos y vuelve a intentarlo", "error", 5000);
            })
        }

        modalRespuestaCartaStReparado = (id_st, concepto) => {
            $('#ModalEmitirCartaStReparado').modal('show')
            $('#id_ost_carta').val(id_st)

            if (concepto == 'Valoracion') {
                document.getElementById('info_concepto_carta').hidden = false;
            } else {
                document.getElementById('info_concepto_carta').hidden = true;
            }
        }

        formEmitirCartaRespuesta = () => {
            notificacion("Emitiendo carta para la OST reparada...", "info", 10000);
            var formulario = new FormData(document.getElementById('form-emitir-carta-solucion'));
            formulario.append('valor', 'valor');
            var datos = $.ajax({
                url: "{{ route('carta.respuesta') }}",
                type: "post",
                dataType: "json",
                data: formulario,
                cache: false,
                contentType: false,
                processData: false
            });
            datos.done((res) => {
                notificacion("Carta emitida exitosamente...", "success", 3000);
                document.getElementById('form-emitir-carta-solucion').reset()
                $('#form-emitir-carta-solucion input').prop('disabled', true)
                document.getElementById('div-form-info-ost').innerHTML = res.form
            })
            datos.fail(() => {
                notificacion("ERROR! Revisa los campos y vuelve a intentarlo", "error", 5000);
            })
        }

        apruebaCartaRespuestaFab = (respuesta, ost) => {
            notificacion("Aprobando carta para la OST reparada...", "info", 10000);
            var datos = $.ajax({
                url: "{{ route('aprobar.respuesta') }}",
                type: "post",
                dataType: "json",
                data: {
                    id_st: ost,
                    id_rsp: respuesta
                }
            });
            datos.done((res) => {
                notificacion("Carta emitida exitosamente...", "success", 3000);
                document.getElementById('div-form-info-ost').innerHTML = res.form
            })
            datos.fail(() => {
                notificacion("ERROR! Revisa la conexión a internet", "error", 5000);
            })
        }

        sendNotificacionCarta = (ost) => {
            notificacion("Enviando notificación y carta al cliente...", "info", 10000);
            var datos = $.ajax({
                url: "{{ route('notificacion.cliente.noga') }}",
                type: "post",
                dataType: "json",
                data: {
                    id_st: ost
                }
            });
            datos.done((res) => {
                notificacion("Notificación enviada exitosamente...", "success", 4000);
            })
            datos.fail(() => {
                notificacion("ERROR! Revisa la conexión a internet", "error", 5000);
            })
        }
    </script>
@endsection
