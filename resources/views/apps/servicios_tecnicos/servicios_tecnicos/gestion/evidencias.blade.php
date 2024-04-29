@if ($estado != 'definido' && ($seccion == 'recogida' || $seccion == 'taller_ingreso' || $seccion == 'taller_reparado'))
    <div class="row mb-4">
        <div class="col-md-12">
            <form id="form-new-evidencias-ost" enctype="multipart/form-data">
                <div class="input-group">
                    <input type="text" class="form-control" name="seccion_evidencias" id="seccion_evidencias" value="{{ $seccion }}" hidden>
                    <input type="text" class="form-control" id="id_ost_evidencias" name="id_ost_evidencias" value="{{ $id_st }}" hidden>
                    <input type="file" class="form-control" id="file_evidencia_ost" name="file_evidencia_ost[]" multiple aria-label="Upload" />
                    <button class="btn btn-outline-danger" type="button" onclick="cargarInfoEvidenciasOstN()">Cargar</button>
                </div>
            </form>
        </div>
    </div>
@endif
@if (count($evidencias) > 0)
    @if ($estado != 'definido' && $seccion != 'recogida' && $seccion != 'taller_ingreso' && $seccion != 'taller_reparado')
        <div class="row mb-4">
            <div class="col-md-12">
                <form id="form-new-evidencias-ost" enctype="multipart/form-data">
                    <div class="input-group">
                        <input type="text" class="form-control" name="seccion_evidencias" id="seccion_evidencias" value="{{ $seccion }}" hidden>
                        <input type="text" class="form-control" id="id_ost_evidencias" name="id_ost_evidencias" value="{{ $id_st }}" hidden>
                        <input type="file" class="form-control" id="file_evidencia_ost" name="file_evidencia_ost[]" multiple aria-label="Upload" />
                        <button class="btn btn-outline-danger" type="button" onclick="cargarInfoEvidenciasOstN()">Cargar</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
    <div class="row">
        @foreach ($evidencias as $item)
            <div class="col-md-12 mb-2">
                <div class="bs-toast toast show" style="min-width: 100%" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header">
                        @if ($estado != 'definido')
                            <button type="button" class="btn-close"
                                onclick="EliminarInfoEvidenciaOst('{{ $item->tabla }}','{{ $item->id }}','{{ $id_st }}')"></button>
                        @endif
                        @if ($item->tipo == 'mp4')
                            <video width="100%" controls>
                                <source src="{{ asset($item->url) }}" type="video/mp4">
                                El video no es soportado por el navegador
                            </video>
                        @else
                            <a href="{{ asset($item->url) }}" target="_BLANK"><img src="{{ asset($item->url) }}" alt="{{ $item->nombre_img }}"
                                    width="100%"></a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <p>Aún no se ha realizado el cargue de las evidencias para esta orden de servicio</p>
@endif
