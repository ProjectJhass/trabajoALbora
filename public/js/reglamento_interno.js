$(function () {
    $('#informacion-general-reglamento').DataTable({
        "oLanguage": {
            "sSearch": "Buscar:",
            "sInfo": "Mostrando _END_ de _TOTAL_ registros",
            "oPaginate": {
                "sPrevious": "Volver",
                "sNext": "Siguiente"
            },
            "sEmptyTable": "No se encontró ningun registro en la base de datos",
            "sZeroRecords": "No se encontraron resultados...",
            "sLengthMenu": "Mostrar _MENU_ registros"
        },
        "pageLength": 4,
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": false,
    });
});

ValidarExistenciaCedulaReglamento = (form) => {
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
            $('#tomar-fotografia-reglamento').modal('show');
            ActivarFuncionCamara(res.data[0].cedula, res.data[0].nombre, res.data[0].empresa);
        } else {
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'El usuario no existe en la empresa',
                showConfirmButton: false,
                timer: 2000
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

ActivarFuncionCamara = (cedula, nombre, empresa) => {
    //FUNCIONES PARA TOMAR FOTO NEXUS
    function tieneSoporteUserMedia() {
        return !!(navigator.getUserMedia || (navigator.mozGetUserMedia || navigator.mediaDevices.getUserMedia) || navigator.webkitGetUserMedia || navigator.msGetUserMedia)
    }
    function _getUserMedia() {
        return (navigator.getUserMedia || (navigator.mozGetUserMedia || navigator.mediaDevices.getUserMedia) || navigator.webkitGetUserMedia || navigator.msGetUserMedia).apply(navigator, arguments);
    }

    // Declaramos elementos del DOM
    const $video = document.querySelector("#video"),
        $canvas = document.querySelector("#canvas"),
        $boton = document.querySelector("#boton"),
        $estado = document.querySelector("#estado"),
        $listaDeDispositivos = document.querySelector("#listaDeDispositivos");

    // La función que es llamada después de que ya se dieron los permisos
    // Lo que hace es llenar el select con los dispositivos obtenidos
    const llenarSelectConDispositivosDisponibles = () => {

        navigator
            .mediaDevices
            .enumerateDevices()
            .then(function (dispositivos) {
                const dispositivosDeVideo = [];
                dispositivos.forEach(function (dispositivo) {
                    const tipo = dispositivo.kind;
                    if (tipo === "videoinput") {
                        dispositivosDeVideo.push(dispositivo);
                    }
                });

                // Vemos si encontramos algún dispositivo, y en caso de que si, entonces llamamos a la función
                if (dispositivosDeVideo.length > 0) {
                    // Llenar el select
                    dispositivosDeVideo.forEach(dispositivo => {
                        const option = document.createElement('option');
                        option.value = dispositivo.deviceId;
                        option.text = dispositivo.label;
                        $listaDeDispositivos.appendChild(option);
                        console.log("$listaDeDispositivos => ", $listaDeDispositivos)
                    });
                }
            });
    }

    (function () {
        // Comenzamos viendo si tiene soporte, si no, nos detenemos
        if (!tieneSoporteUserMedia()) {
            alert("Lo siento. Tu navegador no soporta esta característica");
            $estado.innerHTML = "Parece que tu navegador no soporta esta característica. Intenta actualizarlo.";
            return;
        }
        //Aquí guardaremos el stream globalmente
        let stream;


        // Comenzamos pidiendo los dispositivos
        navigator
            .mediaDevices
            .enumerateDevices()
            .then(function (dispositivos) {
                // Vamos a filtrarlos y guardar aquí los de vídeo
                const dispositivosDeVideo = [];

                // Recorrer y filtrar
                dispositivos.forEach(function (dispositivo) {
                    const tipo = dispositivo.kind;
                    if (tipo === "videoinput") {
                        dispositivosDeVideo.push(dispositivo);
                    }
                });

                // Vemos si encontramos algún dispositivo, y en caso de que si, entonces llamamos a la función
                // y le pasamos el id de dispositivo
                if (dispositivosDeVideo.length > 0) {
                    // Mostrar stream con el ID del primer dispositivo, luego el usuario puede cambiar
                    mostrarStream(dispositivosDeVideo[0].deviceId);
                }
            });



        const mostrarStream = idDeDispositivo => {
            _getUserMedia(
                {
                    video: {
                        // Justo aquí indicamos cuál dispositivo usar
                        deviceId: idDeDispositivo,
                    }
                },
                function (streamObtenido) {
                    // Aquí ya tenemos permisos, ahora sí llenamos el select,
                    // pues si no, no nos daría el nombre de los dispositivos
                    llenarSelectConDispositivosDisponibles();

                    // Escuchar cuando seleccionen otra opción y entonces llamar a esta función
                    $listaDeDispositivos.onchange = () => {
                        // Detener el stream
                        if (stream) {
                            stream.getTracks().forEach(function (track) {
                                track.stop();
                            });
                        }
                        // Mostrar el nuevo stream con el dispositivo seleccionado
                        mostrarStream($listaDeDispositivos.value);
                    }

                    // Simple asignación
                    stream = streamObtenido;

                    // Mandamos el stream de la cámara al elemento de vídeo
                    $video.srcObject = stream;
                    $video.play();

                    //Escuchar el click del botón para tomar la foto
                    $boton.addEventListener("click", function () {

                        //Pausar reproducción
                        $video.pause();

                        //Obtener contexto del canvas y dibujar sobre él
                        let contexto = $canvas.getContext("2d");
                        $canvas.width = $video.videoWidth;
                        $canvas.height = $video.videoHeight;
                        contexto.drawImage($video, 0, 0, $canvas.width, $canvas.height);

                        let foto = $canvas.toDataURL(); //Esta es la foto, en base 64

                        fetch(window.location.href + "/foto/" + cedula + "/" + nombre + "/" + empresa, {
                            method: "POST",
                            body: encodeURIComponent(foto),
                            headers: {
                                "Content-type": "application/json",
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        }).then(res => res.json()).then(
                            (respuesta) => {
                                if (respuesta.status == true) {
                                    $('#tomar-fotografia-reglamento').modal('hide');
                                    $('#modal-visualizacion-reglamento-interno-trabajo').modal('show');
                                    $('#documento-encontrado-reglamento').html(respuesta.iframe);
                                } else {
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'error',
                                        title: respuesta.mensaje,
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                }
                            },
                            (error) => {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'error',
                                    title: 'Hubo un problema al procesar la solicitud',
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                            }
                        )

                        $video.stop();
                    });
                }, function (error) {
                    console.log("Permiso denegado o error: ", error);
                    $estado.innerHTML = "No se puede acceder a la cámara, o no diste permiso.";
                });
        }
    })();
}