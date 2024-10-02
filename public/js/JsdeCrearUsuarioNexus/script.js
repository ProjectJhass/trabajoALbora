

// document.querySelector('.profile-img-edit').addEventListener('click', function() {
//     document.querySelector('.file-upload').click();
// });

// document.querySelector('.file-upload').addEventListener('change', function(event) {
//     const file = event.target.files[0];
//     if (file) {
//         const reader = new FileReader();
//         reader.onload = function(e) {
//             document.querySelector('.profile-pic').src = e.target.result;
//         }
//         reader.readAsDataURL(file);
//     } else {
//         document.querySelector('.profile-pic').src = defaultImageUrl;
//     }
// });
const iconUploadFile=document.getElementsByClassName("upload-icone")[0];
const fileImageUpload=document.getElementsByClassName("file-upload")[0];

iconUploadFile.addEventListener("click", function() {
    fileImageUpload.disabled=false;
    fileImageUpload.focus();
})





// buscarCiudadDpto = (id_depto) => {
//     if (id_depto.length > 0) {
//         var datos = $.ajax({
//             url: "{{ route('search.ciudad.nexus') }}",
//             type: "post",
//             dataType: "json",
//             data: {
//                 id_depto
//             }
//         });
//         datos.done((res) => {
//             notificacion("Información encontrada", "success", 3000)
//             document.getElementById('ciudad').innerHTML = res.info
//         })
//     } else {
//         document.getElementById('ciudad').innerHTML = ""
//     }
// }

// validarNombreDeUsuario = (usuario) => {
//     var datos = $.ajax({
//         url: "{{ route('search.user.nexus') }}",
//         type: "post",
//         dataType: "json",
//         data: {
//             usuario
//         }
//     });
//     datos.done((res) => {
//         notificacion("Nombre de usuario disponible", "success", 3000)
//     })
//     datos.fail(() => {
//         notificacion("¡ERROR! Nombre de usuario en uso, agrega otro", "error", 6000)
//     })
// }

// buscarAreasEmpresa = (id) => {
//     if (id.length > 0) {
//         var datos = $.ajax({
//             url: "{{ route('search.areas.nexus') }}",
//             type: "post",
//             dataType: "json",
//             data: {
//                 id
//             }
//         });
//         datos.done((res) => {
//             notificacion("Información encontrada", "success", 3000)
//             document.getElementById('area_user').innerHTML = res.info
//         })
//     } else {
//         document.getElementById('area_user').innerHTML = ""
//     }
// }

// buscarCargosAreas = (area) => {
//     if (area.length > 0) {
//         var datos = $.ajax({
//             url: "{{ route('search.cargos.nexus') }}",
//             type: "post",
//             dataType: "json",
//             data: {
//                 area
//             }
//         });
//         datos.done((res) => {
//             notificacion("Información encontrada", "success", 3000)
//             document.getElementById('cargo_user').innerHTML = res.info
//             if (area == 10) {
//                 document.getElementById('infoGeneralZona').hidden = false
//             } else {
//                 $('#zona_user').val('')
//                 document.getElementById('infoGeneralZona').hidden = true
//             }
//         })
//     } else {
//         document.getElementById('cargo_user').innerHTML = ""
//     }
// }

// generarNombreUsuario = () => {
//     var nombre = document.getElementById('nombre_usuario').value;
//     var apellidos = document.getElementById('apellidos_usuario').value;

//     var nombresArray = nombre.trim().split(' ');
//     var apellidosArray = apellidos.trim().split(' ');

//     var primerNombre = nombresArray[0];
//     var primerApellido = apellidosArray[0];

//     var nombreUsuario = primerNombre + '.' + primerApellido;
//     $("#usuario").val(nombreUsuario)
//     validarNombreDeUsuario(nombreUsuario)
// }

// validarContraseñasIngresadas = (valor) => {
//     var pwd = $("#password").val()
//     if (pwd === valor) {
//         $("#rpassword").removeClass("is-invalid")
//         $("#rpassword").addClass("is-valid")
//     } else {
//         $("#rpassword").removeClass("is-valid")
//         $("#rpassword").addClass("is-invalid")
//     }
// }

// crearInformacionNuevoUsuario = () => {
//     notificacion("Creando información del nuevo usuario, Por favor espera...", "info", 10000);

//     var depto = document.getElementById("departamento");
//     var nom_depto = depto.options[depto.selectedIndex].text;

//     var ciudad = document.getElementById("ciudad");
//     var nom_ciudad = ciudad.options[ciudad.selectedIndex].text;

//     var formulario = new FormData(document.getElementById('formInformacionNuevoUsuario'));
//     formulario.append('nom_depto', nom_depto);
//     formulario.append('nom_ciudad', nom_ciudad);
//     var datos = $.ajax({
//         url: "{{ route('crear.users.nexus') }}",
//         type: "post",
//         dataType: "json",
//         data: formulario,
//         cache: false,
//         contentType: false,
//         processData: false
//     });
//     datos.done((res) => {
//         if (res.status == true) {
//             notificacion(res.mensaje, "success", 5000)
//             document.getElementById('formInformacionNuevoUsuario').reset()
//         }
//         if (res.status == false) {
//             notificacion(res.mensaje, "error", 6000)
//         }
//     })
//     datos.fail(() => {
//         notificacion("¡ERROR! Hubo un problema de conexión, vuelve a intentar", "error", 5000)
//     })
// }


// function SubmitInformationUser(event) {
//     event.prevenDefault();
// }