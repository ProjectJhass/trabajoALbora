<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Intranet Muebles Albura - Login</title>
    <link rel="shortcut icon" href="{{ asset('img/alburac.png') }}" type="image/x-icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.0.0/mdb.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
    <style>
        .divider:after,
        .divider:before {
            content: "";
            flex: 1;
            height: 1px;
            background: #eee;
        }

        .h-custom {
            height: calc(100% - 73px);
        }

        @media (max-width: 450px) {
            .h-custom {
                height: 100%;
            }
        }
    </style>
    <style>
        .reloj {
            display: inline-block;
            background: #d1dae3;
            color: #71767f;
            padding: 30px;
            font-weight: bold;
            font-size: 27px;
            border-radius: 4px;
            border: 4px solid #cad3dc;
            box-shadow: -8px -8px 15px rgba(255, 255, 255, 0.5),
                10px 10px 10px rgba(0, 0, 0, 0.1),
                inset -8px -8px 15px rgba(255, 255, 255, 0.5),
                inset 10px 10px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <section class="vh-100">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-9 col-lg-6 col-xl-5">
                    <img src="{{ asset('img/mueble_int.png') }}" class="img-fluid" alt="Sample image">
                </div>
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                    <div class="card cascading-right" style="background: hsla(0, 0%, 100%, 0.55);backdrop-filter: blur(30px);">
                        <div class="card-body p-5 shadow-5 text-center">
                            <form autocomplete="off" method="POST" enctype="multipart/form-data" action="{{ route('login') }}">
                                <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-end">
                                    <p class="lead fw-normal mb-0 me-2"><small>Realizar registro</small></p>
                                    <button type="button" class="btn btn-danger btn-floating mx-1" data-mdb-ripple-init data-mdb-modal-init
                                        data-mdb-target="#exampleModal">
                                        <i class="fa-regular fa-clock"></i>
                                    </button>
                                </div>

                                <div class="divider d-flex align-items-center my-4">
                                    <p class="text-center fw-bold mx-3 mb-0">Inicia Sesión</p>
                                </div>

                                <!-- Email input -->
                                <div class="form-outline mb-4" data-mdb-input-init>
                                    <input type="text" id="usuario" name="usuario" class="form-control form-control-lg" placeholder="" />
                                    <label class="form-label" for="usuario">Nombre de usuario</label>
                                </div>

                                <!-- Password input -->
                                <div class="form-outline mb-3" data-mdb-input-init>
                                    <input type="password" id="password" name="password" class="form-control form-control-lg" placeholder="" />
                                    <label class="form-label" for="password">Contraseña</label>
                                </div>

                                <div class="d-flex justify-content-between align-items-center">

                                </div>

                                <div class="text-center text-lg-center mt-4 pt-2">
                                    <button type="submit" class="btn btn-danger btn-lg"
                                        style="padding-left: 2.5rem; padding-right: 2.5rem;">Ingresar</button>
                                    </p>
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            {{ $errors->first() }}
                                        </div>
                                    @endif
                                    @if (session('message'))
                                        <div class="alert alert-danger">
                                            {{ session('message') }}
                                        </div>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-0 px-4 px-xl-5"
            style="background-color: #ba1c1c">
            <div class="text-white mb-3 mb-md-0">
                Muebles Albura S.A.S
            </div>
            <div>
            </div>
        </div>
    </section>

</body>
<footer>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Registro de ingreso diario</h5>
                    <button type="button" class="btn-close" data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-5 text-lg-center" style="">
                            <div class="btn-group me-2" role="group" aria-label="Second group">
                                <button type="button" id="btnRegisterIn" class="btn btn-outline-secondary btnIntranetIn active"
                                    onclick="changeOptionIn('btnRegisterIn', 'in')" data-mdb-ripple-init
                                    data-mdb-ripple-color="dark">Ingresar</button>
                                <button type="button" id="btnRegisterOut" class="btn btn-outline-secondary btnIntranetIn"
                                    onclick="changeOptionIn('btnRegisterOut', 'out')" data-mdb-ripple-init data-mdb-ripple-color="dark">Salir</button>
                                <button type="button" id="btnRegisterDobleIn" class="btn btn-outline-secondary btnIntranetIn"
                                    onclick="changeOptionIn('btnRegisterDobleIn', 'doblein')" data-mdb-ripple-init
                                    data-mdb-ripple-color="dark">Re-ingresar</button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-7 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <form autocomplete="off" id="form-ingreso-personal-as">
                                        <div class="row">
                                            <div class="form-group" hidden>
                                                <input type="text" class="form-control" name="hora-usuario-i" value="00:00:00"
                                                    id="hora-usuario-i">
                                            </div>
                                            <div class="form-group" hidden>
                                                <input type="text" class="form-control" name="validarAccionIngreso" value="ingresar"
                                                    id="validarAccionIngreso">
                                            </div>
                                            <div class="col-md-12 mb-4">
                                                <div class="form-outline" data-mdb-input-init>
                                                    <input type="text" id="cedula-usuario-i" name="cedula-usuario-i" class="form-control" />
                                                    <label class="form-label" for="cedula-usuario-i">Número de cédula</label>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-4" id="selectNovedad">
                                                <label for="novedad-general" style="color: #a0a0a0ea">Novedad <small>(No
                                                        obligatorio)</small></label>
                                                <select name="novedad-general" id="novedad-general" class="form-control"
                                                    style="border: .5px solid; border-color: rgb(173, 173, 173)"
                                                    onchange="habilitarCampoComentarioSalir(this.value)">
                                                    <option value="">Seleccionar...</option>
                                                    <option value="CITA MEDICA">CITA MEDICA</option>
                                                    <option value="PERMISO PERSONAL">PERMISO PERSONAL</option>
                                                    <option value="LLEGADA TARDE">LLEGADA TARDE</option>
                                                    <option value="TRABAJO EXTERNO">TRABAJO EXTERNO</option>
                                                    <option value="URGENCIAS">URGENCIAS</option>
                                                    <option value="NO REGISTRA INGRESO">NO REGISTRA INGRESO</option>
                                                    <option value="OTRO">OTRO</option>
                                                </select>
                                            </div>
                                            <div class="col-md-12 mb-3" id="obsNovedad" hidden>
                                                <div class="form-outline" data-mdb-input-init>
                                                    <textarea class="form-control" id="novedad-salida-user" name="novedad-salida-user" rows="4"></textarea>
                                                    <label class="form-label" for="novedad-salida-user">Observaciones <small>(No
                                                            obligatorio)</small></label>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="d-flex flex-row align-items-center justify-content-center">
                                <section>
                                    <div class="reloj">
                                        <span id="tiempo">00 : 00 : 00</span>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-mdb-ripple-init data-mdb-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-danger" onclick="RegistrarIngresoPersonal()" data-mdb-ripple-init>Registrar
                        información</button>
                </div>
            </div>
        </div>
    </div>


    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.0.0/mdb.umd.min.js"></script>
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        habilitarCampoComentarioSalir = (value) => {
            if (value.length > 0) {
                document.getElementById('obsNovedad').hidden = false
            } else {
                $('#novedad-salida-user').val('')
                document.getElementById('obsNovedad').hidden = true
            }
        }

        changeOptionIn = (idBtn, action) => {

            $('.btnIntranetIn').removeClass('active')
            $('#' + idBtn).addClass('active')

            $('#novedad-general').val('')
            document.getElementById('obsNovedad').hidden = true

            if (action == 'out') {
                $('#validarAccionIngreso').val('salir')
            } else {
                if (action == 'in') {
                    $('#validarAccionIngreso').val('ingresar')
                } else {
                    $('#validarAccionIngreso').val('reingresar')
                }
            }
        }
    </script>
    <script>
        let html = document.getElementById("tiempo");

        setInterval(function() {
            tiempo = new Date();

            horas = tiempo.getHours();
            minutos = tiempo.getMinutes();
            segundos = tiempo.getSeconds();

            //evitar los 0 o numeros individuales
            if (horas < 10)
                horas = "0" + horas;
            if (minutos < 10)
                minutos = "0" + minutos;
            if (segundos < 10)
                segundos = "0" + segundos;

            html.innerHTML = horas + " : " + minutos + " : " + segundos;
            $('#hora-usuario-i').val(horas + ":" + minutos + ":" + segundos);
        }, 1000);
    </script>
    <script>
        RegistrarIngresoPersonal = (valor) => {
            var cedula = $('#cedula-usuario-i').val();
            var hora = $('#hora-usuario-i').val();
            if (cedula.length > 0 && hora.length > 0) {
                var formData = new FormData(document.getElementById('form-ingreso-personal-as'));
                formData.append('dato', 'valor');
                var datos = $.ajax({
                    url: "{{ route('registrar.ingreso.asesor') }}",
                    type: "POST",
                    dataType: "json",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false
                });
                datos.done((res) => {
                    if (res.status == true) {
                        Swal.fire({
                            text: "¡Excelente! " + res.mensaje,
                            icon: "success",
                            showConfirmButton: false,
                            position: "top-end",
                            timer: 3000,
                            toast: true,
                        });
                        $('#cedula-usuario-i').val('');
                    }
                    if (res.status == false) {
                        Swal.fire({
                            text: "¡UPS! " + res.mensaje,
                            icon: "error",
                            showConfirmButton: false,
                            position: "top-end",
                            timer: 5000,
                            toast: true,
                        });
                        $('#cedula-usuario-i').val('');
                    }
                });
                datos.fail(() => {
                    Swal.fire({
                        text: "Revisa la conexión a internet y vuelve a intentar",
                        icon: "error",
                        showConfirmButton: false,
                        position: "top-end",
                        timer: 3000,
                        toast: true,
                    });
                });
            } else {
                Swal.fire({
                    text: "Llena el campo y vuelve a intentarlo",
                    icon: "error",
                    showConfirmButton: false,
                    position: "top-end",
                    timer: 3000,
                    toast: true,
                });
            }
        }
    </script>
</footer>

</html>
