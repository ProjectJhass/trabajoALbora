@extends('apps.control_madera.plantilla.app')
@section('head')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endsection
@section('p.corte.proceso')
    active
@endsection
@section('body')
    <div class="row">
        <div class="col-md-12">
            <div class="card" data-aos="fade-up" data-aos-delay="300">
                <div class="card-header">
                    <h5>Cortes en proceso</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="datatableMadera">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Serie</th>
                                    <th>Cantidad</th>
                                    <th>Fecha</th>
                                    <th>Planificador</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @foreach ($cortes as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td class="text-start">{{ $item->mueble . ' ' . $item->serie . ' ' . strtoupper($item->madera) }}</td>
                                        <td>{{ $item->cantidad }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>{{ $item->usuario_creacion }}</td>
                                        <td>
                                            <a href="{{ route('info.piezas.c.planner', ['id_corte' => $item->id]) }}"
                                                class="btn btn-primary btn-sm">Ver</a>
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
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "responsive": false,
            });
        });
    </script>
@endsection
