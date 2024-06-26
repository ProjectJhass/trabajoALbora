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
    </style>
@endsection
@section('maestra')
    active
@endsection
@section('contenido')
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
            <div class="row mb-3 justify-content-center">
                <div class="col-md-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Almacen</div>
                        </div>
                        <select class="form-control" name="almacen_co" id="almacen_co" onchange="ConsultarAsesoresCo(this.value)">
                            <option value="">Seleccionar...</option>
                            @foreach ($sucursales as $item)
                                <option value="{{ $item->co }}">{{ str_replace('Muebles Albura SAS ', '', $item->nombre_sucursal) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Asesor</div>
                        </div>
                        <select class="form-control" name="asesor_co" id="asesor_co"
                            onchange="ConsultarInformacionAsesor(this.value, this.options[this.selectedIndex].dataset.nombre)">
                            <option value="" data-nombre="">Seleccionar...</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Tipo</div>
                        </div>
                        <select class="form-control" onchange="BuscarInformacionTipo()" name="tipo_cliente_asesor" id="tipo_cliente_asesor">
                            <option value="0">TODOS</option>
                            <option value="1">OPORTUNIDAD</option>
                            <option value="2">PROSPECTOS</option>
                            <option value="3">EFECTIVOS</option>
                            <option value="5">PREFERENCIAL</option>
                            <option value="6">PRE-APROBADO</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>Información general</strong>
                        </div>
                        <div class="card-body table-responsive" id="infoGeneralAsesorMaestra">

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="delete-clients" onclick="EliminarClienteAsesor('formDeleteClientsMaestra')" class="btn btn-danger back-to-top" role="button"
            aria-label="Delete Clients Maestra">
            <i class="fas fa-trash-alt"></i>
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
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Cédula</label>
                                        <input type="number" class="form-control" name="cedula_cliente" id="cedula_cliente" placeholder="Cédula"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Primer nombre</label>
                                        <input type="text" class="form-control" name="primer_nombre" id="primer_nombre"
                                            onkeyup="this.value = this.value.toUpperCase();" placeholder="Primer nombre" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Segundo nombre</label>
                                        <input type="text" class="form-control" name="segundo_nombre" id="segundo_nombre"
                                            onkeyup="this.value = this.value.toUpperCase();" placeholder="Segundo nombre">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Primer apellido</label>
                                        <input type="text" class="form-control" name="primer_apellido" id="primer_apellido"
                                            onkeyup="this.value = this.value.toUpperCase();" placeholder="Primer apellido" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Segundo apellido</label>
                                        <input type="text" class="form-control" name="segundo_apellido" id="segundo_apellido"
                                            onkeyup="this.value = this.value.toUpperCase();" placeholder="Segundo apellido">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Genero</label>
                                        <select class="form-control" name="genero" id="genero">
                                            <option value="">Seleccionar...</option>
                                            <option value="HOMBRE">HOMBRE</option>
                                            <option value="MUJER">MUJER</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Celular 1</label>
                                        <input type="number" class="form-control" name="celular_1" id="celular_1" placeholder="Número de celular"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Celular 2</label>
                                        <input type="number" class="form-control" name="celular_2" id="celular_2" placeholder="Número de celular">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Email</label>
                                        <input type="email" class="form-control" name="email" id="email"
                                            onkeyup="this.value = this.value.toLowerCase();" placeholder="Correo electrónico" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Cumpleaños</label>
                                        <input type="date" class="form-control" name="cumple" id="cumple">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Departamento</label>
                                        <select class="form-control" onchange="obtenerCiudadesCrm(this.value)" name="depto_crm" id="depto_crm"
                                            required>
                                            <option value="">Seleccionar...</option>
                                            @foreach ($deptos as $item)
                                                <option value="{{ $item->id_depto }}">{{ $item->depto }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Ciudad</label>
                                        <select class="form-control" name="ciudad" id="ciudad" required>
                                            <option value="">Seleccionar...</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Barrio</label>
                                        <input type="text" class="form-control" name="barrio" id="barrio"
                                            onkeyup="this.value = this.value.toUpperCase();" placeholder="Barrio">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Dirección</label>
                                        <input type="text" class="form-control" name="direccion" id="direccion"
                                            onkeyup="this.value = this.value.toUpperCase();" placeholder="Dirección" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Origen</label>
                                        <select class="form-control" name="origen" id="origen">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($origen as $item)
                                                <option value="{{ $item->origen }}">{{ $item->origen }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Lista de precios</label>
                                        <select class="form-control" name="lista_precio" id="lista_precio" required>
                                            <option value="">Seleccionar...</option>
                                            <option value="101">LISTA CONTADO COMERCIALIZADORA</option>
                                            <option value="102">2 CUOTAS</option>
                                            <option value="103">3 CUOTAS</option>
                                            <option value="104">4 CUOTAS</option>
                                            <option value="105">5 CUOTAS</option>
                                            <option value="106">6 CUOTAS</option>
                                            <option value="107">7 CUOTAS</option>
                                            <option value="108">8 CUOTAS</option>
                                            <option value="109">9 CUOTAS</option>
                                            <option value="110">10 CUOTAS</option>
                                            <option value="111">11 CUOTAS</option>
                                            <option value="112">12 CUOTAS</option>
                                            <option value="113">13 CUOTAS</option>
                                            <option value="114">14 CUOTAS</option>
                                            <option value="115">15 CUOTAS</option>
                                            <option value="116">16 CUOTAS</option>
                                            <option value="117">17 CUOTAS</option>
                                            <option value="118">18 CUOTAS</option>
                                            <option value="119">19 CUOTAS</option>
                                            <option value="120">20 CUOTAS</option>
                                            <option value="121">21 CUOTAS</option>
                                            <option value="122">22 CUOTAS</option>
                                            <option value="123">23 CUOTAS</option>
                                            <option value="124">24 CUOTAS</option>
                                            <option value="125">25 CUOTAS</option>
                                            <option value="126">26 CUOTAS</option>
                                            <option value="127">27 CUOTAS</option>
                                            <option value="128">28 CUOTAS</option>
                                            <option value="129">29 CUOTAS</option>
                                            <option value="130">30 CUOTAS</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Tipo de cliente</label>
                                        <select class="form-control" name="tipo_cliente_siesa" id="tipo_cliente_siesa" required>
                                            <option value="">Seleccionar...</option>
                                            <option value="0010">AGUAS DE MANIZALES</option>
                                            <option value="0011">CONVENIO BRILLA</option>
                                            <option value="0013">CLIENTES NACIONALES CONTADO</option>
                                            <option value="0014">CLIENTES NACIONALES CREDITO</option>
                                            <option value="0015">CONVENIO ADDI</option>
                                            <option value="0017">CONVENIO GASES DE OCCIDENTE</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="text" hidden name="id_cliente_crm" id="id_cliente_crm">
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" id="btn-crm-create-siesa" class="btn btn-warning" onclick="CrearTerceroSiesa()">Crear Tercero en
                        SIESA</button>
                    <button type="button" id="btn-crm-update-info" class="btn btn-success"
                        onclick="ActualizarInformacionCliente('formulario-informacion-clientes-crm')">Actualizar información</button>
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
                    <button type="button" class="close" data-dismiss="modal" onclick="LimpiarCamposModal()" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="text-dark" id="spinner-antes" style="display: none;">
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
                                    <input type="number" class="form-control" name="fve_efect" id="fve_efect" placeholder="N°"
                                        onchange="ValidarInfoClienteEfectivo()" aria-label="Username" aria-describedby="basic-addon1">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">CO</span>
                                    </div>
                                    <input type="number" class="form-control" name="co_efect" id="co_efect" placeholder="N°"
                                        onchange="ValidarInfoClienteEfectivo()" aria-label="Username" aria-describedby="basic-addon1">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="co_efect_soli" id="co_efect_soli" placeholder="CO"
                                        aria-label="Username" aria-describedby="basic-addon1" disabled>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="num_cedula_efect" id="num_cedula_efect" placeholder="Cédula"
                                        aria-label="Username" aria-describedby="basic-addon1" disabled>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="nombre1_efect" id="nombre1_efect" placeholder="Primer Nombre"
                                        aria-label="Username" aria-describedby="basic-addon1" disabled>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="nombre2_efect" id="nombre2_efect" placeholder="Segundo Nombre"
                                        aria-label="Username" aria-describedby="basic-addon1" disabled>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="apellido1_efect" id="apellido1_efect"
                                        placeholder="Primer Apellido" aria-label="Username" aria-describedby="basic-addon1" disabled>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="apellido2_efect" id="apellido2_efect"
                                        placeholder="Segundo Apellido" aria-label="Username" aria-describedby="basic-addon1" disabled>
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
                                                <input type="text" class="form-control" id="valor_efect_total" aria-describedby="basic-addon3"
                                                    disabled>
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
                                                <option value="Addi">Addi</option>
                                                <option value="Brilla">Brilla</option>
                                                <option value="OnCredit">OnCredit</option>
                                                <option value="Contra entrega">Contra entrega</option>
                                                <option value="Link de pago">Link de pago</option>
                                                <option value="Punto de venta">Punto de venta</option>
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
                                    <button type="button" id="btn-change-efectivo" class="btn btn-success"
                                        onclick="MarcarVentaEfectivaUsuario()">Marcar como efectivo</button>
                                </center>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer left-content-between">
                    <button type="button" class="btn btn-danger" onclick="LimpiarCamposModal()" data-dismiss="modal">Cerrar información</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        tableFormmater = () => {
            $('#clientes-maestra-general-admin').DataTable({
                "oLanguage": {
                    "sSearch": "Buscar:",
                    "sInfo": "Mostrando de _START_ a _END_ de _TOTAL_ registros",
                    "oPaginate": {
                        "sPrevious": "Volver",
                        "sNext": "Siguiente"
                    },
                    "sEmptyTable": "No se encontró ningun registro en la base de datos",
                    "sZeroRecords": "No se encontraron resultados...",
                    "sLengthMenu": "Mostrar _MENU_ registros"
                },
                "order": [
                    [6, "desc"]
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "responsive": true,
            });
        }

        $(document).ready(function() {
            $('.select2').select2();
        });

        BuscarInformacionTipo = () => {
            var asesor = $("#asesor_co").val()
            ConsultarInformacionAsesor(asesor, "ALBURA")
        }
    </script>
@endsection
