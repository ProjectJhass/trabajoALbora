@extends('apps.automoviles.layout.app')
@section('title')
    Comparativos
@endsection
@section('head')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endsection
@section('active-comparativo')
    active
@endsection
@section('body')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5 class="m-0">Comparativo automóviles</h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('albura.autos') }}">Inicio</a></li>
                        <li class="breadcrumb-item active">Comparativos</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-outline card-secondary">
                <div class="card-header">
                    <h6>Información general</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5 mb-3">
                            <div class="card card-outline card-danger">
                                <div class="card-header">
                                    Periodo
                                </div>
                                <div class="card-body">
                                    <form id="form-automoviles-comp" method="post">
                                        @csrf
                                        <div class="form-row align-items-center">
                                            <div class="col-sm-12 mt-3 mb-2">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">Desde</div>
                                                    </div>
                                                    <input type="month" name="fecha_i_com" id="fecha_i_com" class="form-control" min="2022-01"
                                                        id="inlineFormInputGroupUsername" placeholder="Username">
                                                </div>
                                            </div>
                                            <div class="col-sm-12 mt-3 mb-2">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">Hasta</div>
                                                    </div>
                                                    <input type="month" name="fecha_f_com" id="fecha_f_com" class="form-control" min="2022-01"
                                                        id="inlineFormInputGroupUsername" placeholder="Username">
                                                </div>
                                            </div>
                                            <div class="col-sm-auto mt-3">
                                                <button type="button" onclick="ConsultarInfoAutosComp('form-automoviles-comp')"
                                                    class="btn btn-info btn-block">Consultar todos los autos</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-7 mb-3">
                            <div class="card card-outline card-danger">
                                <div class="card-body">
                                    <form class="was-validated">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Automóvil 1</label>
                                                    <select class="form-control" name="auto_1" id="auto_1"
                                                        onchange="BuscarInfoAutoComparativo(this.value, '1')" style="width: 100%;">
                                                        <option value="">Seleccionar...</option>
                                                        @foreach ($autos as $value)
                                                            <option value="{{ $value->row_id }}">{{ $value->placa }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Automóvil 2</label>
                                                    <select class="form-control" name="auto_2" id="auto_2"
                                                        onchange="BuscarInfoAutoComparativo(this.value, '2')" style="width: 100%;">
                                                        <option value="">Seleccionar...</option>
                                                        @foreach ($autos as $val)
                                                            <option value="{{ $val->row_id }}">{{ $val->placa }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Automóvil 3</label>
                                                    <select class="form-control" name="auto_3" id="auto_3"
                                                        onchange="BuscarInfoAutoComparativo(this.value, '3')" style="width: 100%;">
                                                        <option value="">Seleccionar...</option>
                                                        @foreach ($autos as $item)
                                                            <option value="{{ $item->row_id }}">{{ $item->placa }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card card-outline card-danger">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">

                                    <div id="automovil_1"></div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div id="automovil_2"></div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div id="automovil_3"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card card-outline card-danger">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <div id="informacion-general-autos"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
@section('footer')
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(() => {
            $('.autos_1').select2();
            $('.select2').select2();
            $('.select3').select2();
        });

        CargueInformacionGeneral = () => {
            $('#table-reporte-placas-general').DataTable({
                "oLanguage": {
                    "sSearch": "Buscar:",
                    "sInfo": "Mostrando de _START_ a _END_ de _TOTAL_ registros",
                    "oPaginate": {
                        "sPrevious": "Volver",
                        "sNext": "Siguiente"
                    },
                    "sEmptyTable": "No se encontró ningun registro en la base de datos",
                    "sZeroRecords": "No se encontraron resultados...",
                    "sLengthMenu": "Mostrar _MENU_ registros"
                },
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        }

        BuscarInfoAutoComparativo = (placa, id) => {
            var fecha_i = $('#fecha_i_com').val();
            var fecha_f = $('#fecha_f_com').val();

            var datos = $.ajax({
                type: 'post',
                url: "{{ route('search.info.auto') }}",
                dataType: "json",
                data: {
                    placa,
                    fecha_i: fecha_i,
                    fecha_f: fecha_f
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            datos.done((res) => {
                if (res.status == true) {
                    document.getElementById('automovil_' + id).innerHTML = res.informacion;
                }
            });
            datos.fail(() => {});
        }

        NotificacionAlert = (tipo, mensaje, tiempo) => {
            Swal.fire({
                position: 'top-end',
                icon: tipo,
                title: mensaje,
                showConfirmButton: false,
                timer: tiempo
            });
        }

        ConsultarInfoAutosComp = (form) => {

            NotificacionAlert('info', 'Buscando informacion...', 20000);

            var formData = new FormData(document.getElementById(form));
            formData.append('dato', 'valor');
            var datos = $.ajax({
                url: window.location.href,
                type: "POST",
                dataType: "json",
                data: formData,
                cache: false,
                contentType: false,
                processData: false
            });

            datos.done((res) => {
                if (res.status == true) {
                    NotificacionAlert('success', 'Información encontrada', 1000);
                    document.getElementById('informacion-general-autos').innerHTML = res.data;
                    CargueInformacionGeneral();
                }
            });
            datos.fail(() => {
                NotificacionAlert('error', 'Hubo un problema al procesar la petición', 1500);
            });
        }
    </script>
@endsection
