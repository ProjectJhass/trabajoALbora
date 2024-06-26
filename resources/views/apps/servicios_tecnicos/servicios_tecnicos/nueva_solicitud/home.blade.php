@extends('apps.servicios_tecnicos.plantilla.app')
@section('head')
    <link href="{{ asset('plugins/select2/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('plugins/select2/b5Select2.min.css') }}" rel="stylesheet" />
    <style>
        #floating-btn-new-st {
            display: none;
        }
    </style>
@endsection
@section('body')
    @php
        echo $form;
    @endphp
@endsection
@section('footer')
    <script src="{{ asset('plugins/select2/select2.bundle.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/select2Full.full.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            buscarInfoCentroExp()

            $('#causales_st').select2({
                theme: "bootstrap-5",
                placeholder: $(this).data('placeholder'),
                closeOnSelect: false,
                tags: true
            });

            $('.articulo_st').select2({
                theme: "bootstrap-5",
                placeholder: $(this).data('placeholder'),
            });
        });

        updateInfoProduct = (selectElement) => {
            var id_item = $(selectElement).find('option:selected').data('id_item');
            var ext1 = $(selectElement).find('option:selected').data('ext1');
            var ext2 = $(selectElement).find('option:selected').data('ext2');
            $('#id_item').val(id_item)
            $('#ext1').val(ext1)
            $('#ext2').val(ext2)
        }

        validarProveedorForm = (valor) => {
            switch (valor) {
                case "HAPPY SLEEP":
                    $("#co_new_ost").val("999")
                    break;
                case "HOTEL ABADIA":
                    $("#co_new_ost").val("051")
                    break;
                case "HOTEL SONESTA":
                    $("#co_new_ost").val("052")
                    break;
                case "TERCEROS":
                    $("#co_new_ost").val("053")
                    break;
            }
        }

        validarTipoStForm = (valor) => {

            var co = $("#co_new_ost").val()

            switch (valor) {
                case "CLIENTE":
                    $("#cedula_st").val("")
                    $("#nombre_st").val("")
                    $("#celular_st").val("")
                    $("#email_st").val("")
                    $("#direccion_st").val("")
                    $("#barrio_st").val("")
                    $("#ciudad_st").val("")
                    break;
                case "ALMACEN":
                    if (co == "999") {
                        $("#cedula_st").val("")
                        $("#nombre_st").val("")
                        $("#celular_st").val("")
                        $("#email_st").val("")
                        $("#direccion_st").val("")
                        $("#barrio_st").val("")
                        $("#ciudad_st").val("")
                    } else {
                        buscarInfoEmailSt(co)
                        $("#cedula_st").val("800009732")
                        $("#nombre_st").val("MUEBLES ALBURA SAS")
                        $("#celular_st").val("")
                        $("#direccion_st").val("")
                        $("#barrio_st").val("")
                        $("#ciudad_st").val("")
                    }
                    break;
                case "BODEGA":
                    if (co == "999") {
                        $("#cedula_st").val("890003838")
                        $("#nombre_st").val("COLCHONES HAPPY SLEEP SAS")
                        $("#celular_st").val("3116356431")
                        $("#email_st").val("logistica@happysleep.com.co")
                        $("#direccion_st").val("KM 1 VIA EL EDEN")
                        $("#barrio_st").val("FRENTE AL BARRIO ARRAYANES")
                        $("#ciudad_st").val("ARMENIA")
                    } else {
                        $("#cedula_st").val("800009732")
                        $("#nombre_st").val("MUEBLES ALBURA SAS")
                        $("#celular_st").val("3183569509")
                        $("#email_st").val("bodega.ppal@mueblesalbura.com.co")
                        $("#direccion_st").val("CARRERA 16 A N 10 - 42")
                        $("#barrio_st").val("LA POPA")
                        $("#ciudad_st").val("DOSQUEBRADAS")
                    }
                    break;
            }
        }

        buscarInfoEmailSt = (co) => {
            var datos = $.ajax({
                url: "{{ route('find.email.form.create.ost') }}",
                type: "post",
                dataType: "json",
                data: {
                    co
                }
            });
            datos.done((res) => {
                $("#email_st").val(res.email)
            })
        }

        CrearNuevaSolicitudST = () => {
            notificacion("Guardando información de la orden de servicio", "info", 10000);
            var formulario = new FormData(document.getElementById('form-send-new-ost'));
            formulario.append('valor', 'valor');
            var datos = $.ajax({
                url: "{{ route('form.create.ost') }}",
                type: "post",
                dataType: "json",
                data: formulario,
                cache: false,
                contentType: false,
                processData: false
            });
            datos.done((res) => {
                notificacion("Excelente! Orden de servicio técnico creado", "success", 5000);
                setTimeout(() => {
                    window.location.href = "{{ route('informe.seg') }}"
                }, 1500);
            })
            datos.fail(() => {
                notificacion("ERROR! Revisa la información y vuelve a intentarlo", "error", 5000);
            })
        }
    </script>
@endsection
