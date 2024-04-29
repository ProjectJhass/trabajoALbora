@extends('apps.crm_almacenes.gcp.plantilla.app')
@section('title')
    Nuevo registro
@endsection
@section('digitar')
    active
@endsection
@section('contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Digitar información</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item text-blue">CRM</li>
                        <li class="breadcrumb-item active">Digitar información</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-outline card-danger">
                <div class="card-header">
                    información personal
                </div>
                <div class="card-body">
                    <form id="formulario-datos-nuevo-cliente" class="was-validated" style="font-size: 14px" autocomplete="off">
                        @csrf
                        <div class="row">
                            <input type="text" name="tipo_cotizacion" id="tipo_cotizacion" hidden>
                            <div class="col-md-4 mb-3">
                                <label for="">Cédula</label>
                                <input type="number" class="form-control form-cmp" onchange="BuscarInformacionClienteCRM(this.value)"
                                    name="cedula_cliente" id="cedula_cliente" placeholder="Número de cédula" required>
                                <div class="form-group form-check" id="div_check_sin_cedula">
                                    <input type="checkbox" class="form-check-input" id="check_sin_cedula">
                                    <label class="form-check-label" for="check_sin_cedula">Sin cédula</label>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="">Primer Nombre</label>
                                <input type="text" class="form-control form-cmp" onkeyup="this.value=this.value.toUpperCase()" name="primer_nombre"
                                    id="primer_nombre" placeholder="Primer nombre" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="">Segundo Nombre</label>
                                <input type="text" class="form-control form-cmp" onkeyup="this.value=this.value.toUpperCase()" name="segundo_nombre"
                                    id="segundo_nombre" placeholder="Segundo nombre">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="">Primer Apellido</label>
                                <input type="text" class="form-control form-cmp" onkeyup="this.value=this.value.toUpperCase()" name="primer_apellido"
                                    id="primer_apellido" placeholder="Primer apellido">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="">Segundo Apellido</label>
                                <input type="text" class="form-control form-cmp" onkeyup="this.value=this.value.toUpperCase()" name="segundo_apellido"
                                    id="segundo_apellido" placeholder="Segundo apellido">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="">Dirección</label>
                                <input type="text" class="form-control form-cmp" name="direccion" id="direccion" placeholder="Dirección">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="">Departamento</label>
                                <select name="depto" id="depto" onchange="obtenerCiudadesCrm(this.value)" class="form-control form-cmp" required>
                                    <option value="">Seleccionar</option>
                                    @foreach ($deptos as $item)
                                        <option value="{{ $item->id_depto }}">{{ $item->depto }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="">Ciudad</label>
                                <select name="ciudad" id="ciudad" class="form-control form-cmp" required>
                                    <option value="">Seleccionar...</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="">Barrio</label>
                                <input type="text" class="form-control form-cmp" name="barrio" id="barrio" placeholder="Barrio">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="">Teléfono 1</label>
                                <input type="number" class="form-control form-cmp" name="telefono1" id="telefono1" placeholder="Número de celular"
                                    required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="">Teléfono 2</label>
                                <input type="number" class="form-control form-cmp" name="telefono2" id="telefono2" placeholder="Número de celular">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="">E-mail</label>
                                <input type="email" class="form-control form-cmp" onkeyup="this.value=this.value.toLowerCase()" name="correo"
                                    id="correo" placeholder="Correo electronico">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="">Cumpleaños</label>
                                <input type="date" class="form-control form-cmp" name="cumple" id="cumple">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="">Género</label>
                                <select name="genero" id="genero" class="form-control form-cmp" required>
                                    <option value="">Seleccionar...</option>
                                    <option value="HOMBRE">HOMBRE</option>
                                    <option value="MUJER">MUJER</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="">Tipo cliente</label>
                                <select name="tipo_c" id="tipo_c" class="form-control form-cmp" required>
                                    <option value="">Seleccionar...</option>
                                    <option value="1">Oportunidad</option>
                                    <option value="2">Prospecto</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="">Origen</label>
                                <select name="origen" id="origen" class="form-control form-cmp" required>
                                    <option value="" selected>Seleccionar</option>
                                    @foreach ($origen as $item)
                                        <option value="{{ $item->origen }}">{{ $item->origen }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="">Categoría</label>
                                <select name="categoria" id="categoria" class="form-control form-cmp" required>
                                    <option value="">Seleccionar...</option>
                                    <option value="SALAS">SALAS</option>
                                    <option value="COMEDORES">COMEDORES</option>
                                    <option value="COLCHONES">COLCHONES</option>
                                    <option value="ALCOBAS">ALCOBAS</option>
                                    <option value="ACCESORIOS">ACCESORIOS</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label for="">Observaciones</label>
                                <textarea name="observaciones" id="observaciones" class="form-control form-cmp" cols="30" rows="1" placeholder="Comentarios"
                                    required></textarea>
                            </div>
                        </div>
                        <center>
                            <button type="button" class="btn btn-danger mb-4"
                                onclick="GuardarInformacionClienteCrm('formulario-datos-nuevo-cliente')">Crear información cliente</button>
                        </center>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('footer')
    <script>
        var check = document.getElementById('check_sin_cedula');
        check.addEventListener('change', function() {
            var numeroced = Math.floor(Math.random() * 1000000000) + 1000000;
            if (this.checked) {
                $('#cedula_cliente').val(numeroced);
            } else {
                $('#cedula_cliente').val("");
            }
        });

        obtenerCiudadesCrm = (id) => {
            var datos = $.ajax({
                url: "{{ route('consultar.ciudad') }}",
                type: "POST",
                dataType: "json",
                data: {
                    id
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            datos.done((res) => {
                if (res.status == true) {
                    $('#ciudad').html(res.ciudad);
                }
            });
        }

        BuscarInformacionClienteCRM = (cedula) => {
            if (cedula.length > 0) {
                var datos = $.ajax({
                    url: "{{ route('search.new.cliente') }}",
                    type: "POST",
                    dataType: "json",
                    data: {
                        cedula
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                datos.done((res) => {
                    if (res.status == true) {
                        $('#primer_nombre').val(res.info.nombre_1);
                        $('#segundo_nombre').val(res.info.nombre_2);
                        $('#primer_apellido').val(res.info.apellido_1);
                        $('#segundo_apellido').val(res.info.apellido_2);
                        $('#direccion').val(res.info.direccion);
                        $('#depto').val(res.info.id_depto);
                        $('#barrio').val(res.info.barrio);
                        $('#telefono1').val(res.info.celular_1);
                        $('#telefono2').val(res.info.celular_2);
                        $('#correo').val(res.info.email);
                        $('#cumple').val(res.info.fecha_cumple);
                        $('#genero').val(res.info.genero);

                        var select = document.getElementById("depto");
                        var event = new Event("change");
                        select.dispatchEvent(event);

                        setTimeout(() => {
                            $('#ciudad').val(res.info.ciudad);
                        }, 1000);
                    }
                });
            } else {
                document.getElementById('formulario-datos-nuevo-cliente').reset()
            }
        }

        GuardarInformacionClienteCrm = (form) => {
            loandingPanel()
            var formData = new FormData(document.getElementById(form));

            var ciudad = $('#ciudad').find('option:selected');
            formData.append('id_ciudad', ciudad.data('id_city'));
            formData.append('id_depto', ciudad.data('id_depto'));
            formData.append('id_pais', ciudad.data('id_pais'));

            var datos = $.ajax({
                url: "{{ route('add.new.cliente.info') }}",
                type: "POST",
                dataType: "json",
                data: formData,
                cache: false,
                contentType: false,
                processData: false
            });
            datos.done((res) => {
                loadedPanel()
                if (res.status == true) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: res.mensaje,
                        showConfirmButton: false,
                        timer: 2000
                    })
                    document.getElementById(form).reset();
                }
                if (res.status == false) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: res.mensaje,
                        showConfirmButton: false,
                        timer: 3000
                    })
                }
            })
            datos.fail(() => {
                loadedPanel()
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Hubo un problema al procesar la solicitud',
                    showConfirmButton: false,
                    timer: 3000
                })
            })
        }
    </script>
@endsection
