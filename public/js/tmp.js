CargarDocumentosTemporales = (form) => {
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
            location.reload();
        }
    });
    datos.fail(() => {

    });
}