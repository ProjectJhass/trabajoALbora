notificaiones = (icon, title, timer) => {
    Swal.fire({
        position: 'top-end',
        icon: icon,
        title: title,
        showConfirmButton: false,
        timer: timer
    })
}
CrearSolicitudBitacora = (form) => {
    notificaiones('info', 'Generando solicitud...', 2000);
    var formulario = new FormData(document.getElementById(form));
    formulario.append('valor', 'valor');
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
            notificaiones('success', 'Solicitud creada exitosamente', 1500);
            document.getElementById(form).reset();
        }
    });
    datos.fail(() => {
        notificaiones('error', 'Revisa la información y vuelve a intentarlo', 1500);
    });
}