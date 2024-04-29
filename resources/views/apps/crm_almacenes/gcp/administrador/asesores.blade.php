@extends('apps.crm_almacenes.gcp.plantilla.app')
@section('title')
    Asesores
@endsection
@section('header')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endsection
@section('asesores')
    active
@endsection
@section('contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Asesores</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item text-blue">CRM</li>
                        <li class="breadcrumb-item active">Asesores</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-outline card-danger">
                <div class="card-header">
                    Información general
                </div>
                <div class="card-body">
                    <table id="table-info-asesores-al" class="table table-sm table-bordered table-striped">
                        <thead class="text-center" style="background-color: #c22121; color: white;">
                            <tr>
                                <th>Cédula</th>
                                <th>Nombre</th>
                                <th>Usuario</th>
                                <th>Sucursal</th>
                                <th>Cargo</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($asesores as $item)
                                <?php $estado_ = $item->estado == '1' ? 'Activo' : 'Inactivo'; ?>
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td class="text-left">{{ $item->nombre }}</td>
                                    <td class="text-left">{{ $item->usuario }}</td>
                                    <td>{{ $item->sucursal }}</td>
                                    <td>
                                        <select class="form-control" name="cargo-asesor" id="cargo-asesor" onchange="ActualizarAsesor('cargo',this.value,'{{ $item->id }}')">
                                            <option value="{{ $item->cargo }}" selected>{{ $item->cargo }}</option>
                                            <option value="administrador">Administrador</option>
                                            <option value="asesor">Asesor</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control" name="estado-asesor" id="estado-asesor" onchange="ActualizarAsesor('estado',this.value,'{{ $item->id }}')">
                                            <option value="{{ $item->estado }}" selected>{{ $estado_ }}</option>
                                            <option value="1">Activo</option>
                                            <option value="0">Inactivo</option>
                                        </select>
                                    </td>
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
    <script src="{{ asset('js/asesores_admin.js') }}"></script>
@endsection
