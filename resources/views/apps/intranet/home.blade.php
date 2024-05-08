@extends('apps.intranet.plantilla.app')
@section('title')
    Inicio
@endsection
@section('head')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection
@section('home')
    bg-danger active
@endsection
@section('body')

@php
    $baseUrl = env('APP_BASE_URL', 'http://localhost');
@endphp

    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div id="imagen_head">
                        <h4 class="text-left text-white neon" style="margin-left: 3%;"><br>HOLA, {{ Auth::user()->nombre }}</h4>
                        <h5 class="text-center text-white mt-4 neon ml-5 mr-5">"{{ $frase }}"</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-outline card-danger">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    @foreach ($imagenes as $item)
                                        <div class="carousel-item {{ $item->orden == 1 ? 'active' : '' }}">
                                            <img class="d-block w-100" src="{{ asset($item->url_imagen) }}" alt="{{ $item->nombre_imagen }}">
                                        </div>
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
                        <div class="col-md-4">
                            <div class="card card-outline card-secondary">
                                <div class="card-header">
                                    <h3 class="card-title">Números de contacto</h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <ul class="nav nav-pills flex-column">
                                        @foreach ($numeros as $item)
                                            <li class="nav-item active">
                                                <a href="https://web.whatsapp.com/send/?phone=57{{ $item->numero_celular }}" target="_BLANK"
                                                    class="nav-link">
                                                    <i class="fas fa-user"></i> {{ $item->nombre_propietario }}
                                                    <span class="badge bg-success float-right">
                                                        <i class="fab fa-whatsapp"></i> {{ $item->numero_celular }}
                                                    </span>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if (Auth::user()->dpto_user == '4' || Auth::user()->permisos == '4')
            <a href="{{ route('home.edit') }}" id="delete-clients" class="btn btn-danger back-to-top" role="button" aria-label="Editar inicio">
                <i class="fas fa-edit"></i>
            </a>
        @endif

    </section>
@endsection
@section('footer')
    <div class="modal fade" id="modalimgRoutePTEE" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body text-center" id="imgRoutePTEE">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal" onclick="updateViewFlayer('Sin leer','0')">No leí la imagen</button>
                    <button type="button" class="btn btn-success" data-dismiss="modal" onclick="updateViewFlayer('Leído','1')">Leí la imagen</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function() {
            fetch("{{ $baseUrl }}/app/public/api/autos/validar", {
                    method: 'POST',
                    body: JSON.stringify({
                        validar: 1
                    }),
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                .then(res => res.json())
        });
    </script>
    <script>
        $(document).ready(() => {
            var datos = $.ajax({
                url: "{{ route('validate.flayer') }}",
                type: "post",
                dataType: "json",
                data: {
                    val: 1
                }
            });

            datos.done((res) => {
                if (res.status === true) {
                     $('#modalimgRoutePTEE').modal('show')
                     document.getElementById('imgRoutePTEE').innerHTML = res.img;
                }
            })
        });

        updateViewFlayer = (estado, id_estado) => {
            var datos = $.ajax({
                url: "{{ route('register.flayer') }}",
                type: "post",
                dataType: "json",
                data: {
                    estado,
                    id_estado
                }
            });
        }
    </script>
@endsection
