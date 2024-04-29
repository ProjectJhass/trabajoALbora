@extends('apps.intranet_fabrica.layout_fabrica.app')
@section('title')
    Carrucel
@endsection
@section('active-usuarios')
    bg-danger active
@endsection
@section('active-sub-carrucel')
    active
@endsection
@section('fabrica-body')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5 class="m-0">Imágenes</h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home.intranet.fabrica') }}">Fábrica</a></li>
                        <li class="breadcrumb-item active">Imágenes</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-outline card-danger">
                <div class="card-header">
                    Imágenes cargadas
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <small><strong>Antes de cargar las imagenes ve a este sitio web para comprimirlas <a href="https://compressor.io/"
                                        target="_BLANK">Compressor</a></strong></small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-outline card-secondary">
                                <div class="card-header">
                                    <strong>Imágenes Carrucel</strong>
                                    <div class="card-tools">
                                        <i class="fas fa-upload" style="cursor: pointer;"
                                            onclick="CargarImagenesAppFabrica('formulario-cargue-carrucel','carrucel')"></i>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form class="was-validated" id="formulario-cargue-carrucel">
                                        @csrf
                                        <div class="form-group">
                                            <label for="">Imágenes</label>
                                            <input type="file" multiple class="form-control" name="imagenes_carrucel[]" id="imagenes_carrucel[]">
                                        </div>
                                    </form>
                                    @foreach ($imagenes as $item)
                                        @if ($item->seccion_img == 'carrucel')
                                            <div class="callout callout-danger">
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <a href="{{ asset('storage/carrucel/' . $item->nombre_img) }}" target="_BLANK">
                                                            <img src="{{ asset('storage/carrucel/' . $item->nombre_img) }}" width="30%" alt="">
                                                        </a>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <i class="fas fa-eye {{ $item->estado == '1' ? 'text-green' : '' }}"
                                                            id="img{{ $item->id_imagen }}" style="cursor: pointer;"
                                                            onclick="ActivarImagenCarrucel('{{ $item->id_imagen }}','{{ $item->estado }}')"></i>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <i class="fas fa-trash text-danger" style="cursor: pointer;"
                                                            onclick="EliminarImagenesCarrucel('{{ $item->id_imagen }}')"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-outline card-secondary">
                                <div class="card-header">
                                    <strong>Imágen derecha</strong><small> (Activar solo una)</small>
                                    <div class="card-tools">
                                        <i class="fas fa-upload" style="cursor: pointer;"
                                            onclick="CargarImagenesAppFabrica('formulario-cargue-derecha','derecha')"></i>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form class="was-validated" id="formulario-cargue-derecha">
                                        @csrf
                                        <div class="form-group">
                                            <label for="">Imágen</label>
                                            <input type="file" class="form-control" name="imagenes_carrucel[]" id="imagenes_carrucel[]">
                                        </div>
                                    </form>
                                    @foreach ($imagenes as $item)
                                        @if ($item->seccion_img == 'derecha')
                                            <div class="callout callout-danger">
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <a href="{{ asset('storage/carrucel/' . $item->nombre_img) }}" target="_BLANK">
                                                            <img src="{{ asset('storage/carrucel/' . $item->nombre_img) }}" width="30%" alt="">
                                                        </a>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <i class="fas fa-eye {{ $item->estado == '1' ? 'text-green' : '' }}"
                                                            id="img{{ $item->id_imagen }}" style="cursor: pointer;"
                                                            onclick="ActivarImagenCarrucel('{{ $item->id_imagen }}','{{ $item->estado }}')"></i>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <i class="fas fa-trash text-danger" style="cursor: pointer;"
                                                            onclick="EliminarImagenesCarrucel('{{ $item->id_imagen }}')"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script>
        CargarImagenesAppFabrica = (form, tipo, url) => {
            var formData = new FormData(document.getElementById(form));
            formData.append('tipo', tipo);
            toastr.info('Cargando imágenes ...');
            var datos = $.ajax({
                url: "{{ route('add.imagenes') }}",
                type: "POST",
                dataType: "json",
                data: formData,
                cache: false,
                contentType: false,
                processData: false
            });
            datos.done((res) => {
                if (res.status == true) {
                    toastr.success('Imágenes cargadas exitosamente');
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                }
            });
            datos.fail(() => {
                toastr.error('ERROR: Verifica la información y vuelve a intentar');
            });
        }

        ActivarImagenCarrucel = (id_imagen, estado, url) => {
            var datos = $.ajax({
                url: "{{ route('activar.imagenes') }}",
                type: "POST",
                dataType: "json",
                data: {
                    id_imagen,
                    estado
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            datos.done((res) => {
                if (res.status == true) {
                    switch (res.estado) {
                        case '0':
                            $('#img' + id_imagen).removeClass('text-green');
                            break;
                        case '1':
                            $('#img' + id_imagen).addClass('text-green');
                            break;
                    }
                }
            });
            datos.fail(() => {
                toastr.error('ERROR: Verifica la información y vuelve a intentar');
            });
        }

        EliminarImagenesCarrucel = (id_imagen, url) => {
            var datos = $.ajax({
                url: "{{ route('eliminar.img.carrucel') }}",
                type: "POST",
                dataType: "json",
                data: {
                    id_imagen
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            datos.done((res) => {
                if (res.status == true) {
                    location.reload();
                }
            });
            datos.fail(() => {
                toastr.error('ERROR: Verifica la información y vuelve a intentar');
            });
        }
    </script>
@endsection
