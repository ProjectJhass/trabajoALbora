@extends('apps.intranet_fabrica.layout_fabrica.app')
@section('title')
    Inicio
@endsection

@section('active-inicio')
    bg-danger active
@endsection


@section('tables-bootstrap-css')
    {{-- --------------------CSS------------------------ --}}
@endsection

@section('fabrica-body')
    <div class="content-header">
        <div class="container-fluid">
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">

            {{-- puente --}}
            <input type="text" value="{{ $alerta }}" hidden id="alerta">

            <div class="card card-outline card-danger">
                <div style="background-size:100% 100%; background-repeat:none; background-image: url('{{ asset('img/fabrica home.png') }}');">
                    <h5 class="text-left text-white" style="margin-top: 2%; margin-left: 3%;"><strong>Hola, {{ Auth::user()->nombre }}</strong></h5>
                    <h6 class="text-center text-white mb-5" style="margin-top: 1.5%; margin-left: 1%;"><strong>"¿Qué sería de la vida si no tuviéramos el
                            valor de intentar cosas nuevas?"</strong></h6>
                </div>
            </div>

            <div class="card card-outline card-danger">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8 mb-3" style="border-right: 1px solid; color: red;">
                            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    {{ $n = 0 }}
                                    @foreach ($imagenes as $item)
                                        @if ($item->seccion_img == 'carrucel')
                                            {{ $n++ }}
                                            <div class="carousel-item {{ $n == 1 ? 'active' : '' }}">
                                                <img class="d-block w-100" src="{{ asset('storage/carrucel/' . $item->nombre_img) }}"
                                                    style="max-width: 1080px; max-height: 791px" alt="{{ $item->nombre_img }}">
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            @foreach ($imagenes as $item)
                                @if ($item->seccion_img == 'derecha')
                                    <img src="{{ asset('storage/carrucel/' . $item->nombre_img) }}" width="100%" alt="{{ $item->nombre_img }}">
                                @endif
                            @endforeach
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
            let alerta = document.getElementById("alerta").value;
            document.getElementById("alerta").style.display = "none";
            if (alerta) {
                ejecutarModal();
            }
        })


        function ejecutarModal() {

            let timerInterval;
            Swal.fire({
                html: '<i class="far fa-bell"></i> Tienes mantenimientos pendientes!<br><small>Visita la pestaña de mantenimientos.</small>',
                timer: 10000,
                timerProgressBar: true,
                position: "top",
                Toasts: true,
                willClose: () => {
                    clearInterval(timerInterval);
                },
            }).then((result) => {
                /* Read more about handling dismissals below */
                if (result.dismiss === Swal.DismissReason.timer) {

                }
            });
        }
    </script>
@endsection
