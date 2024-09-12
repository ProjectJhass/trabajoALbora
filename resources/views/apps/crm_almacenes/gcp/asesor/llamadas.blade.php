@extends('apps.crm_almacenes.gcp.plantilla.app')
@section('title')
    Llamadas pendientes
@endsection
@section('header')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endsection
@section('llamadas')
    active
@endsection
@section('contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Llamadas pendientes</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item text-blue">CRM</li>
                        <li class="breadcrumb-item active">Llamadas pendientes</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-outline card-danger">
                <div class="card-header">
                    Llamadas a realizar
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-sm" id="table-informacion-llamadas-pendientes">
                        <thead>
                            <tr class="text-center" style="background-color: #c22121; color: white;">
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Fecha</th>
                                <th>Celular</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($llamadas as $item)
                                <?php $text = $item->fecha_a_llamar < date('Y-m-d') ? 'text-danger' : ''; ?>
                                <tr id="infoLlamada{{ $item->id_llamada }}" class="{{ $text }}">
                                    <td>{{ $item->id_llamada }}</td>
                                    <td class="text-left">
                                        {{ $item->nombre_1 . ' ' . $item->nombre_2 . ' ' . $item->apellido_1 . ' ' . $item->apellido_2 }}
                                    </td>
                                    <td>{{ $item->fecha_a_llamar }}</td>
                                    <td>{{ $item->celular_1 . ' - ' . $item->celular_2 }}</td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <button type="button" class="btn btn-secondary"
                                                onclick="AgregarComentariosSeguimiento('{{ $item->id_cliente }}', '{{ $item->id_llamada }}')"><i
                                                    class="fas fa-headset"></i></button>
                                            <button type="button" class="btn btn-info"
                                                onclick="VisualizarProductosCliente('{{ $item->id_cliente }}')"><i
                                                    class="fas fa-shopping-cart"></i></button>
                                            <button type="button" class="btn btn-warning"
                                                onclick="VisualizarCometariosCliente('{{ $item->id_cliente }}')"><i
                                                    class="fas fa-comments"></i></button>
                                            <a href="{{ route('asesor.whatsapp', ['celular' => empty($item->celular_1) ? 1 : $item->celular_1]) }}"
                                                target="_BLANK" type="button" class="btn btn-success"><i
                                                    class="fab fa-whatsapp"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>


    {{-- Modal visualizacion de comentarios realizados al cliente --}}

    <div class="modal fade" id="historial-comentarios-seguimiento">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #c22121; color: white;">
                    <h5 class="modal-title">Comentarios</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="comentarios-realizados-cliente-almacen">
                    </div>
                </div>
                <div class="modal-footer left-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar información</button>
                </div>
            </div>
        </div>
    </div>


    {{-- Modal visualización de información de los productos cotizados --}}

    <div class="modal fade" id="informacion-productos-cotizados">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #c22121; color: white;">
                    <h5 class="modal-title">Productos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="informacion-productos-cotizados-cliente"></div>
                    <div style="margin-left: 35%; margin-right: 35%;">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon3"><strong>Valor a pagar</strong></span>
                            </div>
                            <input type="text" class="form-control" id="valor_a_pagar" aria-describedby="basic-addon3"
                                disabled>
                        </div>
                    </div>
                </div>
                <div class="modal-footer left-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar información</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal agregar seguimiento cliente crm --}}

    <div class="modal fade" id="agregar-informacion-seguimiento-llamada">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #c22121; color: white;">
                    <h5 class="modal-title">Agregar seguimiento de llamada</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="was-validated" id="formulario-actulizar-seguimiento-crm">
                        @csrf
                        <input type="text" hidden name="id_cliente_crm" id="id_cliente_crm">
                        <input type="text" hidden name="id_llamada_crm" id="id_llamada_crm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Asesor</div>
                                    </div>
                                    <input type="text" class="form-control" value="{{ Auth::user()->nombre }}"
                                        id="inlineFormInputGroup" placeholder="Asesor" disabled>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Estado de la llamada</div>
                                    </div>
                                    <input type="text" class="form-control" value="PENDIENTE"
                                        id="inlineFormInputGroup" placeholder="Estado" disabled>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <textarea name="comentario_seguimiento" id="comentario_seguimiento" class="form-control" cols="30"
                                    rows="3" placeholder="Seguimiento realizado" required></textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Próxima llamada</div>
                                    </div>
                                    <input type="date" class="form-control" id="fecha_proxima_llamada"
                                        name="fecha_proxima_llamada">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer left-content-between">
                    <button type="button" class="btn btn-success"
                        onclick="AgregarInformacionSeguimientoLlamada('formulario-actulizar-seguimiento-crm')">Actualizar
                        seguimiento</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar información</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(function() {
            $('#table-informacion-llamadas-pendientes').DataTable({
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
                    [2, "asc"]
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "responsive": false,
            });
        });

        VisualizarCometariosCliente = (id_cliente) => {
            $('#historial-comentarios-seguimiento').modal('show');
            document.getElementById('comentarios-realizados-cliente-almacen').innerHTML = "";
            Swal.fire({
                position: 'top',
                icon: 'info',
                toast: true,
                title: 'Cargando comentarios.',
                showConfirmButton: false,
                timer: 10000
            })
            var datos = $.ajax({
                url: "{{ route('comentarios.asesores') }}",
                type: "POST",
                dataType: "json",
                data: {
                    id_usuario: id_cliente
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            datos.done((res) => {
                if (res.status == true) {
                    Swal.fire({
                        position: 'top',
                        icon: 'success',
                        toast: true,
                        title: 'Comentarios cargados.',
                        showConfirmButton: false,
                        timer: 2000
                    })
                    document.getElementById('comentarios-realizados-cliente-almacen').innerHTML = res
                        .comentarios
                }
            });
            datos.fail(() => {
                document.getElementById('comentarios-realizados-cliente-almacen').innerHTML = "";
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Hubo un problema al procesar la solicitud',
                    showConfirmButton: false,
                    timer: 1500
                })
            });
        }

        AgregarComentariosSeguimiento = (id_cliente, id_llamada) => {
            $('#agregar-informacion-seguimiento-llamada').modal('show');
            $('#id_cliente_crm').val(id_cliente);
            $('#id_llamada_crm').val(id_llamada);
        }

        AgregarInformacionSeguimientoLlamada = (form) => {
            var formData = new FormData(document.getElementById(form));
            var id_llamada = $('#id_llamada_crm').val();

            formData.append('dato', 'valor');
            var datos = $.ajax({
                url: "{{ route('add.seguimiento.crm') }}",
                type: "POST",
                dataType: "json",
                data: formData,
                cache: false,
                contentType: false,
                processData: false
            });
            datos.done((res) => {
                if (res.status == true) {
                    $('#agregar-informacion-seguimiento-llamada').modal('hide');
                    $('#comentario_seguimiento').val('');
                    $('#fecha_proxima_llamada').val('');
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Seguimiento agregado exitosamente',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    document.getElementById('infoLlamada' + id_llamada).hidden = true;
                }
            })
            datos.fail(() => {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Revisa la información y vuelve a intentar',
                    showConfirmButton: false,
                    timer: 1500
                })
            })
        }
    </script>
@endsection
