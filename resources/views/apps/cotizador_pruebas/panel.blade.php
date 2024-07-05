@extends('apps.cotizador_pruebas.plantilla.app')
@section('title')
    Panel
@endsection
@section('head')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endsection
@section('body')
    <div class="panel-inicio" style="margin-left: 3%; margin-right: 3%;">
        <div class="row">
            <div class="col-md-8 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h5>Lista de precios</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="productos-lista-de-precios">
                                <thead class="text-center text-white">
                                    <tr style="background-color: #be0811;">
                                        <th>Sku</th>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Valor</th>
                                        <th>Agregar</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">

                                    @foreach ($productos as $key => $item)
                                        <?php $existencia = $item['cantidad'];
                                        if (empty($existencia) || $existencia == 0 || $existencia > 150) {
                                            $existencia = 999;
                                        } ?>
                                        <tr>
                                            <td>{{ $item['sku'] }}</td>
                                            <td id="producto{{ $item['sku'] }}" data-valor="{{ $item['producto'] }}" class="text-left">
                                                {{ $item['producto'] }}</td>
                                            <td>{{ number_format($existencia) }}</td>
                                            <td id="valor{{ $item['sku'] }}" data-valor="{{ round($item['precio']) }}">$
                                                {{ number_format($item['precio']) }}</td>
                                            <td><i class="fas fa-shopping-cart" style="cursor: pointer;"
                                                    onclick="AgregarProductoCotizador('{{ $item['sku'] }}')"></i></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h6>Producto</h6>
                    </div>
                    <div class="card-body">
                        <form id="formulario-agregar-productos-cotizador">
                            <div class="form-group">
                                <label for="">Sku</label>
                                <input type="text" class="form-control" name="sku-cotizador" id="sku-cotizador" disabled>
                            </div>
                            <div class="form-group">
                                <label for="">Producto</label>
                                <input type="text" class="form-control" name="producto-cotizador" id="producto-cotizador" disabled>
                            </div>
                            <div class="form-group">
                                <label for="">Valor contado</label>
                                <input type="text" class="form-control" name="valor-cotizador" id="valor-cotizador" disabled>
                            </div>
                            <div class="form-group">
                                <label for="">Cantidad</label>
                                <input type="text" class="form-control" name="cantidad-cotizador" id="cantidad-cotizador">
                            </div>
                            <center>
                                <div class="btn-group text-center" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-success" onclick="AgregarInfoProductoSeleccionado()">Agregar Item</button>
                                    <a href="{{ route('liquidar.cotizacion.pruebas') }}" type="button" class="btn btn-danger">Liquidador final</a>
                                </div>
                            </center>
                        </form>
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
            $('#productos-lista-de-precios').DataTable({
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
                "responsive": false,
            });
        });

        AgregarProductoCotizador = (sku) => {
            var producto = $('#producto' + sku).data('valor');
            var valor = $('#valor' + sku).data('valor');

            $('#sku-cotizador').val(sku);
            $('#producto-cotizador').val(producto);
            $('#valor-cotizador').val(valor);
            $('#cantidad-cotizador').val('1');
        }

        AgregarInfoProductoSeleccionado = (url) => {
            var sku = $('#sku-cotizador').val();
            var producto = $('#producto-cotizador').val();
            var valor = $('#valor-cotizador').val();
            var cantidad = $('#cantidad-cotizador').val();

            if (sku.length > 0 && producto.length > 0 && valor.length > 0 && cantidad.length > 0) {
                var datos = $.ajax({
                    url: "{{ route('add.new.product.pruebas') }}",
                    type: "POST",
                    dataType: "json",
                    data: {
                        sku,
                        producto,
                        valor,
                        cantidad
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                datos.done((res) => {
                    if (res.status == true) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: res.mensaje,
                            showConfirmButton: false,
                            timer: 500
                        });
                        $('#sku-cotizador').val('');
                        $('#producto-cotizador').val('');
                        $('#valor-cotizador').val('');
                        $('#cantidad-cotizador').val('');
                    }
                    if (res.status == false) {
                        $('#sku-cotizador').val('');
                        $('#producto-cotizador').val('');
                        $('#valor-cotizador').val('');
                        $('#cantidad-cotizador').val('');
                    }
                });
                datos.fail(() => {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Hubo un problema al guardar',
                        showConfirmButton: false,
                        timer: 1000
                    });
                });
            } else {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Completa todos los campos',
                    showConfirmButton: false,
                    timer: 1000
                });
            }
        }
    </script>
@endsection
