@extends('apps.control_madera.plantilla.app')
@section('op.siesa')
    active
@endsection
@section('body')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <h5>Crear orden de producción en SIESA</h5>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" id="formInformacionOrdenProduccion" class="was-validated">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Tipo de corte</label>
                                    <div class="input-group mb-3">
                                        <button class="btn text-black" style="background-color: rgb(218, 218, 218)" type="button"
                                            id="button-addon1">Corte</button>
                                        <select class="form-control" name="tipoCorteBuscado" id="tipoCorteBuscado" aria-describedby="button-addon1"
                                            required>
                                            <option value=""></option>
                                            <option value="tabla">Corte de tabla</option>
                                            <option value="serie">Corte de serie</option>
                                            <option value="Tserie">Tablas cortadas de serie</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="">Planificación</label>
                                    <div class="input-group mb-3">
                                        <button class="btn text-black" style="background-color: rgb(218, 218, 218)" type="button" id="btnInfoCorte"
                                            onclick="searchInfoCortesPlanificados()">Planificación</button>
                                        <input type="text" hidden class="form-control" name="pulgadas_solicitar" id="pulgadas_solicitar" required>
                                        <input type="text" hidden class="form-control" name="id_corte_planificado" id="id_corte_planificado" required>
                                        <input type="text" class="form-control" onchange="searchInfoCorteNombre(this.value)"
                                            name="nombre_corte_planificado" id="nombre_corte_planificado" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Fecha</label>
                                    <div class="input-group mb-3">
                                        <button class="btn text-black" style="background-color: rgb(218, 218, 218)" type="button"
                                            id="button-addon1">Fecha</button>
                                        <input type="date" class="form-control" readonly value="{{ date('Y-m-d') }}" name="fecha" id="fecha">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Tipo de documento</label>
                                    <div class="input-group mb-3">
                                        <button class="btn text-black" style="background-color: rgb(218, 218, 218)" type="button"
                                            id="button-addon1">Docto</button>
                                        <input type="text" class="form-control" readonly value="OP" name="tipo_doc" id="tipo_doc">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="">Tipo madera</label>
                                    <div class="input-group mb-3">
                                        <button class="btn text-black" style="background-color: rgb(218, 218, 218)" type="button"
                                            id="button-addon1">Código</button>
                                        <select class="form-control" name="codigo_siesa_op" id="codigo_siesa_op" required>
                                            <option value=""></option>
                                            @foreach ($idCodigos as $item)
                                                <option value="{{ $item->codigo }}">{{ $item->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="">Planificador</label>
                                    <div class="input-group mb-3">
                                        <button class="btn text-black" style="background-color: rgb(218, 218, 218)" type="button"
                                            id="button-addon1">Planificador</button>
                                        <input type="text" class="form-control" readonly value="{{ Auth::user()->nombre }}" name="planificador"
                                            id="planificador">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Notas</label>
                                    <textarea class="form-control" name="notas_op_siesa" id="notas_op_siesa" cols="30" rows="3" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="justify-content-center">
                            <center>
                                <button type="button" class="btn btn-primary" onclick="generarSolicitudcreacionOpSiesa()">Crear orden de
                                    producción</button>
                                <button type="reset" class="btn btn-secondary">Limpiar campos</button>
                            </center>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalInfoCortesPlanificados" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="infoGeneralCortesPlanificadosCompletados">
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script>
        searchInfoCortesPlanificados = () => {
            var tipo_corte = $('#tipoCorteBuscado').val()
            if (tipo_corte.length > 0) {
                var datos = $.ajax({
                    url: "{{ route('search.codigos.siesa') }}",
                    type: "post",
                    dataType: "json",
                    data: {
                        tipo_corte
                    }
                });
                datos.done(function(res) {
                    $('#modalInfoCortesPlanificados').modal('show')
                    document.getElementById("infoGeneralCortesPlanificadosCompletados").innerHTML = res.table
                })
            } else {
                notificacion("¡ERROR! Primero debes escoger un tipo de corte", "error", 5000)
            }
        }

        searchInfoCorteNombre = (valor) => {
            var tipo_corte = $('#tipoCorteBuscado').val()
            if (valor.length > 0 && tipo_corte.length > 0) {
                var datos = $.ajax({
                    url: "{{ route('search.info.codigos.siesa') }}",
                    type: "post",
                    dataType: "json",
                    data: {
                        tipo_corte,
                        valor_buscado: valor
                    }
                });
                datos.done(function(res) {
                    $('#modalInfoCortesPlanificados').modal('show')
                    document.getElementById("infoGeneralCortesPlanificadosCompletados").innerHTML = res.table
                })
            } else {
                notificacion("¡ERROR! Primero debes escoger un tipo de corte", "error", 5000)
            }
        }

        seleccionarInfoOp = (id, codigo) => {
            var nombre = $("#nombre" + id).text()
            var pulgadas = $("#pulgadas" + id).text()
            $("#pulgadas_solicitar").val(pulgadas)
            $("#id_corte_planificado").val(id)
            $("#nombre_corte_planificado").val(nombre)
            $("#codigo_siesa_op").val(codigo)
            $('#modalInfoCortesPlanificados').modal('hide')
        }

        generarSolicitudcreacionOpSiesa = () => {
            notificacion("Creando nueva orden de producción en SIESA, Por favor espera...", "info", 10000);
            var formulario = new FormData(document.getElementById('formInformacionOrdenProduccion'));
            formulario.append('valor', 'valor');
            var datos = $.ajax({
                url: "{{ route('crear.info.op.siesa') }}",
                type: "post",
                dataType: "json",
                data: formulario,
                cache: false,
                contentType: false,
                processData: false
            });
            datos.done((res) => {
                if (res.status == true) {
                    notificacion(res.mensaje, "success", 5000)
                    document.getElementById('formInformacionOrdenProduccion').reset()
                }
                if (res.status == false) {
                    notificacion(res.mensaje, "error", 6000)
                }
            })
            datos.fail(() => {
                notificacion("¡ERROR! Hubo un problema de conexión, vuelve a intentar", "error", 5000)
            })
        }
    </script>
@endsection
