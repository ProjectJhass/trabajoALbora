@extends('apps.control_madera.plantilla.app')
@section('head')
@endsection
@section('custodia')
    active
@endsection
@section('body')
    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="card alert-top" data-aos="fade-up" data-aos-delay="300">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h5 class="card-title">Etiquetas en custodia</h5>
                    </div>
                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalAgregarConsecutivos"><i class="fas fa-tags"></i>
                        Agregar etiquetas</button>
                </div>
                <div class="card-body table-responsive" id="table-etiquetas-en-custodia">
                    {!! $table !!}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalAgregarConsecutivos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Consecutivos no utilizados</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formAlmacenarConsecutivos" method="post" class="was-validated">
                        @csrf
                        <div class="row mt-3 mb-5">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="consecutivo_inicio">Consecutivo inicio</label>
                                    <input type="number" class="form-control" id="consecutivo_inicio" name="consecutivo_inicio" placeholder="Ejm: 1"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="consecutivo_final">Consecutivo final</label>
                                    <input type="number" class="form-control" id="consecutivo_final" name="consecutivo_final" placeholder="Ejm: 15"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="usuario_responsable">Usuario quien custodia las etiquetas</label>
                                    <select name="usuario_responsable" id="usuario_responsable" class="form-control" required>
                                        <option value="">Seleccionar...</option>
                                        @foreach ($usuarios as $item)
                                            <option value="{{ trim($item->nombre . ' ' . $item->apellidos) }}">
                                                {{ trim($item->nombre . ' ' . $item->apellidos) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="agregarConsecutivosEnCustodia()">Guardar información</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script>
        $(() => {
            formatearTable()
        })

        formatearTable = () => {
            $('#tableInfoEtiquetasCustodia').DataTable({
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
                "responsive": true,
            });
        }

        agregarConsecutivosEnCustodia = () => {
            notificacion("Agregando consecutivos en custodia...", "info", 10000);
            var formulario = new FormData(document.getElementById('formAlmacenarConsecutivos'));
            formulario.append('valor', 'valor');
            var datos = $.ajax({
                url: "{{ route('add.etiquetas.custodia') }}",
                type: "post",
                dataType: "json",
                data: formulario,
                cache: false,
                contentType: false,
                processData: false
            });
            datos.done((res) => {
                if (res.status == true) {
                    notificacion(res.mensaje, "success", 3000)
                    document.getElementById('formAlmacenarConsecutivos').reset()
                    document.getElementById('table-etiquetas-en-custodia').innerHTML = res.table
                    formatearTable()
                }
                if (res.status == false) {
                    notificacion(res.mensaje, "error", 5000)
                }
            })
            datos.fail(() => {
                notificacion("ERROR! Revisa los campos y vuelve a intentarlo", "error", 5000);
            })
        }
    </script>
@endsection
