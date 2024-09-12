@extends('apps.intranet_fabrica.layout_fabrica.app')
@section('title')
    Encuesta satisfacción
@endsection

@section('menu-calidad')
    menu-open
@endsection

@section('active-calidad')
    bg-danger active
@endsection

@section('active-sub-encuesta')
    active
@endsection

@section('tables-bootstrap-css')
    <style>
        .input-group-text input[type="checkbox"] {
            width: 100%;
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            transform: scale(2);
        }
    </style>
@endsection

@section('fabrica-body')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5 class="m-0">Encuesta de satisfacción</h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home.intranet.fabrica') }}">Fábrica</a></li>
                        <li class="breadcrumb-item active">Encuesta de satisfacción</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-outline card-danger">
                <div class="card-header">
                    <div class="row text-center">
                        <div class="col-md-6 mb-3" style="border: 1px solid; border-radius: 12px;">
                            <img src="{{ asset('img/BLANCO.png') }}" width="50%" alt="">
                        </div>
                        <div class="col-md-6 mb-3" style="border: 1px solid; border-radius: 12px;">
                            <h5><strong>ENCUESTA DE SATISFACCIÓN DEL CLIENTE <br> INTERNO</strong></h5>
                        </div>
                        <div class="col-md-4" style="border: 1px solid; border-radius: 12px;">
                            <strong>CÓDIGO: RG-TH-07</strong>
                        </div>
                        <div class="col-md-4" style="border: 1px solid; border-radius: 12px;">
                            <strong>VERSIÓN: 06</strong>
                        </div>
                        <div class="col-md-4" style="border: 1px solid; border-radius: 12px;">
                            <strong>PÁGINA: 1</strong>
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 d-flex justify-content-center">
                            <strong class="pr-5">PROCESO: </strong>
                            @foreach ($proceso as $val)
                                {{ $nom_proceso = $val->nombre_proceso }}
                            @endforeach
                        </div>
                        <div class="col-md-6 mb-3 d-flex justify-content-center">
                            <strong class="pr-5">SECCIÓN: </strong>
                            @foreach ($seccion as $val)
                                {{ $nom_seccion = $val->nombre_seccion }}
                            @endforeach
                        </div>
                    </div>
                    <div class="container mt-4">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <b>Tiempo que lleva en la empresa:</b>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="input-group">
                                    <div class="input-group-text">
                                        <input type="checkbox" class="checkbox-toggle-disable" value="Menos de 1 año">
                                    </div>
                                    <input type="text" class="form-control bg-light text-center" value="Menos de 1 año"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="input-group">
                                    <div class="input-group-text">
                                        <input type="checkbox" class="checkbox-toggle-disable" value="Entre 1 y 5 años">
                                    </div>
                                    <input type="text" class="form-control bg-light text-center" value="Entre 1 y 5 años"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="input-group">
                                    <div class="input-group-text">
                                        <input type="checkbox" class="checkbox-toggle-disable" value="5 años en adelante">
                                    </div>
                                    <input type="text" class="form-control bg-light text-center"
                                        value="5 años en adelante" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-4 mb-3 d-flex justify-content-center">
                            <strong class="pr-5">FECHA: </strong>{{ date('Y-m-d') }}
                        </div>
                    </div>
                    <hr>
                    <div class="row d-flex">
                        <div class="col-md-5 mb-3" style="border: 1px solid; border-radius: 15px; margin-left: 5%">
                            <strong>OBJETIVO:</strong>
                            <p style="text-align: justify; font-size: 14px;">
                                Medir el nivel de satisfacción del personal interno con el fin de identificar y determinar
                                fortalezas y debilidades de la empresa para sus colaboradores de manera que ayude
                                a generar estrategias para incrementar su satisfacción y por ende la productividad general.
                            </p>
                        </div>
                        <div class="col-md-1 mb-3"></div>
                        <div class="col-md-5 mb-3" style="border: 1px solid; border-radius: 15px">
                            <strong>INSTRUCCIONES:</strong>
                            <p style="text-align: justify; font-size: 14px;">
                                Lea atentamente cada uno de los puntos y califique el factor mencionado de 1 a 5, donde 1 es
                                la calificación más baja y 5 es la calificación mas alta,
                                conforme a sus perserción general de la empresa.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" class="was-validated" style="margin-bottom: 8%"
                        id="formulario-respuestas-usuario-encuesta">
                        @csrf
                        <div class="row" hidden>
                            <div class="form-group">
                                <input type="text" class="form-control" value="{{ $nom_proceso }}" name="proceso"
                                    id="proceso">
                                <input type="text" class="form-control" value="{{ $nom_seccion }}" name="seccion"
                                    id="seccion">
                            </div>
                        </div>
                        <div class="d-flex justify-content-center pb-4">
                            <strong>FACTORES A EVALUAR</strong>
                        </div>
                        <div class="row">
                            <div class="col-md-9 mb-3">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <td><b>ÁREA DE TRABAJO</b></td>
                                            <td><b>CALIFICACIÓN</b></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($preguntas as $key => $value)
                                            @if ($value->orden == 1)
                                                <tr>
                                                    <td>{{ ucfirst($value->pregunta) }}</td>
                                                    <td><input type="text" name="p{{ $value->id_pregunta }}"
                                                            id="p{{ $value->id_pregunta }}"
                                                            class="form-control input-toggle-validation"
                                                            placeholder="Calificación del 1 al 5" required></td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-3 mb-3 d-flex align-items-center">
                                <img src="https://app-mueblesalbura.com/plataformas_web/public/storage/documentacion-sgc/AREA_DE_TRABAJO.jpeg"
                                    alt="Área de trabajo" width="100%">
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-3 mb-3 d-flex align-items-center">
                                <img src="https://app-mueblesalbura.com/plataformas_web/public/storage/documentacion-sgc/COMUNICACION.jpg"
                                    alt="Equipo" width="100%">
                            </div>
                            <div class="col-md-9 mb-3">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <td><b>COMUNICACIÓN</b></td>
                                            <td><b>CALIFICACIÓN</b></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($preguntas as $key => $value)
                                            @if ($value->orden == 2)
                                                <tr>
                                                    <td>{{ ucfirst($value->pregunta) }}</td>
                                                    <td><input type="text" name="p{{ $value->id_pregunta }}"
                                                            id="p{{ $value->id_pregunta }}"
                                                            class="form-control input-toggle-validation"
                                                            placeholder="Calificación del 1 al 5" required></td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-9 mb-3">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <td><b>LIDERAZGO</b></td>
                                            <td><b>CALIFICACIÓN</b></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($preguntas as $key => $value)
                                            @if ($value->orden == 3)
                                                <tr>
                                                    <td>{{ ucfirst($value->pregunta) }}</td>
                                                    <td><input type="text" name="p{{ $value->id_pregunta }}"
                                                            id="p{{ $value->id_pregunta }}"
                                                            class="form-control input-toggle-validation"
                                                            placeholder="Calificación del 1 al 5" required></td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-3 mb-3 d-flex align-items-center">
                                <img src="https://app-mueblesalbura.com/plataformas_web/public/storage/documentacion-sgc/LIDERAZGO.jpg"
                                    alt="Equipo" width="100%">
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-3 mb-3 d-flex align-items-center">
                                <img src="https://app-mueblesalbura.com/plataformas_web/public/storage/documentacion-sgc/TRABAJO_EN_EQUIPO.jpeg"
                                    alt="Equipo" width="100%">
                            </div>
                            <div class="col-md-9 mb-3">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <td><b>TRABAJO EN EQUIPO</b></td>
                                            <td><b>CALIFICACIÓN</b></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($preguntas as $key => $value)
                                            @if ($value->orden == 4)
                                                <tr>
                                                    <td>{{ ucfirst($value->pregunta) }}</td>
                                                    <td><input type="text" name="p{{ $value->id_pregunta }}"
                                                            id="p{{ $value->id_pregunta }}"
                                                            class="form-control input-toggle-validation"
                                                            placeholder="Calificación del 1 al 5" required></td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-9 mb-3">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <td><b>CONDICIONES AMBIENTALES</b></td>
                                            <td><b>CALIFICACIÓN</b></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($preguntas as $key => $value)
                                            @if ($value->orden == 5)
                                                <tr>
                                                    <td>{{ ucfirst($value->pregunta) }}</td>
                                                    <td><input type="text" name="p{{ $value->id_pregunta }}"
                                                            id="p{{ $value->id_pregunta }}"
                                                            class="form-control input-toggle-validation"
                                                            placeholder="Calificación del 1 al 5" required></td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-3 mb-3 d-flex align-items-center">
                                <img src="https://app-mueblesalbura.com/plataformas_web/public/storage/documentacion-sgc/CONDICIONES_AMBIENTALES.jpeg"
                                    alt="Equipo" width="100%">
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-3 mb-3 d-flex align-items-center">
                                <img src="https://app-mueblesalbura.com/plataformas_web/public/storage/documentacion-sgc/MOTIVACION_Y_ETICA_EMPRESARIAL.jpeg"
                                    alt="Equipo" width="100%">
                            </div>
                            <div class="col-md-9 mb-3">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <td><b>MOTIVACIÓN Y ÉTICA EMPRESARIAL</b></td>
                                            <td><b>CALIFICACIÓN</b></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($preguntas as $key => $value)
                                            @if ($value->orden == 6)
                                                <tr>
                                                    <td>{{ ucfirst($value->pregunta) }}</td>
                                                    <td><input type="text" name="p{{ $value->id_pregunta }}"
                                                            id="p{{ $value->id_pregunta }}"
                                                            class="form-control input-toggle-validation"
                                                            placeholder="Calificación del 1 al 5" required></td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <div class="form-group">
                                    <label for="">
                                        <p style="font-size: 14px">¿Esta dispuesto a participar en actividades de
                                            integración en horarios adicionales?</p>
                                    </label>
                                    <textarea name="actividad_participacion" id="actividad_participacion" class="form-control" cols="30"
                                        rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="form-group">
                                    <label for="">
                                        <p style="font-size: 14px">¿Qué actividades de integración sugiere?</p>
                                    </label>
                                    <textarea name="actividad_integracion" id="actividad_integracion" class="form-control" cols="30"
                                        rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="form-group">
                                    <label for="">
                                        <p style="font-size: 14px">¿Qué habilidades posee (cantar, bailar, jugar, etc.)?
                                        </p>
                                    </label>
                                    <textarea name="habilidad" id="habilidad" class="form-control" cols="30" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="form-group">
                                    <label for="">
                                        <p style="font-size: 14px">¿Qué mejores sugiere para la empresa?</p>
                                    </label>
                                    <textarea name="mejoras" id="mejoras" class="form-control" cols="30" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                        <center>
                            <button type="button" class="btn btn-danger" id="btn-enviar-y-terminar-encuesta"
                                onclick="ValidarRespuestasEncuesta('formulario-respuestas-usuario-encuesta')">
                                Terminar y enviar encuesta</button>
                        </center>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script>
        let selectedCheckboxValue = null;

        const setupCheckboxToggle = (className) => {
            const checkboxes = document.querySelectorAll(`.${className}`);

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', () => {
                    if (checkbox.checked) {
                        selectedCheckboxValue = checkbox
                            .value; // Almacena el valor del checkbox seleccionado
                        checkboxes.forEach(cb => {
                            if (cb !== checkbox) {
                                cb.checked = false;
                            }
                        });
                    } else if (selectedCheckboxValue === checkbox.value) {
                        selectedCheckboxValue =
                            null;
                    }
                });
            });
        };

        setupInputValidation = (className) => {
            const inputs = document.querySelectorAll(`.${className}`);
            const inputArray = Array.from(inputs);

            inputArray.forEach((input, index) => {
                input.addEventListener('input', () => {
                    const value = parseInt(input.value, 10);
                    if (value != '') {
                        if (value < 1 || value > 5 || isNaN(value)) {
                            input.value = '';
                        } else {
                            const nextIndex = index + 1;
                            if (nextIndex < inputArray.length) {
                                inputArray[nextIndex].focus();
                            }
                        }
                    }
                });

                input.addEventListener('blur', () => {
                    if (input.value === '') {
                        const prevIndex = inputArray.indexOf(input) - 1;
                        if (prevIndex >= 0) {
                            inputArray[prevIndex].focus();
                        }
                    }
                });
            });
        };

        setupInputValidation('input-toggle-validation');
        setupCheckboxToggle('checkbox-toggle-disable')



        RealizarEncuestaSatisfaccion = (url) => {
            var proceso = $('#proceso-fabrica-enc').val();
            var seccion = $('#seccion-fabrica-enc').val();
            var cedula = $('#cedula-user-enc').val();
            document.location.href = url + "/" + proceso + "/" + seccion + "/" + cedula;
        }

        ValidarRespuestasEncuesta = (form) => {
            Swal.fire({
                title: 'Seguro de terminar?',
                text: "No podrás reversar esta operación!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, terminar',
                cancelButtonText: 'No, cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#btn-enviar-y-terminar-encuesta').prop('disabled', true);
                    $('#btn-enviar-y-terminar-encuesta').html(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Enviando encuesta...'
                    );
                    var response = GuardarInformacionEncuesta(form);

                    if (response != undefined) {
                        response.done((res) => {
                            if (res.status == true) {
                                document.getElementById(form).reset();
                                $('#btn-enviar-y-terminar-encuesta').prop('disabled', false);
                                $('#btn-enviar-y-terminar-encuesta').html('Terminar y enviar encuesta');
                                Swal.fire(
                                    'EXCELENTE!',
                                    'La encuesta fue enviada correctamente',
                                    'success'
                                )
                            }
                        });
                        response.fail(() => {
                            $('#btn-enviar-y-terminar-encuesta').prop('disabled', false);
                            $('#btn-enviar-y-terminar-encuesta').html('Terminar y enviar encuesta');
                            Swal.fire(
                                'ERROR!',
                                'Hubo un problema al procesar la solicitud',
                                'error'
                            )
                        });
                    } else {
                        $('#btn-enviar-y-terminar-encuesta').prop('disabled', false);
                        $('#btn-enviar-y-terminar-encuesta').html('Terminar y enviar encuesta');
                    }

                }
            })
        }

        GuardarInformacionEncuesta = (form) => {
            var info = new FormData(document.getElementById(form));

            if (selectedCheckboxValue) {
                info.append('tiempo_en_empresa', selectedCheckboxValue);
                var datos = $.ajax({
                    url: "{{ route('guardar.encuesta') }}",
                    type: "post",
                    dataType: "json",
                    data: info,
                    cache: false,
                    contentType: false,
                    processData: false
                });

                return datos;
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Debes seleccionar el tiempo que llevas en la empresa',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 6000
                })
            }

        };
    </script>
@endsection
