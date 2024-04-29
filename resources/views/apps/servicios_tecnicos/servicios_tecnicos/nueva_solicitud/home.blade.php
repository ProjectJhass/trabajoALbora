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
