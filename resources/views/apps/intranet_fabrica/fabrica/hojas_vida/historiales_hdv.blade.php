@extends('apps.intranet_fabrica.layout_fabrica.app')
@section('title')
    Historiales
@endsection
@section('menu-mtto')
    menu-open
@endsection
@section('active-mtto')
    bg-danger active
@endsection
@section('active-no-anexos')
    active
@endsection

@section('tables-bootstrap-css')
    {{-- --------------------CSS------------------------ --}}
    <link rel="stylesheet" href="{{ asset('css/mantenimiento.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endsection
@section('fabrica-body')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5 class="m-0">Historiales no anexados a hoja de vida</h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home.intranet.fabrica') }}">Fábrica</a></li>
                        <li class="breadcrumb-item active">Hoja de vida</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-danger card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        Historiales.
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="input_searcher">Búsqueda:</label>
                            <input class="form-control border-end-0 border mb-1" id="input_searcher"
                                onkeyup="searcher('{{ route('no.searcher') }}',this.id)" type="text" placeholder="Búsqueda...">

                        </div>
                        <div class="col-md-3">
                            <label for="fecha_i">Fecha inicio:</label>
                            <input type="date" class="form-control" id="fecha_i">
                        </div>
                        <div class="col-md-3">
                            <label for="fecha_f">Fecha final:</label>
                            <input type="date" class="form-control " id="fecha_f">

                        </div>
                        <div class="col-md-2">
                            <button onclick="searchDate('{{ route('search.date') }}')" class="btn btn-danger btn-block" style="margin-top: 2rem"><i class="fas fa-search"></i> Buscar</button>
                        </div>
                    </div>
                    <hr>
                    <div id="container_no_anexos"></div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script>
        const id_searcher = "input_searcher";

        $(document).ready(function() {
            searcher(id_searcher);
        });

        function searcher(id) {
            let buscar = document.getElementById(id).value;
            $.ajax({
                    url: "{{ route('no.searcher') }}",
                    type: "POST",
                    dataType: "json",
                    data: {
                        buscar: buscar,
                    },
                })
                .done(function(res) {
                    if (res) {
                        let container = document.getElementById("container_no_anexos");

                        container.innerHTML = res.render;
                    }
                })
                .fail(function(err) {});
        }

        function searchDate(url) {
            let fecha_i = document.getElementById("fecha_i").value;
            let fecha_f = document.getElementById("fecha_f").value;

            if (fecha_i != "" && fecha_f != "") {
                $.ajax({
                    url: url,
                    type: "post",
                    dataType: "json",
                    data: {
                        fecha1: fecha_i,
                        fecha2: fecha_f,
                    },
                }).done(function(res) {
                    if (res) {
                        let container = document.getElementById("container_no_anexos");

                        container.innerHTML = res.render;
                        document.getElementById("fecha_i").value = "";
                        document.getElementById("fecha_f").value = "";
                    }
                });
            } else {
                searcher(id_searcher);
            }
        }
    </script>
@endsection
