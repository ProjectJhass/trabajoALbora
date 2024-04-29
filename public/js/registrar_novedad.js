ObtenerSucursal = (valor) => {
    if (valor.length > 0) {
        var datos = $.ajax({
            url: window.location.href + "/consultar",
            type: "post",
            dataType: "json",
            data: {
                valor
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        datos.done((res) => {
            if (res.status == true) {
                $('#sucursal').val(res.sucursal);
            }
        });
        datos.fail(() => {
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Hubo un problema al procesar la solicitud',
                showConfirmButton: false,
                timer: 2000
            });
        });
    }
}

RegistrarNovedadesUsuario = (form) => {
    var formulario = new FormData(document.getElementById(form));
    formulario.append('co', $('#sucursal').val());
    var datos = $.ajax({
        url: window.location.href,
        type: "post",
        dataType: "json",
        data: formulario,
        cache: false,
        contentType: false,
        processData: false
    });
    datos.done((res) => {
        if (res.status == true) {
            document.getElementById(form).reset();
            $('#empleado').val(null).trigger('change');
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Información almacenada',
                showConfirmButton: false,
                timer: 1500
            });
        }
    });
    datos.fail(() => {
        Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: 'Hubo un problema al procesar la solicitud',
            showConfirmButton: false,
            timer: 2000
        });
    });
}