@extends('apps.control_madera.plantilla.app')
@section('head')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        /* Loader Styles start here */
        .loader-wrapper {
            --line-width: 5px;
            --curtain-color: #f1faee;
            --outer-line-color: #ff0000;
            --middle-line-color: #7c7c7c;
            --inner-line-color: #000000;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1000;
        }

        .loader {
            display: block;
            position: relative;
            top: 50%;
            left: 50%;
            /*   transform: translate(-50%, -50%); */
            width: 150px;
            height: 150px;
            margin: -75px 0 0 -75px;
            border: var(--line-width) solid transparent;
            border-top-color: var(--outer-line-color);
            border-radius: 100%;
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
            z-index: 1001;
        }

        .loader:before {
            content: "";
            position: absolute;
            top: 4px;
            left: 4px;
            right: 4px;
            bottom: 4px;
            border: var(--line-width) solid transparent;
            border-top-color: var(--inner-line-color);
            border-radius: 100%;
            -webkit-animation: spin 3s linear infinite;
            animation: spin 3s linear infinite;
        }

        .loader:after {
            content: "";
            position: absolute;
            top: 14px;
            left: 14px;
            right: 14px;
            bottom: 14px;
            border: var(--line-width) solid transparent;
            border-top-color: var(--middle-line-color);
            border-radius: 100%;
            -webkit-animation: spin 1.5s linear infinite;
            animation: spin 1.5s linear infinite;
        }

        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        .loader-wrapper .loader-section {
            position: fixed;
            top: 0;
            background: #ffffff6e;
            width: 51%;
            height: 100%;
            z-index: 1000;
        }

        .loader-wrapper .loader-section.section-left {
            left: 0
        }

        .loader-wrapper .loader-section.section-right {
            right: 0;
        }

        /* Loaded Styles */
        .loaded .loader-wrapper .loader-section.section-left {
            transform: translateX(-100%);
            transition: all 0.7s 0.3s cubic-bezier(0.645, 0.045, 0.355, 1.000);
        }

        .loaded .loader-wrapper .loader-section.section-right {
            transform: translateX(100%);
            transition: all 0.7s 0.3s cubic-bezier(0.645, 0.045, 0.355, 1.000);
        }

        .loaded .loader {
            opacity: 0;
            transition: all 0.3s ease-out;
        }

        .loaded .loader-wrapper {
            visibility: hidden;
            transform: translateY(-100%);
            transition: all .3s 1s ease-out;
        }
    </style>
@endsection
@section('p.edit.serie')
    active
@endsection
@section('body')
    <div class="loader-wrapper">
        <div class="loader"></div>
        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card alert-top" data-aos="fade-up" data-aos-delay="200">
                <div class="flex-wrap card-header d-flex justify-content-between align-items-center">
                    <div class="header-title">
                        <h4 class="card-title mb-0">Editar información</h4>
                    </div>
                    <a href="{{ route('crear.serie.piezas') }}" type="button" class="btn btn-sm btn-info"><i class="fas fa-plus"></i> Crear nueva
                        serie</a>
                </div>
                <div class="card-body">
                    <form class="form-label-left input_mask" id="formInfoPlanificacionMadera" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group row">
                                    <label class="col-form-label col-md-3 col-sm-3 ">Serie </label>
                                    <div class="col-md-9 col-sm-9 ">
                                        <select name="serie_planner" id="serie_planner"
                                            onchange="searchInfoMadera(this.value); validarDeleteTitleSerie(this.value);" class="form-control">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($series as $item)
                                                <option value="{{ $item->id_serie }}">{{ $item->serie }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger" id="titleDeleteSerie" hidden style="cursor: pointer"
                                            onclick="eliminarSerieEdit()"><small>¿Eliminar
                                                serie?</small></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group row">
                                    <label class="col-form-label col-sm-3 ">Madera </label>
                                    <div class="col-md-9 col-sm-9 ">
                                        <select name="madera_planner" id="madera_planner" onchange="searchInfoMueble(this.value)" disabled
                                            class="form-control">
                                            <option value="">Seleccionar...</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group row">
                                    <label class="col-form-label col-sm-3">Mueble </label>
                                    <div class="col-md-9 col-sm-9 ">
                                        <select name="mueble_planner" onchange="validarDeleteInfo(this.value)" id="mueble_planner" class="form-control"
                                            disabled>
                                            <option value="">Seleccionar...</option>
                                        </select>
                                        <span class="text-danger" hidden id="titleDeleteMueble" style="cursor: pointer"
                                            onclick="eliminarMuebleEdit()"><small>¿Eliminar
                                                mueble?</small></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="form-group text-center">
                            <button type="button" class="btn btn-secondary" onclick="limpiarCampos()" id="btnResetPlanner"
                                type="reset">Limpiar</button>
                            <button type="button" onclick="planificarCorteMadera()" id="btnCreateplanMadera" class="btn btn-danger">Buscar
                                información</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card alert-top alert-danger" data-aos="fade-up" data-aos-delay="400">
                <div class="flex-wrap card-header d-flex justify-content-between align-items-center">
                    <h6 class="card-title">Piezas de la serie</h6>
                    <div class="card-tools" id="btnAddNewFila" data-bs-toggle="modal" data-bs-target="#modalAgregarPiezaSerie" hidden
                        style="cursor: pointer">
                        <i class="fas fa-plus-circle"></i> Agregar nueva pieza
                    </div>
                </div>
                <div class="card-body">
                    <form id="formEditInfoPiezasMadera" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box" id="piezasgeneradasplanseries"></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modalAgregarPiezaSerie" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar nueva pieza</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formAgregarNuevaPiezaSerieActual">
                        @csrf
                        <div class="accordion" id="accordionPlannerN1">
                            <div class="accordion-item">
                                <h4 class="accordion-header" id="headingPlannerN1">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePlannerN1"
                                        aria-expanded="true" aria-controls="collapsePlannerN1">
                                        Nueva pieza de la serie
                                    </button>
                                </h4>
                                <div id="collapsePlannerN1" class="accordion-collapse collapse show" aria-labelledby="headingPlannerN1"
                                    data-bs-parent="#accordionPlannerN1">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label for="">Pieza</label>
                                                <input type="text" name="nombreN1" id="nombreN1" class="form-control">
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label for="">Cantidad</label>
                                                <input type="number" name="cantidadN1" id="cantidadN1" class="form-control">
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label for="">Largo</label>
                                                <input type="number" name="largoN1" id="largoN1" class="form-control">
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label for="">Ancho</label>
                                                <input type="number" name="anchoN1" id="anchoN1" class="form-control">
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label for="">Grueso</label>
                                                <input type="number" name="gruesoN1" id="gruesoN1" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times-circle"></i> Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="crearNuevaPiezaPlanner()"><i class="fas fa-plus"></i> Agregar nueva
                        pieza</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        window.addEventListener('load', function() {
            document.querySelector('body').classList.add("loaded")
        });

        clickInputSelect = (id) => {
            document.getElementById('troncos' + id).click();
        }

        infoInput = (id) => {
            return $('#troncoNum' + id).val()
        }

        limpiarCampos = () => {
            $('#madera_planner').prop('disabled', true)
            $('#mueble_planner').prop('disabled', true)
            $('#cantidad_planner').prop('disabled', true)
            $('#btnCreateplanMadera').prop('disabled', true)
            document.getElementById('formInfoPlanificacionMadera').reset()
            document.getElementById('piezasgeneradasplanseries').innerHTML = ''
            document.getElementById('btnAddNewFila').hidden = true
        }

        planificarCorteMadera = () => {
            notificacion("Buscando información...", "info", 10000);
            document.querySelector('body').classList.remove("loaded")
            var formulario = new FormData(document.getElementById('formInfoPlanificacionMadera'));
            formulario.append('valor', 'valor');
            var datos = $.ajax({
                url: "{{ route('get.info.p.series') }}",
                type: "post",
                dataType: "json",
                data: formulario,
                cache: false,
                contentType: false,
                processData: false
            });
            datos.done((res) => {
                document.querySelector('body').classList.add("loaded")
                if (res.status == true) {
                    notificacion("¡Información hallada exitosamente!", "success", 3000)
                    document.getElementById('piezasgeneradasplanseries').innerHTML = res.planilla
                    document.getElementById('btnAddNewFila').hidden = false
                } else {
                    notificacion(res.mensaje, "error", 6000)
                }
            })
            datos.fail(() => {
                notificacion("ERROR! Revisa los campos y vuelve a intentarlo", "error", 5000);
                document.querySelector('body').classList.add("loaded")
            })
        }

        UpdateInfoPiezasSeries = () => {
            notificacion("Actualizando información de la serie...", "info", 10000);

            document.querySelector('body').classList.remove("loaded")
            var formulario = new FormData(document.getElementById('formEditInfoPiezasMadera'));

            var datos = $.ajax({
                url: "{{ route('update.info.p.series') }}",
                type: "post",
                dataType: "json",
                data: formulario,
                cache: false,
                contentType: false,
                processData: false
            });
            datos.done((res) => {
                $('#btnCreateplanMadera').click()
                document.querySelector('body').classList.add("loaded")
                notificacion(res.mensaje, "success", 5000)
            })
            datos.fail(() => {
                notificacion("ERROR! Revisa los campos y vuelve a intentarlo", "error", 5000);
                document.querySelector('body').classList.add("loaded")
            })
        }

        crearNuevaPiezaPlanner = () => {
            notificacion("Actualizando información de la serie...", "info", 10000);

            document.querySelector('body').classList.remove("loaded")
            var formulario = new FormData(document.getElementById('formAgregarNuevaPiezaSerieActual'));
            formulario.append('serie_planner', $("#serie_planner").val());
            formulario.append('madera_planner', $("#madera_planner").val());
            formulario.append('mueble_planner', $("#mueble_planner").val());

            var datos = $.ajax({
                url: "{{ route('create.info.p.series') }}",
                type: "post",
                dataType: "json",
                data: formulario,
                cache: false,
                contentType: false,
                processData: false
            });
            datos.done((res) => {
                document.querySelector('body').classList.add("loaded")
                if (res.status == true) {
                    document.getElementById('formAgregarNuevaPiezaSerieActual').reset()
                    notificacion(res.mensaje, "success", 5000)
                    setTimeout(() => {
                        $('#btnCreateplanMadera').click()
                    }, 1000);
                } else {
                    notificacion(res.mensaje, "error", 7000)
                }
            })
            datos.fail(() => {
                notificacion("ERROR! Revisa los campos y vuelve a intentarlo", "error", 5000);
                document.querySelector('body').classList.add("loaded")
            })
        }

        validarDeleteTitleSerie = (valor) => {
            if (valor.length > 0) {
                document.getElementById('titleDeleteSerie').hidden = false
            } else {
                document.getElementById('titleDeleteSerie').hidden = true
            }
        }

        eliminarSerieEdit = () => {
            var id_serie = $("#serie_planner").val()
            if (id_serie.length > 0) {
                Swal.fire({
                    title: "Esta seguro(a) de eliminar?",
                    text: "No podras reversar esta operación!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Si, eliminar",
                    cancelButtonText: "No, cancelar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        var datos = confirmDeleteSerie(id_serie)
                        datos.done((res) => {
                            if (res.status == true) {
                                notificacion(res.mensaje, "success", 5000)
                                setTimeout(() => {
                                    window.location.reload()
                                }, 1500);
                            }
                        })
                        datos.fail(() => {
                            notificacion("¡ERROR! hubo un problema al procesar la solicitud", "error", 5000)
                        })
                    }
                });
            }
        }

        confirmDeleteSerie = (id_serie) => {
            var datos = $.ajax({
                url: "{{ route('delete.serie.edit') }}",
                type: "post",
                dataType: "json",
                data: {
                    _token: "{{ csrf_token() }}",
                    id_serie
                }
            });
            return datos;
        }

        validarDeleteInfo = (valor) => {
            if (valor.length > 0) {
                document.getElementById('titleDeleteMueble').hidden = false
            } else {
                document.getElementById('titleDeleteMueble').hidden = true
            }
        }

        eliminarMuebleEdit = () => {
            var id_mueble = $("#mueble_planner").val()
            if (id_mueble.length > 0) {
                Swal.fire({
                    title: "Esta seguro(a) de eliminar?",
                    text: "No podras reversar esta operación!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Si, eliminar",
                    cancelButtonText: "No, cancelar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        var datos = confirmDeleteMueble(id_mueble)
                        datos.done((res) => {
                            if (res.status == true) {
                                notificacion(res.mensaje, "success", 5000)
                                setTimeout(() => {
                                    window.location.reload()
                                }, 1500);
                            }
                        })
                        datos.fail(() => {
                            notificacion("¡ERROR! hubo un problema al procesar la solicitud", "error", 5000)
                        })
                    }
                });
            }
        }

        confirmDeleteMueble = (id_mueble) => {
            var datos = $.ajax({
                url: "{{ route('delete.mueble.edit') }}",
                type: "post",
                dataType: "json",
                data: {
                    _token: "{{ csrf_token() }}",
                    id_mueble
                }
            });
            return datos;
        }
    </script>
@endsection
@section('footer')
@endsection
