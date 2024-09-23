@extends('apps.crm_almacenes.gcp.plantilla.app')
@section('title')
    Maestra general
@endsection
@section('header')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <style>
        .select2.select2-container .select2-selection {
            border: 1px solid #ccc;
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            border-radius: 3px;
            height: 38px;
            margin-bottom: 15px;
            outline: none !important;
            transition: all .15s ease-in-out;
        }

        .select2.select2-container .select2-selection .select2-selection__arrow {
            background: #f8f8f8;
            border-left: 1px solid #ccc;
            -webkit-border-radius: 0 3px 3px 0;
            -moz-border-radius: 0 3px 3px 0;
            border-radius: 0 3px 3px 0;
            height: 32px;
            width: 33px;
        }

        #spinner-info {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.39);
            z-index: 1;
        }

        #spinner-info-maestra {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.507);
            z-index: 1;
        }
    </style>
@endsection
@section('maestra')
    active
@endsection
@section('contenido')
    <div class="text-white" id="spinner-info-maestra" style="display: none">
        <center>
            <div style="z-index: 2; position: absolute; margin-left: 47%; margin-top: 15%;">
                <div class="spinner-border" role="status"></div>
                <p id="text-spinner">Consultando...</p>
            </div>
        </center>
    </div>

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Maestra general</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item text-blue">CRM</li>
                        <li class="breadcrumb-item active">Maestra general</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <form class="was-validated">
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <select class="form-control" onchange="ActualizarInformacionM(this.value)">
                            <option value="4" {{ $tipo == '4' ? 'selected' : '' }}>TODOS</option>
                            <option value="1" {{ $tipo == '1' ? 'selected' : '' }}>OPORTUNIDAD</option>
                            <option value="2" {{ $tipo == '2' ? 'selected' : '' }}>PROSPECTOS</option>
                            <option value="3" {{ $tipo == '3' ? 'selected' : '' }}>EFECTIVOS</option>
                            <option value="5" {{ $tipo == '5' ? 'selected' : '' }}>PREFERENCIAL</option>
                        </select>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>Información general</strong>
                        </div>
                        <div class="card-body table-responsive">

                            <table class="table table-bordered table-sm" id="clientes-maestra-general">
                                <thead>
                                    <tr class="text-center" style="font-size: 14px; background-color: #c22121; color: white;">
                                        <th>#</th>
                                        <th>Tipo</th>
                                        <th>Cédula</th>
                                        <th>Cliente</th>
                                        <th>Fecha creación</th>
                                        <th>Próxima llamada</th>
                                        <th>Ciudad</th>
                                        <th>Celular</th>
                                        <th>Productos</th>
                                        <th>Comentarios</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody style="font-size: 15px">
                                    @foreach ($clientes as $key => $value)
                                        <?php $nombre_c = trim($value->nombre_1 . ' ' . $value->apellido_1); ?>
                                        <tr>
                                            <td>{{ $value->id_cliente }} <?php echo $value->estado == 2 ? '<span class="badge badge-pill badge-info">Preferencial</span>' : ''; ?></td>
                                            <td style="cursor: pointer">
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <i class="fas fa-star text-gray start1{{ $value->tipo_cliente }} star{{ $value->id_cliente }}" id="cl{{ $value->id_cliente }}1"
                                                        onclick="validarEstella('1', '{{ $value->id_cliente }}')" title="Oportunidad"></i>
                                                    <i class="fas fa-star text-gray start2{{ $value->tipo_cliente }} star{{ $value->id_cliente }}" id="cl{{ $value->id_cliente }}2"
                                                        onclick="validarEstella('2', '{{ $value->id_cliente }}')" title="Prospecto"></i>
                                                    <i class="fas fa-star text-gray start3{{ $value->tipo_cliente }} star{{ $value->id_cliente }}" id="cl{{ $value->id_cliente }}3"
                                                        onclick="validarEstella('3', '{{ $value->id_cliente }}')" title="Efectivo"></i>
                                                </div>
                                            </td>
                                            <td>{{ $value->cedula_cliente }}</td>
                                            <td id="cliente{{ $value->id_cliente }}" data-nombre="{{ $nombre_c }}">{{ $nombre_c }}</td>
                                            <td class="text-center">{{ $value->fecha_registro }}</td>
                                            <td class="text-center" id="llamar{{ $value->id_cliente }}">{{ $value->fecha_a_llamar }}</td>
                                            <td>{{ $value->ciudad }}</td>
                                            <td>{{ $value->celular_1 }}</td>
                                            <td class="text-center">
                                                <div class="nav-item dropdown">
                                                    <a class="nav-link text-danger" data-toggle="dropdown" href="#">
                                                        <i class="fas fa-shopping-cart"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-xl dropdown-menu-right">
                                                        <span class="dropdown-item dropdown-header">Productos</span>
                                                        <div id="products{{ $value->id_cliente }}">
                                                            <div class="dropdown-divider"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <a class="btn btn-app bg-danger" style="min-width: 30px; height: 45px;" onclick="MostrarComentariosCliente('{{ $value->id_cliente }}')">
                                                    <span class="badge bg-teal">{{ $value->coment }}</span>
                                                    <i class="fas fa-comments"></i>
                                                </a>
                                            <td class="text-center" id="opcionesCliente{{ $value->id_cliente }}">
                                                @if ($value->tipo_cliente != '0')
                                                    <div class="btn-group" role="group" aria-label="Basic example">
                                                        <button type="button" class="btn btn-sm btn-info" title="Ver información cliente" onclick="ObtenerInformacionCliente('{{ $value->id_cliente }}')"><i
                                                                class="fas fa-eye" style="font-size: 15px"></i></button>
                                                        <button type="button" class="btn btn-sm btn-primary" title="Programar una llamada" onclick="AgendarLlamadaCliente('{{ $value->id_cliente }}')"><i
                                                                class="fas fa-phone-alt" style="font-size: 15px"></i></button>
                                                        <a href="{{ url('asesor/maestra/WhatsApp/' . $value->celular_1) }}" target="_BLANK" type="button" class="btn btn-sm btn-success" title="Enviar mensaje al WhatsApp"><i
                                                                class="fab fa-whatsapp" style="font-size: 15px"></i></a>
                                                    </div>
                                                    <div class="btn-group" role="group" aria-label="Basic example">
                                                        @if ($value->tipo_cliente == '3')
                                                            <button type="button" class="btn btn-sm btn-warning" id="ventaEfectiva{{ $value->id_cliente }}"
                                                                onclick="MarcarVentaEfectivaCliente('{{ $value->id_cliente }}', '{{ $value->cedula_cliente }}')" title="Marcar venta efectiva"><i
                                                                    class="far fa-money-bill-alt" style="font-size: 15px"></i></button>
                                                        @else
                                                            <button type="button" class="btn btn-sm btn-warning" id="ventaEfectivaCl{{ $value->id_cliente }}"
                                                                onclick="VentaEfectivaClienteCrm('{{ $value->id_cliente }}', '{{ $value->cedula_cliente }}')" title="Marcar venta efectiva"><i
                                                                    class="far fa-money-bill-alt" style="font-size: 15px"></i></button>
                                                        @endif
                                                        <a href="{{ url('asesor/maestra/encuesta/' . $value->celular_1 . '/' . $nombre_c) }}" target="_BLANK" type="button" class="btn btn-sm btn-secondary"
                                                            title="Enviar encuesta de satisfacción"><i class="fas fa-paper-plane" style="font-size: 15px"></i></a>
                                                        <button type="button" class="btn btn-sm btn-danger" onclick="NotificarEliminacionClienteCrm('{{ $value->id_cliente }}')" title="Eliminar contacto"><i
                                                                class="fas fa-trash-alt" style="font-size: 15px"></i></button>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    {{-- Modal visualizacion de comentarios realizados al cliente --}}

    <div class="modal fade" id="historial-seguimiento-asesor">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #c22121; color: white;">
                    <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="{{ asset('imagenes/profile.png') }}" alt="user image">
                        <span class="username">
                            <h5><span id="nombre-cliente-almacen"></span></h5>
                        </span>
                        <span class="description text-white">Comentarios realizados</span>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="direct-chat-messages" id="comentarios-realizados-cliente-almacen">
                    </div>
                    <hr>
                    <div class="">
                        <div class="direct-chat-msg">
                            <div class="direct-chat-infos clearfix">
                                <span class="direct-chat-name float-left">{{ Auth::user()->nombre }}</span>
                                <span class="direct-chat-timestamp float-right">{{ date('d-m-Y') }}</span>
                            </div>
                            <img class="direct-chat-img" src="{{ asset('imagenes/profile.png') }}" alt="message user image">
                            <div class="direct-chat-text">
                                <input type="text" name="id_validar_cliente_alm" id="id_validar_cliente_alm" style="display: none;">
                                <textarea name="new-coment-user-alm" id="new-coment-user-alm" cols="30" rows="3" class="form-control" placeholder="Nuevo comentario"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer left-content-between">
                    <button type="button" class="btn btn-success" onclick="AgregarComentariosSeguimientosCliente();">Agregar nuevo comentario</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar información</button>
                </div>
            </div>
        </div>
    </div>


    {{-- Modal visualización de información personal del cliente --}}

    <div class="modal fade" id="informacion-personal-del-cliente">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #c22121; color: white;">
                    <h5 class="modal-title">Información personal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formulario-informacion-clientes-crm" method="post" class="was-validated">
                        @csrf
                        <div class="form-group" id="Informacion-General-Clientes-Crm">
                        </div>
                        <input type="text" hidden name="id_cliente_crm" id="id_cliente_crm">
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-warning" onclick="CrearTerceroSiesa()">Crear Tercero en SIESA</button>
                    <button type="button" class="btn btn-success" onclick="ActualizarInformacionCliente('formulario-informacion-clientes-crm')">Actualizar información</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar información</button>
                </div>
            </div>
        </div>
    </div>

    {{--  Modal programar llamadas usuario --}}

    <div class="modal fade" id="agendar-proxima-llamada-cliente">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #c22121; color: white;">
                    <h5 class="modal-title">Programar llamada</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="was-validated" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="">Fecha a llamar</label>
                            <input type="date" class="form-control" name="fecha_a_llamar_cliente" id="fecha_a_llamar_cliente">
                            <input type="number" hidden name="id_cliente_crm_llam" id="id_cliente_crm_llam">
                        </div>
                    </form>
                </div>
                <div class="modal-footer left-content-between">
                    <button type="button" class="btn btn-success" onclick="progrmarFechaLlamadaCliente();">Agendar nueva llamada</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar información</button>
                </div>
            </div>
        </div>
    </div>


    {{-- Modal para marcar la venta efectiva de clientes punto de ventas --}}

    <div class="modal fade" id="modal-marcar-venta-efectiva-cliente">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #c22121; color: white;">
                    <h5>Productos adquiridos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="informacion-productos-cotizados-cliente"></div>
                    <div style="margin-left: 35%; margin-right: 35%;">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon3"><strong>Valor pagado</strong></span>
                            </div>
                            <input type="text" class="form-control" id="valor_total_pagar_user_p" aria-describedby="basic-addon3" disabled>
                        </div>
                    </div>
                </div>
                <div class="modal-footer left-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar información</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal para marcar la venta efectiva de clientes punto de ventas SIESA --}}

    <div class="modal fade" id="ModalVentaEfectivaErp">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #c22121; color: white;">
                    <h5>Marcar como venta efectiva</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-white" id="spinner-antes" style="display: none">
                        <center>
                            <div style="z-index: 2; position: absolute; margin-left: 45%; margin-top: 7%;">
                                <div class="spinner-border" role="status"></div>
                                <p id="text-spinner"></p>
                            </div>
                        </center>
                    </div>
                    <form class="was-validated" method="post" id="formInfoEfectivoC">
                        @csrf
                        <input type="text" name="id_user_crm" id="id_user_crm" hidden class="was-validated">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">FVE</span>
                                    </div>
                                    <input type="number" class="form-control" name="fve_efect" id="fve_efect" placeholder="N°" onchange="ValidarInfoClienteEfectivo()" aria-label="Username"
                                        aria-describedby="basic-addon1">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">CO</span>
                                    </div>
                                    <input type="number" class="form-control" name="co_efect" id="co_efect" placeholder="N°" onchange="ValidarInfoClienteEfectivo()" aria-label="Username"
                                        aria-describedby="basic-addon1">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="co_efect_soli" id="co_efect_soli" placeholder="CO" aria-label="Username" aria-describedby="basic-addon1" disabled>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="num_cedula_efect" id="num_cedula_efect" placeholder="Cédula" aria-label="Username" aria-describedby="basic-addon1" disabled>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="nombre1_efect" id="nombre1_efect" placeholder="Primer Nombre" aria-label="Username" aria-describedby="basic-addon1" disabled>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="nombre2_efect" id="nombre2_efect" placeholder="Segundo Nombre" aria-label="Username" aria-describedby="basic-addon1" disabled>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="apellido1_efect" id="apellido1_efect" placeholder="Primer Apellido" aria-label="Username" aria-describedby="basic-addon1" disabled>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="apellido2_efect" id="apellido2_efect" placeholder="Segundo Apellido" aria-label="Username" aria-describedby="basic-addon1" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Producto</th>
                                                        <th>Cant</th>
                                                        <th>Valor</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="productos-efect_v" style="font-size: 13px">
                                                </tbody>
                                            </table>
                                        </div>
                                        <div style="margin-left: 20%; margin-right: 20%;">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon4"><strong>Valor a pagar</strong></span>
                                                </div>
                                                <input type="text" class="form-control" id="valor_efect_total" aria-describedby="basic-addon3" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <select name="cierre_venta" id="cierre_venta" class="form-control" required>
                                                <option value="" selected disabled>Cierre</option>
                                                <option value="Crexit">Crexit</option>
                                                <option value="Addi">Addi</option>
                                                <option value="Brilla">Brilla</option>
                                                <option value="OnCredit">OnCredit</option>
                                                <option value="Contra entrega">Contra entrega</option>
                                                <option value="Link de pago">Link de pago</option>
                                                <option value="Punto de venta">Punto de venta</option>
                                                <option value="Leads">Leads</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <select name="forma_pago_c" id="forma_pago_c" class="form-control" required>
                                                <option value="" selected disabled>Forma de pago</option>
                                                <option value="CONTADO">CONTADO</option>
                                                <option value="CREDITO">CRÉDITO</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <center>
                                    <button type="button" class="btn btn-success" onclick="MarcarVentaEfectivaUsuario()">Marcar como efectivo</button>
                                </center>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer left-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar información</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}" defer></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}" defer></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}" defer></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}" defer></script>
    <script src="{{ asset('js/maestra.js') }}" defer></script>
    <script type="text/javascript" defer>
        $(document).ready(function() {
            for (let index = 1; index < 2; index++) {
                $('.start' + index + '1').removeClass('text-gray');
                $('.start' + index + '1').addClass('text-danger');
            }
            for (let index = 1; index < 3; index++) {
                $('.start' + index + '2').removeClass('text-gray');
                $('.start' + index + '2').addClass('text-danger');
            }
            for (let index = 1; index < 4; index++) {
                $('.start' + index + '3').removeClass('text-gray');
                $('.start' + index + '3').addClass('text-danger');
            }

            cargarProductosCotizados();
        });


        ActualizarInformacionM = (id) => {
            Swal.fire({
                position: 'top-end',
                icon: 'info',
                title: 'Buscando información...',
                showConfirmButton: false,
                timer: 5000
            })
            if (id == 4) {
                location.href = "{{ url('asesor/maestra/clientes') }}";
            } else {
                location.href = "{{ url('asesor/maestra/clientes') }}/" + id;
            }
        }

        VentaEfectivaClienteCrm = (id_cliente) => {
            $('#id_user_crm').val(id_cliente)
            $('#ModalVentaEfectivaErp').modal('show')
        }

        functionSpinner = (id1, id2, style, text) => {
            $('#text-spinner').text(text)
            var spinner = document.getElementById(id1)
            spinner.setAttribute('id', id2)
            document.getElementById(id2).style.display = style;
        }

        ValidarInfoClienteEfectivo = () => {
            var co = $('#co_efect').val()
            var fve = $('#fve_efect').val()

            if (co.length > 0 && fve.length > 0) {
                functionSpinner('spinner-antes', 'spinner-info', 'block', 'Consultando...')
                setTimeout(() => {
                    var datos = $.ajax({
                        url: "{{ Route('ventas.efectivas') }}",
                        type: "POST",
                        dataType: "json",
                        data: {
                            fve,
                            co
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    datos.done((res) => {
                        functionSpinner('spinner-info', 'spinner-antes', 'none', '')
                        if (res.status == true) {
                            var m_pago = res.cliente[0].forma_pago;
                            if (m_pago.trim() == 'CO') {
                                var pago = 'CONTADO'
                            } else {
                                var pago = 'CREDITO'
                            }
                            $('#co_efect_soli').val(res.co)
                            $('#num_cedula_efect').val(res.cliente[0].cedula)
                            $('#nombre1_efect').val(res.cliente[0].nombre)
                            $('#nombre2_efect').val('')
                            $('#apellido1_efect').val(res.cliente[0].ap1)
                            $('#apellido2_efect').val(res.cliente[0].ap2)
                            $('#forma_pago_c').val(pago)
                            $('#valor_efect_total').val("$ " + new Intl.NumberFormat().format(res.cliente[0].valor_ttal))
                            $('#productos-efect_v').html(res.productos)
                        } else {
                            toastr.error('No hay información para esta factura')
                            $('#co_efect_soli').val('')
                            $('#num_cedula_efect').val('')
                            $('#nombre1_efect').val('')
                            $('#nombre2_efect').val('')
                            $('#apellido1_efect').val('')
                            $('#apellido2_efect').val('')
                            $('#forma_pago_c').val('')
                            $('#valor_efect_total').val('')
                            $('#productos-efect_v').html('')
                        }
                    });
                    datos.fail(() => {
                        toastr.error('Hubo un problema al procesar la solicitud')
                        functionSpinner('spinner-info', 'spinner-antes', 'none', '')
                    });
                }, 1000);
            }
        }
        MarcarVentaEfectivaUsuario = () => {
            functionSpinner('spinner-antes', 'spinner-info', 'block', 'Guardando...')
            var co = $('#co_efect_soli').val()
            var formData = new FormData(document.getElementById('formInfoEfectivoC'));
            formData.append('co', co)
            var datos = $.ajax({
                url: "{{ Route('marcar.efectivo') }}",
                type: "POST",
                dataType: "json",
                data: formData,
                cache: false,
                contentType: false,
                processData: false
            });
            datos.done((res) => {
                functionSpinner('spinner-info', 'spinner-antes', 'none', '')
                if (res.status == true) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'La información se actualizó correctamente',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
            datos.fail(() => {
                functionSpinner('spinner-info', 'spinner-antes', 'none', '')
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Hubo un problema al procesar la solicitud',
                    showConfirmButton: false,
                    timer: 1500
                });
            });
        }

        CrearTerceroSiesa = () => {
            var id = $('#id_cliente_crm').val()

            Swal.fire({
                position: 'top-end',
                icon: 'info',
                title: 'Creando información en SIESA...',
                showConfirmButton: false,
                timer: 10000
            })

            var datos = $.ajax({
                url: "{{ Route('crear.siesa') }}",
                type: "POST",
                dataType: "json",
                data: {
                    id
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            datos.done((res) => {
                if (res.status == true) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'El tercero se creó exitosamente en SIESA',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            })
            datos.fail(() => {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Completa todos los campos obligatorios y vuelve a intentar',
                    showConfirmButton: false,
                    timer: 2500
                });
            })
        }

        cargarProductosCotizados = () => {
            var datos = $.ajax({
                url: "{{ Route('productos.cotizados') }}",
                type: "POST",
                dataType: "json",
                data: {
                    validar: '1'
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            datos.done((res) => {
                if (res.status == true) {
                    res.productos.map(function(valor){
                        $('#products'+valor.id_cliente).html(valor.productos)
                        console.log(valor)
                    });
                }
            })
        }
    </script>
@endsection
