$(document).ready(function () {

     document.oncontextmenu = function () {
               return false;
           };
         $("#exampleModal").modal("show");

    // $("#contacto").modal("show");
});
function desplegarTyc() {
    $("#tyc").modal("show");
    $("#exampleModal").modal("toggle");
}

function closeModal() {
    $("#tyc").modal("toggle");
    $("#exampleModal").modal("show");

    let terminos1 = (document.getElementById("terminos1").checked = true);

    let lt1 = document.getElementById("lt1");
    let terminos11 = document.getElementById("terminos1");
    lt1.style.color = "#34ce57";
    terminos11.style.backgroundColor = "#34ce57";
    terminos11.style.border = "none";
}

function validarCheckboxes() {
    let terminos1 = document.getElementById("terminos1").checked;
    let terminos2 = document.getElementById("terminos2").checked;
    let terminos3 = document.getElementById("terminos3").checked;
    let aux = 0;

    if (terminos1) {
        aux = aux + 1;
    }

    if (terminos2) {
        aux = aux + 1;
    }

    if (terminos3) {
        aux = aux + 1;
    }

    if (aux >= 3) {
        $("#exampleModal").modal("toggle");
    } else {
        rechazoTyc();
    }
}

function openModal() {
    $("#contacto").modal("toggle");
}

async function copiar() {
    let input = document.getElementById("input").value;
    try {
        await navigator.clipboard.writeText(input);
        document.getElementById("copiado").style.display = "block";
        document.getElementById("copiado").innerHTML =
            "Contenido copiado al portapapeles.  =)";
        setTimeout(() => {
            document.getElementById("copiado").style.display = "none";
        }, "2000");
    } catch (err) {
        console.error("Error al copiar: ", err);
    }
}

function checkex() {
    let terminos1 = document.getElementById("terminos1").checked;
    let terminos2 = document.getElementById("terminos2").checked;
    let terminos3 = document.getElementById("terminos3").checked;

    let terminos11 = document.getElementById("terminos1");
    let terminos12 = document.getElementById("terminos2");
    let terminos13 = document.getElementById("terminos3");

    let lt1 = document.getElementById("lt1");
    let lt2 = document.getElementById("lt2");
    let lt3 = document.getElementById("lt3");

    if (terminos1) {
        lt1.style.color = "#34ce57";
        terminos11.style.backgroundColor = "#34ce57";
        terminos11.style.border = "none";
    }
    if (terminos2) {
        lt2.style.color = "#34ce57";
        terminos12.style.backgroundColor = "#34ce57";
        terminos12.style.border = "none";
    }
    if (terminos3) {
        lt3.style.color = "#34ce57";
        terminos13.style.backgroundColor = "#34ce57";
        terminos13.style.border = "none";
    }
}
