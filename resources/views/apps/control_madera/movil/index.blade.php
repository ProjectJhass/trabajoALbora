@extends('apps.control_madera.plantilla.app')
@section('p.movil')
    active
@endsection
@section('body')
    <div class="row">
        <div class="col-md-12">
            <div class="card alert-top" data-aos="fade-up" data-aos-delay="200">
                <div class="card-header">
                    <h5>Url de conexión</h5>
                </div>
                <div class="card-body">
                    <form method="post" id="form-url-movil">
                        <div class="input-group mb-3">
                            <input type="text" name="urlConnection" id="urlConnection" value="{{ $url->url }}" class="form-control"
                                placeholder="Url de conexión">
                            <button class="btn btn-primary" onclick="updateUrlInfo()" type="button" id="button-addon2">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card alert-top" data-aos="fade-up" data-aos-delay="300">
                <div class="card-header">
                    <h5>Dispositivos registrados</h5>
                </div>
                <div class="card-body">
                    <div id="info-general-tokens">
                        {!! $table !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card alert-top" data-aos="fade-up" data-aos-delay="400">
                <div class="card-header">
                    <h5>Registrar dispositivos</h5>
                </div>
                <div class="card-body">
                    <div id="info-general-tokens">
                        <form autocomplete="off" id="formRegistrarDispositivoMovil">
                            <div class="mb-3">
                                <label for="token" class="form-label">Token de acceso generado</label>
                                <input type="text" class="form-control" id="token" name="token">
                            </div>
                            <div class="mb-3">
                                <label for="nombre_movil" class="form-label">Nombre del dispositivo</label>
                                <input type="text" class="form-control" id="nombre_movil" name="nombre_movil">
                            </div>
                            <button type="button" class="btn btn-primary" onclick="crearInfoTokenMovil()">Registrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script>
        updateUrlInfo = () => {
            notificacion("Actualizando información...", "info", 10000);
            var formulario = new FormData(document.getElementById('form-url-movil'));
            formulario.append('valor', 'valor');
            var datos = $.ajax({
                url: "{{ route('url.acceso.movil') }}",
                type: "post",
                dataType: "json",
                data: formulario,
                cache: false,
                contentType: false,
                processData: false
            });
            datos.done((res) => {
                notificacion("¡Información actualizada correctamente!", "success", 5000)
            })
        }

        crearInfoTokenMovil = () => {
            notificacion("Agregando información...", "info", 10000);
            var formulario = new FormData(document.getElementById('formRegistrarDispositivoMovil'));
            formulario.append('valor', 'valor');
            var datos = $.ajax({
                url: "{{ route('crear.acceso.movil') }}",
                type: "post",
                dataType: "json",
                data: formulario,
                cache: false,
                contentType: false,
                processData: false
            });
            datos.done((res) => {
                notificacion("¡Información creada correctamente!", "success", 5000)
                document.getElementById('formRegistrarDispositivoMovil').reset()
                document.getElementById('info-general-tokens').innerHTML = res.table
            })
        }

        openEdit = (id) => {
            document.getElementById('celularEdit' + id).hidden = false;
            document.getElementById('celular' + id).hidden = true;
            document.getElementById('tokenEdit' + id).hidden = false;
            document.getElementById('tokenT' + id).hidden = true;
            document.getElementById('buttons' + id).hidden = false;
            document.getElementById('options' + id).hidden = true;
        }

        closeEdit = (id) => {
            document.getElementById('celularEdit' + id).hidden = true;
            document.getElementById('celular' + id).hidden = false;
            document.getElementById('tokenEdit' + id).hidden = true;
            document.getElementById('tokenT' + id).hidden = false;
            document.getElementById('buttons' + id).hidden = true;
            document.getElementById('options' + id).hidden = false;
        }

        editarInfoTokenMovil = (id) => {
            notificacion("Actualizando información...", "info", 10000);
            var datos = $.ajax({
                url: "{{ route('editar.acceso.movil') }}",
                type: "post",
                dataType: "json",
                data: {
                    id_movil: id,
                    token: $("#token" + id).val(),
                    nombre_movil: $("#movil" + id).val()
                }
            });
            datos.done((res) => {
                notificacion("¡Información actualizada correctamente!", "success", 5000)
                document.getElementById('info-general-tokens').innerHTML = res.table
            })
        }

        eliminarInfoMovil = (id) => {
            notificacion("Eliminando información...", "info", 10000);
            var datos = $.ajax({
                url: "{{ route('eliminar.acceso.movil') }}",
                type: "post",
                dataType: "json",
                data: {
                    id_movil: id
                }
            });
            datos.done((res) => {
                notificacion("¡Información eliminada correctamente!", "success", 5000)
                document.getElementById('info-general-tokens').innerHTML = res.table
            })
        }
    </script>
@endsection
