@extends('apps.intranet.plantilla.app')
@section('title')
    Fábrica
@endsection
@section('fabrica')
    bg-danger active
@endsection
@section('head')
    <link rel="stylesheet" href="{{ asset('css/Fabrica_Ideas.css') }}">
@endsection
@section('body')
    <!-- Then put toasts within -->
    <div class="d-flex justify-content-end">
        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" id="toast">
            <div class="toast-header" style="background-color: red;color: white;">
                <img src="{{ asset('img/advertencia.png') }}" class="rounded mr-2" alt="Advertencia!" width="30" height="30">
                <strong class="mr-auto">Error!</strong>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body" id="toast_notification">
            </div>
        </div>
    </div>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Prototípos</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item text-blue">Prototípos</li>
                        <li class="breadcrumb-item active">Fábrica</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-1">
            <button id="button-create" type="button" title="Añadir Idea" class="btn btn-warning mb-2 mr-4 text-white " data-toggle="modal"
                data-target="#exampleModal">
                <i class="fas fa-plus mr-1 text-white"> </i><i class="fas fa-lightbulb text-white"> </i>
                Añadir
            </button>
        </div>

        {{-- iconos y botones de tabs --}}

        <div class="d-flex justify-content-center col-sm-11">
            <ul class="nav nav-pills mb-3 d-flex justify-content-center mt-3 shadow" id="pills-tab" role="tablist">

                <li class="nav-item" role="presentation" id="container_data" data-section="salas">
                    <button onclick="seccion(this.id,'{{ route('secciones-ideas') }}')" id="botones_salas" class="nav-link active" data-toggle="pill"
                        data-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true"><img
                            src="{{ asset('icons/salas.png') }}" alt="" width="30" height="30"> Salas</button>
                </li>
                <li class="nav-item " role="presentation">
                    <button onclick="seccion(this.id,'{{ route('secciones-ideas') }}')" id="botones_comedores" class="nav-link botones" data-toggle="pill"
                        data-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false"><img
                            src="{{ asset('icons/comedores.png') }}" alt="" width="30" height="30"> Comedores</button>
                </li>
                <li class="nav-item " role="presentation">
                    <button onclick="seccion(this.id,'{{ route('secciones-ideas') }}')" id="botones_alcobas" class="nav-link botones" data-toggle="pill"
                        data-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false"><img
                            src="{{ asset('icons/alcobas.png') }}" alt="" width="30" height="30"> Alcobas</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button onclick="seccion(this.id,'{{ route('secciones-ideas') }}')" id="botones_colchones" class="nav-link botones" data-toggle="pill"
                        data-target="#pills-contacts" type="button" role="tab" aria-controls="pills-contact" aria-selected="false"><img
                            src="{{ asset('icons/colchones.png') }}" alt="" width="30" height="30"> Colchones</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button onclick="seccion(this.id,'{{ route('secciones-ideas') }}')" id="botones_accesorios" class="nav-link botones"
                        data-toggle="pill" data-target="#pills-acces" type="button" role="tab" aria-controls="pills-contact"
                        aria-selected="false"><img src="{{ asset('icons/accesorios.png') }}" alt="" width="30" height="30">
                        Accesorios</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button onclick="seccion(this.id,'{{ route('secciones-ideas') }}')" id="botones_otros" class="nav-link botones"
                        data-toggle="pill" data-target="#pills-other" type="button" role="tab" aria-controls="pills-contact"
                        aria-selected="false"><img src="{{ asset('icons/otros.png') }}" alt="" width="30" height="30">
                        Otros</button>
                </li>
            </ul>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-outline card-secondary">
                <div class="card-header ">
                    <h3 class="card-title">Prototípos</h3>
                    <div class="card-tools">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend ">
                                <span class="input-group-text" id="basic-addon1">Buscar</span>
                            </div>
                            <input type="text" class="form-control" onkeyup="buscar(this.value, '{{ route('search.prototipo') }}')"
                                name="searchIde" id="searchIde" placeholder="Valor" aria-label="Username" aria-describedby="basic-addon1"
                                data-searcher="salas">
                        </div>
                    </div>
                </div>

                {{-- contenido de tabs --}}

                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active d-flex justify-content-center" id="pills-home" role="tabpanel"
                        aria-labelledby="pills-home-tab">
                        <div id="container1">
                            <div class="row mt-2" id="secciones_salas">
                                @php
                                    echo $form;
                                @endphp
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade d-flex justify-content-center" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <div id="container1">
                            <div class="row mt-2" id="secciones_comedores">
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade d-flex justify-content-center" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                        <div id="container1">
                            <div class="row mt-2" id="secciones_alcobas">
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade d-flex justify-content-center" id="pills-contacts" role="tabpanel" aria-labelledby="pills-contact-tab">
                        <div id="container1">
                            <div class="row mt-2" id="secciones_colchones">
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade d-flex justify-content-center" id="pills-acces" role="tabpanel" aria-labelledby="pills-contact-tab">
                        <div id="container1">
                            <div class="row mt-2" id="secciones_accesorios">
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade d-flex justify-content-center" id="pills-other" role="tabpanel" aria-labelledby="pills-contact-tab">
                        <div id="container1">
                            <div class="row mt-2" id="secciones_otros">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar un nuevo prototípo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="" enctype="multipart/form-data" autocomplete="off" method="POST" id="envioDatos">
                        @csrf
                        <div class="modal-body ">
                            <div class="d-flex justify-content-center" id="padre">
                                <img src="{{ asset('img/ideas.jpg') }}" alt="ilustracion ideas" id="bombillo">
                            </div>
                            <div id="exito"></div>
                            <div class="row">
                                <div class="col-sm">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="inputGroupSelect01">Categoria</label>
                                        </div>
                                        <select class="custom-select" id="inputGroupSelect01">
                                            <option selected value="seccion">Categoria</option>
                                            <option value="salas">Salas</option>
                                            <option value="comedores">Comedores</option>
                                            <option value="alcobas">Alcobas</option>
                                            <option value="colchones">Colchones</option>
                                            <option value="accesorios">Accesorios</option>
                                            <option value="otros">Otros</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm">
                                    <input type="name" class="form-control mb-2" placeholder="Nombre de tu idea" id="nombre_idea"
                                        name="nombre_idea">
                                </div>
                            </div>
                            <div class="mb-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="1"
                                        onclick="addNode(this.id)">
                                    <label class="form-check-label" for="inlineRadio1">PDF/Imagén</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="2"
                                        onclick="addNode(this.id)">
                                    <label class="form-check-label" for="inlineRadio2">Link</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="3"
                                        onclick="addNode(this.id)">
                                    <label class="form-check-label" for="inlineRadio3">Ambos</label>
                                </div>
                            </div>
                            <div id="container_input2">
                                <div id="container_input"></div>
                            </div>
                        </div>
                        <div class="modal-footer" id="footer-modal">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-danger" onclick="enviarIdea('{{ route('upload.prototipos') }}')" id="send-idea">
                                <i class="fas fa-paper-plane mr-1"></i>
                                Guardar Idea</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>


    <!-- Button trigger modal -->


    <!-- Modal -->
    <div class="modal fade" id="modal_cambios" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" id="modal_cambio">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-pencil-alt"></i> Editar idea: </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-center m-2">
                        <div id="container-text" class=" d-flex justify-content-center shadow">
                            <h5 id="hola"></h5>
                        </div>
                    </div>

                    <label for="inputGroupSelect02" style="color: #6C757D">Selecciona la Categoría: </label>
                    <input type="text" value="" id="puente_ids">
                    <select class="custom-select" id="inputGroupSelect02">
                        <option selected>Categoría</option>
                        <option value="salas">Salas</option>
                        <option value="comedores">Comedores</option>
                        <option value="alcobas">Alcobas</option>
                        <option value="colchones">Colchones</option>
                        <option value="accesorios">Accesorios</option>
                        <option value="otros">Otros</option>
                    </select>
                    <form action="post" enctype="multipart/form-data" class="mt-3" id="formu">
                        @csrf
                        <label for=""><small>Imágen o PDF</small></label>
                        <input name="input-cambio" type="file" class="form-control" id="input-cambio">
                        <label class="mt-4"><small> Url de la imagen (Solo si aplica)</small></label>
                        <input type="url" class="form-control" id="link" name="link" placeholder="https://ejemplo.com"
                            autocomplete="off">
                    </form>
                    <div class="mt-2 d-flex justify-content-center">
                        <div class="notification" id="notification_modal"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button onclick="changeIdea('{{ route('cambio-seccion') }}')" type="button" class="btn btn-danger"><i
                            class="fas fa-paper-plane mr-1"></i> Guardar</button>
                </div>
            </div>
        </div>
    </div>

    {{-- ASIDE --}}
    <aside class="control-sidebar control-sidebar-light" id="container-aside" style="margin-top:20px !important">
        <div class="card card-outline card-danger" style="height: calc(0rem + 1px);">
            <div class="card-header">
                <div class="card-title">
                    <i class="fas fa-cogs" style="font-size: 35px; color: rgb(255, 167, 67)"></i>
                    <span style="font-size: 22px">Seguimiento</span>
                </div>
                <div class="card-tools">
                    <button class="btn btn-light" data-widget="control-sidebar"><i class="fas fa-times fa-lg" style="color:brown"></i></button>
                </div>
            </div>
            <div class="card-body">
                <input type="text" hidden class="form-control" id="id_img_idea">
                <form class="was-validated">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <label for="">Observaciones</label>
                            <textarea name="newCommentUser" id="newCommentUser" class="form-control" required cols="30" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="col d-flex justify-content-center">
                        <button type="button" class="btn btn-info mb-2" onclick="enviarComentario('{{ route('send.comment.prototipo') }}')">
                            <i class="fas fa-comments" id="add-comment"></i> Agregar comentario
                        </button>
                    </div>
                </form>
                <div id="dataCommentsIdeas">
                </div>
            </div>
        </div>
    </aside>
@endsection
@section('footer')
    <script>
        $(document).ready(function() {
            seccion("botones_salas", "{{ route('secciones-ideas') }}");
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


                    label1.setAttribute('for', 'file');
                    label1.setAttribute('class', claseLabel);
                    label1.textContent = 'PDF/Imagén:';
                    label1.style.color = '#6C757D';

                    label2.setAttribute('for', 'input_link');
                    label2.setAttribute('class', claseLabel);
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
            }).done(function(res) {
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
            Swal.fire({
                title: "Estás seguro(a)?",
                text: "No podrás reversar esta acción!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, eliminarlo!",
                cancelButtonText: "No, cancelar!"
            }).then((result) => {
                if (result.isConfirmed) {
                    var datos = confirmDeleteIdea(id, url, section);
                    datos.done((res) => {
                        document.getElementById("secciones_" + section).innerHTML = res.idea;
                        Swal.fire({
                            title: "Eliminado!",
                            text: "Prototípo eliminado",
                            icon: "success"
                        });
                    })

                    datos.fail(() => {
                        Swal.fire({
                            title: "Error!",
                            text: "Hubo un problema al procesar la solicitud",
                            icon: "error"
                        });
                    })
                }
            });
        }

        confirmDeleteIdea = (id, url, section) => {
            var datos = $.ajax({
                url: url,
                type: "POST",
                dataType: "json",
                data: {
                    id_borrar_idea: id,
                    seccion: section,
                },
            })
            return datos;
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
                .done(function(texto) {
                    document.getElementById("dataCommentsIdeas").innerHTML =
                        texto.comment;
                })
                .fail(function(error) {});
        }

        function enviarComentario(url) {
            let id_idea = document.getElementById("id_img_idea").value;
            let comentario = document.getElementById("newCommentUser").value;
            let section = document.getElementById("container_data").dataset.section;
            if (comentario.length > 0) {
                $.ajax({
                        url: url,
                        type: "POST",
                        dataType: "json",
                        data: {
                            texto: comentario,
                            id_ideas: id_idea,
                            seccion: section,
                        },
                        beforeSend: function() {
                            $("#newCommentUser").val("");
                        },
                    })
                    .done(function(res) {
                        document.getElementById("dataCommentsIdeas").innerHTML = res.comment;
                        document.getElementById("secciones_" + section).innerHTML = res.viewCount;
                    })
                    .fail(function(err) {});
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
                .done(function(res) {
                    document.getElementById("dataCommentsIdeas").innerHTML =
                        res.borrar_comentario;
                    document.getElementById("secciones_" + section).innerHTML =
                        res.borrado;
                })
                .fail(function(err) {});
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
                    .done(function(res) {
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
                            document.getElementById("exito").setAttribute('class', 'card bg-success');
                            document.getElementById(
                                "secciones_" + sendSection
                            ).innerHTML = res.respuesta;

                            setTimeout(() => {
                                document.getElementById("exito").style.opacity = 0;
                            }, "3000");
                        }
                    })
                    .fail(function(err) {
                        document.getElementById("exito").style.opacity = 1;
                        $("#exito").css({
                            height: "44px",
                            display: "flex",
                            "justify-content": "center",
                            "font-weight": "bold",
                            "text-align": "center",
                        });
                        document.getElementById("exito").setAttribute('class', 'card bg-danger');
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
                .done(function(res) {
                    if (res) {
                        document.getElementById("secciones_" + section).innerHTML =
                            res.respuesta;
                    }
                })
                .fail(function(err) {});
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
                .done(function(res) {
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
                .fail(function(err) {
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
            }).done(function(res) {
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
            $.ajax({
                url: url,
                type: "POST",
                dataType: "json",
                data: {
                    seccion: section,
                    id_idea: id_idea,
                },
            }).done(function(res) {
                if (res) {
                    document.getElementById("secciones_" + section).innerHTML =
                        res.cambio;
                }
            });
        }
    </script>
@endsection
