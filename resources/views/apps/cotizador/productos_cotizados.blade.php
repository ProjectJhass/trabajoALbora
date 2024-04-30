@extends('apps.cotizador.plantilla.app')
@section('title')
    Liquidador
@endsection
@section('head')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endsection
@section('body')
    <div class="panel-inicio" id="panel-prod-cotizados">
        @if (count($productos) > 0)
            <div class="row">
                <div class="col-md-12 mb-3">
                    <div class="card card-outline card-secondary">
                        <div class="card-header">
                            Liquidador final
                        </div>
                        <div class="card-body">
                            <div id="productsCotizadosAlbura"><?php echo $tblProducts; ?></div>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="{{ route('lista.precios') }}" type="button" class="btn btn-sm btn-danger">Lista de precios</a>
                                <button type="button" class="btn btn-sm btn-success" id="btn-activar-dsto-add"
                                    onclick="habilitarCampoDstoAdd();">Descuento adicional</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" id="detallesVistasCot">
                <?php echo $planesV; ?>
            </div>

            <div class="row">
                <div class="col-md-12 mb-3 text-center">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-danger" onclick="ValidarPlaFinanciacion('CO')">Cotización general</button>
                        <button type="button" class="btn btn-success" onclick="ValidarPlaFinanciacion('CRE')">Solicitar crédito</button>
                    </div>
                </div>

                <div class="col-md-12 mb-4" id="formularioDatosCliente" hidden>
                    <div class="card card-outline card-secondary">
                        <div class="card-header">
                            <h5>Datos del cliente <span class="text-danger" id="text-form"></span></h5>
                        </div>
                        <div class="card-body">
                            <form id="formulario-datos-cliente-cotizacion" style="font-size: 14px" autocomplete="off">
                                @csrf
                                <div class="row">
                                    <input type="text" name="tipo_cotizacion" id="tipo_cotizacion" hidden>
                                    <div class="col-md-4 mb-3">
                                        <label for="">Cédula</label>
                                        <input type="number" class="form-control form-cmp is-valid" value="{{ session('cedula_cliente') }}"
                                            onkeyup="validarCedulaTel('cedula_cliente', this.value)" name="cedula_cliente" id="cedula_cliente" required>
                                        <div class="form-group form-check" id="div_check_sin_cedula" hidden>
                                            <input type="checkbox" class="form-check-input" id="check_sin_cedula">
                                            <label class="form-check-label" for="check_sin_cedula">Sin cédula</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="">Primer Nombre</label>
                                        <input type="text" class="form-control form-cmp is-valid" value="{{ session('primer_nombre') }}"
                                            onkeyup="validarCampoText('primer_nombre',this.value)" name="primer_nombre" id="primer_nombre" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="">Segundo Nombre</label>
                                        <input type="text" class="form-control form-cmp is-valid" value="{{ session('segundo_nombre') }}"
                                            onkeyup="validarCampoText('segundo_nombre',this.value)" name="segundo_nombre" id="segundo_nombre">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="">Primer Apellido</label>
                                        <input type="text" class="form-control form-cmp is-valid" value="{{ session('primer_apellido') }}"
                                            onkeyup="validarCampoText('primer_apellido',this.value)" name="primer_apellido" id="primer_apellido">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="">Segundo Apellido</label>
                                        <input type="text" class="form-control form-cmp is-valid" value="{{ session('segundo_apellido') }}"
                                            onkeyup="validarCampoText('segundo_apellido',this.value)" name="segundo_apellido" id="segundo_apellido">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="">Dirección</label>
                                        <input type="text" class="form-control form-cmp is-valid" value="{{ session('direccion') }}"
                                            onkeyup="validarCampoRequerido('direccion', this.value)" name="direccion" id="direccion">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="">Departamento</label>
                                        <select name="depto" id="depto" onchange="obtenerCiudadesCoti(this.value);"
                                            class="form-control is-invalid">
                                            <option value="">Seleccionar</option>
                                            @foreach ($dptos as $item)
                                                <option value="{{ $item->id_depto }}">{{ $item->depto }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="">Ciudad</label>
                                        <select name="ciudad" id="ciudad" onchange="validarCampoRequerido('ciudad', this.value)"
                                            class="form-control form-cmp is-valid">
                                            <option value="">Seleccionar...</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="">Barrio</label>
                                        <input type="text" class="form-control form-cmp is-valid" value="{{ session('barrio') }}"
                                            onkeyup="validarCampoRequerido('barrio', this.value)" name="barrio" id="barrio">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="">Teléfono 1</label>
                                        <input type="number" class="form-control form-cmp is-valid" value="{{ session('telefono1') }}"
                                            onkeyup="validarCedulaTel('telefono1', this.value)" name="telefono1" id="telefono1">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="">Teléfono 2</label>
                                        <input type="number" class="form-control form-cmp is-valid" value="{{ session('telefono2') }}"
                                            name="telefono2" id="telefono2">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="">E-mail</label>
                                        <input type="email" class="form-control form-cmp is-valid" value="{{ session('correo') }}"
                                            onkeyup="validarCampoRequerido('correo', this.value)" name="correo" id="correo">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="">Género</label>
                                        <select name="genero" id="genero" onchange="validarCampoRequerido('genero', this.value)"
                                            class="form-control form-cmp is-valid">
                                            <option value="">Seleccionar...</option>
                                            <option value="HOMBRE">HOMBRE</option>
                                            <option value="MUJER">MUJER</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="">Fecha cumpleaños</label>
                                        <input type="date" class="form-control form-cmp is-valid" name="cumple_cl" id="cumple_cl">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="">Categoría</label>
                                        <select name="categoria" id="categoria" onchange="validarCampoRequerido('categoria', this.value)"
                                            class="form-control form-cmp is-valid">
                                            <option value="">Seleccionar...</option>
                                            <option value="SALAS">SALAS</option>
                                            <option value="COMEDORES">COMEDORES</option>
                                            <option value="COLCHONES">COLCHONES</option>
                                            <option value="ALCOBAS">ALCOBAS</option>
                                            <option value="ACCESORIOS">ACCESORIOS</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <label for="">Observaciones</label>
                                        <textarea name="observaciones" id="observaciones" onkeyup="validarCampoRequerido('observaciones', this.value)" class="form-control form-cmp"
                                            cols="30" rows="1">{{ session('observaciones') }}</textarea>
                                    </div>
                                </div>
                                <center>
                                    <button type="button" onclick="ValidarInformacionIngresadaCot()" class="btn btn-success mb-4">Generar
                                        cotización</button>
                                </center>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="mensaje text-center mt-5">
                <img src="{{ asset('img/triste.png') }}" width="12%" alt="">
                <h4>UPS !! No tienes productos cotizados</h4>
            </div>
        @endif
    </div>

    <div class="modal fade" id="modalInfoCuentasCartera" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-body" id="info-cuentas-cartera-error"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar información</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('footer')
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        obtenerCiudadesCoti = (id) => {
            if (id.length > 0) {
                $('#depto').removeClass('is-invalid')
                $('#depto').addClass('is-valid')

                var datos = $.ajax({
                    url: "{{ Route('ciudades.consultar') }}",
                    type: "POST",
                    dataType: "json",
                    data: {
                        id
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                datos.done((res) => {
                    if (res.status == true) {
                        $('#ciudad').html(res.ciudad);
                    }
                });
            } else {
                $('#depto').removeClass('is-valid')
                $('#depto').addClass('is-invalid')
            }
        }

        $(document).ready(() => {
            StylesTableCotizacion();
        });

        StylesTableCotizacion = () => {
            $("#productos-liquidador-albura").DataTable({
                oLanguage: {
                    sSearch: "Buscar:",
                    sInfo: "Mostrando de _START_ a _END_ de _TOTAL_ registros",
                    oPaginate: {
                        sPrevious: "Volver",
                        sNext: "Siguiente",
                    },
                    sEmptyTable: "No se encontró ningun registro en la base de datos",
                    sZeroRecords: "No se encontraron resultados...",
                    sLengthMenu: "Mostrar _MENU_ registros",
                },
                order: [
                    [0, "asc"]
                ],
                paging: true,
                lengthChange: true,
                searching: true,
                ordering: true,
                info: true,
                autoWidth: true,
                responsive: true,
            });
        };

        ValidarPlaFinanciacion = (plan) => {
            loandingPanel()
            var datos = $.ajax({
                url: window.location.href,
                type: "POST",
                dataType: "json",
                data: {
                    validar: "1",
                },
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });
            datos.done((res) => {

                loadedPanel()

                if (res.status == true) {
                    ValidarCamposRequeridos(plan);
                }

                if (res.status == false) {
                    Swal.fire(
                        "ERROR!",
                        "Valida el plan de venta de los productos",
                        "error"
                    );
                }
            });
        };

        var check = document.getElementById("check_sin_cedula");
        check.addEventListener("change", function() {
            var numeroced = Math.floor(Math.random() * 1000000000) + 1000000;
            if (this.checked) {
                $("#cedula_cliente").val(numeroced);
            } else {
                $("#cedula_cliente").val("");
            }
        });

        habilitarCampoDstoAdd = () => {
            if ($(".vlr_add_class").is(":disabled")) {
                $("#btn-activar-dsto-add").removeClass("btn btn-success");
                $("#btn-activar-dsto-add").addClass("btn btn-warning");
                $(".vlr_add_class").prop("disabled", false);
            } else {
                $("#btn-activar-dsto-add").removeClass("btn btn-warning");
                $("#btn-activar-dsto-add").addClass("btn btn-success");
                $(".vlr_add_class").prop("disabled", true);
            }
        };

        FormatearCamposFormulario = () => {
            document.getElementById("formularioDatosCliente").hidden = true;

            $(".form-cmp").removeClass("is-invalid");
            $(".form-cmp").removeClass("is-valid");
            $(".form-cmp").addClass("is-valid");
            $("#tipo_cotizacion").val("");
        };

        ValidarCamposRequeridos = (tipo_cotizacion) => {
            FormatearCamposFormulario();

            setTimeout(() => {
                document.getElementById("formularioDatosCliente").hidden = false;
            }, 500);

            switch (tipo_cotizacion) {
                case "CO":
                    document.getElementById("text-form").innerHTML = "Cotización";
                    document.getElementById("div_check_sin_cedula").hidden = false;
                    $("#tipo_cotizacion").val("CO");

                    $("#cedula_cliente").addClass("is-invalid");
                    $("#primer_nombre").addClass("is-invalid");
                    $("#ciudad").addClass("is-invalid");
                    $("#telefono1").addClass("is-invalid");
                    $("#genero").addClass("is-invalid");
                    $("#categoria").addClass("is-invalid");
                    $("#observaciones").addClass("is-invalid");
                    break;
                case "CRE":
                    document.getElementById("text-form").innerHTML = "OnCredit";
                    document.getElementById("div_check_sin_cedula").hidden = true;
                    $("#tipo_cotizacion").val("CRE");

                    $("#cedula_cliente").addClass("is-invalid");
                    $("#primer_nombre").addClass("is-invalid");
                    $("#primer_apellido").addClass("is-invalid");
                    $("#direccion").addClass("is-invalid");
                    $("#ciudad").addClass("is-invalid");
                    $("#barrio").addClass("is-invalid");
                    $("#telefono1").addClass("is-invalid");
                    $("#correo").addClass("is-invalid");
                    $("#genero").addClass("is-invalid");
                    $("#categoria").addClass("is-invalid");
                    break;
            }
        };

        /* EfectoActualizandoPagina = () => {
            document.getElementById("panel-prod-cotizados").innerHTML =
                '<div class="text-center"><img src="{{ asset('img/cargando.gif') }}" alt=""><h4>Actualizando...</h4></div>';
        }; */

        NotificarActualizandoInfo = () => {
            Swal.fire({
                position: "top-end",
                icon: "info",
                title: "Actualizando Información...",
                showConfirmButton: false,
                timer: 2000,
            });
        };

        EliminarProductoCotizado = (id_cotizacion) => {
            Swal.fire({
                title: "Estas seguro de eliminar?",
                text: "No podrás reversar la operación",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, eliminar",
                cancelButtonText: "No, cancelar!",
            }).then((result) => {
                if (result.isConfirmed) {

                    loandingPanel()

                    var datos = ConfirmEliminarProducto(id_cotizacion);

                    datos.done((res) => {

                        loadedPanel()

                        if (res.status == true) {
                            document.getElementById(
                                "productsCotizadosAlbura"
                            ).innerHTML = res.tblProducts;
                            document.getElementById("detallesVistasCot").innerHTML =
                                res.viewDetalle;

                            StylesTableCotizacion();
                        }
                    });
                    datos.fail(() => {

                        loadedPanel()

                        Swal.fire(
                            "ERROR!",
                            "Hubo un problema al procesar la solicitud",
                            "error"
                        );
                    });
                }
            });
        };

        ConfirmEliminarProducto = (id_cotizacion, url) => {
            NotificarActualizandoInfo();

            var datos = $.ajax({
                url: "{{ route('eliminar.item.cot') }}",
                type: "POST",
                dataType: "json",
                data: {
                    id_cotizacion,
                },
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });

            return datos;
        };

        ActualizarProductoCotizado = (id_cotizacion) => {

            loandingPanel()

            var cantidad = $("#cantidad" + id_cotizacion).val();
            var descuento = $("#descuento" + id_cotizacion).val();
            var dsto_ad = $("#dsto_ad" + id_cotizacion).val();

            var datos = $.ajax({
                url: "{{ route('actualizar.producto') }}",
                type: "POST",
                dataType: "json",
                data: {
                    id_cotizacion,
                    cantidad,
                    descuento,
                    dsto_ad,
                },
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });

            datos.done((res) => {

                loadedPanel()

                if (res.status == true) {
                    document.getElementById("productsCotizadosAlbura").innerHTML =
                        res.tblProducts;
                    document.getElementById("detallesVistasCot").innerHTML =
                        res.viewDetalle;

                    StylesTableCotizacion();
                }
            });
            datos.fail(() => {

                loadedPanel()

                Swal.fire({
                    position: "top-end",
                    icon: "error",
                    title: "No se encontraron cambios por realizar",
                    showConfirmButton: false,
                    timer: 2000,
                });
            });
        };

        ActulizarPlanVentaCotizador = () => {

            loandingPanel()

            var plan = $("#plan_venta").val();
            var valor_inicial = $("#valor_inicial_cot").val();

            // EfectoActualizandoPagina();

            var datos = $.ajax({
                url: "{{ route('modificar.plan') }}",
                type: "POST",
                dataType: "json",
                data: {
                    plan,
                    valor_inicial,
                },
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });
            datos.done((res) => {

                loadedPanel()

                if (res.status == true) {
                    document.getElementById("productsCotizadosAlbura").innerHTML =
                        res.tblProducts;
                    document.getElementById("detallesVistasCot").innerHTML =
                        res.viewDetalle;

                    StylesTableCotizacion();

                }
            });
            datos.fail(() => {

                loadedPanel()

                Swal.fire({
                    position: "top-end",
                    icon: "error",
                    title: "Hubo un problema al actualizar",
                    showConfirmButton: false,
                    timer: 2000,
                });
            });
        };

        validarCedulaTel = (id, valor) => {
            if (valor.length > 6 && valor.length <= 10) {
                $("#" + id).removeClass("is-invalid");
                $("#" + id).addClass("is-valid");
            } else {
                $("#" + id).removeClass("is-valid");
                $("#" + id).addClass("is-invalid");
            }
        };

        validarCampoText = (id, valor) => {
            if (valor.length > 0) {
                const patter = new RegExp("^[A-Z\u00D1\u00F1]+$", "i");
                if (patter.test(valor)) {
                    $("#" + id).removeClass("is-invalid");
                    $("#" + id).addClass("is-valid");
                } else {
                    $("#" + id).removeClass("is-valid");
                    $("#" + id).addClass("is-invalid");
                }
            }
        };
        validarCampoRequerido = (id, valor) => {
            if (valor.length > 0) {
                $("#" + id).removeClass("is-invalid");
                $("#" + id).addClass("is-valid");
            } else {
                $("#" + id).removeClass("is-valid");
                $("#" + id).addClass("is-invalid");
            }
        };

        ValidarInformacionIngresadaCot = () => {

            loandingPanel()

            var formData = new FormData(
                document.getElementById("formulario-datos-cliente-cotizacion")
            );

            var ciudad = $("#ciudad").find("option:selected");
            formData.append("id_ciudad", ciudad.data("id_city"));
            formData.append("id_depto", ciudad.data("id_depto"));
            formData.append("id_pais", ciudad.data("id_pais"));

            var datos = $.ajax({
                url: "{{ route('datos.cotizacion') }}",
                type: "POST",
                dataType: "json",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
            });
            datos.done((res) => {

                loadedPanel()

                if (res.status == true) {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: res.mensaje,
                        showConfirmButton: false,
                        timer: 2000,
                    });

                    setTimeout(() => {
                        //window.location.href = res.url;
                        window.open(res.url, '_BLANK');
                    }, 500);
                }
                if (res.status == false) {
                    Swal.fire({
                        position: "top-end",
                        icon: "error",
                        title: res.mensaje,
                        showConfirmButton: false,
                        timer: 3000,
                    });
                }
                if (res.status == "cartera") {
                    $("#modalInfoCuentasCartera").modal("show");

                    Swal.fire({
                        position: "top-end",
                        icon: "error",
                        title: res.mensaje,
                        showConfirmButton: false,
                        timer: 7000,
                        toast: true,
                    });

                    document.getElementById("info-cuentas-cartera-error").innerHTML =
                        res.table;
                }
            });
            datos.fail(() => {

                loadedPanel()

                Swal.fire({
                    position: "top-end",
                    icon: "error",
                    title: "ERROR: Verifica los campos en rojo y vuelve a intentar",
                    showConfirmButton: false,
                    timer: 3000,
                });
            });
        };
    </script>
@endsection
