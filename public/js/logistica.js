AbrirServiciosTecnicosConUsuario = (user) => {
    var url = "https://app-mueblesalbura.com/servicios_tecnicos/index.PHP?usuario_i=";
    Swal.fire({
        title: 'Centro de operación',
        html: 'Selecciona el <a href="' + url + user + '" target="_blank">centro de operación</a> a ingresar',
        icon: 'warning',
        input: 'select',
        inputOptions: {
            'ARMENIA_02': 'ARMENIA_02',
            'CARTAGO_07': 'CARTAGO_07',
            'PEREIRA_06': 'PEREIRA_06',
            'BODEGA_20': 'BODEGA_20',
            'BODEGA_21': 'BODEGA_21',
            'BODEGA_22': 'BODEGA_22',
            'CALI_36': 'CALI_36',
            'DOSQUEBRADAS_08': 'DOSQUEBRADAS_08',
            'GIRARDOT_11': 'GIRARDOT_11',
            'GIRARDOT_27': 'GIRARDOT_27',
            'IBAGUE_04': 'IBAGUE_04',
            'IBAGUE_25': 'IBAGUE_25',
            'MANIZALES_17': 'MANIZALES_17',
            'NEIVA_12': 'NEIVA_12',
            'PEREIRA_10': 'PEREIRA_10',
            'PEREIRA_14': 'PEREIRA_14',
            'PEREIRA_28': 'PEREIRA_28',
            'PALMIRA_37': 'PALMIRA_37',
			'VENTAS WEB_38': 'VENTAS WEB_38',
			'MARKET PLACE_39': 'MARKET PLACE_39'
        },
        inputPlaceholder: 'Seleccionar...',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Acceder',
        cancelButtonText: 'Cerrar',
        showLoaderOnConfirm: true,
        inputValidator: co => {
            // Si el valor es válido, debes regresar undefined. Si no, una cadena
            if (!co) {
                return "Debes seleccionar un CO";
            } else {
                return undefined;
            }
        }
    }).then((result) => {
        if (result.value) {
            let co = result.value;
            window.open(url + co, '_blank');
        }
    });
}

CargarDocumentos = (form) => {
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
