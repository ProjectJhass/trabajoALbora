@extends('apps.servicios_tecnicos.plantilla.app')
@section('head')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endsection
@section('st')
    active
@endsection
@section('body')
    <div class="nav-align-top mb-4">
        @foreach ($valores as $item)
            <ul class="nav nav-tabs nav-fill" role="tablist">
                <li class="nav-item">
                    <button type="button" class="nav-link active" role="tab" onclick="buscarInformacionSolicitudes('st_en_proceso','all')"
                        data-bs-toggle="tab" data-bs-target="#st_en_proceso" aria-controls="st_en_proceso" aria-selected="true">
                        <i class="tf-icons bx bx-home me-1"></i><span class="d-none d-sm-block">En proceso</span>
                        @if ($item['proceso'] > 0)
                            <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger ms-1">{{ $item['proceso'] }}</span>
                        @endif

                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" onclick="buscarInformacionSolicitudes('st_no_gar_def', 'No garantia')"
                        data-bs-toggle="tab" data-bs-target="#st_no_gar_def" aria-controls="st_no_gar_def" aria-selected="false">
                        <i class="tf-icons bx bx-user me-1"></i><span class="d-none d-sm-block">Por definir - No garantía</span>
                        @if ($item['garantia'] > 0)
                            <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger ms-1">{{ $item['garantia'] }}</span>
                        @endif
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" onclick="buscarInformacionSolicitudes('st_recoger', 'Recoger')"
                        data-bs-toggle="tab" data-bs-target="#st_recoger" aria-controls="st_recoger" aria-selected="false">
                        <i class="tf-icons bx bx-message-square me-1"></i><span class="d-none d-sm-block"> Recoger</span>
                        @if ($item['recoger'] > 0)
                            <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger ms-1">{{ $item['recoger'] }}</span>
                        @endif
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" onclick="buscarInformacionSolicitudes('st_definir','En devolucion')"
                        data-bs-toggle="tab" data-bs-target="#st_definir" aria-controls="st_definir" aria-selected="false">
                        <i class="tf-icons bx bx-message-square me-1"></i><span class="d-none d-sm-block"> Por definir</span>
                        @if ($item['definir'] > 0)
                            <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger ms-1">{{ $item['definir'] }}</span>
                        @endif
                    </button>
                </li>{{-- 
                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" onclick="buscarInformacionSolicitudes('st_definidos', 'Definido')"
                        data-bs-toggle="tab" data-bs-target="#st_definidos" aria-controls="st_definidos" aria-selected="false">
                        <i class="tf-icons bx bx-message-square me-1"></i><span class="d-none d-sm-block"> Definidos</span>
                    </button>
                </li> --}}
            </ul>
        @endforeach
        <div class="tab-content">
            <div class="tab-pane fade show active" id="st_en_proceso" role="tabpanel">
                @php
                    echo $table;
                @endphp
            </div>
            <div class="tab-pane fade" id="st_no_gar_def" role="tabpanel"></div>
            <div class="tab-pane fade" id="st_recoger" role="tabpanel"></div>
            <div class="tab-pane fade" id="st_definir" role="tabpanel"></div>
            {{-- <div class="tab-pane fade" id="st_definidos" role="tabpanel"></div> --}}
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

        deleteHtmlTables = () => {
            document.getElementById('st_en_proceso').innerHTML = ''
            document.getElementById('st_no_gar_def').innerHTML = ''
            document.getElementById('st_recoger').innerHTML = ''
            document.getElementById('st_definir').innerHTML = ''
            // document.getElementById('st_definidos').innerHTML = ''
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
                "autoWidth": false,
                "responsive": false,
            });
        }

        buscarInformacionSolicitudes = (seccion, estado) => {
            deleteHtmlTables()
            var data = $.ajax({
                url: "{{ route('info.estado.ost') }}",
                type: 'POST',
                dataType: 'json',
                data: {
                    estado_solicitud: estado
                },
            })
            data.done((res) => {
                document.getElementById(seccion).innerHTML = res.info
                setupTable()
            })
        }
    </script>
@endsection
