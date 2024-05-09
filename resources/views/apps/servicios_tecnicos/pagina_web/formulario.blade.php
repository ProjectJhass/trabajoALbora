<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Servicios Técnicos</title>
    <link rel="shortcut icon" href="{{ asset('img/alburac.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/Bootstrap_5.3_css/bootstrap.min.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.0.0/mdb.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
    <style>
        body {
            background-image: url('../img/detalles.jpg');
            background-repeat: no-repeat;
            width: 100%;
            height: 93.8vh;
            background-size: 100% 120%;
        }
    </style>
</head>

<body>
    <section class="blur-container">
        <div class="container-fluid mt-5">
            <div class="row justify-content-center">
                <div class="col-md-12 col-lg-12 col-xl-8 mt-10">
                    <div class="card cascading-right glass" style="background: hsla(0, 0%, 100%, 0.55); backdrop-filter: blur(30px);">
                        <div class="card-header">
                            <h5 class="text-center">SOLICITUD DE SERVICIO TÉCNICO</h5>
                        </div>
                        <div class="card-body p-5 shadow-5 text-center">
                            <form autocomplete="off" id="formulario" method="POST" enctype="multipart/form-data" action="">

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-outline mb-4" data-mdb-input-init>
                                            <input name="cedula" type="number" id="cedula" class="form-control is-invalid form-control-lg"
                                                required autocomplete="off" onkeyup="validarCedula()" onchange="getInfoClienteSt(this.value)">
                                            <label class="form-label" for="username">Cédula</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-outline mb-4" data-mdb-input-init>
                                            <input type="text" name="nombre" id="nombre" onkeyup="validarNombre()"
                                                class="form-control is-invalid form-control-lg" />
                                            <label class="form-label" for="username">Nombre</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-outline mb-4" data-mdb-input-init>
                                            <input type="text" id="email" name="email" onkeyup="validar_email()"
                                                class="form-control is-invalid form-control-lg" />
                                            <label class="form-label" for="username">Email</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-outline mb-4" data-mdb-input-init>
                                            <input type="text" id="telefono" name="telefono" onkeyup="validar_telfono()"
                                                class="form-control is-invalid form-control-lg" />
                                            <label class="form-label" for="username">Celular</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form">
                                            <select name="option" id="option" onchange="validarOptions()"
                                                class="form-control is-invalid form-control-lg" required>
                                                <option value="">Categoría</option>
                                                <option value="SALAS">SALAS</option>
                                                <option value="COMEDORES">COMEDORES</option>
                                                <option value="ALCOBAS">ALCOBAS</option>
                                                <option value="COLCHONES">COLCHONES</option>
                                                <option value="ACCESORIOS">ACCESORIOS</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form">
                                            <select name="almacen" id="almacen" onchange="validarOptionsAlm()"
                                                class="form-control is-invalid form-control-lg" required>
                                                <option value="">Almacén</option>
                                                <option value="002">ARMENIA</option>
                                                <option value="003">CARTAGO</option>
                                                <option value="004">IBAGUE CENTRO</option>
                                                <option value="006">CC PEREIRA PLAZA</option>
                                                <option value="008">DOSQUEBRADAS</option>
                                                <option value="010">PEREIRA CENTRO</option>
                                                <option value="012">NEIVA</option>
                                                <option value="017">MANIZALES</option>
                                                <option value="025">IBAGUE - CC LA ESTACIÓN</option>
                                                <option value="027">GIRARDOT</option>
                                                <option value="028">PEREIRA UNICENTRO</option>
                                                <option value="036">CALI</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-outline mb-4" data-mdb-input-init>
                                            <textarea name="descripcion" id="descripcion" cols="30" onkeyup="validarDescripcion()" class="form-control is-invalid form-control-lg"
                                                rows="2"></textarea>
                                            <label class="form-label" for="username">Daño reportado</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input name="evidencias[]" type="file" class="form-control is-invalid" placeholder="Subir Evidencias"
                                            id="evidencias" multiple required accept="image/*" onclick="validarImg()">
                                        <div class="invalid-feedback">Mínimo 3 imágenes y máximo 6</div><br>
                                        <div class="invalid-feedback" id="msj_evidencia"></div>
                                        <div id="papa_charge">
                                            <div id="charge_evidence" class="m-2 rounded"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="file" name="video" class="form-control is-valid" id="video" placeholder="videos"
                                            accept="video/*">
                                        <div class="valid-feedback">Máximo 1 video de duracion de 1:00 minuto</div>
                                        <div id="parent_father">
                                            <div class="d-flex justify-content-center mt-3 sm" id="parent-video"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center text-lg-center mt-4 pt-2">
                                    <button type="button" class="btn btn-danger" onclick="enviarInfo('{{ route('guardarOst') }}')"><i
                                            class="fas fa-paper-plane mr-2"></i> Crear
                                        solicitud</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

</body>
<footer>
    <!-- Modal -->
    <div class="modal fade sm" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
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

    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }} "></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }} "></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.0.0/mdb.umd.min.js"></script>
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        notificacion = (txt, icon, timer) => {
            Swal.fire({
                text: txt,
                icon: icon,
                showConfirmButton: false,
                position: "top-end",
                timer: timer,
                toast: true,
                didOpen: () => {
                    const swalContainer = document.querySelector('.swal2-container');
                    if (swalContainer) {
                        swalContainer.style.zIndex = '9999';
                    }
                }
            });
        }

        const input = document.getElementById("evidencias");
        const inputV = document.getElementById("video");

        inputV.addEventListener("change", function(e) {

            let parent_video = document.getElementById("parent-video");
            let hijos = parent_video.childNodes.length;
            if (hijos > 0) {

                let parent_father = document.getElementById("parent_father");
                parent_father.removeChild(parent_video);
                let nuevo_element = document.createElement("div");
                parent_father.appendChild(nuevo_element);
                nuevo_element.setAttribute("id", "parent-video");
                nuevo_element.setAttribute("class", "d-flex justify-content-center mt-3 sm");
            }

            let add_video = document.createElement("video");
            inputV.setAttribute("class", "form-control valido");
            let parent_video1 = document.getElementById("parent-video");
            parent_video1.appendChild(add_video);
            add_video.setAttribute("class", "rounded");
            add_video.setAttribute("id", "video_player");
            add_video.setAttribute("controls", "true");
            add_video.setAttribute("width", "300");
            add_video.setAttribute("heigth", "200");
            add_video.setAttribute("src", URL.createObjectURL(this.files[0]));

        });


        function comprobarHijos() {
            let carga = document.getElementById("charge_evidence");
            let hijos = carga.childNodes.length;

            if (hijos > 0) {
                let papa_carga = document.getElementById("papa_charge");
                let carga = document.getElementById("charge_evidence");
                papa_carga.removeChild(carga);

                let format = document.createElement("div");
                papa_carga.appendChild(format);

                format.setAttribute("id", "charge_evidence");
                format.setAttribute("class", "m-2 rounded");
                format.setAttribute("style", "background-color: white");

            }
        }


        input.addEventListener("change", function(e) {
            let archivos = input.files;
            let cantidad = input.files.length;
            let extensiones = ["png", "jpeg", "heif", "jpg"];
            let correctos = 0;

            comprobarHijos();

            if (cantidad >= 3 && cantidad <= 5) {
                for (let i = 0; i < archivos.length; i++) {
                    let extension = archivos[i].name.split(".").pop();

                    for (let j = 0; j < extensiones.length; j++) {
                        if (extension === extensiones[j]) {
                            previsualizarImg(e, i);
                            correctos++
                            break;
                        }
                    }
                }
                if (correctos < archivos.length) {
                    let carga = document.getElementById("charge_evidence");
                    let papa_carga = document.getElementById("papa_charge");
                    papa_carga.removeChild(carga);

                    let format = document.createElement("div");
                    papa_carga.appendChild(format);
                    format.setAttribute("id", "charge_evidence");
                    format.setAttribute("class", "m-2");
                    archivos = [];
                    input.value = "";
                }
            } else {
                archivos = [];
                input.value = "";
            }
        });

        function previsualizarImg(e, i) {
            var file = e.target.files[i];

            var reader = new FileReader();

            let carga = document.getElementById("charge_evidence");

            let img = document.createElement("img");

            reader.onload = function(e) {
                var result = e.target.result;
                img.src = result;
                img.setAttribute("width", 100);
                img.setAttribute("heigth", 100);
                img.setAttribute("class", "shadow m-2 rounded border-primary sm");
                carga.appendChild(img);
            };
            reader.readAsDataURL(file);
        }

        function enviarInfo(url) {

            let formulario = document.getElementById("formulario");
            let data = new FormData(formulario);
            let definitiva = validarAllInputs();


            if (definitiva) {

                notificacion('Enviando información por favor espere...', 'info', 10000);

                $.ajax({
                        url: url,
                        type: "post",
                        dataType: "json",
                        data: data,
                        cache: false,
                        contentType: false,
                        processData: false
                    })
                    .done(function(texto) {
                        if (texto) {
                            $('#staticBackdrop').modal("show");
                            let parent_video = document.getElementById("parent-video");
                            let parent_father = document.getElementById("parent_father");
                            parent_father.removeChild(parent_video);
                            let nuevo_element = document.createElement("div");
                            parent_father.appendChild(nuevo_element);
                            nuevo_element.setAttribute("id", "parent-video");
                            nuevo_element.setAttribute("class", "d-flex justify-content-center mt-3 sm");

                            let rueda = document.getElementById("rueda");
                            rueda.classList.remove("rueda");
                            rueda.classList.add("rueda_chulo");
                            let cargador_text = document.getElementById("cargador");
                            let cargador_texto = document.getElementById("cargador_texto");
                            cargador_text.innerHTML = "";
                            cargador_texto.innerHTML = "Hecho!";
                            cargador_texto.style.color = "#34ce57";
                            cargador_text.classList.toggle("cargador_chulo");

                            let div = document.createElement("div");
                            let h3 = document.createElement("h3");
                            h3.innerHTML = "Su orden de servicio técnico ha sido enviada satisfactoriamente!";
                            h3.style.color = "#34ce57";
                            h3.setAttribute("class", "m-2");
                            let parrafo = document.createElement("p");
                            let contenido = document.getElementById("contenido");
                            contenido.appendChild(div);

                            parrafo.innerHTML = "Su número de ticket es: <b>" + texto.ticket + "</b>" +
                                "<br>Al correo electronico: <b>" + texto.email +
                                "</b> le llegará un mensaje de notificación proporcionando la información " +
                                "aquí suministrada.<br><br><b>Att: </b>Equipo de servicios técnicos Muebles Albura.";
                            let textos = document.getElementById("_texto");
                            textos.style.width = "95%";
                            textos.appendChild(h3);
                            textos.appendChild(parrafo);

                            document.getElementById("formulario").reset();
                            let carga = document.getElementById("charge_evidence");

                            let papa_carga = document.getElementById("papa_charge");
                            papa_carga.removeChild(carga);
                            let format = document.createElement("div");
                            papa_carga.appendChild(format);
                            format.setAttribute("id", "charge_evidence");
                            format.setAttribute("class", "m-2");
                            input.value = "";
                        }
                    })
                    .fail(function(error) {
                        notificacion('Hubo un problema de conexión, vuelve a intentarlo', 'error', 6000);
                    });
            } else {
                notificacion('Completa toda la información y vuelve a intentar', 'error', 5000);
            }
        }

        function validar_email() {
            let email = document.getElementById("email").value;
            let email_prop = document.getElementById("email");
            let msj_email = document.getElementById("msj_email");

            var regex =
                /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

            if (regex.test(email)) {
                $('#email').removeClass('is-invalid');
                $('#email').addClass('is-valid');

                return true;
            } else {
                $('#email').removeClass('is-valid');
                $('#email').addClass('is-invalid');

                return false;
            }
        }

        function validar_telfono() {
            let valor_input = document.getElementById("telefono").value;
            let input_telefono = document.getElementById("telefono");
            let m_telefono = document.getElementById("msj_telefono");

            if (valor_input.length >= 10) {
                $('#telefono').removeClass("is-invalid");
                $('#telefono').addClass("is-valid");
                return true;
            } else {
                $('#telefono').removeClass("is-valid");
                $('#telefono').addClass("is-invalid");

                return false;
            }
        }

        function validarCedula() {
            let cedula = document.getElementById("cedula").value;
            let cedula_prop = document.getElementById("cedula");
            let msj_cedula = document.getElementById("mensaje");

            if (cedula.length >= 5) {
                $('#cedula').removeClass('is-invalid')
                $('#cedula').addClass('is-valid')
                return true;
            } else {
                $('#cedula').removeClass('is-valid')
                $('#cedula').addClass('is-invalid')

                return false;
            }
        }

        function validarNombre() {
            let nombre = document.getElementById("nombre").value;
            let nombre_prop = document.getElementById("nombre");
            let msj_nombre = document.getElementById("msj_nombre");

            if (nombre.length > 0) {
                $('#nombre').removeClass("is-invalid");
                $('#nombre').addClass("is-valid");
            } else {
                $('#nombre').removeClass("is-valid");
                $('#nombre').addClass("is-invalid");
            }
        }

        function validarOptions() {
            let option = document.getElementById("option").value;
            let option_prop = document.getElementById("option");
            let msj_option = document.getElementById("msj_option");

            if (option === "") {
                $('#option').removeClass("is-valid");
                $('#option').addClass("is-invalid");
                return false;
            } else {
                $('#option').removeClass("is-invalid");
                $('#option').addClass("is-valid");
                return true;
            }
        }

        function validarOptionsAlm() {
            let option = document.getElementById("almacen").value;
            let option_prop = document.getElementById("almacen");

            if (option === "") {
                $('#almacen').removeClass("is-valid");
                $('#almacen').addClass("is-invalid");
                return false;
            } else {
                $('#almacen').removeClass("is-invalid");
                $('#almacen').addClass("is-valid");
                return true;
            }
        }

        function validarDescripcion() {
            let descripcion = document.getElementById("descripcion").value;
            let descripcion_prop = document.getElementById("descripcion");
            let msj_descripcion = document.getElementById("msj_descripcion");

            if (descripcion.length > 0) {
                $('#descripcion').removeClass('is-invalid');
                $('#descripcion').addClass('is-valid');
                return true;
            } else {
                $('#descripcion').removeClass('is-valid');
                $('#descripcion').addClass('is-invalid');
                return false;
            }
        }

        function validarImg() {
            input.addEventListener("change", function(e) {
                let cantidad = input.files.length;

                let evidencia = document.getElementById("evidencias");
                let msj_evidencia = document.getElementById("msj_evidencia");

                if (cantidad >= 3) {
                    $('#evidencias').removeClass('is-invalid')
                    $('#evidencias').addClass('is-valid')
                    return true;
                } else {
                    $('#evidencias').removeClass('is-valid')
                    $('#evidencias').addClass('is-invalid')
                    msj_evidencia.innerHTML = "Ingresa la cantidad de fotos requerida.";
                    return false;
                }
            });
        }

        function validarAllInputs() {
            let nombre = document.getElementById("nombre").value
            let cedula = document.getElementById("cedula").value
            let descripcion = document.getElementById("descripcion").value
            let almacen = document.getElementById("almacen").value
            let option = document.getElementById("option").value
            let email = document.getElementById("email").value
            let valor_input = document.getElementById("telefono").value
            let evidencia = document.getElementById("evidencias")

            if (nombre.length > 0 && cedula.length > 6 && descripcion.length > 0 && almacen.length > 0 && option.length > 0 && email.length > 0 &&
                valor_input.length > 9 && evidencia.files.length > 2) {

                return true;
            }

            return false;
        }

        getInfoClienteSt = (cedula) => {
            if (cedula.length > 0) {
                var datos = $.ajax({
                    url: "{{ route('search.info.cliente') }}",
                    type: "post",
                    dataType: "json",
                    data: {
                        cedula_usuario: cedula
                    }
                })
                datos.done((res) => {
                    $("#nombre").addClass("active")
                    $("#nombre").val(res.data.fullname)
                    $("#email").addClass("active")
                    $("#email").val(res.data.emailU)
                    $("#telefono").addClass("active")
                    $("#telefono").val(res.data.contacto)
                    validarNombre()
                    validar_email()
                    validar_telfono()
                })
            }
        }
    </script>
</footer>

</html>
