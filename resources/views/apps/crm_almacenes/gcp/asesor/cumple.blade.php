@extends('apps.crm_almacenes.gcp.plantilla.app')
@section('title')
    Cumpleaños
@endsection
@section('contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Cumpleaños</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item text-blue">CRM</li>
                        <li class="breadcrumb-item active">Cumpleaños</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="card card-outline card-success">
                        <div class="card-body">
                            @foreach ($hoy as $item)
                                <?php $icon = $item->genero == 'MUJER' ? 'women.png' : 'man.png'; ?>
                                <div class="dropdown-item">
                                    <div class="media">
                                        <img src="{{ asset('img/' . $icon) }}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                                        <div class="media-body">
                                            <h3 class="dropdown-item-title">
                                                {{ $item->nombre_1 . ' ' . $item->nombre_2 . ' ' . $item->apellido_1 . ' ' . $item->apellido_2 }}
                                                <a href="https://web.whatsapp.com/send/?phone=57{{ $item->celular_1 }}&text&type=phone_number&app_absent=0" target="_BLANK" class="float-right text-sm text-success"><i
                                                        class="fab fa-whatsapp" style="font-size: 28px"></i></a>
                                            </h3>
                                            <p class="text-sm">Cumpleaños</p>
                                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> Hoy</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="dropdown-divider"></div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card card-outline card-info">
                        <div class="card-body">
                            @foreach ($ayer as $item)
                                <?php $icon = $item->genero == 'MUJER' ? 'women.png' : 'man.png'; ?>
                                <div class="dropdown-item">
                                    <div class="media">
                                        <img src="{{ asset('img/' . $icon) }}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                                        <div class="media-body">
                                            <h3 class="dropdown-item-title">
                                                {{ $item->nombre_1 . ' ' . $item->nombre_2 . ' ' . $item->apellido_1 . ' ' . $item->apellido_2 }}
                                                <a href="https://web.whatsapp.com/send/?phone=57{{ $item->celular_1 }}&text&type=phone_number&app_absent=0" target="_BLANK" class="float-right text-sm text-success"><i
                                                        class="fab fa-whatsapp" style="font-size: 28px"></i></a>
                                            </h3>
                                            <p class="text-sm">Cumpleaños</p>
                                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> Ayer</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="dropdown-divider"></div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card card-outline card-secondary">
                        <div class="card-body">
                            @foreach ($siente as $item)
                                <?php $icon = $item['genero'] == 'MUJER' ? 'women.png' : 'man.png'; ?>
                                <div class="dropdown-item">
                                    <div class="media">
                                        <img src="{{ asset('img/' . $icon) }}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                                        <div class="media-body">
                                            <h3 class="dropdown-item-title">
                                                {{ $item['nombre'] }}
                                                <a href="https://web.whatsapp.com/send/?phone=57{{ $item['celular'] }}&text&type=phone_number&app_absent=0" target="_BLANK" class="float-right text-sm text-success"><i
                                                        class="fab fa-whatsapp" style="font-size: 28px"></i></a>
                                            </h3>
                                            <p class="text-sm">Cumpleaños</p>
                                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> Últimos 7 días</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="dropdown-divider"></div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('footer')
@endsection
