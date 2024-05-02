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
@section('body')
    <div class="loader-wrapper">
        <div class="loader"></div>
        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>
    </div>

    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h2>Planificación</h2>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="page-body mt-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Información a planear</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card-box">
                                        <form class="form-label-left input_mask" id="formInfoPlanificacionMadera" autocomplete="off">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-group row">
                                                        <label class="col-form-label col-md-3 col-sm-3 ">Serie </label>
                                                        <div class="col-md-9 col-sm-9 ">
                                                            <select name="serie_planner" id="serie_planner" onchange="searchInfoMadera(this.value)"
                                                                class="form-control">
                                                                <option value="">Seleccionar...</option>
                                                                @foreach ($series as $item)
                                                                    <option value="{{ $item->id_serie }}">{{ $item->serie }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-group row">
                                                        <label class="col-form-label col-sm-3 ">Madera </label>
                                                        <div class="col-md-9 col-sm-9 ">
                                                            <select name="madera_planner" id="madera_planner" onchange="searchInfoMueble(this.value)"
                                                                disabled class="form-control">
                                                                <option value="">Seleccionar...</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-group row">
                                                        <label class="col-form-label col-sm-3">Mueble </label>
                                                        <div class="col-md-9 col-sm-9 ">
                                                            <select name="mueble_planner" onchange="insertCantidadChange(this.value)" id="mueble_planner"
                                                                class="form-control" disabled>
                                                                <option value="">Seleccionar...</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-group row">
                                                        <label class="col-form-label col-md-3 col-sm-3">Cantidad </label>
                                                        <div class="col-md-9 col-sm-9 ">
                                                            <input type="number" name="cantidad_planner" id="cantidad_planner" class="form-control"
                                                                disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ln_solid"></div>
                                            <div class="form-group text-center">
                                                <button class="btn btn-secondary" onclick="limpiarCampos()" id="btnResetPlanner"
                                                    type="reset">Limpiar</button>
                                                <button type="button" onclick="planificarCorteMadera()" id="btnCreateplanMadera" disabled
                                                    class="btn btn-danger">Crear
                                                    planificación</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Plan generado</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <form id="form-infoGenerada-planner" autocomplete="off">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="card-box" id="plan-generado-corte-madera"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
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
            //alert(id)
            document.getElementById('troncos' + id).click();
        }

        infoInput = (id) => {
            return $('#troncoNum' + id).val()
        }

        sumarPulgadas = (id, valor, operacion) => {
            var sum_act = parseFloat($('#sumPulg' + id).text())
            var originalString = valor;
            var partes = originalString.split(/\s*-\s*/);
            var pulgadas = partes[1]
            console.log(valor)
            pulgadas = parseFloat(pulgadas.replace("″", ""))

            if (operacion == 'sum') {
                var suma_pulgadas = sum_act + pulgadas;
            } else {
                var suma_pulgadas = sum_act - pulgadas;
            }


            $('#sumPulg' + id).text(suma_pulgadas)
        }

        troncoSeleccionado = (id, valor) => {
            $('#troncos' + id).val('')
            $('#troncos_selected' + id).append('<span class="badge badge-pill badge-secondary" style="cursor:pointer" id="' + id + valor +
                '" onclick="deleteTronco(\'' + id + '\',\'' + valor + '\')" >' + valor + '</span>\t')
            var text = infoInput(id)
            var text = text.replace(/^,/, '');
            $('#troncoNum' + id).val(text + ',' + valor)
            var text = infoInput(id)
            var text = text.replace(',,', ',');
            $('#troncoNum' + id).val(text)

            cambiarEstadoTronco(id, valor, 1)
            sumarPulgadas(id, valor, 'sum')
        }

        deleteTronco = (id, valor) => {
            document.getElementById(id + valor).remove()
            var text = infoInput(id)
            var text = text.replace(valor, '');
            $('#troncoNum' + id).val(text)
            var text = infoInput(id)
            var text = text.replace(',,', ',');
            $('#troncoNum' + id).val(text)

            cambiarEstadoTronco(id, valor, 2)
            sumarPulgadas(id, valor, 'res')
        }

        limpiarCampos = () => {
            $('#madera_planner').prop('disabled', true)
            $('#mueble_planner').prop('disabled', true)
            $('#cantidad_planner').prop('disabled', true)
            $('#btnCreateplanMadera').prop('disabled', true)
            document.getElementById('plan-generado-corte-madera').innerHTML = ''
        }

        cambiarEstadoTronco = (id, valor, estado) => {
            var datos = $.ajax({
                url: "{{ route('change.info.troncos') }}",
                type: "post",
                dataType: "json",
                data: {
                    valor,
                    estado
                }
            });
            datos.done((res) => {
                document.getElementById('troncos' + id).innerHTML = res.options
            })
        }       
        
        insertCantidadChange = (valor) => {
            if (valor.length > 0) {
                $('#btnCreateplanMadera').prop('disabled', false)
                $('#cantidad_planner').prop('disabled', false)
            } else {
                $('#cantidad_planner').val('')
                $('#cantidad_planner').prop('disabled', true)
                $('#btnCreateplanMadera').prop('disabled', true)
            }
        }

        planificarCorteMadera = () => {
            notificacion("Creando planificación...", "info", 10000);
            document.querySelector('body').classList.remove("loaded")
            var formulario = new FormData(document.getElementById('formInfoPlanificacionMadera'));
            formulario.append('valor', 'valor');
            var datos = $.ajax({
                url: "{{ route('create.planner.info') }}",
                type: "post",
                dataType: "json",
                data: formulario,
                cache: false,
                contentType: false,
                processData: false
            });
            datos.done((res) => {
                document.querySelector('body').classList.add("loaded")
                notificacion("¡Planificación creada exitosamente!", "success", 3000)
                document.getElementById('plan-generado-corte-madera').innerHTML = res.planilla
            })
            datos.fail(() => {
                notificacion("ERROR! Revisa los campos y vuelve a intentarlo", "error", 5000);
                document.querySelector('body').classList.add("loaded")
            })
        }

        consultarPulgadasRequeridas = (id, valor) => {
            var ancho = $('#ancho_pieza' + id).val()
            var grueso = $('#grueso_pieza' + id).val()
            var unidades = $('#cantidad_pieza' + id).val()
            var pulgadas_utilizar = Math.round(((ancho * grueso * unidades * valor * 1.13) / 1550));
            $('#pulgadas_utilizadas' + id).val(pulgadas_utilizar)

            buscarTroncosObjetivos(id, pulgadas_utilizar)

        }

        buscarTroncosObjetivos = (id, pulgadas) => {
            var troncos_select = $('#troncoNum' + id).val()
            document.getElementById('troncos_selected' + id).innerHTML = "Buscando troncos..."

            var datos = $.ajax({
                url: "{{ route('search.info.troncos') }}",
                type: "post",
                dataType: "json",
                data: {
                    id,
                    pulgadas,
                    troncos: troncos_select
                }
            });
            datos.done((res) => {
                document.getElementById('troncos_selected' + id).innerHTML = res.span
                document.getElementById('troncos' + id).innerHTML = res.pulgadas
                document.getElementById('sumPulg' + id).innerHTML = res.sum_p
                $('#troncoNum' + id).val(res.ids)
            })
            datos.fail(() => {
                notificacion("No hay troncos disponibles", "error", 5000);
            })
        }


        CrearPlanCorteMadera = () => {

            //Obtenemos valores del primer formulario
            var select_serie = document.getElementById("serie_planner");
            var serie = select_serie.options[select_serie.selectedIndex].text;
            var select_madera = document.getElementById("madera_planner");
            var madera = select_madera.options[select_madera.selectedIndex].text;
            var select_mueble = document.getElementById("mueble_planner");
            var mueble = select_mueble.options[select_mueble.selectedIndex].text;
            var cantidad_planer = $('#cantidad_planner').val()
            //------------------

            notificacion("Creando plan corte de piezas...", "info", 10000);

            var inputs = $('#btnCantTotal').val()

            document.querySelector('body').classList.remove("loaded")
            var formulario = new FormData(document.getElementById('form-infoGenerada-planner'));
            formulario.append('inputs', inputs);
            formulario.append('serie', serie);
            formulario.append('madera', madera);
            formulario.append('mueble', mueble);
            formulario.append('cantidad', cantidad_planer);

            var datos = $.ajax({
                url: "{{ route('planner.corte.piezas') }}",
                type: "post",
                dataType: "json",
                data: formulario,
                cache: false,
                contentType: false,
                processData: false
            });
            datos.done((res) => {
                document.querySelector('body').classList.add("loaded")
                notificacion(res.mensaje, "success", 5000)
                document.getElementById('formInfoPlanificacionMadera').reset()
                limpiarCampos()
            })
            datos.fail(() => {
                notificacion("ERROR! Revisa los campos y vuelve a intentarlo", "error", 5000);
                document.querySelector('body').classList.add("loaded")
            })
        }
    </script>
@endsection
