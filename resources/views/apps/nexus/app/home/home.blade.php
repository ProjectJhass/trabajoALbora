@extends('apps.nexus.plantilla.app')
@section('home')
    active
@endsection
@section('body')
    <div class="row" style="margin-top: 9rem">
        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-center justify-content-between">
                        <div class="d-flex flex-wrap align-items-center">
                            <div class="profile-img position-relative me-3 mb-3 mb-lg-0 profile-logo profile-logo1">
                                <img src="{{ asset('assets/img/avatars/1.png') }}" alt="User-Profile" class="img-fluid rounded-pill avatar-100">

                            </div>
                            <div class="d-flex flex-wrap align-items-center mb-3 mb-sm-0">
                                <h4 class="me-2 h4">
                                    </h4><br>
                                <span>{{ Auth::user()->nombre }}</span>
                            </div>
                        </div>
                        <ul class="d-flex nav nav-pills mb-0 text-center profile-tab" data-toggle="slider-tab" id="profile-pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active show" onclick="mostrarContenidoSeccion('general')" data-bs-toggle="tab" href="#info-general"
                                    role="tab" aria-selected="false">General</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" onclick="mostrarContenidoSeccion('perfil')" data-bs-toggle="tab" href="#info-general"
                                    role="tab" aria-selected="false">Perfil</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" onclick="mostrarContenidoSeccion('entrevista')" data-bs-toggle="tab" href="#info-general"
                                    role="tab" aria-selected="false">Entrevista</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" onclick="mostrarContenidoSeccion('modulos')" data-bs-toggle="tab" href="#info-general"
                                    role="tab" aria-selected="false">Módulos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" onclick="mostrarContenidoSeccion('manual')" data-bs-toggle="tab" href="#info-general"
                                    role="tab" aria-selected="false">Manual de
                                    funciones</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="profile-content tab-content">
                <div id="info-general" class="tab-pane fade active show">
                    {!! $general !!}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script>
        mostrarContenidoSeccion = (seccion) => {
            var datos = $.ajax({
                url: "{{ route('search.seccion.nexus') }}",
                type: "post",
                dataType: "json",
                data: {
                    seccion
                }
            });
            datos.done((res) => {
                document.getElementById('info-general').innerHTML = res.vista
            })
        }
    </script>
@endsection
