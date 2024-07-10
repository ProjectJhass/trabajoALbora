@extends('apps.nexus.plantilla.app')
@section('usuarios')
    active
@endsection
@section('body')
    <form method="post" id="formInformacionNuevoUsuario" autocomplete="off" enctype="multipart/form-data" class="was-validated">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Perfil</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="profile-img-edit position-relative" style="cursor: pointer">
                                <img src="" alt="profile-pic" class="profile-pic rounded avatar-100">
                                <div class="upload-icone bg-primary">
                                    <svg class="upload-button icon-14" width="14" viewBox="0 0 24 24">
                                        <path fill="#ffffff"
                                            d="M14.06,9L15,9.94L5.92,19H5V18.08L14.06,9M17.66,3C17.41,3 17.15,3.1 16.96,3.29L15.13,5.12L18.88,8.87L20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18.17,3.09 17.92,3 17.66,3M14.06,6.19L3,17.25V21H6.75L17.81,9.94L14.06,6.19Z">
                                        </path>
                                    </svg>
                                    <input class="file-upload" type="file" name="infoFotografia" id="infoFotografia" accept="image/*">
                                </div>
                            </div>
                            <div class="img-extension mt-3">
                                <div class="d-inline-block align-items-center">
                                    <span>Solo</span>
                                    <a href="javascript:void();">.jpg</a>
                                    <a href="javascript:void();">.png</a>
                                    <a href="javascript:void();">.jpeg</a>
                                    <span>permitido</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Empresa</label>
                            <select name="empresa_user" onchange="buscarAreasEmpresa(this.value)" id="empresa_user" class="selectpicker form-control"
                                required>
                                <option value="">Seleccionar...</option>
                                <option value="2">Muebles Albura Principal</option>
                                <option value="1">Muebles Albura Fábrica</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Área</label>
                            <select name="area_user" onchange="buscarCargosAreas(this.value)" id="area_user" class="selectpicker form-control" required>
                                <option value="">Seleccionar...</option>
                            </select>
                        </div>
                        <div class="form-group" id="infoGeneralZona" hidden>
                            <label class="form-label">Zona</label>
                            <select name="zona_user" id="zona_user" class="selectpicker form-control" required>
                                <option value="">Seleccionar...</option>
                                <option value="centro">Centro</option>
                                <option value="norte">Norte</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Cargo</label>
                            <select name="cargo_user" id="cargo_user" class="selectpicker form-control" required>
                                <option value="">Seleccionar...</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Rol</label>
                            <select name="rol_user" id="rol_user" class="selectpicker form-control" required>
                                <option value="">Seleccionar...</option>
                                @foreach ($roles as $item)
                                    <option value="{{ $item->id }}">{{ $item->rol }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Permisos</label>
                            <select name="permisos_user" id="permisos_user" class="selectpicker form-control" required>
                                <option value="">Seleccionar...</option>
                                <option value="editar">Editar</option>
                                <option value="ver">Visualizar</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Información del usuario</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="new-user-info">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label" for="fname">Tipo de documento</label>
                                    <select class="form-control" name="tipo_documento" id="tipo_documento" required>
                                        <option value="">Seleccionar...</option>
                                        <option value="Cedula">Cédula</option>
                                        <option value="Tarjeta de identidad">Tarjeta de identidad</option>
                                        <option value="Pasaporte">Pasaporte</option>
                                        <option value="DNI">DNI</option>
                                        <option value="Licencia de conduccion">Licencia de conducción</option>
                                        <option value="Libreta militar">Libreta militar</option>
                                        <option value="Visa">Visa</option>
                                        <option value="Tarjeta de residencia">Tarjeta de residencia</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label" for="fname">Número de identificación</label>
                                    <input type="number" class="form-control" name="numero_documento" id="numero_documento" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label" for="fname">Nombre</label>
                                    <input type="text" class="form-control" onkeyup="this.value=this.value.toUpperCase()" name="nombre_usuario"
                                        id="nombre_usuario" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label" for="lname">Apellidos</label>
                                    <input type="text" class="form-control" onkeyup="this.value=this.value.toUpperCase()" name="apellidos_usuario"
                                        id="apellidos_usuario" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label" for="add1">Celular</label>
                                    <input type="number" class="form-control" name="celular" id="celular" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label" for="add2">Celular alternativo</label>
                                    <input type="number" class="form-control" name="celular2" id="celular2">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label" for="cname">Correo electrónico</label>
                                    <input type="email" class="form-control" onkeyup="this.value=this.value.toLowerCase()" name="email"
                                        id="email" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label" for="add2">Fecha de nacimiento</label>
                                    <input type="date" class="form-control" name="fecha_nacimiento" id="fecha_nacimiento">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label" for="add2">Fecha de ingreso</label>
                                    <input type="date" class="form-control" name="fecha_ingreso" id="fecha_ingreso" required>
                                </div>
                            </div>
                            <hr>
                            <h5 class="mb-3">Información de residencia</h5>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label" for="fname">Departamento</label>
                                    <select class="form-control" name="departamento" id="departamento" onchange="buscarCiudadDpto(this.value)"
                                        required>
                                        <option value="">Seleccionar...</option>
                                        @foreach ($deptos as $item)
                                            <option value="{{ $item->id_depto }}">{{ $item->depto }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label" for="fname">Ciudad</label>
                                    <select class="form-control" name="ciudad" id="ciudad" required>
                                        <option value="">Seleccionar...</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label" for="uname">Barrio</label>
                                    <input type="text" class="form-control" onkeyup="this.value=this.value.toUpperCase()" name="barrio" id="barrio">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label" for="uname">Dirección</label>
                                    <input type="text" class="form-control" onkeyup="this.value=this.value.toUpperCase()" name="direccion" id="direccion">
                                </div>
                            </div>
                            <hr>
                            <h5 class="mb-3">Seguridad</h5>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label class="form-label" for="uname">Nombre de usuario</label>
                                    <input type="text" class="form-control" onkeyup="this.value=this.value.toUpperCase()"
                                        onchange="validarNombreDeUsuario(this.value)" onclick="generarNombreUsuario()" name="usuario" id="usuario"
                                        required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label" for="pass">Contraseña</label>
                                    <input type="password" class="form-control" name="password" id="password" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label" for="rpass">Repetir contraseña</label>
                                    <input type="password" class="form-control" onkeyup="validarContraseñasIngresadas(this.value)" name="rpassword"
                                        id="rpassword" required>
                                    <div class="invalid-feedback">Las claves no coinciden</div>
                                </div>
                            </div>
                            <div class="checkbox mt-2 mb-4">
                                <label class="form-label">
                                    <input class="form-check-input me-2" type="checkbox" name="cambiar_clave" id="cambiar_clave">Solicitar cambio de
                                    clave</label>
                            </div>
                            <div class="checkbox mt-2 mb-4">
                                <label class="form-label">
                                    <input class="form-check-input me-2" type="checkbox" name="crear_siesa" id="crear_siesa">Crear/Actualizar en
                                    SIESA</label>
                            </div>
                            <button type="reset" class="btn btn-secondary">Limpiar campos</button>
                            <button type="button" class="btn btn-primary" onclick="crearInformacionNuevoUsuario()">Crear nuevo usuario</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('footer')
    <script>
        const defaultImageUrl = "{{ asset('assets/img/avatars/1.png') }}";
        document.querySelector('.profile-pic').src = defaultImageUrl;

        document.querySelector('.profile-img-edit').addEventListener('click', function() {
            document.querySelector('.file-upload').click();
        });

        document.querySelector('.file-upload').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.querySelector('.profile-pic').src = e.target.result;
                }
                reader.readAsDataURL(file);
            } else {
                document.querySelector('.profile-pic').src = defaultImageUrl;
            }
        });
    </script>
    <script>
        buscarCiudadDpto = (id_depto) => {
            if (id_depto.length > 0) {
                var datos = $.ajax({
                    url: "{{ route('search.ciudad.nexus') }}",
                    type: "post",
                    dataType: "json",
                    data: {
                        id_depto
                    }
                });
                datos.done((res) => {
                    notificacion("Información encontrada", "success", 3000)
                    document.getElementById('ciudad').innerHTML = res.info
                })
            } else {
                document.getElementById('ciudad').innerHTML = ""
            }
        }

        validarNombreDeUsuario = (usuario) => {
            var datos = $.ajax({
                url: "{{ route('search.user.nexus') }}",
                type: "post",
                dataType: "json",
                data: {
                    usuario
                }
            });
            datos.done((res) => {
                notificacion("Nombre de usuario disponible", "success", 3000)
            })
            datos.fail(() => {
                notificacion("¡ERROR! Nombre de usuario en uso, agrega otro", "error", 6000)
            })
        }

        buscarAreasEmpresa = (id) => {
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
                    document.getElementById('area_user').innerHTML = res.info
                })
            } else {
                document.getElementById('area_user').innerHTML = ""
            }
        }

        buscarCargosAreas = (area) => {
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
                    document.getElementById('cargo_user').innerHTML = res.info
                    if (area == 10) {
                        document.getElementById('infoGeneralZona').hidden = false
                    } else {
                        $('#zona_user').val('')
                        document.getElementById('infoGeneralZona').hidden = true
                    }
                })
            } else {
                document.getElementById('cargo_user').innerHTML = ""
            }
        }

        generarNombreUsuario = () => {
            var nombre = document.getElementById('nombre_usuario').value;
            var apellidos = document.getElementById('apellidos_usuario').value;

            var nombresArray = nombre.trim().split(' ');
            var apellidosArray = apellidos.trim().split(' ');

            var primerNombre = nombresArray[0];
            var primerApellido = apellidosArray[0];

            var nombreUsuario = primerNombre + '.' + primerApellido;
            $("#usuario").val(nombreUsuario)
            validarNombreDeUsuario(nombreUsuario)
        }

        validarContraseñasIngresadas = (valor) => {
            var pwd = $("#password").val()
            if (pwd === valor) {
                $("#rpassword").removeClass("is-invalid")
                $("#rpassword").addClass("is-valid")
            } else {
                $("#rpassword").removeClass("is-valid")
                $("#rpassword").addClass("is-invalid")
            }
        }

        crearInformacionNuevoUsuario = () => {
            notificacion("Creando información del nuevo usuario, Por favor espera...", "info", 10000);

            var depto = document.getElementById("departamento");
            var nom_depto = depto.options[depto.selectedIndex].text;

            var ciudad = document.getElementById("ciudad");
            var nom_ciudad = ciudad.options[ciudad.selectedIndex].text;

            var formulario = new FormData(document.getElementById('formInformacionNuevoUsuario'));
            formulario.append('nom_depto', nom_depto);
            formulario.append('nom_ciudad', nom_ciudad);
            var datos = $.ajax({
                url: "{{ route('crear.users.nexus') }}",
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
                    document.getElementById('formInformacionNuevoUsuario').reset()
                }
                if (res.status == false) {
                    notificacion(res.mensaje, "error", 6000)
                }
            })
            datos.fail(() => {
                notificacion("¡ERROR! Hubo un problema de conexión, vuelve a intentar", "error", 5000)
            })
        }
    </script>
@endsection
