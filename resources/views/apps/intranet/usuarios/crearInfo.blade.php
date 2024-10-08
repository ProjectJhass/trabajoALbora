@extends('apps.intranet.plantilla.app')
@section('title')
Usuarios
@endsection
@section('head')
<style>
    .form-control {
        border-top: none;
        border-left: none;
        border-right: none;
        border-radius: 0;
    }

    label {
        color: rgb(153, 153, 153);
        font-size: 13px;
    }
</style>
@endsection
@section('usuarios')
bg-danger active
@endsection
@section('body')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h4>Crear registro</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item text-blue">Inicio</li>
                    <li class="breadcrumb-item active">Crear información</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form id="formInfoGeneralUsuarios" method="post" class="was-validated">
                    @csrf
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="">Permiso general</label>
                            <select name="permisoGeneral" id="permisoGeneral" class="form-control" required>
                                <option value=""></option>
                                <option value="1" @php echo isset($data->permisos)? (1==$data->permisos?'selected':''):'' @endphp>General
                                </option>
                                <option value="4" @php echo isset($data->permisos)? (4==$data->permisos?'selected':''):'' @endphp>Super admin
                                </option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="">Cédula</label>
                            <input type="number" class="form-control mb-3" value="{{ $cedula }}" name="cedula" id="cedula" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="">Nombre</label>
                            <input type="text" onkeyup="this.value=this.value.toUpperCase()" class="form-control mb-3" value="{{ $nombre }}"
                                name="nombre" id="nombre" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="">Email</label>
                            <input type="email" onkeyup="this.value=this.value.toLowerCase()" class="form-control mb-3"
                                value="{{ isset($data->email) ? $data->email : '' }}" name="email" id="email" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="">Departamento</label>
                            <select name="dpto" id="dpto" class="form-control" required>
                                <option value=""></option>
                                <?php foreach ($dptos as $key => $value) { ?>
                                    <option value="{{ $value->id_dpto }}"
                                        @php echo isset($data->sucursal)? ($value->id_dpto==$data->dpto_user?'selected':''):'' @endphp>
                                        {{ $value->nombre_dpto }}
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="">Permiso dpto</label>
                            <select name="permiso_dpto" id="permiso_dpto" class="form-control" required>
                                <option value=""></option>
                                <option value="1" @php echo isset($data->permiso_dpto)? (1==$data->permiso_dpto?'selected':''):'' @endphp>Editor
                                </option>
                                <option value="0" @php echo isset($data->permiso_dpto)? (0==$data->permiso_dpto?'selected':''):'' @endphp>
                                    Visualizar</option>
                                <option value="2" @php echo isset($data->permiso_dpto)? (2==$data->permiso_dpto?'selected':''):'' @endphp>
                                    Especial
                                </option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="">Sucursal</label>
                            <select class="form-control" name="sucursal" id="sucursal" required>
                                <option value=""></option>
                                @foreach ($almacen as $item)
                                <option value="{{ $item->numero }}"
                                    @php echo !empty($data->sucursal)? ($item->numero==$data->sucursal?'selected':''):'' @endphp>
                                    {{ $item->almacen }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="">Código vendedor</label>
                            <input type="number" value="{{ isset($data->codigo) ? $data->codigo : '' }}" class="form-control mb-3" name="codVendedor"
                                id="codVendedor" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="">Zona</label>
                            <select name="zona" id="zona" class="form-control" required>
                                <option value=""></option>
                                <option value="1" @php echo isset($data->zona)? (1==$data->zona?'selected':''):'' @endphp>Centro
                                </option>
                                <option value="2" @php echo isset($data->zona)? (2==$data->zona?'selected':''):'' @endphp>Norte</option>
                                <option value="0" @php echo isset($data->zona)? (0==$data->zona?'selected':''):'' @endphp>No aplica</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="">Cargo sucursal</label>
                            <select name="cargo" id="cargo" class="form-control" required>
                                <option value=""></option>
                                <option value="administrador"
                                    @php echo isset($data->cargo)? ('administrador'==$data->cargo?'selected':''):'' @endphp>
                                    Administrador</option>
                                <option value="asesor" @php echo isset($data->cargo)? ('asesor'==$data->cargo?'selected':''):'' @endphp>Asesor
                                </option>
                                <option value="guest" @php echo isset($data->cargo)? ('guest'==$data->cargo?'selected':''):'' @endphp>No aplica
                                </option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="">Registrar ingreso</label>
                            <select name="reloj" id="reloj" class="form-control" required>
                                <option value=""></option>
                                <option value="1"
                                    @php echo isset($data->ingreso_personal)? (1==$data->ingreso_personal?'selected':''):'' @endphp>Si</option>
                                <option value="0"
                                    @php echo isset($data->ingreso_personal)? (0==$data->ingreso_personal?'selected':''):'' @endphp>No
                                </option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="">Acceso calendario</label>
                            <select name="calendario" id="calendario" class="form-control" required>
                                <option value=""></option>
                                <option value="1" @php echo isset($data->calendario)? (1==$data->calendario?'selected':''):'' @endphp>Si
                                </option>
                                <option value="0" @php echo isset($data->calendario)? (0==$data->calendario?'selected':''):'' @endphp>No
                                </option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="">Usuario</label>
                            <input type="text" onkeyup="this.value=this.value.toUpperCase()" onchange="validarNombreUsuario(this.value)"
                                value="{{ isset($data->usuario) ? $data->usuario : '' }}" class="form-control mb-3" name="usuario" id="usuario"
                                required>
                            <span class="text-red" id="userNameValidate" hidden><small>Este usuario ya existe en la base de datos</small></span>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="">Contraseña</label>
                            <input type="password" class="form-control mb-3" name="pwd" id="pwd" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="">Bitacora</label>
                            <select name="bitacora" id="bitacora" class="form-control" required>
                                <option value="1" @php echo isset($data->bitacora)? (1==$data->bitacora?'selected':''):'' @endphp>Usuario
                                </option>
                                <option value="2" @php echo isset($data->bitacora)? (2==$data->bitacora?'selected':''):'' @endphp>Asignado
                                </option>
                                <option value="3" @php echo isset($data->bitacora)? (3==$data->bitacora?'selected':''):'' @endphp>Administrador
                                </option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="">Empresa</label>
                            <select name="empresa" id="empresa" class="form-control" required>
                                <option value=""></option>
                                <option value="MUEBLES ALBURA"
                                    @php echo isset($data->empresa)? ('MUEBLES ALBURA'==$data->empresa?'selected':''):'' @endphp>MUEBLES ALBURA
                                </option>
                                <option value="HAPPY SLEEP"
                                    @php echo isset($data->empresa)? ('HAPPY SLEEP'==$data->empresa?'selected':''):'' @endphp>HAPPY SLEEP</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="">Almacen ST</label>
                            <select class="form-control" name="almacen_st" id="almacen_st" required>
                                <option value=""></option>
                                @foreach ($almacen as $item)
                                <option value="{{ $item->almacen }}"
                                    @php echo !empty($data->almacen)? ($item->almacen==$data->almacen?'selected':''):'' @endphp>
                                    {{ $item->almacen }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="">Rol ST</label>
                            <select class="form-control" name="rol_st" id="rol_st" required>
                                <option value=""></option>
                                <option value="1" @php echo isset($data->rol)? (1==$data->rol?'selected':''):'' @endphp>Admin</option>
                                <option value="0" @php echo isset($data->rol)? (0==$data->rol?'selected':''):'' @endphp>General</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="">Fotografía</label>
                            <small><i>{{ isset($data->ruta_foto) ? str_replace('/storage/perfil/', '', $data->ruta_foto) : '' }}</i></small>
                            <input type="file" class="form-control mb-3" name="fotografia" id="fotografia" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="">Permisos Intranet Fab</label>
                            <select class="form-control" name="rol_fab" id="rol_fab" required>
                                <option value=""></option>
                                <option value="1" @php echo isset($data->rol_user)? (1==$data->rol_user?'selected':''):'' @endphp>Admin
                                </option>
                                <option value="2" @php echo isset($data->rol_user)? (2==$data->rol_user?'selected':''):'' @endphp>General
                                </option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="">Permiso control madera</label>
                            @php
                            $premiso_madera = isset($data->permiso_madera)?$data->permiso_madera:'';
                            @endphp
                            <select class="form-control" name="control_madera" id="control_madera" required>
                                <option value=""></option>
                                <option value="1" {{ $premiso_madera == '1' ? 'selected' : '' }}>Administrador</option>
                                <option value="2" {{ $premiso_madera == '2' ? 'selected' : '' }}>Auditor</option>
                                <option value="3" {{ $premiso_madera == '3' ? 'selected' : '' }}>Cortador</option>
                                <option value="4" {{ $premiso_madera == '4' ? 'selected' : '' }}>Impresor</option>
                                <option value="5" {{ $premiso_madera == '5' ? 'selected' : '' }}>Planificador</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="">Inhabilitar automaticamente</label>
                            <select name="inhabilitar" id="inhabilitar" class="form-control" required>
                                <option value=""></option>
                                <option value="1" @php echo isset($data->inhabilitar)? (1==$data->inhabilitar?'selected':''):'' @endphp>Si
                                </option>
                                <option value="0" @php echo isset($data->inhabilitar)? (0==$data->inhabilitar?'selected':''):'' @endphp>No
                                </option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="">Estado</label>
                            <select name="estado" id="estado" class="form-control" required>
                                <option value=""></option>
                                <option value="1" @php echo isset($data->estado)? (1==$data->estado?'selected':''):'' @endphp>Activo</option>
                                <option value="0" @php echo isset($data->estado)? (0==$data->estado?'selected':''):'' @endphp>Inactivo</option>
                            </select>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="">Acceso a Nexus</label>
                            <select name="Nexus" id="Nexus" class="form-control" required onchange="toggleAdminField()">
                                <option value=""></option>
                                <option value="1" @php echo isset($data->estado)? (1==$data->estado?'selected':''):'' @endphp>Permitido</option>
                                <option value="0" @php echo isset($data->estado)? (0==$data->estado?'selected':''):'' @endphp>No Permitido</option>
                            </select>
                        </div>

                        <div class="col-md-3 mb-3" id="adminField" style="display: none;">
                            <label for="">Tipo de Acceso</label>
                            <select name="CargoNexus" id="CargoNexus" class="form-control">
                                <option value="USUARIO"></option>
                                <option value="USUARIO">Usuario</option>
                                <option value="ADMIN">Administrador</option>
                            </select>
                        </div>

                        <script>
                            function toggleAdminField() {
                                var nexusSelect = document.getElementById('Nexus');
                                var adminField = document.getElementById('adminField');

                                // Verifica si el valor seleccionado es '1' (Permitido)
                                if (nexusSelect.value == '1') {
                                    adminField.style.display = 'block'; // Muestra el campo adicional
                                } else {
                                    adminField.style.display = 'none'; // Oculta el campo adicional
                                }
                            }
                        </script>

                    </div>
                    <center>
                        <div class="btn-group mt-4" role="group" aria-label="Basic example">
                            <button type="button" onclick="updateInfoUsuarioIntranet()" class="btn btn-warning">Actualizar información</button>
                            <button type="button" onclick="createInfoUsuarioIntranet()" class="btn btn-success">Crear información</button>
                        </div>
                    </center>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
@section('footer')
<script>
    updateInfoUsuarioIntranet = () => {
        var formData = new FormData(document.getElementById('formInfoGeneralUsuarios'));
        formData.append('dato', 'valor');
        var datos = $.ajax({
            url: "{{ route('update.info.usuario') }}",
            type: "POST",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
        })
        datos.done((response) => {
            if (response.status == true) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: "¡Buen trabajo! La información del usuario ha sido actualizada correctamente.",
                    showConfirmButton: false,
                    timer: 3000,
                    toast: true
                });
            } else {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: response.mensaje,
                    showConfirmButton: false,
                    timer: 4000,
                    toast: true
                });
            }
        })
        datos.fail(() => {
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: '¡ERROR! Revisa la información y vuelve a intentar',
                showConfirmButton: false,
                timer: 4000,
                toast: true
            });
        })
    }

    createInfoUsuarioIntranet = () => {
        var formData = new FormData(document.getElementById('formInfoGeneralUsuarios'));
        formData.append('dato', 'valor');
        var datos = $.ajax({
            url: "{{ route('create.info.user') }}",
            type: "POST",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
        })
        datos.done((response) => {
            if (response.status == true) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: "¡Buen trabajo! La información del usuario ha sido creada correctamente.",
                    showConfirmButton: false,
                    timer: 3000,
                    toast: true
                });
            } else {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: response.mensaje,
                    showConfirmButton: false,
                    timer: 4000,
                    toast: true
                });
            }
        })
        datos.fail(() => {
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: '¡ERROR! Revisa la información y vuelve a intentar',
                showConfirmButton: false,
                timer: 4000,
                toast: true
            });
        })
    }

    validarNombreUsuario = (valor) => {
        var datos = $.ajax({
            url: "{{ route('validar.info.user') }}",
            type: "POST",
            dataType: "json",
            data: {
                userName: valor
            }
        })
        datos.done((res) => {
            if (res.status == true) {
                document.getElementById('userNameValidate').hidden = false
            } else {
                document.getElementById('userNameValidate').hidden = true
            }
        })
        datos.fail(() => {
            document.getElementById('userNameValidate').hidden = true
        })
    }
</script>
@endsection