@extends('apps.servicios_tecnicos.plantilla.app')
@section('head')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endsection
@section('fabrica')
    active
@endsection
@section('body')
    <div class="nav-align-top mb-4">
        <ul class="nav nav-tabs nav-fill" role="tablist">
            <li class="nav-item">
                <button type="button" class="nav-link active" role="tab" onclick="searchInfoFab('valoracion')" data-bs-toggle="tab"
                    data-bs-target="#navs-justified-home" aria-controls="navs-justified-home" aria-selected="true">
                    <i class="tf-icons bx bx-home me-1"></i><span class="d-none d-sm-block">Por valoración</span>
                    @if (!empty($valoracion))
                        <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger ms-1">{{ $valoracion }}</span>
                    @endif
                </button>
            </li>
            <li class="nav-item">
                <button type="button" class="nav-link" role="tab" onclick="searchInfoFab('respuesta')" data-bs-toggle="tab"
                    data-bs-target="#navs-justified-profile" aria-controls="navs-justified-profile" aria-selected="false">
                    <i class="tf-icons bx bx-user me-1"></i><span class="d-none d-sm-block">Emitir respuesta</span>
                    @if (!empty($respuesta))
                        <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger ms-1">{{ $respuesta }}</span>
                    @endif
                </button>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="navs-justified-home" role="tabpanel">
                <div id="tab-table-valoracion">
                    @php
                        echo $table;
                    @endphp
                </div>
            </div>
            <div class="tab-pane fade" id="navs-justified-profile" role="tabpanel">
                <div id="tab-table-respuesta"></div>
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
        $(document).ready(function() {
            setupTable();
        })

        setupTabs = () => {
            document.getElementById('tab-table-respuesta').innerHTML = '';
            document.getElementById('tab-table-valoracion').innerHTML = '';
        }

        setupTable = () => {
            $('#tableStSolicitados').DataTable({
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
                "info": false,
                "autoWidth": true,
                "responsive": false,
            });
        }

        searchInfoFab = (estado) => {
            setupTabs();
            var datos = $.ajax({
                url: "{{ route('fabrica.search') }}",
                type: "post",
                dataType: "json",
                data: {
                    estado
                }
            });
            datos.done((res) => {
                if (estado == 'valoracion') {
                    document.getElementById('tab-table-valoracion').innerHTML = res.table;
                } else {
                    document.getElementById('tab-table-respuesta').innerHTML = res.table;
                }
                setupTable()
            })
        }
    </script>
@endsection
