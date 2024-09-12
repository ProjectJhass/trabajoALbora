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
    </script>
@endsection
