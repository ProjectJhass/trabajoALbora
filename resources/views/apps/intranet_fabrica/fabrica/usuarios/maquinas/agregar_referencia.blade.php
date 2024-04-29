@extends('apps.intranet_fabrica.layout_fabrica.app')
@section('title')
    Máquinas
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
                    <h5 class="m-0">Agregar nueva máquina</h5>
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
                    Nueva máquina
                </div>
                <div class="card-body">
                    <form id="formulario-registro-nueva-maquina" class="was-validated" autocomplete="off" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="">Referencia</label>
                                    <input type="text" class="form-control" name="referencia" id="referencia" placeholder="Ejm: MQ2034">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="">Nombre de la máquina</label>
                                    <input type="text" class="form-control" name="nombre_maquina" id="nombre_maquina"
                                        placeholder="Ejm: ACOLILLADORA DEWALT">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-success"
                                onclick="AgregarNuevaMaquinaFab('{{ route('agregar.nueva.maq') }}','formulario-registro-nueva-maquina')">Agregar
                                máquina</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
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
