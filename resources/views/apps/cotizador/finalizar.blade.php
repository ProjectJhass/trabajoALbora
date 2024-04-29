@extends('apps.cotizador.plantilla.app')
@section('title')
    Finalizar
@endsection
@section('body')
    <div class="row" style="margin-left: 2%; margin-right: 2%">
        <div class="col-md-2 mb-4 mt-3">
            <div class="card">
                <div class="card-header">
                    Generar PDF
                </div>
                <div class="card-body text-center">
                    <a href="{{ route('generar.pdf.cotizacion') }}" target="_BLANK"><img src="{{ asset('img/pdf.png') }}" width="50%" alt=""></a>
                </div>
                <div class="card-footer">
                    <a href="{{ route('generar.pdf.cotizacion') }}" target="_BLANK">Descargar PDF</a>
                </div>
            </div>
        </div>
        <div class="col-md-2 mb-4 mt-3">
            <div class="card">
                <div class="card-header">
                    WhatsApp
                </div>
                <div class="card-body text-center">
                    <a href="{{ route('enviar.whatsapp.cotizacion') }}" target="_BLANK"><img src="{{ asset('img/whatsapp.png') }}" width="50%"
                            alt=""></a>
                </div>
                <div class="card-footer">
                    <a href="{{ route('enviar.whatsapp.cotizacion') }}" target="_BLANK">Enviar por WhatsApp</a>
                </div>
            </div>
        </div>
        <div class="col-md-2 mb-4 mt-3">
            <div class="card">
                <div class="card-header">
                    Email
                </div>
                <div class="card-body text-center" style="cursor: pointer;" onclick="EnviarPdfEmail()">
                    <img src="{{ asset('img/mail.png') }}" width="50%" alt="">
                </div>
                <div class="card-footer" style="cursor: pointer;" onclick="EnviarPdfEmail()">
                    <span style="color: blue;">Enviar por email</span>
                </div>
            </div>
        </div>
        <div class="col-md-1"></div>
        @if (session('tipo_cotizacion_p') != 'CO')
            <div class="col-md-2 mb-4 mt-3">
                <div class="card">
                    <div class="card-header">
                        Documento Fogade
                    </div>
                    <div class="card-body text-center">
                        <a href="{{ route('generar.pdf.fogade') }}" target="_BLANK"><img src="{{ asset('img/documento.png') }}" width="50%"
                                alt=""></a>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('generar.pdf.fogade') }}" target="_BLANK">Descargar documento</a>
                    </div>
                </div>
            </div>
            <div class="col-md-2 mb-4 mt-3">
                <div class="card">
                    <div class="card-header">
                        Crédito
                    </div>
                    <div class="card-body text-center">
                        <a href="{{ route('generar.solicitud.credito') }}" target="_BLANK">
                            <img src="{{ asset('img/credito.png') }}" width="50%" alt="">
                        </a>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('generar.solicitud.credito') }}" target="_BLANK">
                            Solicitar crédito
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
@section('footer')
    <script>
        NotificacionProgreso = () => {
            Swal.fire({
                position: 'top-end',
                icon: 'info',
                title: 'Enviando email...',
                showConfirmButton: false,
                timer: 1000
            });
        }

        NotificacionDocFogade = () => {
            var path = window.location.pathname.replace('menu', '');
            Swal.fire({
                title: 'Debes descargar el documento FOGADE',
                text: "Si ya lo hiciste has caso omiso a este mensaje",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Continuar',
                cancelButtonText: 'Descargar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.open('https://app-mueblesalbura.com' + path + 'credito', '_BLANK');
                } else if (result.dismiss) {
                    window.open('https://app-mueblesalbura.com' + path + 'fogade', '_BLANK');
                }
            })
        }


        EnviarPdfEmail = () => {

            loandingPanel()

            var datos = $.ajax({
                url: "{{ route('enviar.correo.cotizacion') }}",
                type: "POST",
                dataType: "json",
                data: {
                    validar: '1'
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            datos.done((res) => {

                loadedPanel()

                if (res.status == true) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: res.mensaje,
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
                if (res.status == false) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: res.mensaje,
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            });
            datos.fail(() => {

                loadedPanel()

                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Hubo un problema al procesar la solicitud',
                    showConfirmButton: false,
                    timer: 2000
                });
            });
        }
    </script>
@endsection
