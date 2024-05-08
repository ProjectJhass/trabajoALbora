@extends('apps.intranet.plantilla.app')
@section('title')
    Carpetas temporales
@endsection
@section($seccion)
    bg-danger active
@endsection
@section('body')
    @if (($permiso['dpto'] == Auth::user()->dpto_user && $permiso['permiso'] == Auth::user()->permiso_dpto) || Auth::user()->permisos == '4')
        <?php $permiso_edit = 1; ?>
    @else
        <?php $permiso_edit = 0; ?>
    @endif
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Documentos temporales</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item text-blue">Inicio</li>
                        <li class="breadcrumb-item active">Temporales</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                @if ($permiso_edit == 1)
                    <div class="col-md-4 mb-3">
                        <div class="card card-outline card-secondary">
                            <div class="card-header">
                                Cargar información
                            </div>
                            <div class="card-body">
                                <form method="post" id="form-documentacion-tmp" enctype="multipart/form-data">
                                    @csrf
                                    <div class="input-group mb-3">
                                        <input type="file" name="archivos_tmp[]" multiple class="form-control" id="archivos_tmp">
                                        {{-- <div class="custom-file">
                                            <input type="file" name="archivos_tmp[]" multiple class="custom-file-input" id="archivos_tmp">
                                            <label class="custom-file-label" for="archivos_tmp">Buscar archivos</label>
                                        </div> --}}
                                    </div>
                                    <button type="button" onclick="CargarDocumentosTemporales('form-documentacion-tmp')" class="btn btn-danger">Cargar
                                        información</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="col-md-{{ $permiso_edit == 1 ? '8' : '12' }} mb-3">
                    <div class="card card-outline card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Documentos cargados</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <ul class="nav nav-pills flex-column">
                                @foreach ($documentos as $item)
                                    <li class="nav-item active">
                                        <a href="{{ asset($item->url) }}" target="_BLANK" class="nav-link">
                                            <i class="far fa-file-alt"></i> {{ $item->nombre_doc }}
                                            <span class="badge bg-success float-right">{{ $item->tipo }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('footer')
    <script src="{{ asset('js/tmp.js') }}"></script>
@endsection
