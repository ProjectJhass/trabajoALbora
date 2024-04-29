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
@section('fabrica-body')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5 class="m-0">Encuesta de satisfacción</h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Fábrica</a></li>
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
                            <strong>CÓDIGO: RG-TH-06</strong>
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
                        <div class="col-md-4 mb-3">
                            <strong>PROCESO: </strong>
                            @foreach ($proceso as $val)
                                {{ $nom_proceso = $val->nombre_proceso }}
                            @endforeach
                        </div>
                        <div class="col-md-4 mb-3">
                            <strong>SECCIÓN: </strong>
                            @foreach ($seccion as $val)
                                {{ $nom_seccion = $val->nombre_seccion }}
                            @endforeach
                        </div>
                        <div class="col-md-4 mb-3">
                            <strong>FECHA: </strong>{{ date('Y-m-d') }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <strong>NOMBRE: </strong>
                            @foreach ($usuario as $val)
                                {{ $nom_usuario = $val->nombre_usuario }}
                            @endforeach
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-5 mb-3" style="border: 1px solid; border-radius: 15px; margin-left: 5%">
                            <strong>OBJETIVO:</strong>
                            <p style="text-align: justify; font-size: 14px;">
                                MEDIR EL NIVEL DE SATISFACCIÓN DEL PERSONAL INTERNO A FIN DE INDENTIFICAR
                                Y DETERMINAR FORTALEZAS Y DEBILIDADES DE LA EMPRESA CON SUS COLABORADORES
                                DE MANERA QUE AYUDE A GENERAR ESTRATÉGIAS PARA
                                INCREMENTAR SU SATISFACCIÓN Y POR ENDE LA PRODUCTIVIDAD GENERAL.
                            </p>
                        </div>
                        <div class="col-md-1 mb-3"></div>
                        <div class="col-md-5 mb-3" style="border: 1px solid; border-radius: 15px">
                            <strong>INSTRUCCIONES:</strong>
                            <p style="text-align: justify; font-size: 14px;">
                                LEA ATENTAMENTE CADA UNO DE LOS PUNTOS Y CALIFIQUE EL FACTOR MENCIONADO DE 1 A 5,
                                DONDE 1 ES LA CALIFICACIÓN MÁS BAJA Y 5 ES LA CALIFICACIÓN MÁS ALTA, CONFORME A SU
                                PERCEPCIÓN GENERAL DE LA EMPRESA.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" class="was-validated" style="margin-bottom: 8%" id="formulario-respuestas-usuario-encuesta">
                        @csrf
                        <div class="row" hidden>
                            <div class="form-group">
                                <input type="text" class="form-control" value="{{ $nom_proceso }}" name="proceso" id="proceso">
                                <input type="text" class="form-control" value="{{ $nom_seccion }}" name="seccion" id="seccion">
                                <input type="text" class="form-control" value="{{ $nom_usuario }}" name="nombre_u" id="nombre_u">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9 mb-3">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <td>A. ÁREA DE TRABAJO</td>
                                            <td>CALIFICACIÓN</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($preguntas as $key => $value)
                                            @if ($value->orden == 1)
                                                <tr>
                                                    <td>{{ ucfirst($value->pregunta) }}</td>
                                                    <td><input type="text" name="p{{ $value->id_pregunta }}" id="p{{ $value->id_pregunta }}"
                                                            class="form-control" placeholder="Calificación del 1 al 5" required></td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-3 mb-3">
                                <img src="https://www.enginyerscivils.cat/sites/default/files/u6/Areas/cw1.jpg" alt="Equipo" width="100%">
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <img src="https://i.pinimg.com/originals/08/fb/c9/08fbc90c35e671cb086f585368c528b5.gif" alt="Equipo" width="100%">
                            </div>
                            <div class="col-md-9 mb-3">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <td>B. LIDERAZGO</td>
                                            <td>CALIFICACIÓN</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($preguntas as $key => $value)
                                            @if ($value->orden == 2)
                                                <tr>
                                                    <td>{{ ucfirst($value->pregunta) }}</td>
                                                    <td><input type="text" name="p{{ $value->id_pregunta }}" id="p{{ $value->id_pregunta }}"
                                                            class="form-control" placeholder="Calificación del 1 al 5" required></td>
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
                                            <td>C. CLIMA ORGANIZACIONAL</td>
                                            <td>CALIFICACIÓN</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($preguntas as $key => $value)
                                            @if ($value->orden == 3)
                                                <tr>
                                                    <td>{{ ucfirst($value->pregunta) }}</td>
                                                    <td><input type="text" name="p{{ $value->id_pregunta }}" id="p{{ $value->id_pregunta }}"
                                                            class="form-control" placeholder="Calificación del 1 al 5" required></td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-3 mb-3">
                                <img src="https://www.questionpro.com/blog/wp-content/uploads/2021/06/1737-Clima-organizacional_Caracteristicas-e-importancia.jpg"
                                    alt="Equipo" width="100%">
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <img src="http://leanalm360.com/wp-content/uploads/2019/01/clima-laboral1-1073x604-clima-organizacional.jpg"
                                    alt="Equipo" width="100%">
                            </div>
                            <div class="col-md-9 mb-3">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <td>D. CONDICIONES AMBIENTALES</td>
                                            <td>CALIFICACIÓN</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($preguntas as $key => $value)
                                            @if ($value->orden == 4)
                                                <tr>
                                                    <td>{{ ucfirst($value->pregunta) }}</td>
                                                    <td><input type="text" name="p{{ $value->id_pregunta }}" id="p{{ $value->id_pregunta }}"
                                                            class="form-control" placeholder="Calificación del 1 al 5" required></td>
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
                                            <td>E. MEJORA Y MOTIVACIÓN</td>
                                            <td>CALIFICACIÓN</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($preguntas as $key => $value)
                                            @if ($value->orden == 5)
                                                <tr>
                                                    <td>{{ ucfirst($value->pregunta) }}</td>
                                                    <td><input type="text" name="p{{ $value->id_pregunta }}" id="p{{ $value->id_pregunta }}"
                                                            class="form-control" placeholder="Calificación del 1 al 5" required></td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-3 mb-3">
                                <img src="https://elydiazr.files.wordpress.com/2015/05/colab.png" alt="Equipo" width="100%">
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="">
                                        <p style="font-size: 14px">¿Qué actividad de integración sugiere?</p>
                                    </label>
                                    <textarea name="actividad_integracion" id="actividad_integracion" class="form-control" cols="30" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="">
                                        <p style="font-size: 14px">¿Qué habilidad posee (Cantar, Bailar, Jugar... etc)?</p>
                                    </label>
                                    <textarea name="habilidad" id="habilidad" class="form-control" cols="30" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="">
                                        <p style="font-size: 14px">¿Qué mejoras sugiere en la empresa?</p>
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
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Enviando encuesta...');
                    var response = GuardarInformacionEncuesta(form);
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
                }
            })
        }

        GuardarInformacionEncuesta = (form) => {
            var info = new FormData(document.getElementById(form));
            info.append('valor', 'valor');
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
        }
    </script>
@endsection
