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
                <div class="card-body">
                    <form action="" class="was-validated">
                        @csrf
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="">PROCESO</label>
                                    <select name="proceso-fabrica-enc" onchange="ObtenerSeccionesFab(this.value)" id="proceso-fabrica-enc"
                                        class="form-control">
                                        <option value="">Seleccionar...</option>
                                        @foreach ($procesos as $key => $value)
                                            <option value="{{ $value->id_proceso }}">{{ $value->nombre_proceso }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="">SECCIÓN</label>
                                    <select name="seccion-fabrica-enc" id="seccion-fabrica-enc" class="form-control">
                                        <option value="">Seleccionar...</option>
                                    </select>
                                </div>
                            </div>
                            {{-- <div class="col-md-4 mb-3" hidden>
                                <div class="form-group">
                                    <label for="">CÉDULA</label>
                                    <input type="number" class="form-control" name="cedula-user-enc" id="cedula-user-enc" placeholder="Número de cédula">
                                </div>
                            </div> --}}
                            <div class="col-md-4 mb-3 d-flex justify-content-center align-self-center">
                                {{-- <div class="d-flex justify-content-center align-self-center"> --}}
                                    <button type="button" class="btn btn-outline-danger" onclick="RealizarEncuestaSatisfaccionFab('{{ url('/intranet_fabrica/realizar-encuesta-satisfaccion') }}')">Realizar encuesta</button>
                                {{-- </div> --}}
                            </div>
                        </div>
                    </form>
                    <br>
                    <div id="mensaje-de-notificacion-response"></div>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-outline card-danger">
                <div class="card-header">
                    <div class="d-flex justify-content-center">
                        <h4>REVISAR PONDERACIÓN</h4>
                    </div>
                </div>
                <div class="card-body">
                    <form action="" id="frm_review_ponderacion_" class="was-validated">
                        @csrf
                        <div class="row d-flex justify-content-around">
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="">CODIGO DE ACCESO</label>
                                    <input type="text" name="code_fabrica_admin" id="code_fabrica_admin" class="form-control" required />
                                </div>
                            </div>

                            <div class="col-md-4 mb-3 d-flex justify-content-center align-self-center">
                                <button type="button" class="btn btn-outline-secondary" onclick="RevisarPonderacionEncuestasSatisfaccion('{{ url('/intranet_fabrica/realizar-encuesta-satisfaccion') }}')">Revisar ponderación</button>
                            </div>
                        </div>
                    </form>
                    <br>
                    <div id="review-filter-ponderacion-total"></div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script>

        RealizarEncuestaSatisfaccionFab = (url) => {
            var proceso = $('#proceso-fabrica-enc').val();
            var seccion = $('#seccion-fabrica-enc').val();
            // console.log(url + "/" + proceso + "/" + seccion);
            document.location.href = url + "/" + proceso + "/" + seccion;
        }

        ObtenerSeccionesFab = (valor, url) => {
            var datos = $.ajax({
                type: "POST",
                url: "{{ route('secciones.fabrica') }}",
                dataType: "json",
                data: {
                    id_proceso: valor
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            datos.done((res) => {
                if (res.status == true) {
                    document.getElementById('seccion-fabrica-enc').innerHTML = res.data;
                }
            });
            datos.fail(() => {
                toastr.error('Hubo un problema al procesar la informacion');
            });
        }

        const RevisarPonderacionEncuestasSatisfaccion = () => {
            let formData = new FormData(document.getElementById('frm_review_ponderacion_'));

            $.ajax({
                type: "POST",
                url: "{{ route('intranet_fabrica.encuestas_satisfaccion_ponderacion.filters') }}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    $('#review-filter-ponderacion-total').html(response.view_filter_ponderacion);
                    console.log(response)
                }, error: (jqXHR, textStatus, errorThrown) => {
                    $('#review-filter-ponderacion-total').html("");
                    if(jqXHR.status == "403") {
                        toastr.error('Acceso no valido!');
                    } else {
                        toastr.error('No se pudo completar la solicitud, contacte a sistemas!');
                    }
                }
            });
        }

        const load_ponderacion_filters = (frm) => {
            let formData = new FormData(document.getElementById(frm));

            $.ajax({
                type: "POST",
                url: "{{ route('intranet_fabrica.encuestas_satisfaccion_ponderacion.get') }}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    $('#load_ponderacion_encuesta_satisfaccion').html(response.view_data_ponderacion);
                    console.log(response)
                }, error: (jqXHR, textStatus, errorThrown) => {
                    $('#load_ponderacion_encuesta_satisfaccion').html("");
                    console.log(jqXHR);
                    if(jqXHR.status == "400") {
                        toastr.error('Por favor, llenar los datos de fechas para visualizar la ponderación!');
                    }
                }
            });
        }
    </script>
@endsection
