$(document).ready(function(){

    //$("#staticBackdrop").modal("show");
})


const input = document.getElementById("evidencias");
const inputV = document.getElementById("video");

inputV.addEventListener("change", function (e) {

    let parent_video = document.getElementById("parent-video");
    let hijos = parent_video.childNodes.length;
      if(hijos > 0){

          let parent_father = document.getElementById("parent_father");
          parent_father.removeChild(parent_video);
          let nuevo_element = document.createElement("div");
          parent_father.appendChild(nuevo_element);
          nuevo_element.setAttribute("id", "parent-video");
          nuevo_element.setAttribute("class","d-flex justify-content-center mt-3 sm");
      }

    let add_video = document.createElement("video");
    inputV.setAttribute("class","form-control valido");
    let parent_video1 = document.getElementById("parent-video");
    parent_video1.appendChild(add_video);
    add_video.setAttribute("class", "rounded");
    add_video.setAttribute("id", "video_player");
    add_video.setAttribute("controls", "true");
    add_video.setAttribute("width", "300");
    add_video.setAttribute("heigth", "200");
    // let video_player = document.getElementById("video_player");
    add_video.setAttribute("src",URL.createObjectURL(this.files[0]));
    console.log("llegue hasta el final");
    //  video_player.src = URL.createObjectURL(this.files[0]);
});


 function comprobarHijos(){
    let carga = document.getElementById("charge_evidence");
    let hijos = carga.childNodes.length;


    console.log("cuantos hijos tengo: " + hijos);

    if (hijos > 0) {
        console.log("entré porque tengo: "+hijos+" hijos");
        let papa_carga = document.getElementById("papa_charge");
        let carga = document.getElementById("charge_evidence");
        papa_carga.removeChild(carga);

        let format = document.createElement("div");
        papa_carga.appendChild(format);

        console.log(carga);
        format.setAttribute("id", "charge_evidence");
        format.setAttribute("class", "m-2 rounded");
        format.setAttribute("style", "background-color: white");

    }


}


    input.addEventListener("change", function (e) {
        let archivos = input.files;
        let cantidad = input.files.length;
        let extensiones = ["png", "jpeg", "heif", "jpg"];
        let correctos = 0;

          comprobarHijos();

        if (cantidad >= 3 && cantidad <= 5) {
            for (let i = 0; i < archivos.length; i++) {
                let extension = archivos[i].name.split(".").pop();

                console.log("extension:  " + extension + " con posicion: " + i);

                for (let j = 0; j < extensiones.length; j++) {
                    if (extension === extensiones[j]) {
                        previsualizarImg(e, i);
                        correctos ++
                        break;
                    }
                }
            }
            if (correctos < archivos.length) {
                console.log("alguno de los archivos tiene un formato inválido");
                let no_g = document.getElementById("no_guardado");

                no_g.style.visibility = "visible";
                document.getElementById("no_guardado").innerHTML =
                    "alguno de los archivos tiene un formato inválido";

                let carga = document.getElementById("charge_evidence");
                let papa_carga = document.getElementById("papa_charge");
                papa_carga.removeChild(carga);

                let format = document.createElement("div");
                papa_carga.appendChild(format);
                format.setAttribute("id", "charge_evidence");
                format.setAttribute("class", "m-2");
                archivos = [];
                input.value = "";

                setTimeout(() => {
                    document.getElementById("no_guardado").style.visibility =
                        "hidden";
                }, "6000");
            }
        } else {
            archivos = [];
            input.value = "";
            console.log("error debes ingresar el rango de fotos permitido!");
            let no_g = document.getElementById("no_guardado");

            no_g.style.visibility = "visible";
            document.getElementById("no_guardado").innerHTML =
                "Ingresa la cantidad de archivos permitidos! =(";

            setTimeout(() => {
                document.getElementById("no_guardado").style.visibility = "hidden";
            }, "6000");
        }


    });
function previsualizarImg(e, i) {
    var file = e.target.files[i];

    var reader = new FileReader();

    let carga = document.getElementById("charge_evidence");

    let img = document.createElement("img");

    reader.onload = function (e) {
        var result = e.target.result;
        img.src = result;
        img.setAttribute("width", 100);
        img.setAttribute("heigth", 100);
        img.setAttribute("class", "shadow m-2 rounded border-primary sm");
        carga.appendChild(img);

        //  $('#charge_evidence').append(`<img src="${result}" width="100" height="100" class="shadow mt-2">`); //Asignamos el src dinámicamente a un img dinámico también
    };
    reader.readAsDataURL(file);
}

function enviarInfo(url) {
    let formulario = document.getElementById("formulario");
    let data = new FormData(formulario);
    let definitiva = validarAllInputs();


    if (definitiva === 0) {

        $('#staticBackdrop').modal("show");
        $.ajax({
            url: url,
            type: "post",
            dataType: "json",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                document.getElementById("guardado").removeAttribute("class");
                document
                    .getElementById("guardado")
                    .setAttribute("class", "alert alert-warning mt-2");
                document.getElementById("guardado").innerHTML =
                    "Enviando Formulario, espere un momento por favor!...";
            },
        })
            .done(function (texto) {
                if (texto) {

                    let parent_video = document.getElementById("parent-video");
                    let parent_father = document.getElementById("parent_father");
          parent_father.removeChild(parent_video);
          let nuevo_element = document.createElement("div");
          parent_father.appendChild(nuevo_element);
          nuevo_element.setAttribute("id", "parent-video");
          nuevo_element.setAttribute("class","d-flex justify-content-center mt-3 sm");
                    let rueda = document.getElementById("rueda");
                    rueda.classList.remove("rueda");
                    rueda.classList.add("rueda_chulo");
                    let cargador_text = document.getElementById("cargador");
                     let cargador_texto = document.getElementById("cargador_texto");
                    cargador_text.innerHTML = "";
                     cargador_texto.innerHTML = "Hecho!";
                     cargador_texto.style.color = "#34ce57";
                    cargador_text.classList.toggle("cargador_chulo");

                    let div = document.createElement("div");
                    let h3 = document.createElement("h3");
                    h3.innerHTML = "Su orden de Servicio Técnico ha sido enviada Satisfactoriamente!";
                    h3.style.color = "#34ce57";
                    h3.setAttribute("class","m-2");
                    let parrafo = document.createElement("p");
                    let contenido = document.getElementById("contenido");
                    contenido.appendChild(div);



                    parrafo.innerHTML = "Su número de ticket es: <b>"+texto.ticket+"</b>"+
                    "<br>Al correo electronico: <b>"+texto.email+"</b> le llegará un mensaje de notificación proporcionando la información "+
                    "aquí suministrada.<br><br><b>Att: </b>Equipo de servicios técnicos Muebles Albura.";
                    let textos = document.getElementById("_texto");
                    textos.style.width = "95%";
                    textos.appendChild(h3);
                    textos.appendChild(parrafo);
                    document
                        .getElementById("guardado")
                        .removeAttribute("class");
                    document
                        .getElementById("guardado")
                        .setAttribute("class", "alert alert-success mt-2");

                    let guardado = document.getElementById("guardado");
                    guardado.innerHTML =
                        "Información Enviada con Éxito! =) NUMERO DE TICKET: #" +
                        texto.ticket;
                    guardado.style.visibility = "visible";
                    document.getElementById("formulario").reset();
                    let carga = document.getElementById("charge_evidence");

                    console.log("entro aca porque se supone tengo hijos!");
                    let papa_carga = document.getElementById("papa_charge");
                    papa_carga.removeChild(carga);
                    let format = document.createElement("div");
                    papa_carga.appendChild(format);
                    format.setAttribute("id", "charge_evidence");
                    format.setAttribute("class", "m-2");
                    input.value = "";
                    //
                    setTimeout(() => {
                        document.getElementById("guardado").style.visibility =
                            "hidden";
                    }, "10000");
                }
            })
            .fail(function (error) {
                let no_g = document.getElementById("no_guardado");
                no_g.innerHTML = "Su solicitud falló!";

                no_g.style.visibility = "visible";

                setTimeout(() => {
                    document.getElementById("no_guardado").style.visibility =
                        "hidden";
                }, "2000");
            });
    }
}

function validar_email() {
    let email = document.getElementById("email").value;
    let email_prop = document.getElementById("email");
    let msj_email = document.getElementById("msj_email");

    var regex =
        /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

    if (regex.test(email)) {
        email_prop.removeAttribute("class");
        email_prop.setAttribute("class", "form-control mt-2 valido");

        return true;
    } else {
        email_prop.removeAttribute("class");
        email_prop.setAttribute("class", "form-control mt-2 is-invalid");
        msj_email.innerHTML = "ingresa un E-mail válido"

        return false;
    }
}

function validar_telfono() {
    let valor_input = document.getElementById("telefono").value;
    let input_telefono = document.getElementById("telefono");
    let m_telefono = document.getElementById("msj_telefono");

    if (valor_input.length >= 10) {
        input_telefono.removeAttribute("class");
        input_telefono.setAttribute("class", "form-control mt-2 valido");
        return true;
    } else {
        input_telefono.removeAttribute("class");
        m_telefono.innerHTML =
            "El número de telefono tiene: " +
            valor_input.length +
            " digitos y debe tener minimo 10.";
        input_telefono.setAttribute("class", "form-control mt-2 is-invalid");

        return false;
    }
}

function validarCedula() {
    let cedula = document.getElementById("cedula").value;
    let cedula_prop = document.getElementById("cedula");
    let msj_cedula = document.getElementById("mensaje");

    if (cedula.length >= 5) {
        cedula_prop.removeAttribute("class");
        cedula_prop.setAttribute("class", "form-control mt-2 valido");
        return true;
    } else {
        cedula_prop.removeAttribute("class");


        msj_cedula.innerHTML =
            "El número de cédula tiene: " +
            cedula.length +
            " digitos y debe tener minimo 5.";
        cedula_prop.setAttribute("class", "form-control mt-2 is-invalid ");

        return false;
    }
}

function validarNombre() {
    let nombre = document.getElementById("nombre").value;
    let nombre_prop = document.getElementById("nombre");
    let msj_nombre = document.getElementById("msj_nombre");

    if (nombre.length > 0) {
        nombre_prop.removeAttribute("class");
        nombre_prop.setAttribute("class", "form-control mt-2 valido");
    } else {
        nombre_prop.removeAttribute("class");
        nombre_prop.setAttribute("class", "form-control mt-2 is-invalid");
        msj_nombre.innerHTML = "Ingresa un nombre válido.";
    }
}

function validarOptions() {
    let option = document.getElementById("option").value;
    let option_prop = document.getElementById("option");
    let msj_option = document.getElementById("msj_option");

    if (option === "") {
        option_prop.removeAttribute("class");
        option_prop.setAttribute("class", "form-select  is-invalid");
        msj_option.innerHTML = "Elige una opción diferente de 'OPCIONES'.";

        return false;
    } else {
        option_prop.removeAttribute("class");
        option_prop.setAttribute("class", "form-select valido");
        return true;
    }
}

function validarDescripcion() {
    let descripcion = document.getElementById("descripcion").value;
    let descripcion_prop = document.getElementById("descripcion");
    let msj_descripcion = document.getElementById("msj_descripcion");

    if (descripcion.length > 0) {
        descripcion_prop.removeAttribute("class");
        descripcion_prop.setAttribute("class", "form-select  valido");
        return true;
    } else {
        descripcion_prop.removeAttribute("class");
        descripcion_prop.setAttribute("class", "form-select  is-invalid");
        msj_descripcion.innerHTML = "Debes llenar alguna descripción.";
        return false;
    }
}

function validarImg() {
    input.addEventListener("change", function (e) {
        let cantidad = input.files.length;

        let evidencia = document.getElementById("evidencias");
        let msj_evidencia = document.getElementById("msj_evidencia");

        if (cantidad >= 3) {
            evidencia.removeAttribute("class");
            evidencia.setAttribute("class", "form-control  valido");
            return true;
        } else {
            evidencia.removeAttribute("class");
            evidencia.setAttribute("class", "form-control  is-invalid");
            msj_evidencia.innerHTML = "ingresa la cantidad de fotos requerida.";
            return false;
        }
    });
}

function validarAllInputs() {
    let nombre = validarNombre();
    let cedula = validarCedula();
    let descripcion = validarDescripcion();
    let img = validarImg();
    let option = validarOptions();
    let email = validar_email();
    let telefono = validar_telfono();
    let definitivas = [
        nombre,
        cedula,
        descripcion,
        img,
        option,
        email,
        telefono,
    ];
    let definitiva = 0;

    for (let i = 0; i < definitivas.length; i++) {
        if (definitivas[i] == false) {
            definitiva++;
        }
    }
    return definitiva;
}
