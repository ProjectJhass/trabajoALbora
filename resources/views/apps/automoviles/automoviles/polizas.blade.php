@extends('apps.automoviles.layout.app')
@section('title')
    Automoviles
@endsection
@section('active-polizas')
    active
@endsection
@section('body')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5 class="m-0">Pólizas de seguro</h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('albura.autos') }}">Inicio</a></li>
                        <li class="breadcrumb-item active">Pólizas</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-outline card-secondary">
                <div class="card-header">
                    <h6>Información general</h6>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr class="text-center">
                                <th>Id</th>
                                <th>Auto</th>
                                <th>Placa</th>
                                <th>Renovar</th>
                                <th>Historial</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php $hoy = date('Y-m-d'); ?>
                            @foreach ($autos as $item)
                                <?php
                                $val_s = $item->soat < $hoy ? '<span class="badge badge-light">*</span>' : '';
                                $val_a = $item->ambiental < $hoy ? '<span class="badge badge-light">*</span>' : '';
                                $val_t = $item->riesgo < $hoy ? '<span class="badge badge-light">*</span>' : '';
                                ?>
                                <tr>
                                    <td>{{ $item->id_auto }}</td>
                                    <td class="text-left">{{ $item->modelo }}</td>
                                    <td>{{ $item->placa }}</td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <button type="button" class="btn btn-danger" onclick="ActualizarPoliza('soat','{{ $item->id_auto }}')">Soat
                                                <?php echo $val_s; ?></button>
                                            <button type="button" class="btn btn-success"
                                                onclick="ActualizarPoliza('ambiental','{{ $item->id_auto }}')">Ambiental <?php echo $val_a; ?></button>
                                            <button type="button" class="btn btn-info"
                                                onclick="ActualizarPoliza('riesgo','{{ $item->id_auto }}')">Todo riesgo <?php echo $val_t; ?></button>
                                        </div>
                                    </td>
                                    <td><button data-widget="control-sidebar" onclick="HistorialPlaca('{{ $item->placa }}')" data-slide="true"
                                            class="btn btn-default"><i class="fas fa-file-invoice-dollar"></i></button></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="ModalCargarDocsPolizas" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: rgb(201, 0, 0)">
                    <h5 class="modal-title text-white" id="exampleModalLongTitle">Actualizar Información de los seguros</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="was-validated" id="form-docs-polizas" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="">Placa</label>
                                            <select name="renovar_placa" id="renovar_placa" class="form-control" required>
                                                <option value="">Seleccionar</option>
                                                @foreach ($autos as $item)
                                                    <option value="{{ $item->id_auto }}" data-placa="{{ $item->placa }}">{{ $item->placa }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Seguro</label>
                                            <select class="form-control" name="renovar_poliza" id="renovar_poliza" required>
                                                <option value="">Seleccionar</option>
                                                <option value="soat">SOAT</option>
                                                <option value="ambiental">AMBIENTAL</option>
                                                <option value="riesgo">TODO RIESGO</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Fecha de próximo vencimiento</label>
                                            <input type="date" class="form-control" name="fecha_vencimiento" id="fecha_vencimiento" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <label for="">Documento de la poliza adquirida</label>
                                        <input type="file" class="form-control" name="doc_poliza" id="doc_poliza" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-success" onclick="CargarDocumentosPolizas()">Actualizar información</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <aside class="control-sidebar control-sidebar-light" style="margin-top: 30px">
        <div class="card card-outline card-danger" style="min-height: 100%">
            <div class="card-header">
                <div class="card-title">
                    <h4 class="text-center"><i class="fas fa-cogs" style="color: rgba(88, 88, 88, 0.863)"></i> Historial</h4>
                </div>
                <div class="card-tools">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <strong><p class="text-center" id="text-placa"></p></strong>                
                <div class="list-group" id="list-polizas-seguro"></div>
            </div>
        </div>
    </aside>

    <script>
        HistorialPlaca = (placa) => {

            $('#text-placa').text(placa)

            var data = $.ajax({
                type: "POST",
                url: "{{ Route('polizas.historial') }}",
                dataType: "json",
                data: {
                    placa
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            data.done((res) => {
                if (res.status == true) {
                    $('#list-polizas-seguro').html(res.data)
                }
            })
            data.fail(() => {
                toastr.error('Hubo un problema al actualizar')
            })
        }
        ActualizarPoliza = (poliza, placa) => {
            $('#renovar_placa').val(placa)
            $('#renovar_poliza').val(poliza)
            $('#ModalCargarDocsPolizas').modal('show')
        }

        ActualizarCampoPoliza = (fecha, id, campo) => {
            var data = $.ajax({
                type: "POST",
                url: window.location.href,
                dataType: "json",
                data: {
                    fecha: fecha,
                    id: id,
                    campo: campo
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            data.done((res) => {
                if (res.status == true) {
                    toastr.success('Fecha actualizada')
                }
            })
            data.fail(() => {
                toastr.error('Hubo un problema al actualizar')
            })
        }

        CargarDocumentosPolizas = () => {

            var selectedOption = $('#renovar_placa').find('option:selected');
            var dataPlaca = selectedOption.data('placa');

            var formData = new FormData(document.getElementById('form-docs-polizas'));
            formData.append('dataPlaca', dataPlaca);
            var datos = $.ajax({
                url: window.location.href + "/actualiar-poliza",
                type: "POST",
                dataType: "json",
                data: formData,
                cache: false,
                contentType: false,
                processData: false
            })
            datos.done((res) => {
                if (res.status == true) {
                    toastr.success('Información actualizada')
                    document.getElementById('form-docs-polizas').reset();
                }
            })
            datos.fail(() => {
                toastr.error('Verifica la información y vuelve a intentar');
            })
        }
    </script>
@endsection
