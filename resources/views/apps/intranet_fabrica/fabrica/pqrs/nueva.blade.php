<head>
    <title>Generar P.Q.R.S</title>
    <link rel="shortcut icon" href="{{ asset('img/alburac.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('plugins/jqvmap/jqvmap.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }} ">
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('plugins/dropzone/min/dropzone.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('plugins/bs-stepper/css/bs-stepper.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.css') }} ">
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
</head>
<section class="content" style="background-color: #f4f6f9">
    <div class="container-fluid">
        <section class="content" style="width: 60%; margin: 1% 20%">
            <div class="container-fluid">
                <form id="formulario-pqrs" name="formulario-pqrs" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12" style="padding-top: 7.5px">
                            <div class="card card-outline card-danger">
                                <div class="card-header">
                                    <div class="row text-center">
                                        <div class="col-md-6 mb-3" style="border: 1px solid; border-radius: 12px;">
                                            <div class="mt-1">
                                                <img src="{{ asset('img/blanco.png') }}" width="50%"
                                                    alt="Logo Muebles Albura">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3" style="border: 1px solid; border-radius: 12px;">
                                            <h5><strong>PETICIONES, QUEJAS, RECLAMOS<br> Y SUGERENCIAS -
                                                    P.Q.R.S</strong></h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div style="border: 1px solid; border-radius: 7px;">
                                                    <center>
                                                        CÓDIGO:RG-PRD-20
                                                    </center>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div style="border: 1px solid; border-radius: 7px;">
                                                    <center>
                                                        VERSIÓN: 06
                                                    </center>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div style="border: 1px solid; border-radius: 7px;">
                                                    <center>
                                                        PÁGINA: 1
                                                    </center>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-7">
                                            <div class="form-group" style=" margin-left:15%; text-align:justify;">
                                                El deseo de petición, queja, reclamo y sugerencia presentada por el
                                                interesado , será atendido de manera oportuna como compromiso hacia
                                                nuestros clientes por parte de Muebles Albura.
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <center>
                                                <p name="fecha" id="fecha">
                                                    <b>Fecha:</b> 2024-06-17
                                                </p>
                                            </center>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 2%;">
                                        <div class="col-md-12">
                                            <div class="form-group"
                                                style="border: 1px solid; border-radius: 7px; padding:1%;">
                                                <center>
                                                    <strong>
                                                        DATOS PERSONALES
                                                    </strong>
                                                </center>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nombres">Nombres</label>
                                                <input type="text" name="nombres" id="nombres" class="form-control"
                                                    autocomplete="off" placeholder="Nombres" required="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="apellidos">Apellidos</label>
                                                <input type="text" name="apellidos" id="apellidos"
                                                    autocomplete="off" class="form-control" placeholder="Apellidos"
                                                    required="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="cargo">cargo</label>
                                                <input type="text" class="form-control" name="cargo"
                                                    id="cargo" autocomplete="off" placeholder="Cargo"
                                                    required="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" class="form-control" id="email"
                                                    name="email" autocomplete="off" placeholder="Email"
                                                    required="">
                                                <span id="error-message" style="display: none; color: red;">El
                                                    correo electrónico no es válido</span>
                                                <span id="error-empty" style="display: none; color: red;">Debe
                                                    ingresar
                                                    un correo electrónico</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 2%;">
                                        <div class="col-md-12">
                                            <div class="form-group"
                                                style="border: 1px solid; border-radius: 7px; padding:1%;">
                                                <center>
                                                    <strong>
                                                        SOLICITUD
                                                    </strong>
                                                </center>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="tipo">Tipo</label>
                                                <select class="form-control" name="tipo" id="tipo"
                                                    required="">
                                                    <option value="">Seleccionar</option>
                                                    <option value="Peticion">Peticion</option>
                                                    <option value="Queja">Queja</option>
                                                    <option value="Reclamo">Reclamo</option>
                                                    <option value="Sugerencia">Sugerencia</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="lugar">Lugar</label>
                                                <select name="lugar" id="lugar" class="form-control"
                                                    required="">
                                                    <option value="">Seleccionar</option>
                                                    <option value="Bodegas Muebles Albura">Bodegas Muebles Albura
                                                    </option>
                                                    <option value="Ventas Muebles Albura">Ventas Muebles Albura
                                                    </option>
                                                    <option value="Logistica Muebles Albura">Logistica Muebles
                                                        Albura
                                                    </option>
                                                    <option value="Almacenes Muebles Albura">Almacenes Muebles
                                                        Albura
                                                    </option>
                                                    <option value="Fabrica Muebles Albura">Fabrica Muebles Albura
                                                    </option>
                                                    <option value="Logistica Happy Sleep">Logistica Happy Sleep
                                                    </option>
                                                    <option value="Servicio Cliente Happy Sleep">Servicio Cliente
                                                        Happy Sleep</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 2%;">
                                        <div class="col-md-12">
                                            <div class="form-group"
                                                style="border: 1px solid; border-radius: 7px; padding:1%;">
                                                <center>
                                                    <strong>
                                                        DESCRIPCIÓN DE LA SOLICITUD
                                                    </strong>
                                                </center>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <textarea name="descripcion" id="descripcion" style="width: 100%;" autocomplete="off"
                                                    placeholder="Escriba su situación de manera clara y precisa." required=""></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 2%;">
                                        <div class="col-md-12">
                                            <div class="form-group"
                                                style="border: 1px solid; border-radius: 7px; padding:1%;">
                                                <center>
                                                    <strong>
                                                        CARGA DE ANEXOS
                                                    </strong>
                                                </center>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="anexo">Anexos</label>
                                            <input type="file" class="form-control" name="anexos[]"
                                                id="anexo" multiple="" accept=".jpg, .jpeg, .png, .pdf"
                                                onchange="return fileValidation()">
                                            <p><b>Solo se admiten imagenes o archivos PDF</b></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <center>
                                                <button id="crearSolicitudBtn" type="button" class="btn btn-danger" style="margin-top: 2%;"
                                                    onclick="formularioSolicitud()">Enviar solicitud
                                                </button>
                                            </center>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8 col-sm-8">
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            <img src="{{ asset('img/copia_controlada_sgc.png') }}"
                                                alt="Copia Controlada S.G.C" width="90%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
</section>
{{-- @endsection --}}
<script src="{{ asset('plugins/jquery/jquery.min.js') }} "></script>
<script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }} "></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }} "></script>
<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }} "></script>
<script src="{{ asset('plugins/chart.js/Chart.min.js') }} "></script>
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }} "></script>
<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
<script>
    formularioSolicitud = () => {
        toastr.info('Generando y enviando P.Q.R.S')
        $("body").css("cursor", "progress");
        document.getElementById('crearSolicitudBtn').disabled = true;
        let form = new FormData(document.getElementById('formulario-pqrs'));
        var data = $.ajax({
            type: "post",
            url: "{{ Route('pqrs.add.nueva') }}",
            dataType: "html",
            data: form,
            processData: false,
            contentType: false
        })
        data.done((res) => {
            if (JSON.parse(res).status == true) {
                toastr.success('P.Q.R.S generada y enviada con exito')
                $("body").css("cursor", "default");
            }
            document.getElementById('crearSolicitudBtn').disabled = false;
            document.getElementById('formulario-pqrs').reset();
        })
        data.fail((err) => {
            let {
                error
            } = JSON.parse(err.responseText);
            Object.keys(error).forEach(value => {
                let input = document.getElementById(value);
                if (input) {
                    input.removeAttribute("class");
                    input.setAttribute("class", "form-control  is-invalid");
                }
            });
            toastr.error('Hubo un problema al generar la solicitud')
            $("body").css("cursor", "default");
            document.getElementById('crearSolicitudBtn').disabled = false;
        })

    }

    fileValidation = () => {
        let input = $('#anexo')
        let anexo = document.getElementById('anexo');
        let archivo = input[0].files[0];
        if (archivo) {
            var fileType = archivo.type;

            var tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif', 'application/pdf'];
            if ($.inArray(fileType, tiposPermitidos) == -1) {
                anexo.removeAttribute("class");
                anexo.setAttribute("class", "form-control  is-invalid");
                input.val('');
                return;
            }
        }
    }
</script>
