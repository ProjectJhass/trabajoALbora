@extends('apps.control_madera.plantilla.app')
@section('codigos.siesa')
    active
@endsection
@section('body')
    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">

                </div>
                <div class="card-body table-responsive" id="infoGeneralCodigosSiesa">
                    {!! $infoCodigos !!}
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">

                </div>
                <div class="card-body">
                    <form id="formActualizarInfoCodigo" method="post">
                        <div class="form-group" hidden>
                            <label for="">Id código</label>
                            <input type="number" class="form-control" name="id_codigo" id="id_codigo">
                        </div>
                        <div class="form-group">
                            <label for="">Nombre del código</label>
                            <input type="text" class="form-control" name="nombre_codigo" id="nombre_codigo">
                        </div>
                        <div class="form-group">
                            <label for="">Código</label>
                            <input type="number" class="form-control" name="siesa_codigo" id="siesa_codigo">
                        </div>
                        <div class="form-group">
                            <label for="">Estado</label>
                            <select class="form-control" name="estado_codigo" id="estado_codigo">
                                <option value="Activo">Activo</option>
                                <option value="Inactivo">Inactivo</option>
                                <option value="Eliminar">Eliminar</option>
                            </select>
                        </div>
                        <div class="justify-content-between mt-5">
                            <center>
                                <button type="button" class="btn btn-primary" onclick="updateInfoCodigoSiesa()">Actualizar</button>
                                <button type="reset" class="btn btn-secondary">Limpiar campos</button>
                            </center>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script>
        updateInfoCodigoSiesa = () => {
            notificacion("Actualizando información...", "info", 5000);
            var formulario = new FormData(document.getElementById('formActualizarInfoCodigo'));
            formulario.append('valor', 'valor');
            var datos = $.ajax({
                url: "{{ route('crear.codigos.siesa') }}",
                type: "post",
                dataType: "json",
                data: formulario,
                cache: false,
                contentType: false,
                processData: false
            });
            datos.done((res) => {
                notificacion("¡Información actualizada!", "success", 3000)
                document.getElementById('formActualizarInfoCodigo').reset()
                document.getElementById('infoGeneralCodigosSiesa').innerHTML = res.table
            })
            datos.fail(() => {
                notificacion("¡ERROR! Hubo un problema de conexión, vuelve a intentar", "error", 4000)
            })
        }

        editarInformacionCodigos = (id) => {
            var id = $("#id" + id).text()
            var nombre = $("#nombre" + id).text()
            var codigo = $("#codigo" + id).text()
            var estado = $("#estado" + id).text()

            $("#id_codigo").val(id)
            $("#nombre_codigo").val(nombre)
            $("#siesa_codigo").val(codigo)
            $("#estado_codigo").val(estado)
        }
    </script>
@endsection
