$(document).ready(function () {
    // $("#modal_cambios").modal("show");

    // al pasar a produccion cambiar aca para que se autocargue la primera seccion de salas
    let url = "http://localhost/intranet_albura/public/secciones-ideas";
    seccion("botones_salas", url);
});

function childrensRadio() {
    let div = document.getElementById("container_input");
    let superior = document.getElementById("container_input2");
    superior.removeChild(div);
    let nodo_hijo = document.createElement("div");
    nodo_hijo.setAttribute("id", "container_input");
    superior.appendChild(nodo_hijo);
}

function addNode(id) {
    let radio = document.getElementById(id).value;
    childrensRadio();
    console.log("entro a la funcion y lo presionado es: " + radio);
    let container = document.getElementById("container_input");

    switch (radio) {
        case "1":
            let nodo = document.createElement("input");

            nodo.setAttribute("id", "file");
            nodo.setAttribute("type", "file");
            nodo.setAttribute("name", "file");
            nodo.setAttribute("accept", ".jpg, .png, .pdf, .jpeg");
            nodo.setAttribute("class", "form-control m-1");
            container.appendChild(nodo);

            break;

        case "2":
            let nodo2 = document.createElement("input");
            let clase = "form-control m-1";

            nodo2.setAttribute("class", clase);
            nodo2.setAttribute("id", "input_link");
            nodo2.setAttribute("name", "input_link");
            nodo2.setAttribute("type", "url");
            nodo2.setAttribute("placeholder", "https://ejemplo.com");
            container.appendChild(nodo2);

            break;

        case "3":
            let clase1 = 'form-control m-1';
            let input1 = document.createElement("input");
            let input2 = document.createElement("input");
            let label1 = document.createElement("label");
            let label2 = document.createElement("label");
            let claseLabel = 'ml-1'


            label1.setAttribute('for','file');
            label1.setAttribute('class',claseLabel);
            label1.textContent = 'PDF/Imagén:';
            label1.style.color = '#6C757D';

            label2.setAttribute('for','input_link');
            label2.setAttribute('class',claseLabel);
            label2.textContent = 'Link:';
            label2.style.color = '#6C757D';

            input1.setAttribute("class", clase1);
            input1.setAttribute("id", "file");
            input1.setAttribute("type", "file");
            input1.setAttribute("name", "file");
            input1.setAttribute("accept", ".jpg, .png, .pdf, .jpeg");

            input2.setAttribute("class", clase1);
            input2.setAttribute("id", "input_link");
            input2.setAttribute("name", "input_link");
            input2.setAttribute("type", "url");
            input2.setAttribute("placeholder", "https://ejemplo.com");

            container.appendChild(label1);
            container.appendChild(input1);
            container.appendChild(label2);
            container.appendChild(input2);


            break;
    }
}
function validarSection() {
    let selector = document.getElementById("inputGroupSelect01").value;

    if (selector == "seccion") {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Por favor elige una categoría válida!",
        });
        return false;
    } else {
        return true;
    }
}

function puente(id, nombre_idea) {
    let id_idea = document.getElementById("cambio_" + id).dataset.idIdea;
    let puente = (document.getElementById("puente_ids").value = id_idea);
    console.log("el puente es: " + puente);
    let puente2 = document.getElementById("puente_ids").value;
    let section = document.getElementById("container_data").dataset.section;
    document.getElementById("puente_ids").style.visibility = "hidden";
    document.getElementById("puente_ids").style.display = "none";
    let select = document.getElementById("inputGroupSelect02");
    let link = document.getElementById("cambio_" + id).dataset.link;
    let container_link = document.getElementById("container_link");
    let cambio_text = (document.getElementById("hola").innerHTML = nombre_idea);
    select.value = section;
    let papa_link = document.getElementById("container_link");
}

function seccion(id_section, url) {
    let ids = [
        "botones_salas",
        "botones_comedores",
        "botones_alcobas",
        "botones_colchones",
        "botones_accesorios",
        "botones_otros",
    ];

    let id = 0;
    ids.forEach((element) => {
        if (element == id_section) {
            id = element.split("_").pop();
            document.getElementById("secciones_" + id).style.display = "flex";
        }
    });
    let sendSection = document.getElementById("container_data");
    sendSection.dataset.section = id;
    let section_Searcher = document.getElementById("searchIde");
    section_Searcher.dataset.searcher = id;

    $.ajax({
        url: url,
        type: "POST",
        dataType: "json",
        data: {
            seccion: id,
        },
    }).done(function (res) {
        if (res) {
            document.getElementById("secciones_" + id).innerHTML = res.render;

            //como cada sección se concatena lo que se hace aqui es dejar limpio cada sección
            //para que se cargue y se muestre correctamente cada idea, en pocas palabras se formatean las demas
            // secciones para tener una vista limpia
            ids.forEach((element) => {
                if (element != id_section) {
                    id = element.split("_").pop();
                    document.getElementById("secciones_" + id).innerHTML = "";
                    document.getElementById("secciones_" + id).style.display =
                        "none";
                }
            });
        }
    });
}

function cerrar() {
    $("#newCommentUser").val("");
}

function deleteIdea(id, url) {
    let section = document.getElementById("container_data").dataset.section;
    console.log("debugueando el borrado de la seccion: " + section);
    $.ajax({
        url: url,
        type: "POST",
        dataType: "json",
        data: {
            id_borrar_idea: id,
            seccion: section,
        },
    })
        .done(function (res) {
            if (res) {
                // document.getElementById("ideas-contenidas").innerHTML =
                //     res.idea;
                console.log("entro al borrado!");
                document.getElementById("secciones_" + section).innerHTML =
                    res.idea;
            }
        })
        .fail(function (err) {});
}

function validarInformacion(id, url) {
    var id_c = $("#id_ideas" + id).data("id");
    $("#id_img_idea").val(id);
    var id_idea = document.getElementById("id_img_idea").value;

    document.getElementById("id_img_idea").innerHTML = id;

    $.ajax({
        url: url,
        type: "POST",
        dataType: "json",
        data: {
            id_idea: id_idea,
        },
    })
        .done(function (texto) {
            document.getElementById("dataCommentsIdeas").innerHTML =
                texto.comment;
        })
        .fail(function (error) {});
}

function enviarComentario(url) {
    let id_idea = document.getElementById("id_img_idea").value;
    let comentario = document.getElementById("newCommentUser").value;
    let section = document.getElementById("container_data").dataset.section;

    if (comentario) {
        $.ajax({
            url: url,
            type: "POST",
            dataType: "json",
            data: {
                texto: comentario,
                id_ideas: id_idea,
                seccion: section,
            },
            beforeSend: function () {
                $("#newCommentUser").val("");
            },
        })
            .done(function (res) {
                console.log(res);
                document.getElementById("dataCommentsIdeas").innerHTML =
                    res.comment;
                document.getElementById("secciones_" + section).innerHTML =
                    res.viewCount;
            })
            .fail(function (err) {});
    } else {
        console.log("Debe ingresar un valor al comentario");
    }
}

function borrarComentario(id, url) {
    let id_idea = document.getElementById("id_img_idea").value;
    let section = document.getElementById("container_data").dataset.section;

    $.ajax({
        url: url,
        type: "POST",
        dataType: "json",
        data: {
            id_comentario: id,
            id_ideas: id_idea,
            seccion: section,
        },
    })
        .done(function (res) {
            document.getElementById("dataCommentsIdeas").innerHTML =
                res.borrar_comentario;
            document.getElementById("secciones_" + section).innerHTML =
                res.borrado;
        })
        .fail(function (err) {});
}

 function enviarIdea(url) {
    let form = document.getElementById("envioDatos");
    let sendSection = document.getElementById("inputGroupSelect01").value;
    let data = new FormData(form);
    data.append("seccion", sendSection);

    let selector = validarSection();

    if (selector) {
        $.ajax({
            url: url,
            type: "post",
            dataType: "json",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
        })
            .done(function (res) {
                if (res) {
                    document.getElementById("exito").style.opacity = 1;
                    $("#exito").css({
                        height: "44px",
                        display: "flex",
                        "justify-content": "center",
                        "font-weight": "bold",
                        "text-align": "center",
                    });
                    document.getElementById("exito").innerHTML =
                        "¡Se envio la idea correctamente!";
                    document.getElementById("envioDatos").reset();
                    document.getElementById("exito").setAttribute('class','card bg-success');
                    document.getElementById(
                        "secciones_" + sendSection
                    ).innerHTML = res.respuesta;

                    setTimeout(() => {
                        console.log("Retrasado por 3 segundo.");
                        document.getElementById("exito").style.opacity = 0;
                    }, "3000");
                }
            })
            .fail(function (err) {
                document.getElementById("exito").style.opacity = 1;
                $("#exito").css({
                    height: "44px",
                    display: "flex",
                    "justify-content": "center",
                    "font-weight": "bold",
                    "text-align": "center",
                });
                document.getElementById("exito").setAttribute('class','card bg-danger');
                document.getElementById("exito").innerHTML =
                    "!Error¡ no se ha podido enviar su idea, por favor verifique todos los campos.";

                setTimeout(() => {
                   document.getElementById("exito").style.opacity = 0;
                }, "3000");
            });
    }
}
function buscar(valor, url) {
    let section = document.getElementById("searchIde").dataset.searcher;

    $.ajax({
        url: url,
        type: "POST",
        dataType: "json",
        data: {
            buscar: valor,
            seccion: section,
        },
    })
        .done(function (res) {
            if (res) {
                document.getElementById("secciones_" + section).innerHTML =
                    res.respuesta;
            }
        })
        .fail(function (err) {});
}

function changeIdea(url) {
    // $("#modal_cambios").modal("show");
    let idea = document.getElementById("puente_ids").value;
    let seccion_c = document.getElementById("inputGroupSelect02").value;
    let section = document.getElementById("container_data").dataset.section;
    let formulario = document.getElementById("formu");
    let Form = new FormData(formulario);
    let input_file = document.getElementById("input-cambio").value;
    let link;

    let container_link = document.getElementById("container_link");

    Form.append("seccion_c", seccion_c);
    Form.append("id_idea", idea);
    Form.append("seccion", section);
    $.ajax({
        url: url,
        type: "POST",
        dataType: "json",
        data: Form,
        cache: false,
        contentType: false,
        processData: false,
    })
        .done(function (res) {
            if (res) {
                let texto_video = "Archivo editado correctamente!";
                let texto_seccion = "La categoria se cambió correctamente!";
                document.getElementById("secciones_" + section).innerHTML =
                    res.cambio;
                formulario.reset();

                let notification =
                    document.getElementById("notification_modal");

                notification.style.display = "flex";

                if (seccion_c == section) {
                    notification.innerHTML = texto_video;

                    setTimeout(() => {
                        notification.style.display = "none";
                    }, 4000);
                } else {
                    notification.innerHTML = texto_seccion;
                    setTimeout(() => {
                        notification.style.display = "none";
                    }, 4000);
                }
            }
        })
        .fail(function (err) {
            if (err) {
                let notification =
                    document.getElementById("notification_modal");
                let texto_err = "La acción no se pudo realizar! =(";
                notification.style.backgroundColor = "#c82333";
                notification.style.display = "flex";
                notification.innerHTML = texto_err;
                setTimeout(() => {
                    notification.style.display = "none";
                    notification.style.backgroundColor = "#28a745";
                }, 4000);
            }
        });
}
function deleteImage(id_idea, url) {
    let section = document.getElementById("container_data").dataset.section;

    $.ajax({
        url: url,
        type: "POST",
        dataType: "json",
        data: {
            seccion: section,
            id_idea: id_idea,
        },
    }).done(function (res) {
        if (res.cambio === "sin imagen") {
            $("#toast").toast("show");
            document.getElementById("toast_notification").innerHTML =
                "No hay ninguna imagén o archivo para borrar!";
        } else {
            document.getElementById("secciones_" + section).innerHTML =
                res.cambio;
        }
    });
}

function deleteLink(id_idea, url) {
    let section = document.getElementById("container_data").dataset.section;

    console.log("entro a lo que necesito como funcion!");
    $.ajax({
        url: url,
        type: "POST",
        dataType: "json",
        data: {
            seccion: section,
            id_idea: id_idea,
        },
    }).done(function (res) {
        if (res) {
            document.getElementById("secciones_" + section).innerHTML =
                res.cambio;
        }
    });
}
