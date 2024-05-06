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
                    <form action="" method="post" class="was-validated">
                        @csrf
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="">Permiso general</label>
                                <select name="" id="" class="form-control" required>
                                    <option value=""></option>
                                    <option value="1">General</option>
                                    <option value="4">Super admin</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="">Cédula</label>
                                <input type="text" class="form-control mb-3" value="{{ $cedula }}" name="cedula" id="cedula" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="">Nombre</label>
                                <input type="text" class="form-control mb-3" value="{{ $nombre }}" name="" id="" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="">Email</label>
                                <input type="text" class="form-control mb-3" value="{{ isset($data->email) ? $data->email : '' }}" name=""
                                    id="" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="">Departamento</label>
                                <select name="dpto" id="dpto" class="form-control" required>
                                    <option value=""></option>
                                    <?php foreach ($dptos as $key => $value) { ?>
                                    <option value="{{ $value->id_dpto }}"
                                        @php isset($data->sucursal)? ($value->id_dpto==$data->sucursal?'selected':''):'' @endphp>
                                        {{ $value->nombre_dpto }}</option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="">Permiso dpto</label>
                                <select name="permiso_dpto" id="permiso_dpto" class="form-control" required>
                                    <option value=""></option>
                                    <option value="1">Editor</option>
                                    <option value="0">Visualizar</option>
                                    <option value="2">Especial</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="">Sucursal</label>
                                <select class="form-control" name="sucursal_u" id="sucursal_u" required>
                                    <option value=""></option>
                                    <option value="002">002</option>
                                    <option value="004">004</option>
                                    <option value="006">006</option>
                                    <option value="007">007</option>
                                    <option value="008">008</option>
                                    <option value="010">010</option>
                                    <option value="011">011</option>
                                    <option value="012">012</option>
                                    <option value="014">014</option>
                                    <option value="017">017</option>
                                    <option value="020">020</option>
                                    <option value="025">025</option>
                                    <option value="027">027</option>
                                    <option value="028">028</option>
                                    <option value="036">036</option>
                                    <option value="038">038</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="">Código vendedor</label>
                                <input type="text" class="form-control mb-3" name="codVendedor" id="codVendedor" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="">Zona</label>
                                <select name="zona_u" id="zona_u" class="form-control" required>
                                    <option value=""></option>
                                    <option value="2">Norte</option>
                                    <option value="1">Centro</option>
                                    <option value="0">No aplica</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="">Cargo sucursal</label>
                                <select name="cargo_u" id="cargo_u" class="form-control" required>
                                    <option value=""></option>
                                    <option value="administrador">Administrador</option>
                                    <option value="asesor">Asesor</option>
                                    <option value="guest">No aplica</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="">Registrar ingreso</label>
                                <select name="reloj_u" id="reloj_u" class="form-control" required>
                                    <option value=""></option>
                                    <option value="1">Si</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="">Acceso calendario</label>
                                <select name="calendario_u" id="calendario_u" class="form-control" required>
                                    <option value=""></option>
                                    <option value="1">Si</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="">Usuario</label>
                                <input type="text" class="form-control mb-3" name="" id="" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="">Contraseña</label>
                                <input type="password" class="form-control mb-3" name="" id="" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="">Bitacora</label>
                                <select name="bitacora" id="bitacora" class="form-control" required>
                                    <option value="1">Usuario</option>
                                    <option value="2">Asignado</option>
                                    <option value="3">Administrador</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="">Empresa</label>
                                <select name="empresa" id="empresa" class="form-control" required>
                                    <option value=""></option>
                                    <option value="MUEBLES ALBURA">MUEBLES ALBURA</option>
                                    <option value="HAPPY SLEEP">HAPPY SLEEP</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="">Almacen ST</label>
                                <input type="text" class="form-control mb-3" name="" id="" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="">Rol ST</label>
                                <select class="form-control" name="create_rol" id="create_rol" required>
                                    <option value=""></option>
                                    <option value="1">Admin</option>
                                    <option value="0">General</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="">Fotografía</label>
                                <input type="file" class="form-control mb-3" name="" id="" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="">Permisos Intranet Fab</label>
                                <select class="form-control" name="intranet_fab" id="intranet_fab" required>
                                    <option value=""></option>
                                    <option value="1">Admin</option>
                                    <option value="2">General</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="">Estado</label>
                                <select name="estado_u" id="estado_u" class="form-control" required>
                                    <option value=""></option>
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>
                        </div>
                        <center>
                            <div class="btn-group mt-4" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-secondary">Actualizar info</button>
                                <button type="button" class="btn btn-secondary">Crear información</button>
                            </div>
                        </center>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('footer')
@endsection
