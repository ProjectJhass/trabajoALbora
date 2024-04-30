@extends('apps.intranet_fabrica.layout_fabrica.app')
@section('title')
    Máquinas
@endsection
@section('tables-bootstrap-css')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endsection
@section('menu-usuarios')
    menu-open
@endsection
@section('active-usuarios')
    bg-danger active
@endsection
@section('active-sub-maquinas')
    active
@endsection
@section('fabrica-body')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5 class="m-0">Máquinas activas</h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home.intranet.fabrica') }}">Fábrica</a></li>
                        <li class="breadcrumb-item active">Máquinas</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-outline card-danger">
                <div class="card-header">
                    <strong>Máquinas</strong>
                    <div class="card-tools">
                        <a href="{{ route('agregar.maquina.fab') }}" class="btn btn-success btn-sm">Agregar máquina</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm" id="TableMaquinasActivasFab">
                            <thead style="background-color: rgb(177, 5, 5); color: white">
                                <tr class="text-center">
                                    <td>#</td>
                                    <td>Referencia</td>
                                    <td>Nombre máquina</td>
                                    <td>Acción</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($maquinas as $item)
                                    <tr>
                                        <td>{{ $item->id_maquina }}</td>
                                        <td>{{ $item->referencia }}</td>
                                        <td>{{ $item->nombre_maquina }}</td>
                                        <td class="text-center">
                                            <button class="btn btn-danger btn-sm"
                                                onclick="EliminarMaquinaFabrica('{{ $item->id_maquina }}','{{ route('eliminar.maquina') }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script>
        $(function() {
            $('#TableMaquinasActivasFab').DataTable({
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
                    [0, "asc"]
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "responsive": true,
            });
        });

        AgregarNuevaMaquinaFab = (url, form) => {
            Swal.fire({
                title: 'Seguro de crear esta máquina?',
                text: "No podrás reversar esta operación!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, crear',
                cancelButtonText: 'No, cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    var response = CrearNuevaMaquinaFabricaAlbura(url, form);
                    response.done((res) => {
                        if (res.status == true) {
                            document.getElementById(form).reset();
                            Swal.fire(
                                'EXCELENTE!',
                                'La máquina fue creada exitosamente',
                                'success'
                            )
                        }
                    });
                    response.fail(() => {
                        Swal.fire(
                            'ERROR!',
                            'Hubo un problema al procesar la solicitud',
                            'error'
                        )
                    });
                }
            })
        }

        CrearNuevaMaquinaFabricaAlbura = (url, form) => {
            var info = new FormData(document.getElementById(form));
            info.append('valor', 'valor');
            var datos = $.ajax({
                url: url,
                type: "post",
                dataType: "json",
                data: info,
                cache: false,
                contentType: false,
                processData: false
            });
            return datos;
        }

        EliminarMaquinaFabrica = (id_maquina, url) => {
            Swal.fire({
                title: 'Seguro de eliminar esta máquina?',
                text: "No podrás reversar esta operación!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar',
                cancelButtonText: 'No, cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    var response = ConfirmarElilminacionDeMaquina(id_maquina, url);
                    response.done((res) => {
                        if (res.status == true) {
                            Swal.fire(
                                'EXCELENTE!',
                                'La máquina fue eliminada exitosamente',
                                'success'
                            )
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        }
                    });
                    response.fail(() => {
                        Swal.fire(
                            'ERROR!',
                            'Hubo un problema al procesar la solicitud',
                            'error'
                        )
                    });
                }
            })
        }

        ConfirmarElilminacionDeMaquina = (id_maquina, url) => {
            var datos = $.ajax({
                type: "POST",
                url: url,
                dataType: "json",
                data: {
                    id_maquina
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            return datos;
        }
    </script>
@endsection
