@extends('apps.intranet.plantilla.app')
@section('title')
    Bitácora
@endsection
@section('head')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endsection
@section('bitacora')
    bg-danger active
@endsection
@section('body')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Historial de proyectos</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item text-blue">Inicio</li>
                        <li class="breadcrumb-item active">Bitácora</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <center>
                <div class="btn-group mb-4" role="group" aria-label="Basic example">
                    <button type="button" onclick="buscarInfoBitacora('creada')" class="btn btn-danger"><i class="fas fa-hourglass-start"></i>
                        Creados</button>
                    <button type="button" onclick="buscarInfoBitacora('En proceso')" class="btn btn-info"><i class="fas fa-spinner"></i> En
                        proceso</button>
                    <button type="button" onclick="buscarInfoBitacora('Completado')" class="btn btn-success"><i class="far fa-calendar-check"></i>
                        Completados</button>
                </div>
            </center>

            <div class="card card-outline card-secondary" id="infoProyectosBitacora">
                {!! $table !!}
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
        $(document).ready(() => {
            tableFormatter()
        })

        tableFormatter = () => {
            $('#proyectsBitacora').DataTable({
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
                "order": [
                    [0, "desc"]
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "responsive": false,
            });
        }

        buscarInfoBitacora = (estado) => {
            var datos = $.ajax({
                type: 'POST',
                url: "{{ route('search.admin.solicitudes') }}",
                dataType: 'json',
                data: {
                    estado
                }
            })
            datos.done(function(respuesta) {
                if (respuesta.status == true) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Información encontrada',
                        showConfirmButton: false,
                        timer: '2000',
                        toast: true
                    })
                    document.getElementById('infoProyectosBitacora').innerHTML = respuesta.table
                    tableFormatter()
                }
            })
            datos.fail(() => {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Hubo un problema de conexión',
                    showConfirmButton: false,
                    timer: '2000',
                    toast: true
                })
            })
        }
    </script>
@endsection
