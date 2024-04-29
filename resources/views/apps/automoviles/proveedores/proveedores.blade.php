@extends('apps.automoviles.layout.app')
@section('title')
    Proveedores
@endsection
@section('head')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endsection
@section('active-proveedores')
    active
@endsection
@section('body')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5 class="m-0">Proveedores</h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('albura.autos') }}">Inicio</a></li>
                        <li class="breadcrumb-item active">Proveedores</li>
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
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-sm" id="table-proveedores-albura">
                        <thead>
                            <tr class="text-center bg-danger">
                                <th>#</th>
                                <th>Nit</th>
                                <th>Razon</th>
                                <th>Establecimiento</th>
                                <th>Ciudad</th>
                                <th>Barrio</th>
                                <th>Dirección</th>
                                <th>Celular</th>
                                <th>Servicio</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $n = 0; ?>
                            @foreach ($info as $item)
                                <?php $n++; ?>
                                <tr>
                                    <td>{{ $n }}</td>
                                    <td>{{ $item->nit }}</td>
                                    <td>{{ $item->razon_social }}</td>
                                    <td>{{ $item->establecimiento }}</td>
                                    <td>{{ $item->ciudad }}</td>
                                    <td>{{ $item->barrio }}</td>
                                    <td>{{ $item->direccion }}</td>
                                    <td>{{ $item->celular }}</td>
                                    <td>{{ $item->servicio }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('footer')
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/autos/proveedores.js') }}"></script>
@endsection
