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
@section('active-sub-realizadas')
    active
@endsection
@section('fabrica-body')
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h5 class="m-0">P.Q.R.S realizadas</h5>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('pqrs.todas') }}">Todas</a></li>
                            <li class="breadcrumb-item active"><i class="nav-icon fas fa-solid fa-check"></i> Solicitudes realizadas</li>
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
                    <strong>Solicitudes realizadas</strong>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-3" id="tableRealizadas">
                            @php
                                echo $realizadosTable;
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
        setupRealizadasTable();
    })
</script>
@endsection
