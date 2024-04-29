@extends('apps.intranet.plantilla.app')
@section('title')
    Documentación Cartera
@endsection
@section('cartera')
    bg-danger active
@endsection
@section('body')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Páginas para referenciar clientes</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item text-blue">Inicio</li>
                        <li class="breadcrumb-item active">Referenciar</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>Cifín - Ubica</strong>
                        </div>
                        <div class="card-body">
                            <div class="text-center">
                                <a href="https://www.transunion.co/" target="_BLANK">
                                    <img src="{{ asset('icons/cifin.jpg') }} " width="80%" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>Datacrédito - Reconocer</strong>
                        </div>
                        <div class="card-body">
                            <div class="text-center">
                                <a href="https://www.datacredito.com.co/" target="_BLANK">
                                    <img src="{{ asset('icons/datacredito.png') }} " width="60%" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>Antecedentes judiciales</strong>
                        </div>
                        <div class="card-body">
                            <div class="text-center">
                                <a href="https://antecedentes.policia.gov.co:7005/WebJudicial/index.xhtml" target="_BLANK">
                                    <img src="{{ asset('icons/policeman.png') }} " width="30%" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>Ruaf</strong>
                        </div>
                        <div class="card-body">
                            <div class="text-center">
                                <a href="https://ruaf.sispro.gov.co/TerminosCondiciones.aspx" target="_BLANK">
                                    <img src="{{ asset('icons/ruaf.png') }} " width="40%" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>Adres</strong>
                        </div>
                        <div class="card-body">
                            <div class="text-center">
                                <a href="https://www.adres.gov.co/consulte-su-eps" target="_BLANK">
                                    <img src="{{ asset('icons/adres.jpg') }} " width="60%" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>Certificados de Libertad y tradición</strong>
                        </div>
                        <div class="card-body">
                            <div class="text-center">
                                <a href="https://certificados.supernotariado.gov.co/certificado" target="_BLANK">
                                    <img src="{{ asset('icons/certificado.png') }} " width="35%" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>Rues (Consulta empresarial)</strong>
                        </div>
                        <div class="card-body">
                            <div class="text-center">
                                <a href="https://www.rues.org.co/" target="_BLANK">
                                    <img src="{{ asset('icons/rues.png') }} " width="45%" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>Certificado de aportes</strong>
                        </div>
                        <div class="card-body">
                            <div class="text-center">
                                <a href="https://www.aportesenlinea.com/Autoservicio/CertificadoAportes.aspx" target="_BLANK">
                                    <img src="{{ asset('icons/aportes.png') }} " width="100%" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('footer')
    <script src="{{ asset('js/logistica.js') }}"></script>
@endsection
