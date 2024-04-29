@extends('apps.intranet.plantilla.app')
@section('title')
    Historial de Evaluación
@endsection
@section('rrhh')
    bg-danger active
@endsection
@section('head')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endsection
@section('body')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Historial Evaluacion Coordinadores</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item text-blue">Historial Evaluacion</li>
                        <li class="breadcrumb-item active">Regionales</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row d-flex justify-content-center">
                <div class="col-md-12 mb-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>Evaluaciones</strong>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-center">
                                <div class="btn-group btn-group-sm" style="margin-left: 2.5%">
                                    <button type="button" class="btn button" onclick="visualizarTipoDeHistorial('1')">Historial Anual</button>
                                    <button type="button" class="btn button" onclick="visualizarTipoDeHistorial('2')">Historial En años</button>
                                    <button type="button" class="btn button" onclick="modalCambioCentroOperacion()">Centro de operacion asignado</button>
                                    <button type="button" class="btn button" onclick="modalAsignacionCentroOperacion()">Asiganar centros de
                                        operacion</button>
                                </div>
                            </div>
                            <div id="historialAnual" style="display: block">
                                <div>
                                    <form action="{{ route('ver.historialEvaluacion') }}" method="POST">
                                        <div class="d-flex justify-conten-start m-1 col-12">
                                            <div class="m-2 col-3">
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
                                            <div class="m-6 pt-3 col-3">
                                                <button type="button" onclick="buscarHistorial()" class="btn btn-danger mt-4"><i
                                                        class="fas fa-search"></i> Buscar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-12 table-responsive" id="cargarTablaHistorial">

                                </div>
                            </div>

                            <div id="histoialAños" style="display: none">
                                <div>
                                    <form id="historialAños">
                                        <div class="d-flex justify-conten-start m-1 col-12">
                                            <div class="m-2 col-3">
                                                <label for="exampleInputEmail1" class="form-label">Desde:</label>
                                                <select id="fechaInicial" name="fechaInicial" required class="form-control ">
                                                    <option value="">Seleccione el año Inicial</option>
                                                    <?php
                                                    for ($i = 2020; $i <= 2099; $i++) {
                                                        echo "<option value='$i'>$i</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="m-2 col-3">
                                                <label for="exampleInputEmail1" class="form-label">Hasta:</label>
                                                <select id="fechaFinal" name="fechaFinal" required class="form-control ">
                                                    <option value="">Seleccione el año Final</option>
                                                    <?php
                                                    for ($i = 2020; $i <= 2099; $i++) {
                                                        echo "<option value='$i'>$i</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="m-6 pt-3 col-3">
                                                <button type="button" onclick="buscarHistorialAños()" class="btn btn-danger mt-4"><i
                                                        class="fas fa-search"></i> Buscar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-12 table-responsive" id="cargarTablaHistorialAños">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <!-- Encabezado de la modal -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Historial Evaluación Por Departamento</h5>
                        <a href="#" class="close" data-dismiss="modal" aria-label="Cerrar"><i class="fas fa-times-circle"
                                style="color: #ff0000;"></i></a>
                    </div>

                    <!-- Cuerpo de la modal -->
                    <div class="modal-body">
                        <div class="col-12 d-flex justify-content-center">
                            <div class="justify-content-center col-12 m-2">
                                <table class="table table-hover table-bordered table-sm">
                                    <thead class="text-center bg-danger">
                                        <tr>
                                            <th>Departamento</th>
                                            <th>Fecha</th>
                                            <th>Max Puntaje</th>
                                            <th>puntaje Evaluado</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        <!-- Las filas se llenarán dinámicamente mediante JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <aside class="sidebar-n control-sidebar control-sidebar-light p-4 bg-light" style="width: 700px;">
            <div class="card" style="height: 560px;">
                <div class="card-body" style="height: 100%; overflow-y: auto;">
                    <div class="d-flex flex-row bd-highlight mb-3">

                        <div class="col-3 d-flex justify-content-start">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="cerrarSidebar()">
                                <span aria-hidden="true"><i class="fas fa-times-circle" style="color: #ff0000;"></i></span>
                            </button>
                        </div>

                        <div class="align-middle p-0 ">
                            <h5 class="">Evaluacion por Centro de Experiencia</h5>
                        </div>
                    </div>

                    <hr>

                    <div id="titulo_tarea">
                        <table class="table table-hover table-bordered table-sm" id="departamentosEvluados">
                            <thead class="text-center bg-danger">
                                <tr>
                                    <th>Departamento</th>
                                    <th>Porcentaje</th>
                                    <th>Ver</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <!-- Las filas se llenarán dinámicamente mediante JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </aside>

    </section>


    <div class="modal fade" id="modalCentroOperaciones" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Centro operaciones y asesores asignados</h5>
                    <a role="button" onclick="cerrarModalCambioCentroOperacion()" style="font-size: 25px;">
                        <i class="fas fa-times-circle" style="color: #ff0000;"></i>
                    </a>
                </div>
                <div class="modal-body">

                    <div>
                        <label for="coordinador-centro">Seleccione un coordinador</label>
                        <select class="form-control" name="coordinador-centro" id="coordinador-centro" onchange="obtenerCentrosOperacionAsignado()">
                            <option value="">Seleccione un coordinador</option>
                        </select>
                    </div>

                    <div id="tablaCoordinadorCentro" class="mt-4">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="cerrarModalCambioCentroOperacion()">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalAsignacionCentroOperaciones" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Asiganar centro de operacion</h5>
                    <a role="button" onclick="cerrarModalAsignacionCentroOperacion()" style="font-size: 25px;">
                        <i class="fas fa-times-circle" style="color: #ff0000;"></i>
                    </a>
                </div>
                <div class="modal-body" id="cargarFormularioAsignacion">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="cerrarModalAsignacionCentroOperacion()">Cerrar</button>
                    <button type="button" class="btn btn-danger" onclick="asignarCentroOperacion()"><i class="fas fa-save"></i> &nbsp;
                        Guardar</button>
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
    <script type="text/javascript" src="https://cdn.datatables.net/w/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.6/b-html5-1.5.6/datatables.min.js"></script>
    <style>
        .button {
            border: 0.5px solid #DC3545;
            transition-duration: 0.4s;
        }

        .button:hover {
            background-color: #DC3545;
            color: white;
        }
    </style>
    <script>
        flatpickr("#fecha", {
            enableTime: false,
            dateFormat: "Y-m",
            altInput: true,
            altFormat: "F Y",
            mode: "single",
            locale: {
                months: {
                    shorthand: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                    longhand: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre',
                        'Diciembre'
                    ]
                }
            }
        });

        function VerificarPorcentajes(calificacionP, identificador) {
            let calificacionU = parseInt(
                document.getElementById(`porcentajeResultado${identificador}`).value
            );
            calificacionU = calificacionU ? calificacionU : 0;
            if (calificacionU <= calificacionP) {} else {
                $(`#porcentajeResultado${identificador}`).val(0);
                Swal.fire({
                    text: "Por favor, ingresa un número dentro del rango permitido.",
                    icon: "warning",
                    showConfirmButton: false,
                    position: "top-end",
                    timer: 5000,
                    toast: true,
                });
            }
        }

        // se muestran los centros de expericiencia la los que pertenece el coordinador para ser evaluado
        function traerCentrosExperiencia() {
            coordinador = document.getElementById("coordinador").value;
            $.ajax({
                url: "{{ route('centros.coordinaodres') }}",
                type: "POST",
                dataType: "json",
                data: {
                    coordinador: coordinador
                },
                success: function(res) {
                    var data = res.info;
                    let selector = `<label for="">CO:</label>
                <select class="form-select" aria-label="Default select example" name="centro" id="centro" required>
                <option value="" selected>Seleccionar...</option>`;
                    for (var i = 0; i < data.length; i++) {
                        selector += `<option value="${data[i].id}">${data[i].centro_operacion}</option>`;
                    }
                    selector += "</select>";

                    $("#mostrar_centros_coordinador").html(selector);
                },
            });
        }

        function mostrar(fecha, cedula, id_centro) {
            $.ajax({
                url: "{{ route('obtener.datos') }}",
                type: "GET",
                data: {
                    fecha,
                    cedula,
                    id_centro
                },
                dataType: "json",
                success: function(data) {
                    var tableBody = ""; // Variable para almacenar las filas de la tabla
                    data.departamentos.forEach(function(departamento, index) {
                        var departamentos = "";
                        var detalleRows = "";
                        var badera = 1; // Variable para almacenar las filas de detalles
                        data.parametros.forEach(function(parametro) {
                            if (
                                departamento.id_departamento ===
                                parametro.id_departamento
                            ) {
                                detalleRows +=
                                    "<tr>" +
                                    "<td>" +
                                    badera++ +
                                    "</td>" +
                                    '<td class="text-start">' +
                                    parametro.parametros_calificar +
                                    "</td>" +
                                    "<td>" +
                                    parametro.porcentaje_parametro +
                                    "</td>" +
                                    "<td>" +
                                    parametro.porcentaje_pregunta +
                                    "</td>" +
                                    "</tr>";
                            }
                        });
                        if (departamento.id_departamento == "8") {
                            departamentos = "Oncredit";
                        } else if (departamento.id_departamento == "2") {
                            departamentos = "Recursos Humanos";
                        } else {
                            departamentos = departamento.departamento;
                        }
                        tableBody +=
                            '<tr class="fila-expandible" data-toggle="collapse" data-target=".detalle-fila-' +
                            index +
                            ' "style="cursor:pointer;">' +
                            "<td>" +
                            departamentos +
                            "</td>" +
                            "<td>" +
                            departamento.fecha +
                            "</td>" +
                            "<td>" +
                            departamento.porcentaje +
                            "</td>" +
                            "<td>" +
                            departamento.porcentaje_total.toFixed(1) +
                            "</td>" +
                            "</tr>" +
                            '<tr class="collapse detalle-fila-' +
                            index +
                            '">' +
                            '<td colspan="5">' +
                            "<div>" +
                            '<table class="table">' +
                            '<thead class="text-center bg-danger">' +
                            "<tr>" +
                            "<th>ID</th>" +
                            '<th class="col-9">Preguntas departamento de ' +
                            departamentos +
                            "</th>" +
                            '<th class="col-2">Max Puntaje</th>' +
                            "<th>Calificacion</th>" +
                            "</tr>" +
                            "</thead>" +
                            '<tbody class="text-center">' +
                            detalleRows +
                            "</tbody>" +
                            "</table>" +
                            "</div>" +
                            "</td>" +
                            "</tr>";
                    });

                    // Insertar las filas en la tabla de la modales
                    $(".modal-body table tbody").html(tableBody);

                    // // Abrir la modal
                    $("#exampleModal").modal("show");
                },
                error: function(xhr, status, error) {
                    console.error(error);
                },
            });
        }

        function mostrarCentrosEvaluados(cedula, contador) {
            if (contador < 10) {
                contador = 0 + "" + contador;
            }
            let año = document.getElementById("fecha").value;
            var fecha = año + "-" + contador;
            let datos = {
                cedula: cedula,
                mes: contador, // Reemplaza 'valor_del_mes' con el valor del mes que desees enviar
                año: año, // Reemplaza 'valor_del_año' con el valor del año que desees envia
            };
            $.ajax({
                url: "{{ route('obtener.centros') }}",
                type: "GET",
                data: datos,
                success: function(data) {
                    var tabla = document.getElementById("departamentosEvluados");
                    var tbody = tabla.getElementsByTagName("tbody")[0];
                    tbody.innerHTML = "";

                    // Recorrer los datos y agregar filas a la tabla
                    data.forEach(function(fila) {
                        var tr = document.createElement("tr");
                        tr.innerHTML =
                            "<td>" +
                            fila.centro_operacion +
                            "</td>" +
                            "<td>" +
                            fila.suma_porcentaje_total.toFixed(1) +
                            "</td>" +
                            '<td><a role="button" class="ver-detalles" onclick=' +
                            "mostrar('" +
                            fecha +
                            "','" +
                            cedula +
                            "','" +
                            fila.id +
                            "')" +
                            '><i class="fas fa-eye" style="color: #ff0000;"></i></a></td>';
                        tbody.appendChild(tr);
                    });
                },
            });
            $("#modalCentros").modal("show");
        }

        function sumar() {
            let total = 0;
            let porcentajes = parseInt(
                document.getElementById("porcentajes").textContent
            );
            $(`[id*=porcentajeResultado]`).each(function() {
                let n = parseInt($(this).val() | 0);
                total = n + total;
            });
            let porcentaje = (total * porcentajes) / 100;
            $("#sumas").val(porcentaje);
        }

        document.addEventListener("DOMContentLoaded", function() {
            if (document.getElementById("error-alert") !== null) {
                var errorAlert = document.getElementById("error-alert");
                errorAlert.style.display = "block";
                setTimeout(function() {
                    errorAlert.style.display = "none";
                }, 3000);
            }
        });

        document.addEventListener("DOMContentLoaded", function() {
            if (document.getElementById("success-alert") !== null) {
                var errorAlert = document.getElementById("success-alert");
                errorAlert.style.display = "block";
                setTimeout(function() {
                    errorAlert.style.display = "none";
                }, 3000);
            }
        });

        function cerrarSidebar() {
            $(".sidebar-n").css({
                top: "0"
            });
            $(".sidebar-n").css("display", "none");
            $("#sidebar-toggle").toggleClass("active");
            $("body").toggleClass("control-sidebar-slide-open");
        }

        function deleteFormInputs(idFormlario) {
            $(`#${idFormlario}`)
                .closest("form")
                .find("input[type=text], input[type=number], select[id=centro]")
                .val("");
        }

        function evaluacion() {
            let validar = validarFormulario("formulario");
            if (validar) {
                if (!camposEnCero("formulario")) {
                    $.ajax({
                        url: "{{ route('formulario.enviar') }}",
                        type: "POST",
                        data: $("#formulario").serialize(),
                        success: function(data) {
                            deleteFormInputs("formulario");
                            Swal.fire({
                                position: "top-end",
                                icon: data.icono,
                                title: data.mensaje,
                                showConfirmButton: false,
                                timer: 1500,
                                toast: true,
                            });
                        },
                        error: function(xhr, status, error) {
                            var errorMessage = xhr.responseJSON ?
                                xhr.responseJSON.mensaje :
                                error;
                            Swal.fire({
                                position: "top-end",
                                icon: "error",
                                title: errorMessage,
                                showConfirmButton: false,
                                timer: 5000,
                                toast: true,
                            });
                        },
                    });
                } else {
                    Swal.fire({
                        text: "Por favor, complete todos los campos correctamente antes de enviar el formulario.",
                        icon: "warning",
                        showConfirmButton: false,
                        position: "top-end",
                        timer: 5000,
                        toast: true,
                    });
                }
            } else {
                Swal.fire({
                    text: "Complete todo el formulario",
                    icon: "warning",
                    showConfirmButton: false,
                    position: "top-end",
                    timer: 5000,
                    toast: true,
                });
            }
        }

        function camposEnCero(formularioId) {
            let campos = $(
                "#" + formularioId + " input.form-control-sm[type='text'][min='0']"
            );

            let camposEnCero = false;

            campos.each(function() {
                if ($(this).val().trim() === "0") {
                    camposEnCero = true;
                    return false; // Salir del bucle si se encuentra al menos un campo en 0
                }
            });

            return camposEnCero;
        }

        function validarFormulario(id_formulario) {
            var formulario = document.getElementById(id_formulario);
            var elementos = formulario.elements;
            // Itera sobre los elementos del formulario
            for (var i = 0; i < elementos.length; i++) {
                // Verifica si el elemento es un campo de entrada
                if (elementos[i].type !== "submit" && elementos[i].type !== "button") {
                    // Verifica si el campo está vacío
                    if (elementos[i].value === "") {
                        return false;
                    }
                }
            }
            return true;
        }

        function cambiarElemento(elemento) {
            let valorActual = elemento.value;
            $(elemento).val(valorActual.replace(",", "."));
        }

        function buscarHistorial() {
            let fecha = document.getElementById("fecha").value;
            $.ajax({
                url: "{{ route('ver.historialEvaluacion') }}",
                type: "POST",
                data: {
                    fecha: fecha
                },
                success: function(data) {
                    $("#cargarTablaHistorial").html(data);
                },
            });
        }

        $(document).ready(function() {
            buscarHistorial();
        });

        // ---------------historial personal evaluado--------------------

        function abrirModalHistorialCalificado(idDepartamentoEvaluacion) {
            $("#idDepartamentoHistorial").val(idDepartamentoEvaluacion);
            $("#historialCalificado").modal("toggle");
        }

        function historialPersonalEvaluado() {
            let formulario = document.getElementById("historialPersonalEvaluado");
            let formData = new FormData(formulario);
            $.ajax({
                url: "{{ route('historial.Personal.evaluado') }}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $("#tablaHistorialPersonalEvaluado").html(response.tabla);
                },
                error: function(error) {
                    console.log(error);
                },
            });
        }

        // ---------------Historial en años------------------------

        function visualizarTipoDeHistorial(tipo) {
            if (tipo == "1") {
                $("#historialAnual").css("display", "block");
                $("#histoialAños").css("display", "none");
            } else {
                $("#historialAnual").css("display", "none");
                $("#histoialAños").css("display", "block");
            }
        }

        function buscarHistorialAños() {
            let formulario = document.getElementById("historialAños");
            let formData = new FormData(formulario);
            $.ajax({
                url: "{{ route('ver.historialEvaluacion.años') }}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    $("#cargarTablaHistorialAños").html(data);
                },
                erro: function(error) {
                    console.log(error);
                },
            });
        }

        function modalCambioCentroOperacion() {
            $("#coordinador-centro").empty();
            $.ajax({
                url: "{{ route('obtener.coordinadores') }}",
                type: "POST",
                data: {},
                contentType: false,
                processData: false,
                success: function(response) {
                    let coordinadores = response.coordinadores;
                    let selector = document.getElementById("coordinador-centro");
                    let opcionInicial = document.createElement("option");
                    opcionInicial.value = "";
                    opcionInicial.text = "Seleccione un coordinador";
                    opcionInicial.selected = true;
                    selector.add(opcionInicial);
                    coordinadores.forEach(function(opcion) {
                        let opcionElemento = document.createElement("option");
                        opcionElemento.value = opcion.id;
                        opcionElemento.text = opcion.nombre;

                        selector.add(opcionElemento);
                    });
                },
                error: function(error) {
                    console.log(error);
                },
            });
            $("#modalCentroOperaciones").modal("toggle");
        }

        function cerrarModalCambioCentroOperacion() {
            $("#tablaCoordinadorCentro").empty();
            $("#modalCentroOperaciones").modal("toggle");
        }

        function obtenerCentrosOperacionAsignado() {
            let coordinador = document.getElementById("coordinador-centro").value;
            $.ajax({
                url: "{{ route('obtener.centro.coordinadores') }}",
                type: "POST",
                data: {
                    coordinador: coordinador
                },
                success: function(response) {
                    $("#tablaCoordinadorCentro").html(response);
                },
                error: function(error) {
                    console.log(error);
                },
            });
        }

        function cambiarEstadoCentroAsignado(
            checkboxId,
            idCentroAsignado,
            idCoordinador,
            idCentroOperacion
        ) {
            var checkbox = document.getElementById(checkboxId).value;
            let estado = "";
            if (checkbox == "true") {
                document.getElementById(checkboxId).value = false;
                estado = "Deshabilitado";
            } else {
                document.getElementById(checkboxId).value = true;
                estado = "Activo";
            }
            $.ajax({
                url: "{{ route('actualizar.centro.coordinadores') }}",
                type: "POST",
                data: {
                    idCentroAsignado: idCentroAsignado,
                    estado: estado,
                    idCoordinador: idCoordinador,
                    idCentroOperacion: idCentroOperacion,
                },
                success: function(response) {
                    $("#estado" + idCentroAsignado).text(estado);
                    Swal.fire({
                        text: "Se actualizo correctamente",
                        icon: "success",
                        showConfirmButton: false,
                        position: "top-end",
                        timer: 5000,
                        toast: true,
                    });
                },
                error: function(error) {
                    Swal.fire({
                        text: "Error al actualizar el estado",
                        icon: "error",
                        showConfirmButton: false,
                        position: "top-end",
                        timer: 5000,
                        toast: true,
                    });
                },
            });
        }

        function modalAsignacionCentroOperacion() {
            $.ajax({
                url: "{{ route('formulario.asignacion.centro.operacion') }}",
                type: "POST",
                data: {},
                contentType: false,
                processData: false,
                success: function(response) {
                    $("#cargarFormularioAsignacion").html(response.formulario);
                },
                error: function(error) {
                    console.log(error);
                },
            });
            $("#modalAsignacionCentroOperaciones").modal("toggle");
        }

        function cerrarModalAsignacionCentroOperacion() {
            let formulario = document.getElementById("asignarCentroOperacion");
            formulario.reset();
            $("#modalAsignacionCentroOperaciones").modal("toggle");
        }

        function asignarCentroOperacion() {
            let formulario = document.getElementById("asignarCentroOperacion");
            let formData = new FormData(formulario);
            $.ajax({
                url: "{{ route('asignacion.centro.operacion') }}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    Swal.fire({
                        text: "Asiganado Correctamente",
                        icon: "success",
                        showConfirmButton: false,
                        position: "top-end",
                        timer: 5000,
                        toast: true,
                    });
                    formulario.reset();
                    $("#modalAsignacionCentroOperaciones").modal("toggle");
                },
                error: function(error) {
                    Swal.fire({
                        text: "error al actualizar",
                        icon: "error",
                        showConfirmButton: false,
                        position: "top-end",
                        timer: 5000,
                        toast: true,
                    });
                },
            });
        }
    </script>
@endsection
