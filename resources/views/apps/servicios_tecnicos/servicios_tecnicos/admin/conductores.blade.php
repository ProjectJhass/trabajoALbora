@extends('apps.servicios_tecnicos.plantilla.app')
@section('head')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endsection
@section('admin')
    active
@endsection
@section('body')
    <button type="button" class="btn rounded-pill btn-outline-danger mb-4" data-bs-toggle="modal" data-bs-target="#basicModal">
        <span class="tf-icons bx bx-info-circle me-1"></span> Crear información
    </button>
    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-header">Conductores</div>
                <div class="card-body" id="info-table-conductores">
                    @php
                        echo $conductores;
                    @endphp
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-header">Automóviles</div>
                <div class="card-body" id="info-table-automovil">
                    @php
                        echo $vehiculos;
                    @endphp
                </div>
            </div>
        </div>
    </div>


    <div class="mt-3">
        <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel1">Crear información</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-12">
                                <select name="info-para-crear" id="info-para-crear" class="form-control" onchange="validarForm(this.value)">
                                    <option value="c">Conductor</option>
                                    <option value="v">Vehículo</option>
                                </select>
                            </div>
                        </div>

                        <form id="form-createInfo-cliente" method="post">
                            <div class="divider">
                                <div class="divider-text">Crear conductor</div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="input1" class="form-label">Nombre</label>
                                    <input type="text" id="input1" name="input1" class="form-control" />
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="col mb-0">
                                    <label for="input2" class="form-label">Celular</label>
                                    <input type="number" id="input2" name="input2" class="form-control" />
                                </div>
                            </div>
                        </form>
                        <form id="form-createInfo-vehiculo" method="post" hidden>
                            <div class="divider">
                                <div class="divider-text">Crear vehículo</div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="input1" class="form-label">Placa</label>
                                    <input type="text" id="input1" name="input1" class="form-control" />
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="col mb-0">
                                    <label for="input2" class="form-label">Descripción</label>
                                    <input type="text" id="input2" name="input2" class="form-control" />
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Cerrar
                        </button>
                        <button type="button" class="btn btn-success" onclick="crearInformacionAdmin()">Guardar información</button>
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
        $(document).ready(function() {
            setupTableC();
            setupTableV();
        })

        validarForm = (valor) => {
            if (valor == 'v') {
                document.getElementById('form-createInfo-vehiculo').hidden = false;
                document.getElementById('form-createInfo-cliente').hidden = true;
            } else {
                document.getElementById('form-createInfo-cliente').hidden = false;
                document.getElementById('form-createInfo-vehiculo').hidden = true;
            }
        }

        setupTableC = () => {
            $('#tableInfoConductores').DataTable({
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
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": false,
                "autoWidth": true,
                "responsive": false,
            });
        }

        setupTableV = () => {
            $('#tableInfoVehiculos').DataTable({
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
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": false,
                "autoWidth": true,
                "responsive": false,
            });
        }

        crearInformacionAdmin = () => {
            var form = $('#info-para-crear').val()

            if (form == 'v') {
                var info_form = document.getElementById('form-createInfo-vehiculo')
            } else {
                var info_form = document.getElementById('form-createInfo-cliente')
            }
            var formulario = new FormData(info_form);
            formulario.append('option', form);

            var datos = $.ajax({
                url: "{{ route('create.admin') }}",
                type: "post",
                dataType: "json",
                data: formulario,
                cache: false,
                contentType: false,
                processData: false
            });
            datos.done((res) => {
                notificacion("Información creada exitosamente", "success", 3000);
                info_form.reset();

                if (res.seccion == 'v') {
                    document.getElementById('info-table-automovil').innerHTML = res.table
                    setupTableV();
                } else {
                    document.getElementById('info-table-conductores').innerHTML = res.table
                    setupTableC();
                }
            })
            datos.fail(() => {
                notificacion("ERROR! Vuelve a intentarlo", "error", 4000);
            })
        }
    </script>
@endsection
