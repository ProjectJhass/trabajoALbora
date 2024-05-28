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
            <div class="card" data-aos="fade-up" data-aos-delay="200">
                <div class="flex-wrap card-header d-flex justify-content-between align-items-center">
                    <div class="header-title">
                        <h4 class="card-title mb-0">Crear información</h4>
                    </div>
                    <button type="button" class="btn btn-sm btn-secondary" onclick="limpiarTodoForm()"><i class="fas fa-times-circle"></i> Limpiar
                        todo</button>
                </div>
                <div class="card-body">
                    <form class="form-label-left input_mask" id="formInfoPlanificacionMadera" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group row">
                                    <label class="col-form-label col-md-3 col-sm-3 ">Serie </label>
                                    <div class="col-md-9 col-sm-9 ">
                                        <input type="text" class="form-control" onkeyup="this.value=this.value.toUpperCase()" name="nuevaSerie"
                                            id="nuevaSerie">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group row">
                                    <label class="col-form-label col-sm-3 ">Madera </label>
                                    <div class="col-md-9 col-sm-9 ">
                                        <select class="form-control" name="tipoMadera" id="tipoMadera">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($madera as $item)
                                                <option value="{{ $item->id_madera }}">{{ $item->nombre_madera }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group row">
                                    <label class="col-form-label col-sm-3">Mueble </label>
                                    <div class="col-md-9 col-sm-9 ">
                                        <input type="text" onkeyup="this.value=this.value.toUpperCase()" class="form-control" name="nuevoMueble"
                                            id="nuevoMueble">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ln_solid"></div>
                    </form>
                    <div class="form-group text-center">
                        <button type="button" class="btn btn-danger" id="btnCrearNuevaSerieMadera" onclick="UpdateInfoPiezasSeries()" hidden><i
                                class="fas fa-plus"></i> Crear nueva serie</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card" data-aos="fade-up" data-aos-delay="400">
                <div class="flex-wrap card-header d-flex justify-content-between align-items-center">
                    <h6 class="card-title">Piezas para la serie</h6>
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
                    <center>
                        <div class="card-tools" id="btnAddNewFila" style="cursor: pointer">
                            <i class="fas fa-plus-circle"></i> Agregar nueva pieza
                        </div>
                    </center>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        limpiarTodoForm = () => {
            document.getElementById('formInfoPlanificacionMadera').reset()
            document.getElementById('piezasgeneradasplanseries').innerHTML = ''
            document.getElementById('btnCrearNuevaSerieMadera').hidden = true
        }

        window.addEventListener('load', function() {
            document.querySelector('body').classList.add("loaded")

            const container = document.getElementById('piezasgeneradasplanseries');
            const addDivButton = document.getElementById('btnAddNewFila');
            const removeAllDivsButton = document.getElementById('removeAllDivs');

            addDivButton.addEventListener('click', addDiv);
            removeAllDivsButton.addEventListener('click', removeAllDivs);

            function addDiv() {
                const divCount = container.childElementCount + 1;
                const newDiv = document.createElement('div');
                newDiv.classList.add('bd-example', 'mb-4');

                newDiv.innerHTML = `
                    <div class="accordion" id="accordionPlanner${divCount}">
                        <div class="accordion-item">
                            <h4 class="accordion-header" id="headingPlanner${divCount}">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePlanner${divCount}"
                                    aria-expanded="true" aria-controls="collapsePlanner${divCount}">
                                    Pieza ${divCount}
                                </button>
                            </h4>
                            <div id="collapsePlanner${divCount}" class="accordion-collapse collapse show"
                                aria-labelledby="headingPlanner${divCount}" data-bs-parent="#accordionPlanner${divCount}">
                                <div class="accordion-body">
                                    <div class="row">
                                        <div class="col-md-2 mb-3" hidden>
                                            <label for="">Id</label>
                                            <input type="text" name="ciclos[]" id="ciclos" value="${divCount}"
                                                class="form-control">
                                        </div>
                                        <div class="col-md-5 mb-3">
                                            <label for="">Pieza</label>
                                            <input type="text" name="nombre${divCount}" id="nombre${divCount}" 
                                                class="form-control">
                                        </div>
                                        <div class="col-md-1 mb-3">
                                            <label for="">Cantidad</label>
                                            <input type="number" name="cantidad${divCount}" id="cantidad${divCount}"
                                                class="form-control">
                                        </div>
                                        <div class="col-md-1 mb-3">
                                            <label for="">Largo</label>
                                            <input type="number" name="largo${divCount}" id="largo${divCount}" 
                                                class="form-control">
                                        </div>
                                        <div class="col-md-1 mb-3">
                                            <label for="">Ancho</label>
                                            <input type="number" name="ancho${divCount}" id="ancho${divCount}"
                                                class="form-control">
                                        </div>
                                        <div class="col-md-1 mb-3">
                                            <label for="">Grueso</label>
                                            <input type="number" name="grueso${divCount}" id="grueso${divCount}"
                                                class="form-control">
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label for="">Estado</label>
                                            <select name="estado${divCount}" id="estado${divCount}" class="form-control">
                                                <option value="1">Activo</option>
                                                <option value="0">Inactivo</option>
                                            </select>
                                        </div>
                                        <div class="col-md-1 d-flex justify-content-center align-items-center">
                                            <button class="btn btn-danger delete-button"><i class="fas fa-times"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                newDiv.querySelector('.delete-button').addEventListener('click', () => {
                    container.removeChild(newDiv);
                    updateIdentifiers();
                    mostrarBotonCrear()
                });

                container.appendChild(newDiv);
                mostrarBotonCrear()
            }

            function updateIdentifiers() {
                const divs = container.children;
                for (let i = 0; i < divs.length; i++) {
                    const divIndex = i + 1;
                    const accordion = divs[i].querySelector('.accordion');
                    const accordionHeader = divs[i].querySelector('.accordion-header');
                    const accordionButton = divs[i].querySelector('.accordion-button');
                    const accordionCollapse = divs[i].querySelector('.accordion-collapse');
                    const inputs = divs[i].querySelectorAll('input');
                    const select = divs[i].querySelector('select');

                    accordion.id = `accordionPlanner${divIndex}`;
                    accordionHeader.id = `headingPlanner${divIndex}`;
                    accordionButton.setAttribute('data-bs-target', `#collapsePlanner${divIndex}`);
                    accordionButton.setAttribute('aria-controls', `collapsePlanner${divIndex}`);
                    accordionButton.textContent = `Pieza ${divIndex}`;
                    accordionCollapse.id = `collapsePlanner${divIndex}`;
                    accordionCollapse.setAttribute('aria-labelledby', `headingPlanner${divIndex}`);
                    accordionCollapse.setAttribute('data-bs-parent', `#accordionPlanner${divIndex}`);

                    inputs.forEach(input => {
                        input.name = input.name.replace(/\d+$/, divIndex);
                        input.id = input.id.replace(/\d+$/, divIndex);
                    });

                    select.name = select.name.replace(/\d+$/, divIndex);
                    select.id = select.id.replace(/\d+$/, divIndex);
                }
            }

            function removeAllDivs() {
                while (container.firstChild) {
                    container.removeChild(container.firstChild);
                }
            }
        });

        mostrarBotonCrear = () => {
            const container = document.getElementById('piezasgeneradasplanseries');
            const divs = container.children;
            if (divs.length > 0) {
                document.getElementById('btnCrearNuevaSerieMadera').hidden = false
            } else {
                document.getElementById('btnCrearNuevaSerieMadera').hidden = true
            }
        }

        UpdateInfoPiezasSeries = () => {
            notificacion("Creando información de nueva serie...", "info", 10000);

            var serie = $("#nuevaSerie").val()
            var madera = $("#tipoMadera").val()
            var mueble = $("#nuevoMueble").val()

            document.querySelector('body').classList.remove("loaded")
            var formulario = new FormData(document.getElementById('formEditInfoPiezasMadera'));
            formulario.append('serie', serie);
            formulario.append('madera', madera);
            formulario.append('mueble', mueble);

            var datos = $.ajax({
                url: "{{ route('crear.info.serie.piezas') }}",
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
                    notificacion(res.mensaje, "success", 5000)
                } else {
                    notificacion(res.mensaje, "error", 7000)
                }
            })
            datos.fail(() => {
                notificacion("ERROR! Revisa los campos y vuelve a intentarlo", "error", 5000);
                document.querySelector('body').classList.add("loaded")
            })
        }
    </script>
@endsection
@section('footer')
@endsection
