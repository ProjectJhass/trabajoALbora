@extends('apps.intranet.plantilla.app')
@foreach ($datos as $dato)
    @section($dato->departamento)
        bg-danger active
    @endsection
@endforeach
@section('title')
    Formulario evaluación
@endsection
@section('body')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Formulario</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item text-blue">Evaluacion</li>
                        <li class="breadcrumb-item active">Regionales</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    @if (Session::has('success'))
        <div class="d-flex justify-content-center">
            <div class="alert alert-success text-center" style="display: none; width: 50%;" id="success-alert">
                {{ Session::get('success') }}
            </div>
        </div>
    @endif

    @if (Session::has('error'))
        <div class="d-flex justify-content-center">
            <div id="error-alert" class="alert alert-danger text-center" style="display: none; width: 50%;">
                {{ Session::get('error') }}
            </div>
        </div>
    @endif

    <section class="content">
        <div class="container-fluid">
            <div class="row d-flex justify-content-center">
                <div class="col-md-12 mb-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>Formulario De Evaluación</strong>
                        </div>
                        <div class="card-body">
                            <div class="text-center">
                                <div class="col-12 col-md-12 d-flex justify-content-end">
                                    <button type="button" class="btn btn-block btn-info btn-sm col-2"
                                        onclick="abrirModalHistorialCalificado('{{ $idDepartamentoEvaluacion }}')"><i class="fas fa-history"></i>
                                        Historial</button>
                                </div>
                                <form id="formulario" class="was-validated" autocomplete="off">
                                    <div class="row">
                                        <div class="col-4 mt-1 mb-3 text-start">
                                            <label for="">Fecha:</label>
                                            {{-- <input type="month" name="fecha" id="fecha" class="form-control" value="" required> --}}
                                            <input type="text" name="fecha" id="fecha" class="form-control" value="" required>
                                        </div>
                                        <div class="col-4 mt-1 mb-3 text-start">
                                            <label for="">Seleccione coordinador:</label>
                                            <select class="form-select" aria-label="Default select example" name="coordinador" id="coordinador" required
                                                onchange="traerCentrosExperiencia()">
                                                <option value="" selected>Seleccione el Coordinador...</option>
                                                @foreach ($coordinadores as $coordinador)
                                                    <option value="{{ $coordinador->id }}">{{ $coordinador->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-4 mt-1 mb-3 text-start" id="mostrar_centros_coordinador">
                                        </div>
                                    </div>
                                    <table class="table table-hover">
                                        <thead>
                                            <tr class="text-center">
                                                <th class="col-8">PARÁMETROS COORDINADORAS REGIONALES ADMÓN- CARTERA</th>
                                                <th class="col-2">Parametros</th>
                                                <th class="col-2">Puntaje</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $bandera = 0; ?>
                                            @foreach ($datos as $dato)
                                                <tr>
                                                    <?php $bandera++; ?>
                                                    <input type="hidden" value='{{ $dato->departamento_id }}' name="departamento_id{{ $bandera }}"
                                                        id="departamento_id{{ $bandera }}">

                                                    <input type="hidden" value="{{ Auth::user()->id }}" name="usuario{{ $bandera }}">
                                                    <td>
                                                        <input type="hidden" value='{{ $dato->parametro_id }}' name="id_pregunta{{ $bandera }}"
                                                            id="pregunta{{ $bandera }}">
                                                        {{ $dato->parametros_calificar }}
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="hidden" value='{{ $dato->porcentaje_parametro }}'
                                                            id="porcentajePregunta{{ $bandera }}">
                                                        {{ $dato->porcentaje_parametro }}
                                                    </td>
                                                    <td>
                                                        <input class="form-control form-control-sm text-center" required type="text" placeholder="5"
                                                            aria-label=".form-control-sm example" name="porcentajeResultado{{ $bandera }}"
                                                            id="porcentajeResultado{{ $bandera }}" min="0" onchange="sumar(this)"
                                                            oninput="cambiarElemento(this)"
                                                            onkeyup="VerificarPorcentajes({{ $dato->porcentaje_parametro }}, {{ $bandera }})">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot class="text-center">
                                            @php
                                                $ultimoDato = null;
                                            @endphp
                                            @foreach ($datos as $dato)
                                                @php
                                                    $ultimoDato = $dato;
                                                @endphp
                                            @endforeach
                                            <tr>
                                                <th>Total</th>
                                                <th id="porcentajes">{{ $ultimoDato->porcentaje }}</th>
                                                <td>
                                                    <input readonly type="number" class="form-control form-control-sm text-center" id="sumas"
                                                        name="sumas">
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <div class="d-flex justify-content-end">
                                        <button type="button" onclick="evaluacion()" class="btn btn-danger"><i class="fas fa-save"></i>
                                            Guardar
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection

@section('footer')
    <script type="text/javascript">
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
                    document.getElementById("tablaHistorialPersonalEvaluado").innerHTML = response.tabla;
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
    @include('apps.intranet.evaluacionRegional.modalHistorialEvaluacion')
@endsection
