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
                    <h5 class="m-0">Mantenimientos programados no adjuntos en HV</h5>
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
                    <div class="card-title">
                        <h4>Mantenimientos</h4>
                    </div>
                    <div class="card-tools">
                        <input class="form-control border-end-0 border mb-1" id="input_searcher" onkeyup="searcher('{{ route('no.searcher') }}',this.id)"
                            type="text" placeholder="Filtrar...">
                    </div>
                </div>
                <div class="card-body">
                    <div class="justify-content-between">
                        <button class="btn btn-danger btn-sm shadow" data-toggle="modal" data-target="#filtroFechasMaquina"><i class="fas fa-filter"></i>
                            Filtro por fecha</button>
                    </div>
                    <hr>
                    <div id="container_no_anexos"></div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="filtroFechasMaquina" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Filtrar información por fecha</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="row" id="filtrarProcedimientos">
                        @csrf
                        <div class="form-group col-md-6">
                            <label for="exampleFormControlInput1">Fecha Inicial:</label>
                            <input type="date" class="form-control form-control-sm" id="fecha_i" name="fecha_i">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleFormControlInput1">Fecha Final:</label>
                            <input type="date" class="form-control form-control-sm" id="fecha_f" name="fecha_f">
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-danger shadow" onclick="searchDate('{{ route('search.date') }}')"><i class="fas fa-search"></i>
                        Filtrar por
                        fecha</button>
                    <button type="button" class="btn btn-danger shadow"
                        onclick="document.getElementById('filtrarProcedimientos').reset(); searchDate('{{ route('search.date') }}')"><i
                            class="fas fa-search"></i>
                        Mostrar todos</button>
                </div>
            </div>
        </div>
    </div>
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

            $("#filtroFechasMaquina").modal("hide")

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
