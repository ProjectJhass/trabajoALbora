<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Servicios Técnicos</title>
    <link rel="stylesheet" href="{{ asset('css/Bootstrap_5.3_css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style_home.css') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('img/alburac.png') }}" sizes="30">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/theme-default.css') }}" />

</head>

<body>

    <div class="d-flex justify-content-center mt-2 align-items-center">
        <nav id="header" class="shadow">
            <a href="{{ route('info.pagweb') }}" title="Home">
                <div class="logo_Albura "></div>
            </a>
        </nav>
    </div>

    <div class="d-flex justify-content-center">
        <div class="card shadow" id="tarjeta">
            <div class="card-header">
                <center>
                    <h5 class="titulo">Solicitud de servicio técnico</h5>
                </center>
            </div>
            <div class="card-body ">

                <form action="post" class="pb-2" enctype="multipart/form-data" id="formulario">
                    @csrf
                    <div class="row">
                        <div class="col-sm-3">
                            <label for="form-label" class="form-label mt-2 "><b>Cédula:</b></label>
                            <input name="cedula" type="number" id="cedula" class="form-control mt-2 is-invalid"
                                placeholder="Cédula facturada." required autocomplete="off" onkeyup="validarCedula()">
                            <div class="invalid-feedback" id="mensaje">

                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label for="form-label" class="form-label mt-2"><b>Nombre:</b></label>
                            <input name="nombre" id="nombre" type="text" class="form-control mt-2 is-invalid"
                                placeholder="Nombre." required autocomplete="off" onkeyup="validarNombre()">
                            <div class="invalid-feedback" id="msj_nombre">
                            </div>
                        </div>

                        <div class="col-sm-5">
                            <label for="form-label" class="form-label mt-2"><b>E-mail:</b></label>
                            <input name="email" type="email" id="email" class="form-control mt-2 is-invalid"
                                placeholder="E-mail." required autocomplete="off" onkeyup="validar_email()">
                            <div class="invalid-feedback" id="msj_email">

                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-sm-3 mt-4 ">
                            <label for="form-label" class="form-label "> <b>Telefono:</b></label>
                            <input name="telefono" id="telefono" type="number" class="form-control  is-invalid"
                                placeholder="Telefono." required autocomplete="off" onkeyup="validar_telfono()">
                            <div class="invalid-feedback" id="msj_telefono">

                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="mt-3">
                                <label for="option" class="form-label mt-2"><b>Elegir opción:</b></label>
                                <select class="form-select is-invalid" id="option"
                                    aria-label="Default select example" required name="opcion" autocomplete="off"
                                    onclick="validarOptions()">
                                    <option value="" selected="" id="options_p">OPCIONES</option>
                                    <option id="options" value="SALA">SALA</option>
                                    <option id="options" value="COMEDOR">COMEDOR</option>
                                    <option id="options" value="ALCOBA">ALCOBA</option>
                                    <option id="options" value="COLCHÓN">COLCHÓN</option>
                                    <option id="options" value="ACCESORIOS">ACCESORIOS</option>
                                </select>

                                <div class="invalid-feedback" id="msj_option">

                                </div>
                            </div>

                        </div>

                        <div class="col-sm-6">
                            <div class="descript_form mt-2">
                                <label for="descripcion"><b>Descripción:</b></label>

                                <textarea name="descripcion" id="descripcion" class="form-control  is-invalid" cols="30" rows="2"
                                    placeholder="Descripción del Servicio." required autocomplete="off" onkeyup="validarDescripcion()"></textarea>
                                <div class="invalid-feedback" id="msj_descripcion">

                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row mt-3" id="flecha">
                        <div class="col-sm-6">

                            <label for="evidencias"><b>Subir Evidencias:</b></label>
                            <input name="evidencias[]" type="file" class="form-control  is-invalid"
                                placeholder="Subir Evidencias" id="evidencias" multiple required accept="image/*"
                                onclick="validarImg()">
                            <div class="invalid-feedback" id="msj_evidencia">

                            </div>
                            <small class="d-block">Minimo 3 imagenes y máximo 5</small>
                            <div id="papa_charge">
                                <div id="charge_evidence" class="m-2 rounded"></div>
                            </div>

                        </div>
                        <div class="col-sm-6">
                            <label for="video"><b>Video:</b></label>
                            <input type="file" name="video" class="form-control" id="video"
                                placeholder="videos" accept="video/*">
                            <small>Máximo 1 video de duracion de 1:00 minuto.</small>
                            <div id="parent_father">
                                <div class="d-flex justify-content-center mt-3 sm" id="parent-video"></div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <button id="button_enviar" type="button" class="btn btn-danger shadow mt-1"
                            onclick="enviarInfo('{{ route('guardarOst') }}')"><i
                                class="fas fa-paper-plane mr-2"></i>&nbsp;&#160;Solicitar Servicio</button>
                    </div>
                    <div class="d-felx justify-content-center">
                        <div class="alert alert-success mt-2" role="alert" id="guardado">

                        </div>
                        <div class="alert alert-danger" role="alert" id="no_guardado">
                            Su informacion no pudó ser guardada =(
                        </div>
                    </div>
                </form>
            </div>
            <!-- Modal -->
            <div class="modal fade sm" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
                tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-body d-flex justify-content-center m-2" id="contenido">
                            <div class="d-block " id="cargando">
                                <center>
                                    <div id="rueda" class="rueda"></div>
                                </center>
                                <div class="d-block mt-2">
                                    <h3 style="color: red" id="cargador">
                                        Cargando...</h3>
                                </div>
                            </div>
                        </div>
                        <center>
                            <h3 id="cargador_texto"></h3>
                        </center>
                        <div class="d-flex justify-content-center">
                            <div id="_texto" class=""></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <script src="{{ asset('js/Jquery/jquery-3.7.1.js') }}"></script>
        <script src="{{ asset('js/crear_ost.js') }}"></script>
        <script src="{{ asset('js/Bootstrap_5.3_js/bootstrap.min.js') }}"></script>
    </footer>

</body>

</html>
