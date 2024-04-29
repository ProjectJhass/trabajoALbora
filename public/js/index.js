ValidarSesionesEstadisticas = () => {
    var co = $("#centro_de_operacion").val();
    var fecha_i = $("#fechas_estadisticas")
        .data("daterangepicker")
        .startDate.format("YYYY-MM-DD");
    var fecha_f = $("#fechas_estadisticas")
        .data("daterangepicker")
        .endDate.format("YYYY-MM-DD");

    var datos = $.ajax({
        url: "https://app-mueblesalbura.com/intranet_albura/public/general/sesiones",
        type: "post",
        dataType: "json",
        data: {
            co,
            fecha_i,
            fecha_f,
        },
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    datos.done((res) => {
        if (res.status) {
            window.location.reload();
        }
    });
};

function enviarFormularioLoginAlbura() {
    let formData = new FormData(
        document.getElementById("autenticar-usuario-help_desk")
    );

    let url_actual = window.location.href;
    let url = new URL(url_actual);
    let urlBase = url.origin;

    $.ajax({
        url: urlBase + "/mesa_de_ayuda/Logica/logica_login_albura.php",
        type: "POST",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (res) {
            let resDecode = JSON.parse(res);
            console.log(resDecode);

            if (resDecode.redirect == "index_page") {
                window.open(
                    urlBase +
                        "/mesa_de_ayuda/modulos/OpcionesMisCasos/TodosCasos.php",
                    "_blank"
                );
            } else {
                window.open(urlBase + "/mesa_de_ayuda/index.php", "_blank");
            }
        },
        error: function (err) {
            console.error(err);
        },
    });
}
