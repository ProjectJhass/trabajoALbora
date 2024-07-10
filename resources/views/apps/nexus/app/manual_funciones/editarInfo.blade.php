@extends('apps.nexus.plantilla.app')
@section('manual')
    active
@endsection
@section('head')
    <style>
        .select2-selection {
            height: 2.6rem !important;
        }
    </style>
@endsection
@section('body')
    <div class="row justify-content-center">
        <div class="col-md-9">
            @php
                $info_g = $manual->first();
            @endphp
            @foreach ($manual as $manual_i)
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Manual de funciones</h4>
                    </div>
                    <div class="card-body">
                        <form id="formInfoManualFuncionesNexus" method="post" class="was-validated">
                            @csrf
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item mb-4">
                                    <h5>GENERALIDADES</h5>
                                    <div class="row mt-4">
                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">
                                                <label for="">Compañía</label>
                                                <select class="form-control" required onchange="buscarAreasEmpresa()" name="seccion_empresa"
                                                    id="seccion_empresa">
                                                    <option value="">Seleccionar...</option>
                                                    <option value="1" {{ $manual_i->id_empresa == 1 ? 'selected' : '' }}>Muebles Albura - Fábrica
                                                    </option>
                                                    <option value="2" {{ $manual_i->id_empresa == 2 ? 'selected' : '' }}>Muebles Albura - Principal
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">
                                                <label for="">Área/Dependencia</label>
                                                <select class="form-control" required onchange="buscarCargosAreas()" name="area_dependencia"
                                                    id="area_dependencia">
                                                    <option value="">Seleccionar...</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">
                                                <label for="">Cargo</label>
                                                <select class="form-control" required name="cargo_dependencia" id="cargo_dependencia">
                                                    <option value="">Seleccionar...</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">
                                                <label for="">Operación asignada</label>
                                                <input type="text" class="form-control" value="{{ $manual_i->operacion_asignada }}"
                                                    name="operacion_asignada" id="operacion_asignada">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">
                                                <label for="">Jefe inmediato</label>
                                                <select class="form-control js-example-basic-multiple" name="jefe_inmediato" id="jefe_inmediato">
                                                    <option value=""></option>
                                                    @foreach ($usuarios as $item)
                                                        @php
                                                            $jefe_ = trim($item->nombre . ' ' . $item->apellidos);
                                                        @endphp
                                                        <option value="{{ $jefe_ }}" {{ $manual_i->jefe_inmediato == $jefe_ ? 'selected' : '' }}>
                                                            {{ $jefe_ }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">
                                                <label for="">Autoridad formal</label>
                                                <input type="text" class="form-control" value="{{ $manual_i->autoridad_formal }}"
                                                    name="autoridad_formal" id="autoridad_formal">
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item mb-4">
                                    <h5>OBJETIVO GENERAL</h5>
                                    <div class="row mt-4">
                                        <div class="col-md-12 mb-3">
                                            <div class="form-group">
                                                <textarea class="form-control" required name="objetivo_general" id="objetivo_general" cols="30" rows="3">{{ $manual_i->objetivo_general }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                                @foreach ($secciones as $item)
                                    @php
                                        $bandera = 1;
                                    @endphp
                                    @switch($item->id_seccion)
                                        @case(2)
                                            @php
                                                $sec2 = $bandera;
                                            @endphp
                                            <li class="list-group-item mb-4">
                                                <h5>{{ $item->seccion }} <i class="fas fa-plus-circle text-warning" style="cursor: pointer"
                                                        onclick="crearInputFuncionesGenerales('{{ $item->id_seccion }}')"></i></h5>
                                                <hr class="divider">
                                                <div class="form-group mt-4" id="funGeneral{{ $item->id_seccion }}">
                                                    @foreach ($manual_i->funcionesGenerales as $respuesta)
                                                        @if ($respuesta->id_seccion == 2)
                                                            <div class="input-group mb-3" id="funGeneral-{{ $item->id_seccion }}-{{ $bandera }}">
                                                                <input type="text" value="{{ $respuesta->descripcion }}" class="form-control" required=""
                                                                    name="funGeneral{{ $item->id_seccion }}_{{ $bandera }}"
                                                                    id="funGeneral{{ $item->id_seccion }}_{{ $bandera }}">
                                                                <span class="input-group-text delete-fun-general"><i class="fas fa-times text-danger"></i></span>
                                                            </div>
                                                            @php
                                                                $bandera++;
                                                                $sec2 = $bandera;
                                                            @endphp
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </li>
                                            <input type="text" hidden value="{{ $sec2 - 1 }}" class="form-control" name="input{{ $item->id_seccion }}"
                                                id="input{{ $item->id_seccion }}">
                                        @break

                                        @case(3)
                                            @php
                                                $sec3 = $bandera;
                                            @endphp
                                            <li class="list-group-item mb-4">
                                                <h5>{{ $item->seccion }} <i class="fas fa-plus-circle text-warning" style="cursor:pointer"
                                                        onclick="crearInputFuncionesEspecificas('{{ $item->id_seccion }}')"></i></h5>
                                                <hr class="divider">
                                                <div class="form-group mt-4" id="funEspecifica{{ $item->id_seccion }}">
                                                    @foreach ($manual_i->funcionesGenerales as $respuesta)
                                                        @if ($respuesta->id_seccion == 3)
                                                            <div class="input-group mb-3" id="funEspecifica-{{ $item->id_seccion }}-{{ $bandera }}">
                                                                <input type="text" value="{{ $respuesta->descripcion }}" required=""
                                                                    name="descripcion{{ $item->id_seccion }}_{{ $bandera }}"
                                                                    id="descripcion{{ $item->id_seccion }}_{{ $bandera }}" placeholder="Descripción"
                                                                    class="form-control">
                                                                <select class="form-control" required=""
                                                                    name="relevancia{{ $item->id_seccion }}_{{ $bandera }}"
                                                                    id="relevancia{{ $item->id_seccion }}_{{ $bandera }}">
                                                                    <option value="">Relevancia</option>
                                                                    <option value="Alto" {{ $respuesta->relevancia == 'Alto' ? 'selected' : '' }}>Alto
                                                                    </option>
                                                                    <option value="Medio" {{ $respuesta->relevancia == 'Medio' ? 'selected' : '' }}>Medio
                                                                    </option>
                                                                    <option value="Bajo" {{ $respuesta->relevancia == 'Bajo' ? 'selected' : '' }}>Bajo
                                                                    </option>
                                                                </select>
                                                                <select class="form-control" required=""
                                                                    name="frecuencia{{ $item->id_seccion }}_{{ $bandera }}"
                                                                    id="frecuencia{{ $item->id_seccion }}_{{ $bandera }}">
                                                                    <option value="">Frecuencia</option>
                                                                    <option {{ $respuesta->frecuencia = 'Diario' ? 'selected' : '' }} value="Diario">Diario
                                                                    </option>
                                                                    <option {{ $respuesta->frecuencia = 'Semanal' ? 'selected' : '' }} value="Semanal">Semanal
                                                                    </option>
                                                                    <option {{ $respuesta->frecuencia = 'Quincenal' ? 'selected' : '' }} value="Quincenal">
                                                                        Quincenal
                                                                    </option>
                                                                    <option {{ $respuesta->frecuencia = 'Mensual' ? 'selected' : '' }} value="Mensual">Mensual
                                                                    </option>
                                                                    <option {{ $respuesta->frecuencia = 'Bimensual' ? 'selected' : '' }} value="Bimensual">
                                                                        Bimensual
                                                                    </option>
                                                                    <option {{ $respuesta->frecuencia = 'Trimestral' ? 'selected' : '' }} value="Trimestral">
                                                                        Trimestral</option>
                                                                    <option {{ $respuesta->frecuencia = 'Semestral' ? 'selected' : '' }} value="Semestral">
                                                                        Semestral
                                                                    </option>
                                                                    <option {{ $respuesta->frecuencia = 'Anual' ? 'selected' : '' }} value="Anual">Anual
                                                                    </option>
                                                                    <option {{ $respuesta->frecuencia = 'Por requerimiento' ? 'selected' : '' }}
                                                                        value="Por requerimiento">Por requerimiento</option>
                                                                </select>
                                                                <span class="input-group-text delete-fun-especificas" style="cursor:pointer"><i
                                                                        class="fas fa-times text-danger"></i></span>
                                                            </div>
                                                            @php
                                                                $bandera++;
                                                                $sec3 = $bandera;
                                                            @endphp
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </li>
                                            <input type="text" hidden value="{{ $sec3 - 1 }}" class="form-control"
                                                name="input{{ $item->id_seccion }}" id="input{{ $item->id_seccion }}">
                                        @break

                                        @default
                                            <li class="list-group-item mb-4">
                                                <h5 class="mb-5">{{ $item->seccion }}</h5>
                                                @foreach ($item->subSecciones as $value)
                                                    @php
                                                        $ban_ = 1;
                                                        $secsub = $ban_;
                                                    @endphp
                                                    <h6>{{ $value->seccion_m }} <i class="fas fa-plus-circle fa-lg text-warning" style="cursor: pointer"
                                                            onclick="crearInfoInput('{{ $value->id_seccion_m }}', '{{ $item->id_seccion }}')"></i></h6>
                                                    <div class="form-group mt-4" id="sub{{ $value->id_seccion_m }}">
                                                        @foreach ($manual_i->funcionesGenerales as $respuesta)
                                                            @if ($respuesta->id_seccion == $item->id_seccion && $respuesta->id_subseccion == $value->id_seccion_m)
                                                                <div class="input-group mb-3" id="sub-{{ $respuesta->id_subseccion }}-{{ $ban_ }}">
                                                                    <input type="text" value="{{ $respuesta->descripcion }}"
                                                                        name="sub{{ $respuesta->id_subseccion }}_{{ $ban_ }}"
                                                                        id="sub{{ $respuesta->id_subseccion }}_{{ $ban_ }}" required=""
                                                                        class="form-control" aria-describedby="basic-addon2">
                                                                    <span class="input-group-text delete-subInput" style="cursor: pointer" id="basic-addon2"><i
                                                                            class="fas fa-times text-danger"></i></span>
                                                                </div>
                                                                @php
                                                                    $ban_++;
                                                                    $secsub = $ban_;
                                                                @endphp
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                    <input type="text" hidden value="{{ $secsub - 1 }}" class="form-control"
                                                        name="input{{ $item->id_seccion . $value->id_seccion_m }}"
                                                        id="input{{ $item->id_seccion . $value->id_seccion_m }}">
                                                    <hr>
                                                @endforeach
                                            </li>
                                    @endswitch
                                @endforeach
                            </ul>
                            <center>
                                <button type="button" class="btn btn-danger" onclick="formCrearInformacionManualFunciones()">Crear manual de
                                    funciones</button>
                            </center>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
@section('footer')
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
            buscarAreasEmpresa()
            setTimeout(() => {
                $("#area_dependencia").val("{{ $info_g->id_area }}")
            }, 500);
            setTimeout(() => {
                buscarCargosAreas()
            }, 1000);
            setTimeout(() => {
                $("#cargo_dependencia").val("{{ $info_g->id_cargo }}")
            }, 1500);
        });

        buscarAreasEmpresa = () => {
            var id = $("#seccion_empresa").val()

            if (id.length > 0) {
                var datos = $.ajax({
                    url: "{{ route('search.areas.nexus') }}",
                    type: "post",
                    dataType: "json",
                    data: {
                        id
                    }
                });
                datos.done((res) => {
                    notificacion("Información encontrada", "success", 3000)
                    document.getElementById('area_dependencia').innerHTML = res.info
                })
            } else {
                document.getElementById('area_dependencia').innerHTML = ""
            }
        }

        buscarCargosAreas = () => {
            var area = $("#area_dependencia").val()

            if (area.length > 0) {
                var datos = $.ajax({
                    url: "{{ route('search.cargos.nexus') }}",
                    type: "post",
                    dataType: "json",
                    data: {
                        area
                    }
                });
                datos.done((res) => {
                    notificacion("Información encontrada", "success", 3000)
                    document.getElementById('cargo_dependencia').innerHTML = res.info
                })
            } else {
                document.getElementById('cargo_dependencia').innerHTML = ""
            }
        }

        crearInfoInput = (id_subseccion, id_seccion) => {
            const container = document.getElementById('sub' + id_subseccion);
            const divCount = container.childElementCount + 1;
            const newDiv = document.createElement('div');
            newDiv.classList.add('input-group', 'mb-3');
            newDiv.id = `sub-${id_subseccion}-${divCount}`;

            newDiv.innerHTML = `
                        <input type="text" name="sub${id_subseccion}_${divCount}" id="sub${id_subseccion}_${divCount}" required class="form-control" aria-describedby="basic-addon2">
                        <span class="input-group-text delete-subInput" style="cursor: pointer" id="basic-addon2"><i class="fas fa-times text-danger"></i></span>
                `;

            newDiv.querySelector('.delete-subInput').addEventListener('click', () => {
                container.removeChild(newDiv);
                updateIdentifiers(container, id_subseccion, "sub", id_seccion);
            });

            container.appendChild(newDiv);
            $("#input" + id_seccion + id_subseccion).val(divCount)
        }

        updateIdentifiers = (container, id_subseccion, seccion, id_seccion) => {
            const children = container.children;
            for (let i = 0; i < children.length; i++) {
                const div = children[i];
                div.id = `${seccion}-${id_subseccion}-${i + 1}`;
                const input = div.querySelector('input');
                input.name = `${seccion+id_subseccion}_${i + 1}`;
                input.id = `${seccion+id_subseccion}_${i + 1}`;
            }

            $("#input" + id_seccion + id_subseccion).val(children.length)
        }

        crearInputFuncionesGenerales = (id_funcion) => {
            const container = document.getElementById('funGeneral' + id_funcion);
            const divCount = container.childElementCount + 1;
            const newDiv = document.createElement('div');
            newDiv.classList.add('input-group', 'mb-3');
            newDiv.id = `funGeneral-${id_funcion}-${divCount}`;

            newDiv.innerHTML = `<input type="text" class="form-control" required name="funGeneral${id_funcion}_${divCount}" id="funGeneral${id_funcion}_${divCount}">
                        <span class="input-group-text delete-fun-general"><i class="fas fa-times text-danger"></i></span>`;

            newDiv.querySelector('.delete-fun-general').addEventListener('click', () => {
                container.removeChild(newDiv);
                updateIdentifiers(container, id_funcion, "funGeneral", "");
            });

            container.appendChild(newDiv);
            $("#input" + id_funcion).val(divCount)
        }

        crearInputFuncionesEspecificas = (id_funcion) => {
            const container = document.getElementById('funEspecifica' + id_funcion);
            const divCount = container.childElementCount + 1;
            const newDiv = document.createElement('div');
            newDiv.classList.add('input-group', 'mb-3');
            newDiv.id = `funEspecifica-${id_funcion}-${divCount}`;

            newDiv.innerHTML = `
                                <input type="text" required name="descripcion${id_funcion}_${divCount}" id="descripcion${id_funcion}_${divCount}" placeholder="Descripción" class="form-control">
                                <select class="form-control" required name="relevancia${id_funcion}_${divCount}" id="relevancia${id_funcion}_${divCount}">
                                    <option value="">Relevancia</option>
                                    <option value="Alto">Alto</option>
                                    <option value="Medio">Medio</option>
                                    <option value="Bajo">Bajo</option>
                                </select>
                                <select class="form-control" required name="frecuencia${id_funcion}_${divCount}" id="frecuencia${id_funcion}_${divCount}">
                                    <option value="">Frecuencia</option>
                                    <option value="Diario">Diario</option>
                                    <option value="Semanal">Semanal</option>
                                    <option value="Quincenal">Quincenal</option>
                                    <option value="Mensual">Mensual</option>
                                    <option value="Bimensual">Bimensual</option>
                                    <option value="Trimestral">Trimestral</option>
                                    <option value="Semestral">Semestral</option>
                                    <option value="Anual">Anual</option>
                                    <option value="Por requerimiento">Por requerimiento</option>
                                </select>
                                <span class="input-group-text delete-fun-especificas" style="cursor:pointer"><i class="fas fa-times text-danger"></i></span>
                        `;

            newDiv.querySelector('.delete-fun-especificas').addEventListener('click', () => {
                container.removeChild(newDiv);
                updateIdentifiersEspe(container, id_funcion);
            });

            container.appendChild(newDiv);
            $("#input" + id_funcion).val(divCount)
        }

        updateIdentifiersEspe = (container, id_funcion) => {
            const children = container.children;
            for (let i = 0; i < children.length; i++) {
                const div = children[i];
                div.id = `funEspecifica-${id_funcion}-${i + 1}`;
                const input = div.querySelector('input');
                input.name = `descripcion${id_funcion}_${i + 1}`;
                input.id = `descripcion${id_funcion}_${i + 1}`;
                const relevancia = div.querySelector('select[name^="relevancia"]');
                relevancia.name = `relevancia${id_funcion}_${i + 1}`;
                relevancia.id = `relevancia${id_funcion}_${i + 1}`;
                const frecuencia = div.querySelector('select[name^="frecuencia"]');
                frecuencia.name = `frecuencia${id_funcion}_${i + 1}`;
                frecuencia.id = `frecuencia${id_funcion}_${i + 1}`;
            }
            $("#input" + id_funcion).val(children.length)
        }

        formCrearInformacionManualFunciones = () => {

            var area = document.getElementById("area_dependencia");
            var nom_area = area.options[area.selectedIndex].text;

            var cargo = document.getElementById("cargo_dependencia");
            var nom_cargo = cargo.options[cargo.selectedIndex].text;

            var formulario = new FormData(document.getElementById('formInfoManualFuncionesNexus'));
            formulario.append('nom_area', nom_area);
            formulario.append('nom_cargo', nom_cargo);
            var datos = $.ajax({
                url: "{{ route('crear.manual.nexus') }}",
                type: "post",
                dataType: "json",
                data: formulario,
                cache: false,
                contentType: false,
                processData: false
            });
            datos.done((res) => {
                if (res.status == true) {
                    notificacion(res.mensaje, "success", 5000)
                    document.getElementById('formInfoManualFuncionesNexus').reset()
                }
            })
            datos.fail(() => {
                notificacion("¡ERROR! Hubo un problema de conexión, vuelve a intentar", "error", 5000)
            })
        }
    </script>
@endsection
