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
                            src="{{ asset('storage/icons/salas.png') }}" alt="" width="30" height="30"> Salas</button>
                </li>
                <li class="nav-item " role="presentation">
                    <button onclick="seccion(this.id,'{{ route('secciones-ideas') }}')" id="botones_comedores" class="nav-link botones" data-toggle="pill"
                        data-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false"><img
                            src="{{ asset('storage/icons/comedores.png') }}" alt="" width="30" height="30"> Comedores</button>
                </li>
                <li class="nav-item " role="presentation">
                    <button onclick="seccion(this.id,'{{ route('secciones-ideas') }}')" id="botones_alcobas" class="nav-link botones" data-toggle="pill"
                        data-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false"><img
                            src="{{ asset('storage/icons/alcobas.png') }}" alt="" width="30" height="30"> Alcobas</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button onclick="seccion(this.id,'{{ route('secciones-ideas') }}')" id="botones_colchones" class="nav-link botones" data-toggle="pill"
                        data-target="#pills-contacts" type="button" role="tab" aria-controls="pills-contact" aria-selected="false"><img
                            src="{{ asset('storage/icons/colchones.png') }}" alt="" width="30" height="30"> Colchones</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button onclick="seccion(this.id,'{{ route('secciones-ideas') }}')" id="botones_accesorios" class="nav-link botones"
                        data-toggle="pill" data-target="#pills-acces" type="button" role="tab" aria-controls="pills-contact"
                        aria-selected="false"><img src="{{ asset('storage/icons/accesorios.png') }}" alt="" width="30" height="30">
                        Accesorios</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button onclick="seccion(this.id,'{{ route('secciones-ideas') }}')" id="botones_otros" class="nav-link botones"
                        data-toggle="pill" data-target="#pills-other" type="button" role="tab" aria-controls="pills-contact"
                        aria-selected="false"><img src="{{ asset('storage/icons/otros.png') }}" alt="" width="30" height="30">
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
                            <input type="text" class="form-control" onkeyup="buscar(this.value, '{{ url('/search') }}')" name="searchIde"
                                id="searchIde" placeholder="Valor" aria-label="Username" aria-describedby="basic-addon1" data-searcher="salas">
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
                        <h5 class="modal-title" id="exampleModalLabel">Agregar una nueva idea</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="" enctype="multipart/form-data" method="POST" id="envioDatos">
                        @csrf
                        <div class="modal-body ">
                            <div class="d-flex justify-content-center" id="padre">
                                <img src="{{ asset('storage/img/ideas.jpg') }}" alt="ilustracion ideas" id="bombillo">
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

                            {{--
                                <input class="form-control mb-2" type="file" name="file" id="file"
                                    accept=".jpg, .png, .pdf, jpeg,">
                                    <span clas="description" id="span-format">Adjuntar enlace a página web:</span>
                                    <input type="url" placeholder="https://ejemplo.com" class="form-control mb-2" id="input_link" name="input_link"> --}}
                        </div>
                        <div class="modal-footer" id="footer-modal">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-danger" onclick="enviarIdea('{{ url('/uploadfiles') }}')" id="send-idea">
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
        <div class="modal-dialog">
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
                        <input name="input-cambio" type="file" class="form-control" id="input-cambio">
                        <input type="url" class="form-control mt-3" id="link" name="link" placeholder="https://ejemplo.com"
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
                        <button type="button" class="btn btn-info mb-2" onclick="enviarComentario('{{ url('enviarComentario') }}')">
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
    <script src="{{ asset('js/ideas.js') }}"></script>
@endsection
