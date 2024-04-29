@extends('apps.intranet_fabrica.layout_fabrica.app')
@section('title')
    Documentación
@endsection
@section('menu-prod')
    menu-open
@endsection
@section('active')
    bg-danger active
@endsection
@section('active-sub-doc')
    active
@endsection
@section('fabrica-body')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5 class="m-0">Documentación técnica</h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home.intranet.fabrica') }}">Fábrica</a></li>
                        <li class="breadcrumb-item active">Documentación</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-outline card-danger">
                <div class="card-header">
                    <strong>Sección</strong>
                    <div class="card-tools">
                        <a href="http://190.144.22.254:8080/fabrica/appa/buscaproducto.php" type="button" class="btn btn-secondary" target="_BLANK">App
                            versión anterior</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="callout callout-danger">
                                <div class="form-group">
                                    <label>Producto a trabajar</label>
                                    <select class="select2" data-placeholder="Seleccione el producto" style="width: 100%;"
                                        id="producto-a-trabajar-fab">
                                        <option value=""></option>
                                        @foreach ($referencias as $key => $value)
                                            <option value="{{ $value->id_referencia }}">{{ $value->nombre_referencia }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @foreach ($secciones as $key => $item)
                            <div class="col-md-4 mt-2">
                                <div class="card">
                                    <div class="card-body" style="cursor: pointer; color:blue;"
                                        onclick="buscarInformacionProd('{{ route('title.prods', ['seccion' => $item->nombre_seccion, 'id_seccion' => $item->id_seccion, 'id_producto' => 'PROD_TRABAJAR']) }}')">
                                        <div id="secciones-fabrica-produccion">
                                            <img src="{{ asset('icons/' . $item->icono) }}" alt="{{ $item->nombre_seccion }}" width="70px">
                                            {{ $item->nombre_seccion }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script>
        $(function() {
            $('.select2').select2()
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        });

        ValidarProductoSelect = (producto, url) => {
            var datos = $.ajax({
                type: "POST",
                url: url,
                dataType: "json",
                data: {
                    producto
                }
            });
            datos.done((response) => {
                if (response.status == true) {
                    $('#titulos-relacionados-producto').html(response.data);
                }
            });
            datos.fail(() => {

            });
        }

        buscarInformacionProd = (url) => {
            var producto = $('#producto-a-trabajar-fab').val();
            if (producto != '') {
                var url_n = url.replace("PROD_TRABAJAR", producto);
                window.location.href = url_n;
            }
        }
    </script>
@endsection
