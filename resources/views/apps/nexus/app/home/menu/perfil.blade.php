<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">Perfil</h4>
                </div>
            </div>
            <div class="card-body">
                <form>
                    <div class="form-group">
                        <div class="profile-img-edit position-relative">
                            <img src="{{ asset('assets/img/avatars/1.png') }}" alt="profile-pic" class="profile-pic rounded avatar-100">
                            <div class="upload-icone bg-primary">
                                <svg class="upload-button icon-14" width="14" viewBox="0 0 24 24">
                                    <path fill="#ffffff"
                                        d="M14.06,9L15,9.94L5.92,19H5V18.08L14.06,9M17.66,3C17.41,3 17.15,3.1 16.96,3.29L15.13,5.12L18.88,8.87L20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18.17,3.09 17.92,3 17.66,3M14.06,6.19L3,17.25V21H6.75L17.81,9.94L14.06,6.19Z">
                                    </path>
                                </svg>
                                <input class="file-upload" type="file" accept="image/*">
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
                        <label class="form-label">Área</label>
                        <select name="type" class="selectpicker form-control" data-style="py-0">
                            <option>Select</option>
                            <option>Web Designer</option>
                            <option>Web Developer</option>
                            <option>Tester</option>
                            <option>Php Developer</option>
                            <option>Ios Developer </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Cargo</label>
                        <select name="type" class="selectpicker form-control" data-style="py-0">
                            <option>Select</option>
                            <option>Web Designer</option>
                            <option>Web Developer</option>
                            <option>Tester</option>
                            <option>Php Developer</option>
                            <option>Ios Developer </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Rol</label>
                        <select name="type" class="selectpicker form-control" data-style="py-0">
                            <option>Select</option>
                            <option>Web Designer</option>
                            <option>Web Developer</option>
                            <option>Tester</option>
                            <option>Php Developer</option>
                            <option>Ios Developer </option>
                        </select>
                    </div>
                </form>
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
                    <form>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="form-label" for="fname">Tipo de documento</label>
                                <select class="form-control" name="" id="">
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
                                <input type="number" class="form-control" id="fname">
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label" for="fname">Nombre</label>
                                <input type="text" class="form-control" id="fname">
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label" for="lname">Apellidos</label>
                                <input type="text" class="form-control" id="lname">
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label" for="add1">Celular</label>
                                <input type="text" class="form-control" id="add1">
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label" for="add2">Celular alternativo</label>
                                <input type="text" class="form-control" id="add2">
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label" for="cname">Correo electrónico</label>
                                <input type="text" class="form-control" id="cname">
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label" for="add2">Fecha de nacimiento</label>
                                <input type="text" class="form-control" id="add2">
                            </div>
                        </div>
                        <hr>
                        <h5 class="mb-3">Información de residencia</h5>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="form-label" for="fname">Departamento</label>
                                <select class="form-control" name="" id="">
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
                                <label class="form-label" for="fname">Ciudad</label>
                                <select class="form-control" name="" id="">
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
                                <label class="form-label" for="uname">Barrio</label>
                                <input type="text" class="form-control" id="uname">
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label" for="uname">Dirección</label>
                                <input type="text" class="form-control" id="uname">
                            </div>
                        </div>
                        <hr>
                        <h5 class="mb-3">Seguridad</h5>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="form-label" for="uname">Nombre de usuario</label>
                                <input type="text" class="form-control" id="uname">
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label" for="pass">Contraseña</label>
                                <input type="password" class="form-control" id="pass">
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label" for="rpass">Repetir contraseña</label>
                                <input type="password" class="form-control" id="rpass">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Add New User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
