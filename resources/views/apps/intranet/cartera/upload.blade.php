@extends('apps.intranet.plantilla.app')
@section('title')
    Documentación Cartera
@endsection
@section('cartera')
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
                    <h4>Cargue de información digitalización</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item text-blue">Inicio</li>
                        <li class="breadcrumb-item active">Digitalización</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="container" style="width: 40%">
                <div class="card card-outline card-secondary">
                    <div class="card-header">
                        <div class="card-title">
                            <small><strong>Cargue de información digitalización</strong></small>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="formDataDigitalizacion" class="text-center" method="post" enctype="multipart/form-data">
                            @csrf
                            <label for="">Archivo de Excel <small>(.xlsx)</small></label>
                            <input type="file" class="form-control mb-3" onchange="mostrarInformacionExcel()" name="archivo_excel" id="archivo_excel">
                            <button type="button" onclick="cargarInformacionDigitalizacion()" class="btn btn-sm btn-danger"><i class="fas fa-upload"></i>
                                Cargar información</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card card-outline card-danger">
                <div class="card-header">
                    <div class="card-title">
                        Cargue de información digitalización
                    </div>
                </div>
                <div class="card-body" id="infoCargueExcelDigitalizacion">

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
        mostrarInformacionExcel = () => {
            var info = new FormData(document.getElementById("formDataDigitalizacion"));
            info.append('valor', 'valor');
            var datos = $.ajax({
                url: "{{ route('search.dig.excel') }}",
                type: "post",
                dataType: "json",
                data: info,
                cache: false,
                contentType: false,
                processData: false
            });
            datos.done((res) => {
                if (res.status == true) {
                    document.getElementById("infoCargueExcelDigitalizacion").innerHTML = res.table
                    tableFormatter()
                }
            });
        }

        tableFormatter = () => {
            $('#tableInfoCargueDigitalizacion').DataTable({
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

        cargarInformacionDigitalizacion = () => {

            Swal.fire({
                text: "Agregando información...",
                icon: "info",
                showConfirmButton: false,
                position: "top-end",
                timer: 10000,
                toast: true,
            });

            var info = new FormData(document.getElementById("formDataDigitalizacion"));
            info.append('valor', 'valor');
            var datos = $.ajax({
                url: "{{ route('upload.dig.excel') }}",
                type: "post",
                dataType: "json",
                data: info,
                cache: false,
                contentType: false,
                processData: false
            });
            datos.done((res) => {
                if (res.status == true) {
                    Swal.fire({
                        text: res.mensaje,
                        icon: "success",
                        showConfirmButton: false,
                        position: "top-end",
                        timer: 3000,
                        toast: true,
                    });
                    document.getElementById("infoCargueExcelDigitalizacion").innerHTML = res.table
                    tableFormatter()
                }
                if (res.status == false) {
                    Swal.fire({
                        text: res.mensaje,
                        icon: "error",
                        showConfirmButton: false,
                        position: "top-end",
                        timer: 5000,
                        toast: true,
                    });
                }
            });
        }
    </script>
@endsection
