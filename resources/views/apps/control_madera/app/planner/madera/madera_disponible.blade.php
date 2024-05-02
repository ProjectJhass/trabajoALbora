@extends('apps.control_madera.plantilla.app')
@section('header')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endsection
@section('body')
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h2>Madera disponible</h2>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="page-body mt-4">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Madera / Troncos disponibles</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-box table-responsive">
                                <p class="text-muted font-13 m-b-30">
                                    Los siguientes consecutivos corresponden a los troncos o madera que actualmente están disponibles y que no se han
                                    procesado por medio de la plataforma
                                </p>
                                <table id="datatableMadera" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr class="text-center">
                                            <th>Consecutivo</th>
                                            <th>Ancho</th>
                                            <th>Grueso</th>
                                            <th>Largo</th>
                                            <th>Pulgadas</th>
                                            <th>Tipo de madera</th>
                                            <th>Responsable impresión</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        @foreach ($madera as $item)
                                            <tr>
                                                <td>{{ $item->id }}</td>
                                                <td>{{ $item->ancho }}</td>
                                                <td>{{ $item->grueso }}</td>
                                                <td>{{ $item->largo }}</td>
                                                <td>{{ number_format($item->pulgadas) }}</td>
                                                <td>{{ $item->tipo_madera }}</td>
                                                <td>{{ $item->usuario_creacion }}</td>
                                                <td>
                                                    <select class="form-control" onchange="updateEstadoTroncos(this.value, '{{ $item->id }}')"
                                                        name="estado-tronco" id="estado-tronco">
                                                        <option value="Activo" {{ $item->estado == 'Activo' ? 'selected' : '' }}>Activo</option>
                                                        <option value="Procesado" {{ $item->estado == 'Procesado' ? 'selected' : '' }}>Procesado</option>
                                                    </select>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
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
            $('#datatableMadera').DataTable({
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
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "responsive": false,
            });
        });

        updateEstadoTroncos = (valor, id) => {
            var datos = $.ajax({
                url: "{{ route('update.madera.estado') }}",
                type: "post",
                dataType: "json",
                data: {
                    valor,
                    id
                }
            });
            datos.done((res) => {
                if (res.status == true) {
                    notificacion("¡Excelente! Información actualizada", "success", 3000);
                }
            })
            datos.fail(() => {
                notificacion("ERROR! Revisa los campos y vuelve a intentarlo", "error", 5000);
            })
        }
    </script>
@endsection
