@extends('apps.intranet_fabrica.layout_fabrica.app')
@section('title')
    Solicitudes Mtto
@endsection
@section('menu-mtto')
    menu-open
@endsection
@section('active-mtto')
    bg-danger active
@endsection
@section('hojas-de-vida')
    active
@endsection
@section('tables-bootstrap-css')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/hojas_de_vida.css') }}">
@endsection
@section('fabrica-body')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5 class="m-0">Hoja de vida maquinas o herramientas</h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home.intranet.fabrica') }}">Fábrica</a></li>
                        <li class="breadcrumb-item active">hojas de vida</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-outline card-danger">
                <div class="card-header">
                    <strong>Cantidad: <span class="badge badge-danger" id="cantMaquinasfiltro">{{ $cantidad }}</span> </strong>
                </div>
                <div class="card-body">
                    <div class="col-md-12 mb-4 d-flex justify-content-center">
                        <div class="inputBox_container">
                            <svg class="search_icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" alt="search icon">
                                <path
                                    d="M46.599 46.599a4.498 4.498 0 0 1-6.363 0l-7.941-7.941C29.028 40.749 25.167 42 21 42 9.402 42 0 32.598 0 21S9.402 0 21 0s21 9.402 21 21c0 4.167-1.251 8.028-3.342 11.295l7.941 7.941a4.498 4.498 0 0 1 0 6.363zM21 6C12.717 6 6 12.714 6 21s6.717 15 15 15c8.286 0 15-6.714 15-15S29.286 6 21 6z">
                                </path>
                            </svg>
                            <input class="inputBox" id="inputBox" type="text" oninput="buscar()" placeholder="Buscar Maquina / Herramienta">
                        </div>
                    </div>
                    <div class="row" id="infoGeneralMaquinasHv">
                        {!! $maquinas !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    {{-- modal --}}
    @include('apps.intranet_fabrica.fabrica.hojas_vida.modal_editar_imagen')

    <script>
        function buscar() { //buscar.hoja.vida
            var input = document.getElementById('inputBox').value.toLowerCase();

            var datos = $.ajax({
                url: "{{ route('buscar.hoja.vida') }}",
                type: 'POST',
                data: {
                    valor: input
                }
            })
            datos.done((res) => {
                document.getElementById('infoGeneralMaquinasHv').innerHTML = res.maquinas
                document.getElementById('cantMaquinasfiltro').innerHTML = res.cantidad
            })
            datos.fail(() => {
                Swal.fire({
                    text: "Error de conexión",
                    icon: "error",
                    showConfirmButton: false,
                    position: "top-end",
                    timer: 5000,
                    toast: true,
                });
            })
        }

        function abrirModalEditarImagen(idMaquina) {
            $('#idMaquina').val(idMaquina);
            $("#editarImagenMaquina").modal('toggle');
        }

        function editarImagenMaquina() {
            let formulario = document.getElementById('formActualizarImagen');
            let formData = new FormData(formulario);
            let idMaquina = $('#idMaquina').val()
            $.ajax({
                url: "{{ route('actualizar.imagen.maquina') }}",
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $(`#imgMaquina${idMaquina}`).attr('src', response.rutaImg);
                    $("#editarImagenMaquina").modal('toggle');
                    Swal.fire({
                        text: "Se actualizo correctamente",
                        icon: "success",
                        showConfirmButton: false,
                        position: "top-end",
                        timer: 5000,
                        toast: true,
                    });
                },
                error: function(error) {
                    Swal.fire({
                        text: "Error al actualizar la imagen",
                        icon: "error",
                        showConfirmButton: false,
                        position: "top-end",
                        timer: 5000,
                        toast: true,
                    });
                }
            });
        }

        function abrirModalComentarios(referencia) {
            $('#id_maquina').val(referencia);
            $("#modalComentarios").modal('toggle');
        }

        function guardarComentario() {
            let formulario = document.getElementById('agregarComaentarios');
            let formData = new FormData(formulario);
            $.ajax({
                url: "{{ route('guardar.comentario') }}",
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    var nuevoElemento = $('<div>', {
                        'class': 'direct-chat-text m-0 mb-2',
                        'id': 'comentario',
                        'text': response.comentario
                    });
                    $('#divComantarios').append(nuevoElemento);
                    $("#agregarComaentarios")[0].reset();
                    Swal.fire({
                        text: "Se agrego correctamente",
                        icon: "success",
                        showConfirmButton: false,
                        position: "top-end",
                        timer: 5000,
                        toast: true,
                    });
                },
                error: function(error) {
                    console.error(error);
                }
            });
        }
    </script>
@endsection
