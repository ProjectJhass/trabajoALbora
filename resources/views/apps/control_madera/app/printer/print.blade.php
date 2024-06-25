@extends('apps.control_madera.plantilla.app')
@section('printer')
    active
@endsection
@section('body')
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="row row-cols-1">
                <div class="overflow-hidden d-slider1">
                    <ul class="p-0 m-0 mb-2 swiper-wrapper list-inline justify-content-center">
                        <li class="swiper-slide card card-slide alert-top" data-aos="fade-up" data-aos-delay="400">
                            <div class="card-body">
                                <div class="progress-widget">
                                    <div id="circle-progress-02" class="text-center circle-progress-01 circle-progress circle-progress-info"
                                        data-min-value="0" data-max-value="100" data-value="80" data-type="percent">
                                        <svg class="card-slie-arrow icon-24" width="24" viewBox="0 0 24 24">
                                            <path fill="currentColor" d="M19,6.41L17.59,5L7,15.59V9H5V19H15V17H8.41L19,6.41Z" />
                                        </svg>
                                    </div>
                                    <div class="progress-detail">
                                        <p class="mb-2">Cantidad impresos</p>
                                        <h4 id="cantidad_impresiones_correctas" class="counter" style="cursor: pointer"
                                            onclick="ConsultarImpresiones('1')" data-cantidadTrue="0">
                                            0
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="swiper-slide card card-slide alert-top" data-aos="fade-up" data-aos-delay="500">
                            <div class="card-body">
                                <div class="progress-widget">
                                    <div id="circle-progress-03" class="text-center circle-progress-01 circle-progress circle-progress-primary"
                                        data-min-value="0" data-max-value="100" data-value="70" data-type="percent">
                                        <svg class="card-slie-arrow icon-24" width="24" viewBox="0 0 24 24">
                                            <path fill="currentColor" d="M19,6.41L17.59,5L7,15.59V9H5V19H15V17H8.41L19,6.41Z" />
                                        </svg>
                                    </div>
                                    <div class="progress-detail">
                                        <p class="mb-2">Cantidad fallidos</p>
                                        <h4 id="cantidad_impresiones_fallidas" class="counter" style="cursor: pointer" onclick="ConsultarImpresiones('2')"
                                            data-cantidadFalse="0">
                                            0
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-7 mb-3">
            <div class="card alert-top" data-aos="fade-up" data-aos-delay="400">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h6 class="card-title">Estación de etiquetado</h6>
                    </div>
                </div>
                <div class="card-body">
                    <form class="form-label-left input_mask" id="form-print-info-marquillas-qr" autocomplete="off">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label>N° Bloques *</label>
                                <input type="number" onkeyup="$('#txt_cantidad_print').val(this.value)" name="txt_cantidad_bloques"
                                    id="txt_cantidad_bloques" class="form-control">
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="form-group">
                                    <label class="">N° Stickers *</label>
                                    <input type="number" style="background-color: #e3e3e3;" name="txt_cantidad_print" id="txt_cantidad_print"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>Madera *</label>
                                    <select name="txt_tipo_madera" id="txt_tipo_madera" class="form-control">
                                        <option value="">Seleccionar...</option>
                                        @foreach ($madera as $item)
                                            <option value="<?php echo $item->id_madera; ?>"><?php echo $item->nombre_madera; ?></option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>Subproceso *</label>
                                    <input type="text" name="subproceso" id="subproceso" onkeyup="this.value=this.value.toUpperCase()"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>Vehículo *</label>
                                    <select name="tipo_vehiculo" id="tipo_vehiculo" class="form-control">
                                        <option value="">Seleccionar...</option>
                                        <option value="SENCILLO">SENCILLO</option>
                                        <option value="DOBLE TROQUE">DOBLE TROQUE</option>
                                        <option value="CUATRO MANOS">CUATRO MANOS</option>
                                        <option value="MULA">MULA</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>Placa</label>
                                    <input type="text" name="txt_placa" onkeyup="this.value=this.value.toUpperCase()" id="txt_placa"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>S. Conducto</label>
                                    <input type="text" name="txt_salvo_conducto" onkeyup="this.value=this.value.toUpperCase()"
                                        id="txt_salvo_conducto" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-check">
                                    <input type="number" class="form-control" name="cant_etiquetas_custodia" id="cant_etiquetas_custodia">
                                    <input class="form-check-input" type="checkbox" name="etiquetas_custodia" id="etiquetas_custodia">
                                    <label class="form-check-label" for="etiquetas_custodia">
                                        Utilizar etiquetas custodiadas
                                    </label>
                                </div>
                            </div>
                            <div class="form-group text-center">
                                <button type="button" onclick="btnPrintInfoQr()" class="btn btn-success">Imprimir consecutivos</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-5 mb-3">
            <div class="card alert-top" data-aos="fade-up" data-aos-delay="500">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h6 class="card-title">Información impresora</h6>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-form-label col-md-3 col-sm-3 ">Impresora </label>
                        <div class="col-md-9 col-sm-9 ">
                            <input type="text" class="form-control" readonly="readonly" value="{{ $impresora->nombre }}">
                        </div>
                    </div>
                    @if ($conexion == 'red')
                        <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 ">IP impresora</label>
                            <div class="col-md-9 col-sm-9 ">
                                <input type="text" class="form-control" readonly="readonly" value="{{ $impresora->ip }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 ">Puerto</label>
                            <div class="col-md-9 col-sm-9 ">
                                <input type="text" class="form-control" readonly="readonly" value="{{ $impresora->puerto }}">
                            </div>
                        </div>
                    @endif
                    <div class="form-group row">
                        <label class="col-form-label col-md-3 col-sm-3 ">Estado</label>
                        <div class="col-md-9 col-sm-9 ">
                            <input type="text" id="info-impresora-red" class="form-control" readonly="readonly" value="{{ $estado }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card alert-top alert-danger" data-aos="fade-up" data-aos-delay="600">
                <div class="card-header">
                    <div class="card-title">
                        <h6>Impresiones realizadas hoy</h6>
                    </div>
                </div>
                <div class="card-body" id="tableInfoImpresionesRealizadas">
                    {!! $historyPrint !!}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalInfoHistoryPrinted" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Información general <span id="titlePrinted"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="mensajeBody">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalInfoConsecutivosEnCustodia" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Consecutivos en custodia</h5>
                    {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr class="text-center">
                                <td>#</td>
                                <td>Consecutivo</td>
                                <td>Usuario responsable</td>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($custodia as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->id_consecutivo }}</td>
                                    <td>{{ $item->usuario_a_cargo }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-primary" onclick="utilizarImprimirEtiquetas()">Utilizar e imprimir más</button>
                    <button type="button" class="btn btn-success" onclick="utilizarEtiquetasCustodia()">Solo utilizar estas etiquetas</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalInfoConsecutivosCustodia" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Información adicional</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formUtilizarInfoCustodia" method="post" class="was-validated">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>Madera *</label>
                                    <select name="txt_tipo_madera" id="txt_tipo_madera" class="form-control" required>
                                        <option value="">Seleccionar...</option>
                                        @foreach ($madera as $item)
                                            <option value="<?php echo $item->id_madera; ?>"><?php echo $item->nombre_madera; ?></option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>Subproceso *</label>
                                    <input type="text" name="subproceso" id="subproceso" onkeyup="this.value=this.value.toUpperCase()"
                                        class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>Vehículo *</label>
                                    <select name="tipo_vehiculo" id="tipo_vehiculo" class="form-control" required>
                                        <option value="">Seleccionar...</option>
                                        <option value="SENCILLO">SENCILLO</option>
                                        <option value="DOBLE TROQUE">DOBLE TROQUE</option>
                                        <option value="CUATRO MANOS">CUATRO MANOS</option>
                                        <option value="MULA">MULA</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="utilizarInformacionConsecutivos()">Utilizar consecutivos</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    @if (count($custodia) > 0)
        <script>
            $(document).ready(function() {
                $("#modalInfoConsecutivosEnCustodia").modal("show")
                $("#cant_etiquetas_custodia").val("{{ count($custodia) }}")
            })
        </script>
    @endif
    <script>
        btnPrintInfoQr = () => {
            var cantidad = $('#txt_cantidad_print').val()
            if (cantidad > 0) {
                var consecutivo = "";
                $('input[name="impresion_realizada"]').each(function() {
                    if ($(this).is(':checked')) {
                        consecutivo = $(this).val();
                    }
                });

                var formulario = new FormData(document.getElementById('form-print-info-marquillas-qr'));
                formulario.append('consecutivo', consecutivo);
                var datos = $.ajax({
                    url: "{{ route('print.info.qr') }}",
                    type: "post",
                    dataType: "json",
                    data: formulario,
                    cache: false,
                    contentType: false,
                    processData: false
                });
                datos.done((res) => {
                    if (res.status == true) {
                        if (res.impresas == 0) {
                            notificacion("¡Error! Impresiones fallidas " + res.fallidas, "error", 5000);
                        } else {
                            notificacion("Se imprimieron " + res.impresas + " marquillas", "success", 5000);
                        }
                        $('#cantidad_impresiones_correctas').text(res.impresas)
                        $('#cantidad_impresiones_correctas').attr("data-cantidadTrue", res.id_printed)
                        $('#cantidad_impresiones_fallidas').text(res.fallidas)
                        $('#cantidad_impresiones_fallidas').attr("data-cantidadFalse", res.id_printed)
                        $('#info-impresora-red').val(res.impresora)
                        document.getElementById('form-print-info-marquillas-qr').reset()
                        document.getElementById('tableInfoImpresionesRealizadas').innerHTML = res.table
                    }
                    if (res.status == false) {
                        $('#info-impresora-red').val(res.impresora)
                        notificacion("ERROR! " + res.mensaje, "error", 5000);
                    }
                })
                datos.fail(() => {
                    notificacion("ERROR! Revisa los campos y vuelve a intentarlo", "error", 5000);
                })
            } else {
                notificacion("ERROR! El campo cantidad debe ser mayor a 0", "error", 5000);
            }

        }

        ConsultarImpresiones = (tipo) => {
            $('#modalInfoHistoryPrinted').modal('show')
            if (tipo == 1) {
                $('#titlePrinted').text("Impresos")
                var id_printed = $("h1[data-cantidadTrue]").attr("data-cantidadTrue")
            } else {
                $('#titlePrinted').text("Fallidos")
                var id_printed = $("h1[data-cantidadFalse]").attr("data-cantidadFalse")
            }
            var datos = $.ajax({
                url: "{{ route('search.printed') }}",
                type: "post",
                dataType: "json",
                data: {
                    tipo,
                    id_printed
                }
            });
            datos.done((res) => {
                document.getElementById('mensajeBody').innerHTML = res.mensaje
            })
        }

        utilizarEtiquetasCustodia = () => {
            $("#modalInfoConsecutivosCustodia").modal("show")
        }

        utilizarInformacionConsecutivos = () => {
            notificacion("Utilizando consecutivos...", "info", 6000);
            var formulario = new FormData(document.getElementById('formUtilizarInfoCustodia'));
            var datos = $.ajax({
                url: "{{ route('utilizar.qr.custodia') }}",
                type: "post",
                dataType: "json",
                data: formulario,
                cache: false,
                contentType: false,
                processData: false
            });
            datos.done((res) => {
                notificacion(res.mensaje, "success", 3000);
                document.getElementById('tableInfoImpresionesRealizadas').innerHTML = res.table
                $("#modalInfoConsecutivosCustodia").modal("hide")
                $("#modalInfoConsecutivosEnCustodia").modal("hide")
            })
            datos.fail(() => {
                notificacion("ERROR! Revisa los campos y vuelve a intentarlo", "error", 5000);
            })
        }

        utilizarImprimirEtiquetas = () => {
            $("#etiquetas_custodia").attr("checked", true)
            var cantidad_custodia = $("#cant_etiquetas_custodia").val()
            $("#cantidad_impresiones_correctas").text(cantidad_custodia)
            $("#modalInfoConsecutivosEnCustodia").modal("hide")
        }
    </script>
@endsection
