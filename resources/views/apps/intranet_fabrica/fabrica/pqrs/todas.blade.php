@extends('apps.intranet_fabrica.layout_fabrica.app')
@section('title')
    PQRS pendientes
@endsection
@section('menu-calidad')
    menu-open
@endsection
@section('menu-pqrs')
    menu-open
@endsection
@section('active-calidad')
    bg-danger active
@endsection
@section('active-pqrs')
    active
@endsection
@section('active-sub-todas')
    active
@endsection
@section('fabrica-body')
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h5 class="m-0">P.Q.R.S recibidos a la fecha</h5>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home.intranet.fabrica') }}">Todas</a></li>
                            <li class="breadcrumb-item active"><i class="nav-icon fas fa-solid fa-inbox"></i> Solicitudes recibidas</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-outline card-danger">
                <div class="card-header">
                    <strong>Solicitudes pendientes</strong>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-3" id="tableTodas">
                            @php
                                echo $todosTable;
                            @endphp
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
<script>
     $(document).ready(function() {
            setupTodasTable();
        })
</script>
@endsection
