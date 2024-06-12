@extends('apps.control_madera.plantilla.app')
@section('wood')
    active
@endsection
@section('body')
    <div class="row row-cols-1">
        <div class="overflow-hidden d-slider1 swiper-container-initialized swiper-container-horizontal swiper-container-pointer-events">
            <ul class="p-0 m-0 mb-2 swiper-wrapper list-inline" id="swiper-wrapper-0dd3c934f1d1048d9" aria-live="polite">
                <li class="swiper-slide card card-slide aos-init aos-animate swiper-slide-active" data-aos="fade-up" data-aos-delay="700"
                    style="width: 289px; margin-right: 32px;" role="group" aria-label="1 / 7">
                    <div class="card-body">
                        <div class="progress-widget">
                            <div id="circle-progress-01" class="text-center circle-progress-01 circle-progress circle-progress-primary" data-min-value="0"
                                data-max-value="100" data-value="90" data-type="percent" role="progressbar" aria-valuemin="0" aria-valuemax="100"
                                aria-valuenow="90">
                                <svg class="card-slie-arrow icon-24" width="24" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M5,17.59L15.59,7H9V5H19V15H17V8.41L6.41,19L5,17.59Z"></path>
                                </svg>
                            </div>
                            <div class="progress-detail">
                                <p class="mb-2">Cantidad a cortar</p>
                                <h4 class="counter" style="visibility: visible;">{{ $info->cantidad }}</h4>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="swiper-slide card card-slide aos-init aos-animate swiper-slide-next" data-aos="fade-up" data-aos-delay="800"
                    style="width: 289px; margin-right: 32px;" role="group" aria-label="2 / 7">
                    <div class="card-body">
                        <div class="progress-widget">
                            <div id="circle-progress-02" class="text-center circle-progress-01 circle-progress circle-progress-info" data-min-value="0"
                                data-max-value="100" data-value="80" data-type="percent" role="progressbar" aria-valuemin="0" aria-valuemax="100"
                                aria-valuenow="80">
                                <svg class="card-slie-arrow icon-24" width="24" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M19,6.41L17.59,5L7,15.59V9H5V19H15V17H8.41L19,6.41Z"></path>
                                </svg>
                            </div>
                            <div class="progress-detail">
                                <p class="mb-2">Medidas</p>
                                <h4 class="counter" style="visibility: visible;">{{ $info->medida_grosor }} mm</h4>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="swiper-slide card card-slide aos-init aos-animate" data-aos="fade-up" data-aos-delay="900"
                    style="width: 289px; margin-right: 32px;" role="group" aria-label="3 / 7">
                    <div class="card-body">
                        <div class="progress-widget">
                            <div id="circle-progress-03" class="text-center circle-progress-01 circle-progress circle-progress-primary" data-min-value="0"
                                data-max-value="100" data-value="70" data-type="percent" role="progressbar" aria-valuemin="0" aria-valuemax="100"
                                aria-valuenow="70">
                                <svg class="card-slie-arrow icon-24" width="24" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M19,6.41L17.59,5L7,15.59V9H5V19H15V17H8.41L19,6.41Z"></path>
                                </svg>
                            </div>
                            <div class="progress-detail">
                                <p class="mb-2">Estado</p>
                                <h4 class="counter" id="infoGeneralEstado" style="visibility: visible;">{{ $info->estado }}</h4>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="swiper-slide card card-slide aos-init aos-animate" data-aos="fade-up" data-aos-delay="1000"
                    style="width: 289px; margin-right: 32px;" role="group" aria-label="4 / 7">
                    <div class="card-body">
                        <div class="progress-widget">
                            <div id="circle-progress-04" class="text-center circle-progress-01 circle-progress circle-progress-info" data-min-value="0"
                                data-max-value="100" data-value="60" data-type="percent" role="progressbar" aria-valuemin="0" aria-valuemax="100"
                                aria-valuenow="60">
                                <svg class="card-slie-arrow icon-24" width="24px" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M5,17.59L15.59,7H9V5H19V15H17V8.41L6.41,19L5,17.59Z"></path>
                                </svg>
                            </div>
                            @php
                                $cantidad_p = $info->cantidad - $info->cantidad_cortada;
                            @endphp
                            <div class="progress-detail">
                                <p class="mb-2">Cantidad pendiente</p>
                                <h4 class="counter" id="infoCantidadPendiente" style="visibility: visible;">
                                    {{ $cantidad_p < 0 ? 0 : $cantidad_p }}</h4>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="card credit-card-widget aos-init aos-animate" data-aos="fade-up" data-aos-delay="900">
                        <div class="card-body">
                            <div class="card aos-init aos-animate" style="border: 1px solid; border-color:rgb(221, 221, 221)" data-aos="fade-in"
                                data-aos-delay="500">
                                <div class="text-center card-body d-flex justify-content-around">
                                    <div>
                                        <h2 class="mb-2" id="cantidadCortadaInfo">{{ $info->cantidad_cortada }}</h2>
                                        <p class="mb-0 text-gray">Cantidad cortada</p>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-5">
                                <div class="form-group mb-3" hidden>
                                    <label for="">Id</label>
                                    <input type="number" style="text-align: center" value="{{ $idT }}" class="form-control is-valid"
                                        name="txtIdCorteTabla" id="txtIdCorteTabla">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="">Agregar bloque a utilizar</label>
                                    <input type="number" style="text-align: center" onchange="agregarBloquesUtilizados(this.value)"
                                        class="form-control is-invalid" name="txtBloqueCorte" id="txtBloqueCorte">
                                </div>
                                <div class="form-group">
                                    <label for="">Agregar tablas cortadas</label>
                                    <input type="number" style="text-align: center" class="form-control is-valid" name="txtCantidadTabla"
                                        id="txtCantidadTabla">
                                </div>
                            </div>
                            <div class="grid-cols-2 d-grid gap-card">
                                <button class="p-2 btn btn-primary text-uppercase" onclick="agregarInfoGeneralCorteTablas()">Agregar</button>
                                <button class="p-2 btn btn-secondary text-uppercase" id="btnTerminarCorteTabla"
                                    onclick="confirmarTerminarCorte()">Terminar corte</button>
                            </div>
                        </div>
                    </div>
                    <div class="card aos-init aos-animate" data-aos="fade-up" data-aos-delay="500">
                        <div class="text-center card-body">
                            <div>
                                <div class="mb-2 mt-1" id="infoBloquesUtilizadosTabla">
                                    @php
                                        $bloques = explode(',', $info->bloques_utilizados);
                                    @endphp
                                    @foreach ($bloques as $item)
                                        <span class="badge bg-danger rounded-pill" style="cursor:pointer"
                                            onclick="eliminarBloqueUtilizadoTab('{{ $item }}')">{{ $item }}</span>&nbsp;
                                    @endforeach
                                </div>
                                <p class="mb-0 text-gray">Bloques utilizados</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const inputField = document.getElementById('txtCantidadTabla');
            inputField.addEventListener('keydown', (event) => {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    agregarInfoGeneralCorteTablas()
                }
            });
        });
    </script>
    <script>
        agregarBloquesUtilizados = (valor) => {
            var elemento = document.querySelector(".ui-pnotify-fade-normal");
            if (elemento) {
                elemento.parentNode.removeChild(elemento);
            }
            var id_corte = $('#txtIdCorteTabla').val()
            var datos = $.ajax({
                url: "{{ route('search.bloque.tabla') }}",
                type: "post",
                dataType: "json",
                data: {
                    id_corte,
                    bloque: valor
                }
            });
            datos.done((res) => {
                new PNotify({
                    title: 'Pulgadas: ' + res.pulgadas,
                    text: 'Bloque: ' + res.bloque + '<br>Largo: ' + res.largo,
                    hide: false,
                    type: 'info',
                    styling: 'bootstrap3',
                    addclass: 'info stack-bottomright',
                })
                document.getElementById('infoBloquesUtilizadosTabla').innerHTML = res.bloques
                $("#txtBloqueCorte").val('')
            })
            datos.fail(() => {
                notificacion("¡ERROR! Este bloque ya fue utilizado, utiliza otro", "error", 6000)
            })
        }

        eliminarBloqueUtilizadoTab = (valor) => {
            var id_corte = $('#txtIdCorteTabla').val()
            var datos = $.ajax({
                url: "{{ route('delete.bloque.tabla') }}",
                type: "post",
                dataType: "json",
                data: {
                    id_corte,
                    bloque: valor
                }
            });
            datos.done((res) => {
                var elemento = document.querySelector(".ui-pnotify-fade-normal");
                if (elemento) {
                    elemento.parentNode.removeChild(elemento);
                }
                notificacion("¡Excelente! Bloque eliminado", "success", 3000)
                document.getElementById('infoBloquesUtilizadosTabla').innerHTML = res.bloques
            })
            datos.fail(() => {
                notificacion("¡ERROR! Hubo un problema de conexión, vuelve a intentarlo", "error", 6000)
            })
        }

        agregarInfoGeneralCorteTablas = () => {
            var cantidad = $("#txtCantidadTabla").val()
            if (cantidad.length > 0) {
                var datos = $.ajax({
                    url: window.location.href,
                    type: "post",
                    dataType: "json",
                    data: {
                        cantidad
                    }
                })
                datos.done((res) => {
                    notificacion("¡Excelente! Seguimiento de corte de tabla agregado exitosamente", "success", 3000)
                    document.getElementById('infoGeneralEstado').innerHTML = res.estado
                    document.getElementById('infoCantidadPendiente').innerHTML = res.pendiente
                    document.getElementById('cantidadCortadaInfo').innerHTML = res.cortada
                    $("#txtCantidadTabla").val('')
                })
                datos.fail(() => {
                    notificacion("¡ERROR! Hubo un problema de conexión, por favor vuelve a intentarlo", "error", 5000)
                })
            } else {
                notificacion("¡ERROR! Debes agregar un valor mayor a 0", "error", 5000)
            }
        }

        confirmarTerminarCorte = () => {
            Swal.fire({
                title: "Estas seguro de terminar?",
                text: "Se cerrará el corte actual",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, terminar",
                cancelButtonText: "No, cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Cerrado!",
                        text: "Su corte se ha cerrado exitosamente",
                        icon: "success"
                    });
                    setTimeout(() => {
                        terminarCerrarCorte()
                    }, 1000);
                }
            });
        }

        terminarCerrarCorte = () => {
            var datos = $.ajax({
                url: window.location.href,
                type: "post",
                dataType: "json",
                data: {
                    terminar: 1
                }
            })
            datos.done((res) => {
                window.location.href = res.url
            })
        }
    </script>
@endsection
