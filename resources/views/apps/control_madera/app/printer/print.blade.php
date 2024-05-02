@extends('apps.control_madera.plantilla.app')
@section('body')
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h2>Imprimir códigos QR</h2>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="page-body mt-4">
            <div class="row">
                <div class="col-md-7 mb-3">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                Información para imprimir QR's
                            </div>
                        </div>
                        <div class="card-body">
                            <form class="form-label-left input_mask" id="form-print-info-marquillas-qr" autocomplete="off">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group row">
                                            <label class="col-form-label col-md-3 col-sm-3 ">N° Bloques *</label>
                                            <div class="col-md-9 col-sm-9 ">
                                                <input type="number" onkeyup="$('#txt_cantidad_print').val(this.value)" name="txt_cantidad_bloques"
                                                    id="txt_cantidad_bloques" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group row">
                                            <label class="col-form-label col-md-3 col-sm-3 ">N° Stickers *</label>
                                            <div class="col-md-9 col-sm-9 ">
                                                <input type="number" style="background-color: #e3e3e3;" name="txt_cantidad_print" id="txt_cantidad_print"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group row">
                                            <label class="col-form-label col-md-3 col-sm-3 ">Madera *</label>
                                            <div class="col-md-9 col-sm-9 ">
                                                <select name="txt_tipo_madera" id="txt_tipo_madera" class="form-control">
                                                    <option value=""></option>
                                                    @foreach ($madera as $item)
                                                        <option value="<?php echo $item->id_madera; ?>"><?php echo $item->nombre_madera; ?></option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group row">
                                            <label class="col-form-label col-md-3 col-sm-3 ">Subproceso *</label>
                                            <div class="col-md-9 col-sm-9 ">
                                                <input type="text" name="subproceso" id="subproceso" onkeyup="this.value=this.value.toUpperCase()"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group row">
                                            <label class="col-form-label col-md-3 col-sm-3 ">Vehículo *</label>
                                            <div class="col-md-9 col-sm-9 ">
                                                <select name="tipo_vehiculo" id="tipo_vehiculo" class="form-control">
                                                    <option value=""></option>
                                                    <option value="SENCILLO">SENCILLO</option>
                                                    <option value="DOBLE TROQUE">DOBLE TROQUE</option>
                                                    <option value="CUATRO MANOS">CUATRO MANOS</option>
                                                    <option value="MULA">MULA</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group row">
                                            <label class="col-form-label col-md-3 col-sm-3 ">Placa</label>
                                            <div class="col-md-9 col-sm-9 ">
                                                <input type="text" name="txt_placa" onkeyup="this.value=this.value.toUpperCase()" id="txt_placa"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group row">
                                            <label class="col-form-label col-md-3 col-sm-3 ">S. Conducto</label>
                                            <div class="col-md-9 col-sm-9 ">
                                                <input type="text" name="txt_salvo_conducto" onkeyup="this.value=this.value.toUpperCase()"
                                                    id="txt_salvo_conducto" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="ln_solid"></div>
                                <div class="form-group text-center">
                                    <button type="button" onclick="btnPrintInfoQr()" class="btn btn-success">Imprimir consecutivos</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 mb-3">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    Cantidad procesados
                                </div>
                                <div class="card-body text-center">
                                    <h1 id="cantidad_impresiones_correctas" style="cursor: pointer" onclick="ConsultarImpresiones('1')"
                                        data-cantidadTrue="0">0</h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    Cantidad fallidos
                                </div>
                                <div class="card-body text-center">
                                    <h1 id="cantidad_impresiones_fallidas" style="cursor: pointer" onclick="ConsultarImpresiones('2')"
                                        data-cantidadFalse="0">0</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            Información impresora
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-form-label col-md-3 col-sm-3 ">Nombre impresora </label>
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
                                <label class="col-form-label col-md-3 col-sm-3 ">Estado impresora</label>
                                <div class="col-md-9 col-sm-9 ">
                                    <input type="text" id="info-impresora-red" class="form-control" readonly="readonly"
                                        value="{{ $estado }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalInfoHistoryPrinted" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Información general <span id="titlePrinted"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="mensajeBody">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script>
        btnPrintInfoQr = () => {
            var cantidad = $('#txt_cantidad_print').val()
            if (cantidad > 0) {

                var formulario = new FormData(document.getElementById('form-print-info-marquillas-qr'));

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
    </script>
@endsection
