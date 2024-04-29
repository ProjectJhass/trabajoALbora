@extends('apps.servicios_tecnicos.plantilla.app')
@section('head')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endsection
@section('seguimiento')
    active
@endsection
@section('body')
    <div class="card">
        <div class="card-header">
            <div class="card-title d-flex align-items-start justify-content-between">
                <h5>Seguimiento general</h5>

                <button type="button" class="btn btn-sm btn-success text-nowrap" onclick="buscarInfoCentroExpInf()" data-bs-toggle="popover" data-bs-offset="0,14" data-bs-placement="top"
                    data-bs-html="true"
                    data-bs-content="<form action='{{ route('export.st.seg') }}' method='post'>
                        <div class='row'>
                            <div class='col-md-12 mb-3'>
                                <label for='co_new_ost'>Centro de experiencia</label>
                                <select class='form-control' name='id_co_new_ost' id='id_co_new_ost'>
                                </select>                                
                            </div>
                            <div class='col-md-12'>
                                <label for=''>Desde:</label>
                                <input type='date' class='form-control' name='fecha_i' id='fecha_i'>
                            </div>
                        </div><br>
                        <div class='d-flex justify-content-center'><button type='submit' class='btn btn-sm btn-success'>Exportar</button>
                        </div>
                    </form>"
                    title="Exportar">
                    <i class="bx bxs-file-export"></i>
                </button>

                {{-- <div class='d-flex justify-content-center'><button type='button' class='btn btn-sm btn-warning' onclick='btnEliminarSTAdmin({{ $item->id_st }})' id='btnEliminarSTAdmin{{ $item->id_st }}'>Eliminar servicio técnico</button></div><br> --}}

                {{-- <a href="{{ route('export.st.seg') }}" type="button" class="btn btn-sm btn-success">
                    <i class="bx bxs-file-export"></i>
                </a> --}}
            </div>
        </div>
        <div class="card-body" id="infoGeneralSTAdmin">
            @php
                echo $table;
            @endphp
        </div>
    </div>
@endsection
@section('footer')
    <script src="{{ asset('assets/js/ui-popover.js') }}"></script>
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            setupTable();
        })

        buscarInfoCentroExpInf = () => {
            var data = $.ajax({
                url: "{{ route('search.co') }}",
                type: 'POST',
                dataType: 'json',
                data: {
                    codigo: 1
                },

            })
            data.done((res) => {
                document.getElementById("id_co_new_ost").innerHTML = res.options
            })
        }

        btnEliminarSTAdmin = (id) => {
            notificacion("Eliminando información del servicio técnico", "info", 5000);
            var datos = $.ajax({
                url: "{{ route('delete.st.seg') }}",
                type: "post",
                dataType: "json",
                data: {
                    id
                }
            });
            datos.done((res) => {
                notificacion("Servicio técnico eliminado exitosamente", "success", 5000);
                document.getElementById('infoGeneralSTAdmin').innerHTML = res.table;
                $('.popover').removeClass('show')
                setupTable()
            })
            datos.fail(() => {
                notificacion("ERROR: No se puede procesar esta solicitud", "error", 5000);
            })
        }

        setupTable = () => {
            $('#tableSeguimientoGeneralAdmin').DataTable({
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
                    [6, "desc"]
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
    </script>
@endsection
