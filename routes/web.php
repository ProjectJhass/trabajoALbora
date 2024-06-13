<?php

use App\Http\Controllers\apps\automoviles\ControllerAdminInfo;
use App\Http\Controllers\apps\automoviles\ControllerAutomoviles;
use App\Http\Controllers\apps\automoviles\ControllerComparativo;
use App\Http\Controllers\apps\automoviles\ControllerComparativoGeneral;
use App\Http\Controllers\apps\automoviles\ControllerPolizas;
use App\Http\Controllers\apps\automoviles\ControllerProveedores;
use App\Http\Controllers\apps\control_madera\ControllerCrearNuevasSeries;
use App\Http\Controllers\apps\control_madera\ControllerFabricaMadera;
use App\Http\Controllers\apps\control_madera\ControllerHistorialImpresora;
use App\Http\Controllers\apps\control_madera\ControllerHistorialSiesa;
use App\Http\Controllers\apps\control_madera\ControllerInfoGeneralCortes;
use App\Http\Controllers\apps\control_madera\ControllerMaderaDisponible;
use App\Http\Controllers\apps\control_madera\ControllerPlannerMadera;
use App\Http\Controllers\apps\control_madera\ControllerPlannerTabla;
use App\Http\Controllers\apps\control_madera\ControllerPlannerWood;
use App\Http\Controllers\apps\control_madera\ControllerPrinterQr;
use App\Http\Controllers\apps\control_madera\ControllerProcedimientosSiesa;
use App\Http\Controllers\apps\control_madera\ControllerSavePlanificacionCorte;
use App\Http\Controllers\apps\control_madera\ControllerSearchMadera;
use App\Http\Controllers\apps\control_madera\movil\ControllerTokenAcceso;
use App\Http\Controllers\apps\cotizador\ControllerCatalogo;
use App\Http\Controllers\apps\cotizador\ControllerFinalizar;
use App\Http\Controllers\apps\cotizador\ControllerGenerarCredito;
use App\Http\Controllers\apps\cotizador\ControllerLiquidador;
use App\Http\Controllers\apps\cotizador\ControllerPanel;
use App\Http\Controllers\apps\cotizador\ControllerPdfCotizacion;
use App\Http\Controllers\apps\cotizador\ControllerPdfFogade;
use App\Http\Controllers\apps\cotizador\ControllerRetomarCotizacion;
use App\Http\Controllers\apps\cotizador\ControllerValidarProductos;
use App\Http\Controllers\apps\cotizador\session\session;
use App\Http\Controllers\apps\crm_almacenes\ControllerClientesEfectivos;
use App\Http\Controllers\apps\crm_almacenes\ControllerCrearTerceroSiesa;
use App\Http\Controllers\apps\crm_almacenes\ControllerCumpleClientes;
use App\Http\Controllers\apps\crm_almacenes\ControllerEstadisticasAdmin;
use App\Http\Controllers\apps\crm_almacenes\ControllerInformeDeVentas;
use App\Http\Controllers\apps\crm_almacenes\ControllerInicioCrm;
use App\Http\Controllers\apps\crm_almacenes\ControllerLiquidadorDescuentos;
use App\Http\Controllers\apps\crm_almacenes\ControllerLlamadasPendientes;
use App\Http\Controllers\apps\crm_almacenes\ControllerMaestraAdmin;
use App\Http\Controllers\apps\crm_almacenes\ControllerMaestraAsesor;
use App\Http\Controllers\apps\crm_almacenes\ControllerNuevoRegistroCliente;
use App\Http\Controllers\apps\crm_almacenes\ControllerValidarInfo;
use App\Http\Controllers\apps\crm_almacenes\ControllerVentasEfectivas;
use App\Http\Controllers\apps\crm_almacenes\liquidador\ControllerLiquidadorIntereses;
use App\Http\Controllers\apps\intranet\Bitacora\ControllerAdmin;
use App\Http\Controllers\apps\intranet\Bitacora\ControllerAsignado;
use App\Http\Controllers\apps\intranet\Bitacora\ControllerBitacoraUsuario;
use App\Http\Controllers\apps\intranet\Bitacora\ControllerProyectos;
use App\Http\Controllers\apps\intranet\ControllerCalendar;
use App\Http\Controllers\apps\intranet\ControllerCargarCartera;
use App\Http\Controllers\apps\intranet\ControllerCargueDigitalizacion;
use App\Http\Controllers\apps\intranet\ControllerDocumentacionIntranet;
use App\Http\Controllers\apps\intranet\ControllerDominicales;
use App\Http\Controllers\apps\intranet\ControllerEvaluacionDepartamentos;
use App\Http\Controllers\apps\intranet\ControllerFirmasDescansos;
use App\Http\Controllers\apps\intranet\ControllerFlayer;
use App\Http\Controllers\apps\intranet\ControllerHome;
use App\Http\Controllers\apps\intranet\ControllerIdeas;
use App\Http\Controllers\apps\intranet\ControllerInfoReloj;
use App\Http\Controllers\apps\intranet\ControllerIngresosSalidas;
use App\Http\Controllers\apps\intranet\ControllerLogistica;
use App\Http\Controllers\apps\intranet\ControllerPdfDiaDescanso;
use App\Http\Controllers\apps\intranet\ControllerRecursosHumanos;
use App\Http\Controllers\apps\intranet\ControllerRegisterFlayer;
use App\Http\Controllers\apps\intranet\ControllerRegistrarIngresos;
use App\Http\Controllers\apps\intranet\ControllerRegistrarNovedades;
use App\Http\Controllers\apps\intranet\ControllerReglamentoInterno;
use App\Http\Controllers\apps\intranet\ControllerSesiones;
use App\Http\Controllers\apps\intranet\ControllerTemporal;
use App\Http\Controllers\apps\intranet\ControllerUsuarios;
use App\Http\Controllers\apps\intranet\EnviarNotificacion;
use App\Http\Controllers\apps\intranet_fabrica\CambiosEnSeries;
use App\Http\Controllers\apps\intranet_fabrica\ControllerCarrucel;
use App\Http\Controllers\apps\intranet_fabrica\ControllerCerrarSolicitudMtto;
use App\Http\Controllers\apps\intranet_fabrica\ControllerDocsSgc;
use App\Http\Controllers\apps\intranet_fabrica\ControllerEncuestaSatisfaccion;
use App\Http\Controllers\apps\intranet_fabrica\ControllerHojasDeVida;
use App\Http\Controllers\apps\intranet_fabrica\ControllerInicioFabrica;
use App\Http\Controllers\apps\intranet_fabrica\ControllerMantenimiento;
use App\Http\Controllers\apps\intranet_fabrica\ControllerMaquinasFab;
use App\Http\Controllers\apps\intranet_fabrica\ControllerSolicitudesMtto;
use App\Http\Controllers\apps\intranet_fabrica\ControllerUsuarios as Intranet_fabricaControllerUsuarios;
use App\Http\Controllers\apps\intranet_fabrica\ControllerUsuariosEncuesta;
use App\Http\Controllers\apps\intranet_fabrica\DocumentacionTecnica;
use App\Http\Controllers\apps\servicios_tecnicos\analytics\ControllerAnalytics;
use App\Http\Controllers\apps\servicios_tecnicos\pagina_web\ControllerWeb;
use App\Http\Controllers\apps\servicios_tecnicos\servicios\admin\ControllerInformes;
use App\Http\Controllers\apps\servicios_tecnicos\servicios\admin\ControllerMaestros;
use App\Http\Controllers\apps\servicios_tecnicos\servicios\ControllerAdmin as ServiciosControllerAdmin;
use App\Http\Controllers\apps\servicios_tecnicos\servicios\ControllerCreateServicio;
use App\Http\Controllers\apps\servicios_tecnicos\servicios\ControllerFormatosPdf;
use App\Http\Controllers\apps\servicios_tecnicos\servicios\ControllerGestionTaller;
use App\Http\Controllers\apps\servicios_tecnicos\servicios\ControllerInfoAlmacenes;
use App\Http\Controllers\apps\servicios_tecnicos\servicios\ControllerInfoDespachos;
use App\Http\Controllers\apps\servicios_tecnicos\servicios\ControllerNoGarantiaCliente;
use App\Http\Controllers\apps\servicios_tecnicos\servicios\ControllerNuevaSolicitud;
use App\Http\Controllers\apps\servicios_tecnicos\servicios\ControllerSearchSt;
use App\Http\Controllers\apps\servicios_tecnicos\servicios\ControllerSeguimientoSt;
use App\Http\Controllers\apps\servicios_tecnicos\servicios\fabrica\ControllerSeguimientoFab;
use App\Http\Controllers\apps\servicios_tecnicos\servicios\plantilla\ControllerAlmacenes;
use App\Http\Controllers\apps\servicios_tecnicos\servicios\pw\ControllerAdminInfoPw;
use App\Http\Controllers\apps\servicios_tecnicos\ws\ControllerConexionWs;
use App\Http\Controllers\PruebaOP;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::get('/', function () {
    return redirect(route("login"));
    #return redirect("https://mueblesalbura.com.co");
});

/* Route::get('/makehash/{pwd}', function ($pwd) {
    return Hash::make($pwd);
}); */

Route::post('/login/ingreso', [ControllerRegistrarIngresos::class, 'RegistrarIngreso'])->name("registrar.ingreso.asesor");

Route::group(['prefix' => 'intranet', 'middleware' => 'auth', 'middleware' => 'checkSesion'], function () {

    //Seccion de prototipos fábrica
    Route::post('/search', [ControllerIdeas::class, 'searchIdea'])->name('search.prototipo');
    Route::post('/uploadfiles', [ControllerIdeas::class, 'uploadFiles'])->name('upload.prototipos');
    Route::post('/deletecomment', [ControllerIdeas::class, 'deletecomment'])->name('delete.comment.prototipo');
    Route::post('/deleteidea', [ControllerIdeas::class, 'deleteIdea'])->name('delete.prototipo');
    Route::post('/enviarComentario', [ControllerIdeas::class, 'enviarComentario'])->name('send.comment.prototipo');
    Route::post('/ideasid', [ControllerIdeas::class, 'mostrarComentarios'])->name('comentarios.prototipos');
    Route::post('/secciones-ideas', [ControllerIdeas::class, 'ideasRender'])->name("secciones-ideas");
    Route::post('/cambio-seccion', [ControllerIdeas::class, 'changeSection'])->name("cambio-seccion");
    Route::post('/delete-img', [ControllerIdeas::class, 'deleteImg'])->name("delete-img");
    Route::post('/delete-link', [ControllerIdeas::class, 'deleteLink'])->name("delete-link");
    ////////////////////////////////////////////////////////////////////

    Route::post('/general/sesiones', [ControllerSesiones::class, 'index']);
    Route::post('general/notificaciones', [EnviarNotificacion::class, 'index'])->name('intranet.docs.general.not');

    //Calendario individual Asesores
    Route::group(['prefix' => 'calendario'], function () {
        Route::get('general', [ControllerCalendar::class, 'index'])->name('calendar');
        Route::get('general/pdf/{id}', [ControllerPdfDiaDescanso::class, 'generarPdfCertificado'])->name("generar.pdf.firma");
        Route::post('search-evento', [ControllerCalendar::class, 'searchEvento'])->name('datos.descansodom');
        Route::post('guardar-foto', [ControllerCalendar::class, 'saveInfoFotoDescanso'])->name('guardar.foto');
        Route::post('guardar-info-firma', [ControllerCalendar::class, 'saveFormFirmaDescanso'])->name('guardar.info.firma');

        //Historial firmas generadas y firmadas
        Route::get('historial-firmas-descansos', [ControllerCalendar::class, 'showHistorial'])->name("h.firmas.asesor");
        Route::post('historial-firmas-asesor', [ControllerCalendar::class, 'getInfoHistorialAsesor'])->name("firmas.asesor.fechas");
    });

    // evaluaciones Regionales
    Route::get('/paginas-para-evaluacion', [ControllerEvaluacionDepartamentos::class, 'formularioEvaluacion'])->name('paginas.evaluacion');
    Route::post('/paginas-para-evaluacion', [ControllerEvaluacionDepartamentos::class, 'validarFormulario'])->name('formulario.enviar');
    Route::get('/historail-evaluaciones', [ControllerEvaluacionDepartamentos::class, 'historialEvaluaciones'])->name('paginas.historialEvaluacion');
    Route::post('/historail-evaluaciones', [ControllerEvaluacionDepartamentos::class, 'buscarHistorail'])->name('ver.historialEvaluacion');
    Route::post('/historail-en-años', [ControllerEvaluacionDepartamentos::class, 'buscarHistorialAnos'])->name('ver.historialEvaluacion.años');
    Route::get('/historail-evaluaciones/obtener-datos/', [ControllerEvaluacionDepartamentos::class, 'obtenerDatos'])->name('obtener.datos');
    Route::get('/historail-evaluaciones/centros-evaluados', [ControllerEvaluacionDepartamentos::class, 'obetnerCentrosEvaluados'])->name('obtener.centros');
    Route::post('/historail-evaluaciones/centros-coordinadores', [ControllerEvaluacionDepartamentos::class, 'centrosCoordinadores'])->name('centros.coordinaodres');
    Route::post('/historail-personas-evaluadas', [ControllerEvaluacionDepartamentos::class, 'historialPersonalEvaluado'])->name('historial.Personal.evaluado');
    Route::post('/obtener-coordinadores', [ControllerEvaluacionDepartamentos::class, 'obtenerCoordinadores'])->name('obtener.coordinadores');
    Route::post('/obtener-centro-coordinador', [ControllerEvaluacionDepartamentos::class, 'obtenerCentroCoordinadores'])->name('obtener.centro.coordinadores');
    Route::post('/actualizar-centro-coordinador', [ControllerEvaluacionDepartamentos::class, 'actualizarCentroCoordinadores'])->name('actualizar.centro.coordinadores');
    Route::post('/formulario-asignacion', [ControllerEvaluacionDepartamentos::class, 'formularioAsignacionCentroOperacion'])->name('formulario.asignacion.centro.operacion');
    Route::post('/asignacion-centro-operacion', [ControllerEvaluacionDepartamentos::class, 'asignacionCentroOperacion'])->name('asignacion.centro.operacion');


    //Route::group(['middleware' => 'AsesorAccess', 'prefix' => 'asesor'], function () {
    Route::group(['prefix' => 'tmp'], function () {
        Route::get('/docs/{dpto}', [ControllerTemporal::class, 'index'])->name('intranet.docs.tmp');
        Route::post('/docs/{dpto}', [ControllerTemporal::class, 'CargarDocumentosTmp']);
    });


    //Documentos generales memorandos áreas
    Route::get('/{seccion}/docs/{memo}', [ControllerDocumentacionIntranet::class, 'documentos'])->name('intranet.memorandos.areas');
    Route::post('{seccion}/docs/{memo}', [ControllerDocumentacionIntranet::class, 'cargar_documentos']);
    Route::post('{seccion}/docs/{memo}/eliminar', [ControllerDocumentacionIntranet::class, 'eliminar_documentos']);


    //'middleware'=>'intranet'
    Route::group(['prefix' => 'home'], function () {
        Route::get('/general', [ControllerHome::class, 'index'])->name('home');
        Route::get('/editar', [ControllerHome::class, 'editar'])->name('home.edit');
        Route::post('/editar/cargar', [ControllerHome::class, 'cargar']);
        Route::post('/editar/eliminar', [ControllerHome::class, 'eliminar']);
        Route::post('/editar/actualizar', [ControllerHome::class, 'actualizar']);
    });

    Route::group(['prefix' => 'logistica'], function () {
        Route::get('/general', [ControllerLogistica::class, 'index'])->name('logistica');
        Route::get('/menu-memos-vigentes', function () {
            return view('apps.intranet.logistica.menu_memos');
        })->name('menu.memos.log');
    });

    Route::group(['prefix' => 'cartera'], function () {
        Route::get('/general', [ControllerCargarCartera::class, 'index'])->name('cartera');
        Route::get('/paginas-para-referenciar', function () {
            return view('apps.intranet.cartera.referenciar');
        })->name('paginas.referenciar');

        Route::group(['prefix' => 'info'], function () {
            Route::get("", [ControllerCargueDigitalizacion::class, 'index'])->name("info.dig.excel");
            Route::post("", [ControllerCargueDigitalizacion::class, 'getInfoExcel'])->name("search.dig.excel");
            Route::post("/cargar-info", [ControllerCargueDigitalizacion::class, 'uploadInfo'])->name("upload.dig.excel");
        });
    });


    Route::group(['prefix' => 'ingresos-y-salidas'], function () {
        Route::get('/estadisticas', [ControllerIngresosSalidas::class, 'index'])->name('estadisticas');
        Route::post('/estadisticas', [ControllerIngresosSalidas::class, 'actualizarEstadisticas'])->name('search.estadisticas');
        Route::get('/ingresos-diarios', [ControllerIngresosSalidas::class, 'ingresos'])->name('i.diarios');
        Route::post('/ingresos-diarios', [ControllerIngresosSalidas::class, 'searchInfoIngresos'])->name('search.diarios');
        Route::get('/llegadas-tarde', [ControllerIngresosSalidas::class, 'tarde'])->name('l.tarde');
        Route::post('/llegadas-tarde', [ControllerIngresosSalidas::class, 'searchLlegadasTarde'])->name('search.tarde');
        Route::get('/inasistencias', [ControllerIngresosSalidas::class, 'inasistencias'])->name('inasistencias');
        Route::post('/inasistencias', [ControllerIngresosSalidas::class, 'searchInfoInasistencias'])->name('search.inasistencias');
        Route::get('/novedades', [ControllerIngresosSalidas::class, 'novedades'])->name('novedades');
        Route::post('/novedades', [ControllerIngresosSalidas::class, 'getInfoNovedades'])->name('search.novedades');

        Route::group(['prefix' => 'registrar-novedad'], function () {
            Route::get('', [ControllerIngresosSalidas::class, 'registrarNovedad'])->name('r.novedad');
            Route::post('', [ControllerRegistrarNovedades::class, 'index']);
            Route::post('consultar', [ControllerRegistrarNovedades::class, 'consultar']);
        });

        Route::group(['prefix' => 'dominicales-descansos'], function () {
            Route::get('', [ControllerIngresosSalidas::class, 'dominicales'])->name('dominicales');
            Route::post('', [ControllerDominicales::class, 'sesionZonas']);
            Route::post('bloquear-eventos', [ControllerDominicales::class, 'bloquearEventos']);
            Route::post('nuevo-evento', [ControllerDominicales::class, 'agregarNuevoEvento']);
            Route::post('actualizar-fecha-evento', [ControllerDominicales::class, 'actualizarFechaEvento']);
            Route::post('actualizar-evento', [ControllerDominicales::class, 'actualizarEvento']);
            Route::post('eliminar-evento', [ControllerDominicales::class, 'eliminarEvento']);
        });

        Route::get('/exportar-info', [ControllerIngresosSalidas::class, 'exportar'])->name('exportar');
        Route::post('/exportar-info', [ControllerIngresosSalidas::class, 'descargarExcel']);
    });


    Route::group(['prefix' => 'ventas'], function () {
        Route::get('/general', function () {
            return view('apps.intranet.ventas.home');
        })->name('ventas');
    });

    Route::group(['prefix' => 'rrhh'], function () {

        Route::get('/general', [ControllerRecursosHumanos::class, 'index'])->name('rrhh');
        Route::get('/reloj-fabrica', [ControllerInfoReloj::class, 'index'])->name('reloj.rrhh');

        Route::group(['prefix' => 'reglamento-interno-de-trabajo'], function () {
            Route::get('', [ControllerRecursosHumanos::class, 'Reglamento'])->name('reglamento.interno');
            Route::post('', [ControllerReglamentoInterno::class, 'index']);
            Route::post('foto/{cedula}/{nombre}/{empresa}', [ControllerReglamentoInterno::class, 'guardarFoto']);
        });

        Route::get('/sst', function () {
            return view('apps.intranet.rrhh.menu_sst');
        })->name('sst');

        Route::group(['prefix' => 'flayer'], function () {
            Route::get('', [ControllerFlayer::class, 'home'])->name('flayer');
            Route::post('', [ControllerFlayer::class, 'updateImgFlayer']);
            Route::post('search', [ControllerFlayer::class, 'searchInfoFlayer']);
            Route::post('visualizar-flayer', [ControllerRegisterFlayer::class, 'validateImgFlayer'])->name('validate.flayer');
            Route::post('register-info-flayer', [ControllerRegisterFlayer::class, 'saveInfoViewFlayer'])->name('register.flayer');
            Route::get('download-excel/{month}', [ControllerRegisterFlayer::class, 'ExportInfoFlayer']);
        });

        Route::group(['prefix' => 'firmas-descansos'], function () {
            Route::get('', [ControllerFirmasDescansos::class, 'index'])->name('firmas.descansos');
            Route::post('', [ControllerFirmasDescansos::class, 'searchInfoDescansos'])->name('search.firmas.descansos');
            Route::get('/detalles/{id}', [ControllerFirmasDescansos::class, 'detalleDelaFirma'])->name('detalles.firmas');
            Route::get('/export/{fecha_i}/{fecha_f}', [ControllerFirmasDescansos::class, 'export'])->name('export.detalles.firmas');
        });
    });

    Route::group(['prefix' => 'auditoria'], function () {
        Route::get('/general', function () {
            return view('apps.intranet.auditoria.home');
        })->name('auditoria');
        Route::get('/docs/{memo}', [ControllerDocumentacionIntranet::class, 'documentos']);
        Route::post('/docs/{memo}', [ControllerDocumentacionIntranet::class, 'cargar_documentos']);
        Route::post('/docs/{memo}/eliminar', [ControllerDocumentacionIntranet::class, 'eliminar_documentos']);
    });

    Route::group(['prefix' => 'contabilidad'], function () {
        Route::get('/general', function () {
            return view('apps.intranet.contabilidad.home');
        })->name('contabilidad');
        Route::get('/docs/{memo}', [ControllerDocumentacionIntranet::class, 'documentos']);
        Route::post('/docs/{memo}', [ControllerDocumentacionIntranet::class, 'cargar_documentos']);
        Route::post('/docs/{memo}/eliminar', [ControllerDocumentacionIntranet::class, 'eliminar_documentos']);
    });

    Route::group(['prefix' => 'sistemas'], function () {
        Route::get('/general', function () {
            return view('apps.intranet.sistemas.home');
        })->name('sistemas');
        Route::get('/docs/{memo}', [ControllerDocumentacionIntranet::class, 'documentos']);
        Route::post('/docs/{memo}', [ControllerDocumentacionIntranet::class, 'cargar_documentos']);
        Route::post('/docs/{memo}/eliminar', [ControllerDocumentacionIntranet::class, 'eliminar_documentos']);
    });

    Route::group(['prefix' => 'fabrica'], function () {
        Route::get('/general', function () {
            return view('apps.intranet.fabrica.home');
        })->name('fabrica');

        Route::get('/memorandos-fabrica', function () {
            return view('apps.intranet.fabrica.menu_memos');
        })->name('memos.fabrica');

        Route::get('/docs/{memo}', [ControllerDocumentacionIntranet::class, 'documentos']);
        Route::post('/docs/{memo}', [ControllerDocumentacionIntranet::class, 'cargar_documentos']);
        Route::post('/docs/{memo}/eliminar', [ControllerDocumentacionIntranet::class, 'eliminar_documentos']);


        Route::get('ideas-fab', [controllerIdeas::class, 'getInfoIdeas'])->name('info.ideas');
    });

    Route::group(['prefix' => 'usuarios'], function () {
        Route::get('/general', [ControllerUsuarios::class, 'index'])->name('usuarios');
        Route::post('/general', [ControllerUsuarios::class, 'getInfoUsuarioIntranet'])->name('get.info.usuarios');

        Route::group(['prefix' => 'admin'], function () {
            Route::get('/crear-info/{cedula?}/{nombre?}', [ControllerUsuarios::class, 'createUserIntranet'])->name('crear.info.usuario');
            Route::post('/crear-info', [ControllerUsuarios::class, 'updateInfoUsuarioIntranet'])->name('update.info.usuario');
            Route::post('/crear-info-user', [ControllerUsuarios::class, 'createInfoGeneralUser'])->name('create.info.user');
            Route::post('/validar-info-user', [ControllerUsuarios::class, 'findUserName'])->name('validar.info.user');
        });
    });

    Route::group(['prefix' => 'bitacora'], function () {

        Route::group(['prefix' => '/usuario'], function () {
            Route::get('/inicio/{estado}', [ControllerBitacoraUsuario::class, 'index'])->name('dev.bitacora');
            Route::get('/detalles/{idSolicitud}', [ControllerBitacoraUsuario::class, 'detalles'])->name('dev.details.bitacora');
            Route::get('/crear', [ControllerBitacoraUsuario::class, 'crear'])->name('bitacora.crear');
            Route::post('/crear', [ControllerProyectos::class, 'crearNuevoProyecto']);
        });

        Route::group(['prefix' => '/admin'], function () {
            Route::get('/general', [ControllerAdmin::class, 'index'])->name('dev.admin.listar');
            Route::post('/general', [ControllerAdmin::class, 'getInfoSolicitudes'])->name('search.admin.solicitudes');
            Route::get('/detalles/{idSolicitud}', [ControllerAdmin::class, 'ObtenerInformacion'])->name('dev.admin.ver');
            Route::post('/detalles/{idSolicitud}/{accion}', [ControllerAdmin::class, 'agregarPuntosP']);
        });

        Route::group(['prefix' => '/asignado'], function () {
            Route::get('/general/{estado}', [ControllerAsignado::class, 'index'])->name('dev.asignado.listar');
            Route::get('/detalles/{idSolicitud}', [ControllerAsignado::class, 'ObtenerInformacion'])->name('dev.asig.detalle');
            Route::post('/detalles/{idSolicitud}/{accion}', [ControllerAsignado::class, 'agregarPuntosP']);
        });
    });
});

Route::group(['prefix' => 'automoviles', 'middleware' => 'auth'], function () {

    Route::get('/automoviles', [ControllerAutomoviles::class, 'index'])->name('albura.autos');
    Route::post('/automoviles', [ControllerAutomoviles::class, 'ActualizarImagenAutomovil']);
    Route::get('/informacion-general/{id_auto}/{placa}/{row_id}', [ControllerAutomoviles::class, 'InformacionAuto'])->name('informacion.autos');
    Route::post('/informacion-general/{id_auto}/{placa}/{row_id}', [ControllerAutomoviles::class, 'ConsultarFechas']);


    Route::get('/proveedores', [ControllerProveedores::class, 'index'])->name('proveedores.albura');


    Route::get('/comparativo', [ControllerComparativo::class, 'index'])->name('comparativo.albura');
    Route::post('/comparativo', [ControllerComparativoGeneral::class, 'index']);
    Route::post('/buscar-informacion-auto', [ControllerComparativo::class, 'informacionAutos'])->name('search.info.auto');

    Route::group(['prefix' => 'polizas'], function () {
        Route::get('', [ControllerPolizas::class, 'index'])->name('polizas');
        Route::post('', [ControllerPolizas::class, 'actualizar']);
        Route::post('historial', [ControllerPolizas::class, 'historial'])->name('polizas.historial');
        Route::post('actualiar-poliza', [ControllerPolizas::class, 'cargarDocumentacion']);
    });

    Route::group(['prefix' => 'admin'], function () {
        Route::get('', [ControllerAdminInfo::class, 'index'])->name('admin.info.autos');
        Route::post('import-excel', [ControllerAdminInfo::class, 'importar'])->name('import.excel');
    });
});

Route::group(['prefix' => 'catalogo', 'middleware' => 'auth'], function () {
});

Route::group(['prefix' => 'control_de_piso', 'middleware' => 'auth'], function () {
});

Route::group(['prefix' => 'control_de_madera', 'middleware' => 'auth', 'middleware' => 'checkPermisosMadera'], function () {

    Route::get('', [ControllerFabricaMadera::class, 'home'])->name('madera.home');
    //Route::get('pruebaOP', [PruebaOP::class, 'index']);
    Route::get('pruebaOP', [PruebaOP::class, 'consultaOPS']);

    Route::group(['prefix' => 'printer'], function () {
        Route::get('', [ControllerPrinterQr::class, 'index'])->name('printer');
        Route::post('', [ControllerPrinterQr::class, 'generateQRCode'])->name('print.info.qr');
        Route::post('/search_printed', [ControllerPrinterQr::class, 'printedHistory'])->name('search.printed');
        Route::post('/reprinter-info', [ControllerPrinterQr::class, 'infoRePrinterCodigoQr'])->name('info.reprinted');

        Route::group(['prefix' => 'history'], function () {
            Route::get('', [ControllerHistorialImpresora::class, 'index'])->name('history.printer');
            Route::get('/print_doc/{id}', [ControllerHistorialImpresora::class, 'renderPrinter'])->name('print.history.info');
            Route::post('/search_history', [ControllerHistorialImpresora::class, 'searchInfoHistory'])->name('search.history.printer');
            Route::post('/edit-history', [ControllerHistorialImpresora::class, 'editInfoHistory'])->name('edit.history.printed');
            Route::post('/edit-info-history', [ControllerHistorialImpresora::class, 'editHistoryPrinted'])->name('edit.info.printed');
        });

        Route::group(['prefix' => 'config'], function () {
            Route::get('', [ControllerPrinterQr::class, 'config'])->name('config.printer');
            Route::post('', [ControllerPrinterQr::class, 'saveConfig'])->name('save.config.printer');
            Route::post('/search', [ControllerPrinterQr::class, 'search_info'])->name('search.config.printer');
        });
    });

    Route::group(['prefix' => 'planner'], function () {
        Route::get('', [ControllerPlannerMadera::class, 'planner'])->name('new.planner.day');
        Route::post('search-madera', [ControllerPlannerMadera::class, 'searchMadera'])->name('planner.search.madera');
        Route::post('search-mueble', [ControllerPlannerMadera::class, 'searchMueble'])->name('planner.search.mueble');
        Route::post('create-planificacion', [ControllerPlannerMadera::class, 'createPlanificacionSerie'])->name('create.planner.info');
        Route::post('create-planner-corte', [ControllerSavePlanificacionCorte::class, 'savePlanificacion'])->name('planner.corte.piezas');
        Route::post('search-troncos', [ControllerSearchMadera::class, 'search'])->name('search.info.troncos');
        Route::post('change-tronco', [ControllerSearchMadera::class, 'changeEstadoTroco'])->name('change.info.troncos');

        //Planear Corte de tablas
        Route::post('planner-corte-tabla', [ControllerPlannerTabla::class, 'saveInfoCorteTabla'])->name('save.planner.tabla');
        Route::get('info-corte-tabla/{id}', [ControllerPlannerTabla::class, 'formInfoCorteTabla'])->name('get.planner.tabla');
        Route::post('info-corte-tabla/{id}', [ControllerPlannerTabla::class, 'saveInfoCorteTablas'])->name('save.tabla.cortada');
        //Actualizar corte de tablas
        Route::post('searchInfo-bloque-tabla', [ControllerPlannerTabla::class, 'troncosUtilizarTablas'])->name('search.bloque.tabla');
        Route::post('delete-bloque-tabla', [ControllerPlannerTabla::class, 'actualizarBloquesUtilizados'])->name('delete.bloque.tabla');

        Route::group(['prefix' => 'admin'], function () {
            Route::post('/search-troncos-utilizados', [ControllerInfoGeneralCortes::class, 'getinfoTroncosUtilizados'])->name('get.info.troncos.utili');
            Route::get('/cortes-pendientes', [ControllerInfoGeneralCortes::class, 'index'])->name('cortes.madera.planner');
            Route::get('/piezas-planificadas/{id_corte}', [ControllerInfoGeneralCortes::class, 'piezasPlanificadas'])->name('info.piezas.c.planner');
            Route::get('/cortes-completados', [ControllerInfoGeneralCortes::class, 'cortesTerminados'])->name('cortes.madera.completado');
            Route::get('/cortes-completados/{id_corte}', [ControllerInfoGeneralCortes::class, 'piezasTerminadas'])->name('info.piezas.c.terminado');
            Route::post('/cortes-completados', [ControllerInfoGeneralCortes::class, 'filtrarCortesTerminados'])->name('search.madera.completado');
            Route::get('/madera-disponible', [ControllerMaderaDisponible::class, 'index'])->name('madera.disponible.cortes');
            Route::post('/madera-disponible', [ControllerMaderaDisponible::class, 'updateEstadoMadera'])->name('update.madera.estado');

            //Corte de tabla terminado
            Route::get('/cortes-tabla-completado/{id_corte}', [ControllerPlannerTabla::class, 'getInfoTablasTerminadas'])->name('info.table.completado');

            Route::group(['prefix' => 'crear-series'], function () {
                Route::get('/', [ControllerCrearNuevasSeries::class, 'getView'])->name('create.series');
                Route::post('/', [ControllerCrearNuevasSeries::class, 'getInfoPiezasMadera'])->name('get.info.p.series');
                Route::post('/update', [ControllerCrearNuevasSeries::class, 'updateInfoPiezasSelected'])->name('update.info.p.series');
                Route::post('/create-pieza', [ControllerCrearNuevasSeries::class, 'agregarInfoNuevaPieza'])->name('create.info.p.series');
                Route::get('/crear', [ControllerCrearNuevasSeries::class, 'crearNuevaSerie'])->name('crear.serie.piezas');
                Route::post('/crear', [ControllerCrearNuevasSeries::class, 'crearInfoNuevaSerie'])->name('crear.info.serie.piezas');
                //Eliminar Serie/Mueble
                Route::post('/delete-series', [ControllerCrearNuevasSeries::class, 'deleteSerie'])->name('delete.serie.edit');
                Route::post('/delete-mueble', [ControllerCrearNuevasSeries::class, 'deleteMueble'])->name('delete.mueble.edit');
            });

            Route::group(['prefix' => 'config'], function () {
                Route::get('/', [ControllerTokenAcceso::class, 'index'])->name('token.acceso.movil');
                Route::post('/url', [ControllerTokenAcceso::class, 'urlConnection'])->name('url.acceso.movil');
                Route::post('/create-movil', [ControllerTokenAcceso::class, 'RegistrarDispositivo'])->name('crear.acceso.movil');
                Route::post('/editar-movil', [ControllerTokenAcceso::class, 'EditarDispositivo'])->name('editar.acceso.movil');
                Route::post('/eliminar-movil', [ControllerTokenAcceso::class, 'EliminarDipositivo'])->name('eliminar.acceso.movil');
            });
        });
    });

    Route::group(['prefix' => 'siesa'], function () {
        Route::get('', [ControllerProcedimientosSiesa::class, 'index'])->name('index.op.siesa');
        Route::get('codigos-siesa', [ControllerProcedimientosSiesa::class, 'getInfocodigos'])->name('c.codigos.siesa');
        Route::post('crear-codigos-siesa', [ControllerProcedimientosSiesa::class, 'crearInfoCodigos'])->name('crear.codigos.siesa');
        Route::post('search-codigos-siesa', [ControllerProcedimientosSiesa::class, 'searchInfoTodoPlanificacion'])->name('search.codigos.siesa');
        Route::post('search-info-codigos-siesa', [ControllerProcedimientosSiesa::class, 'searchInfoPlanificacionValor'])->name('search.info.codigos.siesa');
        Route::post('crear-op-siesa', [ControllerProcedimientosSiesa::class, 'crearInformacionOpSiesa'])->name('crear.info.op.siesa');
        //Historial OPs creadas Siesa
        Route::get('/historial-op-siesa', [ControllerHistorialSiesa::class, 'index'])->name('historial.op.siesa');
        Route::post('/historial-op-siesa', [ControllerHistorialSiesa::class, 'getInfoRangoFecha'])->name('search.historial.op.siesa');
    });

    Route::group(['prefix' => 'wood'], function () {
        Route::get('/', [ControllerPlannerWood::class, 'index'])->name('index.wood');
        Route::get('/cortar/{id_corte}', [ControllerPlannerWood::class, 'infoPiezasCorte'])->name('corte.woodmiser');
        Route::post('/cortar/{id_corte}', [ControllerPlannerWood::class, 'saveInformacionTablasCortes']);
        Route::post('/agregar-troncos', [ControllerPlannerWood::class, 'addTroncoUtilizado'])->name('add.tronco.woodmiser');
        Route::post('/delete-troncos', [ControllerPlannerWood::class, 'deleteTroncoUtilizado'])->name('delete.tronco.woodmiser');
        Route::post('/agregar-piezas-cortadas', [ControllerPlannerWood::class, 'addPiezasCortadas'])->name('add.piezas.woodmiser');
        Route::post('/search-troncos-wood', [ControllerPlannerWood::class, 'getDataTableCortes'])->name('getDataTables');
        Route::post('/search-obs-wood', [ControllerPlannerWood::class, 'getDataObsCortes'])->name('getObsWood');
        Route::post('/search-piezas-favor', [ControllerPlannerWood::class, 'getInfoDataPiezasMadera'])->name('getinfoPiezasFavor');
        Route::post('/save-piezas-favor', [ControllerPlannerWood::class, 'saveInformacionPiezasFavor'])->name('saveinfoPiezasFavor');
    });
});

Route::group(['prefix' => 'cotizador', 'middleware' => 'auth'], function () {

    Route::get('check-session', [session::class, 'checkSession']);

    Route::group(['prefix' => 'cotizador'], function () {
        Route::get('/retomar/{id_retomar}', [ControllerRetomarCotizacion::class, 'RetomarCotizacionCliente'])->name('retomar.cotizacion');
        Route::post('/consultar-cedula', [ControllerRetomarCotizacion::class, 'ObtenerInformacionUltimasCotizaciones'])->name('search.info.cliente');
        Route::get('/catalogo', [ControllerCatalogo::class, 'index'])->name('catalogo.cotizador');
    });

    Route::group(['prefix' => 'panel'], function () {
        Route::get('/lista-de-precios/{origen?}', [ControllerPanel::class, 'panel'])->name('lista.precios');
        Route::post('/agregar-producto', [ControllerPanel::class, 'AgregarProducto'])->name('add.new.product');
        Route::get('/nueva-cotizacion', [ControllerPanel::class, 'GenerarNuevaCotizacion'])->name('precios.nueva.cotizacion');
    });

    Route::group(['prefix' => 'liquidador'], function () {
        Route::get('/cotizacion', [ControllerLiquidador::class, 'index'])->name('liquidar.cotizacion');
        Route::post('/cotizacion', [ControllerValidarProductos::class, 'index']);

        Route::post('/eliminar', [ControllerLiquidador::class, 'eliminar'])->name("eliminar.item.cot");
        Route::post('/actualizar', [ControllerLiquidador::class, 'actualizar'])->name("actualizar.producto");
        Route::post('/actualizar-plan', [ControllerLiquidador::class, 'ModificarPlanCotizacion'])->name("modificar.plan");
        Route::post('/validar-informacion', [ControllerLiquidador::class, 'ValidarDatosCotizacion'])->name("datos.cotizacion");

        Route::post('consultar-ciudades', [ControllerLiquidador::class, 'ConsultarCiudad'])->name('ciudades.consultar');
    });

    Route::group(['prefix' => 'finalizar'], function () {
        Route::get('/menu', [ControllerFinalizar::class, 'index'])->name("finalizar.cotizacion");
        Route::get('/pdf', [ControllerPdfCotizacion::class, 'GenerarPdfCotizacion'])->name('generar.pdf.cotizacion');
        Route::get('/whatsapp', [ControllerFinalizar::class, 'WhatsApp'])->name("enviar.whatsapp.cotizacion");
        Route::post('/email', [ControllerFinalizar::class, 'Email'])->name("enviar.correo.cotizacion");
        Route::get('/fogade', [ControllerPdfFogade::class, 'GenerarDocumentoFogade'])->name("generar.pdf.fogade");
        Route::get('/credito', [ControllerGenerarCredito::class, 'GenerarSolicitudCredito'])->name("generar.solicitud.credito");
    });
});

Route::group(['prefix' => 'crm_almacenes', 'middleware' => 'auth'], function () {


    Route::prefix('liquidador')->group(function () {
        Route::prefix('/intereses')->group(function () {
            Route::get('/calcular', [ControllerLiquidadorIntereses::class, 'index'])->name('liquidador.intereses');
            Route::post('/calcular', [ControllerLiquidadorIntereses::class, 'RealizarCalculoIntereses'])->name('calcular.interes.liq');
            Route::post('/calcular/diferencia', [ControllerLiquidadorIntereses::class, 'CalcularValoresDiferencia'])->name('calcular.diferencia.liq');
            Route::post('/calcular/nueva-cuota', [ControllerLiquidadorIntereses::class, 'CalcularValoresNuevaCuota'])->name('calcular.nueva.cuota');
        });
        Route::prefix('/descuentos')->group(function () {
            Route::get('/calcular', [ControllerLiquidadorDescuentos::class, 'index'])->name('liquidador.descuentos');
            Route::post('/calcular', [ControllerLiquidadorDescuentos::class, 'ObtenerValoresLiquidadorDescuentos'])->name('calcular.dsto.liq');
        });
    });

    Route::get('/crm-punto-venta', [ControllerInicioCrm::class, 'index'])->name('inicio.crm.punto.venta');

    Route::post('/consultar-ciudad', [ControllerValidarInfo::class, 'ObtenerCiudades'])->name('consultar.ciudad');
    Route::post('/consultar', [ControllerValidarInfo::class, 'index'])->name('validar.llamadas.realizar');
    Route::post('/comentarios', [ControllerMaestraAsesor::class, 'ObtenerComentarios'])->name('comentarios.asesores');
    Route::post('/agregar-comentarios', [ControllerMaestraAsesor::class, 'AgregarComentarios'])->name('add.coments.asesor');
    Route::post('/obtenerInformacion', [ControllerMaestraAsesor::class, 'ObtenerInformacionCliente'])->name('info.general.cliente');
    Route::post('/programar-llamada', [ControllerMaestraAsesor::class, 'ProgramarNuevaLlamada'])->name('programar.llamada.cliente');
    Route::get('/WhatsApp/{celular}', [ControllerMaestraAsesor::class, 'whatsapp'])->name('asesor.whatsapp');
    Route::post('/obtener-info-venta-efectiva', [ControllerVentasEfectivas::class, 'ObtenerInformacionVentaEfectiva'])->name('info.efectivo.cliente');
    Route::post('/v-efectiva', [ControllerVentasEfectivas::class, 'index'])->name('ventas.efectivas');
    Route::post('/formEfectivos', [ControllerVentasEfectivas::class, 'efectivos'])->name('marcar.efectivo');
    Route::get('/encuesta/{celular}/{nombre}', [ControllerMaestraAsesor::class, 'encuesta'])->name('send.encuesta.asesor');
    Route::post('/crearTercero', [ControllerCrearTerceroSiesa::class, 'CrearInformacion'])->name('crear.siesa');
    Route::post('/actualizar-informacion', [ControllerMaestraAsesor::class, 'ActualizarInformacionCliente'])->name('update.info.cliente.crm');

    Route::prefix('/registrar')->group(function () {
        Route::get('/cliente', [ControllerNuevoRegistroCliente::class, 'index'])->name('registrar.nuevo.cliente');
        Route::post('/buscar-informacion', [ControllerNuevoRegistroCliente::class, 'BuscarInformacion'])->name('search.new.cliente');
        Route::post('/agregar-informacion', [ControllerNuevoRegistroCliente::class, 'NuevaInformacion'])->name('add.new.cliente.info');
    });

    Route::prefix('/llamadas-pendientes')->group(function () {
        Route::get('/registros', [ControllerLlamadasPendientes::class, 'index'])->name('llamadas.pendientes.crm');
        Route::post('/comentarios', [ControllerLlamadasPendientes::class, 'comentarios']);
        Route::post('/productos', [ControllerLlamadasPendientes::class, 'productos'])->name('items.cotizados.crm');
        Route::post('/agregar-seguimiento', [ControllerLlamadasPendientes::class, 'AgregarSeguimiento'])->name('add.seguimiento.crm');
    });

    Route::prefix('/clientes-efectivos')->group(function () {
        Route::get('/informacion', [ControllerClientesEfectivos::class, 'index'])->name("info.cliente.efectivo");
        Route::post('/informacion/actualizar', [ControllerClientesEfectivos::class, 'actualizarInformacion'])->name("updateInfo.cliente.crm");
    });


    Route::group(['prefix' => 'asesor'], function () {

        Route::prefix('/maestra')->group(function () {
            Route::get('/clientes', [ControllerMaestraAsesor::class, 'index'])->name('home.crm.asesor');
            Route::post('/clientes', [ControllerMaestraAsesor::class, 'tipoCliente'])->name('search.info.tipo.cliente');

            Route::post('/actualizar-tipo', [ControllerMaestraAsesor::class, 'ActualizarTipoCliente'])->name('update.tipoC.crm');
            Route::post('/comentarios', [ControllerMaestraAsesor::class, 'ObtenerComentarios']);

            Route::post('/obtener-precio-producto', [ControllerVentasEfectivas::class, 'ObtenerPrecioProductoBuscado']);
            Route::post('/agregar-producto-cliente', [ControllerVentasEfectivas::class, 'AgregarNuevoProductoDB']);
            Route::post('/eliminar-producto', [ControllerVentasEfectivas::class, 'EliminarProductoCliente']);
            Route::post('/actualizar-cliente-efectivo', [ControllerVentasEfectivas::class, 'ActualizarClienteVentaEfectiva']);
            Route::post('/eliminar-cliente', [ControllerMaestraAsesor::class, 'EliminarClienteCrm'])->name('solicitud.eliminar.cliente');
        });

        Route::prefix('/informe-de-ventas')->group(function () {
            Route::get('/estadisticas', [ControllerInformeDeVentas::class, 'index'])->name("informes.asesor.crm");
            Route::post('/estadisticas', [ControllerInformeDeVentas::class, 'fechas'])->name("search.asesor.info");
        });

        Route::prefix('/cumple')->group(function () {
            Route::get('/notificaciones', [ControllerCumpleClientes::class, 'index'])->name("cumple.asesor.info");
        });
    });


    Route::group(['prefix' => 'administrador'], function () {

        Route::prefix('/maestra')->group(function () {
            Route::get('/clientes', [ControllerMaestraAdmin::class, 'index'])->name('home.crm.admin');
            Route::post('/asesores', [ControllerMaestraAdmin::class, 'ObtenerAsesoresC'])->name('search.asesor.crm');
            Route::post('/info-clientes-asesor', [ControllerMaestraAdmin::class, 'informacionAsesor'])->name('info.general.asesor.m');
            Route::post('/eliminar-registros', [ControllerMaestraAdmin::class, 'EliminarRegistroDB'])->name('delete.record.clientes');
            Route::post('/comentarios', [ControllerMaestraAsesor::class, 'ObtenerComentarios']);
        });

        Route::prefix('/nuevo-registro')->group(function () {
            Route::get('/cliente', [ControllerNuevoRegistroCliente::class, 'index']);
            Route::post('/buscar-informacion', [ControllerNuevoRegistroCliente::class, 'BuscarInformacion']);
            Route::post('/agregar-informacion', [ControllerNuevoRegistroCliente::class, 'NuevaInformacion']);
        });

        Route::prefix('/llamadas-pendientes')->group(function () {
            Route::get('/registros', [ControllerLlamadasPendientes::class, 'index']);
            Route::post('/comentarios', [ControllerLlamadasPendientes::class, 'comentarios']);
            Route::post('/productos', [ControllerLlamadasPendientes::class, 'productos']);
            Route::post('/agregar-seguimiento', [ControllerLlamadasPendientes::class, 'AgregarSeguimiento']);
        });

        Route::prefix('/informe-de-ventas')->group(function () {
            Route::get('/estadisticas', [ControllerEstadisticasAdmin::class, 'index'])->name('estadisticas.admin.crm');
            Route::post('/asesores', [ControllerEstadisticasAdmin::class, 'ObtenerAsesores']);
            Route::post('/por-asesor', [ControllerEstadisticasAdmin::class, 'fechas'])->name("consultar.info.asesor.estadisticas");
        });
    });
});

Route::group(['prefix' => 'intranet_fabrica', 'middleware' => 'auth'], function () {

    Route::get('/inicio', [ControllerInicioFabrica::class, 'index'])->name("home.intranet.fabrica");

    /* ---------------------- */

    /* Rutas Para la parte de documentacion técnica */
    Route::get('/documentacion-tecnica', [DocumentacionTecnica::class, 'ObtenerSeccionFabrica'])->name('documentacion.tec.fab');
    Route::get('/productos_seccion/{id_seccion}/{seccion}', [DocumentacionTecnica::class, 'ObtenerProductosPorSeccion'])->name('id_seccion', 'seccion');
    Route::get('/informacion-title', [DocumentacionTecnica::class, 'ObtenerProductosPorSeccion'])->name('productos.title');
    Route::get('/titulos-producto/{seccion}/{id_seccion}/{id_producto}', [DocumentacionTecnica::class, 'ObtenerTitulosProductoSection'])->name('title.prods');
    Route::post('/titulos-producto', [DocumentacionTecnica::class, 'CrearNuevoTituloSeccion'])->name('crear.title');
    Route::post('/crear-nuevo-documento-fabrica', [DocumentacionTecnica::class, 'CargarNuevoDocumentoFab'])->name('new.doc');
    Route::post('/eliminar-documento-fabrica', [DocumentacionTecnica::class, 'EliminarDocumentoFabrica'])->name('eliminar.documento');
    Route::post('/eliminar-carpeta-doc', [DocumentacionTecnica::class, 'EliminarCarpetaFabrica'])->name('eliminar.carp.fab');


    /* Rutas para realizar el envio de informacion para los cambios en series */
    Route::get('/cambios-en-series', [CambiosEnSeries::class, 'VisualizarFormulario'])->name('cambios.serie.fab');
    Route::post('/guardar-formulario-cambios', [CambiosEnSeries::class, 'GuardarInformacionFormularioCambios'])->name('guardar.cambios');
    Route::get('/generar-documento-pdf', [CambiosEnSeries::class, 'GenerarPDFSeries']);

    /* Rutas Para calidad - encuesta de satisfacción */
    Route::get('/encuesta-de-satisfaccion', [ControllerEncuestaSatisfaccion::class, 'VisualizarInformacion'])->name("encuesta.satisfaccion.fab");
    Route::post('/validar-existencia-de-usuario', [ControllerEncuestaSatisfaccion::class, 'ValidarExistenciaDeUsuario'])->name('existencia.usuario');
    Route::post('/obtener-secciones-fabrica', [ControllerEncuestaSatisfaccion::class, 'ObtenerSeccionesFabricaEnc'])->name('secciones.fabrica');
    Route::get('/realizar-encuesta-satisfaccion/{proceso}/{seccion}/{cedula}', [ControllerEncuestaSatisfaccion::class, 'RealizarEncuestaSatisfaccion']);
    Route::post('/guardar-informacion-encuesta', [ControllerEncuestaSatisfaccion::class, 'GuardarInformacionEncuestaCliente'])->name('guardar.encuesta');

    /* Rutas para solicitud de mantenimiento */
    Route::get('/menu-solicitudes-mantenimiento', [ControllerSolicitudesMtto::class, 'MenuSolicitudes'])->name('menu.solicitud');
    Route::get('/consultar-solicitud-por-numero', [ControllerSolicitudesMtto::class, 'ConsultarSolicitudNumero'])->name('solicitud.numero');
    Route::post('/consultar-informacion-mtto', [ControllerSolicitudesMtto::class, 'ConsultarInformacionSolicitud'])->name('consultar.numero');
    Route::get('/consultar-solicitudes-por-fecha', [ControllerSolicitudesMtto::class, 'ConsultarSolicitudFecha'])->name('solicitudes.fecha');

    Route::get('/generar-solicitud-mantenimiento', [ControllerSolicitudesMtto::class, 'GenerarSolicitudMtto'])->name('nueva.solicitud');
    Route::post('/crear-nueva-solicitud-mtto', [ControllerSolicitudesMtto::class, 'GuardarInformacionNuevaSolicitud'])->name('generar.solicitud.mtto');
    Route::post('/generar-archivo-excel-mmto', [ControllerSolicitudesMtto::class, 'ObtenerExportarSolicitudesFecha'])->name('excel.export');

    Route::get('/solicitudes-mtto-pendientes', [ControllerSolicitudesMtto::class, 'SolicitudesMantenimientoPendientes'])->name('solicitudes.mtto.pend');
    Route::post('/obtener-info-solicitud-mtto', [ControllerSolicitudesMtto::class, 'ObtenerInformacionSolicitudMtto'])->name('verificar.info.mtto');
    Route::post('/dar-solucion-mtto', [ControllerSolicitudesMtto::class, 'ActualizarSolicitudMttoSolucion'])->name('dar.solucion.mtto');

    /*Rutas para cerrar solicitud mantenimiento */
    Route::get('/cerrar-solicitudes-mantenimiento', [ControllerCerrarSolicitudMtto::class, 'CerrarSolicitudesMtto'])->name('mtto.cerrar');
    Route::post('/buscar-informacion-mtto', [ControllerCerrarSolicitudMtto::class, 'ObtenerInformacionPorSeccion'])->name('cerrar.informacion');
    Route::post('/obtener-historial-solicitud', [ControllerCerrarSolicitudMtto::class, 'ObtenerHistorialSolicitudMtto'])->name('historial.mtto');
    Route::post('/definir-solicitud-mtto', [ControllerCerrarSolicitudMtto::class, 'DefinirSolicitudMtto'])->name('cerrar.solicitud.admin');


    /*Rutas para SGC */
    Route::get('/documentacion-sgc', [ControllerDocsSgc::class, 'index'])->name('docs.sgc');
    Route::get('/documentacion-sgc/{seccion}', [ControllerDocsSgc::class, 'ObtenerDocumentosNivel1'])->name('docs.sgc.niv1');
    Route::get('/documentacion-sgc/{seccion}/{carpeta_seccion}', [ControllerDocsSgc::class, 'ObtenerDocumentosNivel2'])->name('docs.sgc.niv2');

    Route::post('/cargar-documentacion-sgc', [ControllerDocsSgc::class, 'CargarDocumentacionSGC'])->name('cargar.sgc');
    Route::post('/eliminar-documento-sgc', [ControllerDocsSgc::class, 'EliminarDocumentoSGC'])->name('eliminar.doc.sgc');


    /*Hojas de vida */
    Route::prefix('hojas-de-vida')->group(function () {
        Route::get('/', [ControllerHojasDeVida::class, 'hojasDeVida'])->name('hojas.vida');
        Route::post('/buscar-maquina', [ControllerHojasDeVida::class, 'buscarMaquinaHojaDeVida'])->name('buscar.hoja.vida');
        Route::get('/maquina/{referencia}', [ControllerHojasDeVida::class, 'historialMaquina'])->name('historial.maquina');
        Route::post('/actualizar-img', [ControllerHojasDeVida::class, 'actualizarImagenMaquina'])->name('actualizar.imagen.maquina');
        Route::post('/guardar-comentario', [ControllerHojasDeVida::class, 'GuardarComentario'])->name('guardar.comentario');
        Route::post('/historial-fechas', [ControllerHojasDeVida::class, 'historialFechas'])->name('historial.fechas');
    });

    /*  Mantenimientos */
    Route::get('/maquinas-mantenimiento', [ControllerMantenimiento::class, 'viewMantenices'])->name('maquinas.mantenimiento');
    Route::post('/enviar-data', [ControllerMantenimiento::class, 'saveMantenices'])->name('save.mantenice');
    Route::post('/charge-mantenice', [ControllerMantenimiento::class, 'chargeMantenices'])->name('charge.mantenice');
    Route::post('/change-mantenice', [ControllerMantenimiento::class, 'changeMantenices'])->name('change.mantenice');
    Route::post('/delete-mantenice', [ControllerMantenimiento::class, 'deleteMantenices'])->name('delete.mantenice');
    Route::post('/charge-info', [ControllerMantenimiento::class, 'cargarMantenimiento'])->name('user.mantenice');
    Route::post('/request-info', [ControllerMantenimiento::class, 'requestMantenimiento'])->name('request.mantenice');
    Route::post('/show-mantenice', [ControllerMantenimiento::class, 'showMantenices'])->name('mostrar.mantenimiento');
    Route::get('/show-historial', [ControllerMantenimiento::class, 'showNoHistory'])->name('no.historial');

    Route::post('/searcher', [ControllerMantenimiento::class, 'searcher'])->name('no.searcher');
    Route::post('/searcher-date', [ControllerMantenimiento::class, 'searcherDate'])->name('search.date');

    /*Rutas para usuarios */
    Route::get('/usuarios-fabrica', [Intranet_fabricaControllerUsuarios::class, 'index'])->name('usuarios.fabrica');
    Route::get('/registrar-usuario', [Intranet_fabricaControllerUsuarios::class, 'RegistrarNuevoUsuario'])->name('registrar.usuario');
    Route::post('/registrar-nuevo-usuario', [Intranet_fabricaControllerUsuarios::class, 'AgregarNuevoUsuarioDB'])->name('registrar.users.fab');
    Route::post('/eliminar-usuario-registrado', [Intranet_fabricaControllerUsuarios::class, 'EliminarUsuarioRegistrado'])->name('eliminar.user.fab');
    Route::get('/agregar-referencia-prod', [Intranet_fabricaControllerUsuarios::class, 'AgregarReferenciaDocumentacion'])->name('referencia.producto');
    Route::post('/nueva-referencia-fab', [Intranet_fabricaControllerUsuarios::class, 'CrearReferenciaFabrica'])->name('agregar.referencia.fab');

    Route::get('/maquinas-fabrica', [ControllerMaquinasFab::class, 'MaquinasFabrica'])->name('maquinas.fab');
    Route::get('/agregar-nueva-maquina', [ControllerMaquinasFab::class, 'AgregarMaquinasFabrica'])->name('agregar.maquina.fab');
    Route::post('/nueva-maquinaria-fab', [ControllerMaquinasFab::class, 'RegistarNuevaMaquinaFab'])->name('agregar.nueva.maq');
    Route::post('/eliminar-maquina-fabrica', [ControllerMaquinasFab::class, 'EliminarRefMaquinaFabrica'])->name('eliminar.maquina');

    /*Usuarios Encuestas */
    Route::get('/encuestas/usuarios-registrados', [ControllerUsuariosEncuesta::class, 'index'])->name('listado.usuarios');
    Route::get('/encuestas/registrar-nuevo-usuario', [ControllerUsuariosEncuesta::class, 'FormRegistro'])->name('nuevo.user.encuesta');
    Route::post('/encuestas/agregar-nuevo-registro', [ControllerUsuariosEncuesta::class, 'InformacionRegistroUser'])->name('agregar.user.encuesta');
    Route::post('/encuestas/eliminar-registro-encuesta', [ControllerUsuariosEncuesta::class, 'EliminarInformacionUsuario'])->name('eliminar.user.encuesta');

    Route::get('/carrucel', [ControllerCarrucel::class, 'index'])->name('albura.carrucel');
    Route::post('/agregar-imagenes-fab', [ControllerCarrucel::class, 'AgregarImagenes'])->name('add.imagenes');
    Route::post('/activar-imagenes-fab', [ControllerCarrucel::class, 'ActivarImagenes'])->name('activar.imagenes');
    Route::post('/eliminar-img-carrucel', [ControllerCarrucel::class, 'EliminarImagenes'])->name('eliminar.img.carrucel');
});

Route::group(['prefix' => 'nexus', 'middleware' => 'auth'], function () {
});


//Servicios técnicos

//Link para acceder desde la web
Route::group(['prefix' => 'pagina-web'], function () {
    Route::get('/', [ControllerWeb::class, 'home']);
    Route::get('/enviar-data', [ControllerWeb::class, 'formulario'])->name('enviar-data');
    Route::post('/guardar-info', [ControllerWeb::class, 'guardarOst'])->name('guardarOst');
    Route::post('/consultar_info', [ControllerWeb::class, 'getInfoClientePw'])->name('search.info.cliente');
});

//Enlaces para acceder como administrador
Route::group(['prefix' => 'servicios_tecnicos', 'middleware' => 'auth', 'middleware' => 'checkPermisosServicios'], function () {

    Route::group(['prefix' => 'st'], function () {
        Route::get('products', [ControllerMaestros::class, 'viewProductsApp']);

        Route::get('analytics', [ControllerAnalytics::class, 'home'])->name('analytics');
        Route::post('analytics', [ControllerAnalytics::class, 'searchinfo'])->name('analytics.search');

        Route::post('search-ost', [ControllerSearchSt::class, 'search'])->name('search.ost');
        Route::post('search-co', [ControllerAlmacenes::class, 'ObtenerInfoAlmacenes'])->name('search.co');
        Route::post('search-facturas', [ControllerConexionWs::class, 'getInfoFacturasCliente'])->name('search.facturas');
        Route::post('search-productos', [ControllerConexionWs::class, 'getInfoProductosCliente'])->name('search.productos');
        Route::get('crear-solicitud-st/{cedula_new_ost?}/{co_new_ost?}/{factura_cliente?}/{item_cliente?}/{factura?}/{fecha_factura?}/{remision?}/{fecha_remision?}/{id_item?}/{ext1?}/{ext2?}/{ticket?}', [ControllerCreateServicio::class, 'formParametros'])->name('create.solicitud');

        Route::group(['prefix' => '/seguimiento'], function () {
            Route::get('', [ControllerSeguimientoSt::class, 'home_st'])->name('informe.seg');
            Route::get('/info_st/{id_st}/{seccion?}', [ControllerSeguimientoSt::class, 'viewInfoGeneralOst'])->name('st.find.ost.card');
            Route::post('evidencias-ost', [ControllerSeguimientoSt::class, 'getInfoEvidenciasSt'])->name('evidencias.ost');
            Route::post('eliminar-evidencias-ost', [ControllerSeguimientoSt::class, 'deleteInfoEvidenciasSt'])->name('delete.evidencia');
            Route::post('updateInfoVisitaEvidencias', [ControllerSeguimientoSt::class, 'updateInfoEvidenciasVisita'])->name('update.evidencia.visita');
            Route::post('addCommentsGeneral', [ControllerSeguimientoSt::class, 'addComentariosGeneralesOst'])->name('add.comment.general');
            Route::post('addValoracionFabrica', [ControllerSeguimientoSt::class, 'addValoracionFabrica'])->name('add.valoracion.fabrica');
            Route::post('searchInfoEstadoSt', [ControllerSeguimientoSt::class, 'searInformacionSolicitudes'])->name('info.estado.ost');
            Route::post('definirOrdenServicio', [ControllerSeguimientoSt::class, 'definirOrdenServicioT'])->name('definir.ost');
            Route::post('UpdatedefinirOrdenServicio', [ControllerSeguimientoSt::class, 'updateOrdenDefinida'])->name('update.definir.ost');
            Route::post('agregarEvidenciasAdicionales', [ControllerSeguimientoSt::class, 'addEvidenciasSolicitudSt'])->name('add.evid.adic');
            Route::post('updateConceptoFabrica', [ControllerSeguimientoSt::class, 'updateValoracionFabGerencia'])->name('update.concepto.fab');
            Route::get('printFormatoSolicitud/{id_st}', [ControllerFormatosPdf::class, 'GenerarPdfOrdenServicioTec'])->name('print.form.solicitud');
            Route::post('updateRecogidaSt', [ControllerSeguimientoSt::class, 'updateDataRecogidaSt'])->name('update.recogida.item');
            Route::post('updateIngresoTaller', [ControllerGestionTaller::class, 'actualizarIngresoTaller'])->name('update.ingreso.taller');
            Route::post('seguimientoEnTaller', [ControllerSeguimientoSt::class, 'agregarSeguimientoTaller'])->name('add.seg.taller');
            Route::post('emitirCartaRespuesta', [ControllerSeguimientoSt::class, 'EmitirCartaRespuestaServicio'])->name('carta.respuesta');
            Route::post('aprobarCartaRespuesta', [ControllerSeguimientoSt::class, 'aprobarRespuestaEmitida'])->name('aprobar.respuesta');
            Route::get('imprimirCartaFabrica/{id_st}', [ControllerFormatosPdf::class, 'printFormatoRespuesta'])->name('print.carta');
            Route::post('notificacionClienteNoGarantia', [ControllerNoGarantiaCliente::class, 'enviarNotificacion'])->name('notificacion.cliente.noga');
        });

        Route::group(['prefix' => '/create'], function () {
            Route::get('', [ControllerCreateServicio::class, 'home'])->name('new.ost');
            Route::get('pagina-web/{ticket?}', [ControllerCreateServicio::class, 'infoPagWeb'])->name('new.ost.pw');
            Route::post('', [ControllerNuevaSolicitud::class, 'crearNuevaSolicitud'])->name('form.create.ost');
        });
        Route::group(['prefix' => '/formatos'], function () {
            Route::get('/{id_st}', [ControllerFormatosPdf::class, 'createDocument'])->name('format.hs');
        });

        Route::group(['prefix' => 'fabrica'], function () {
            Route::get('', [ControllerSeguimientoFab::class, 'valoracion'])->name('home.fabrica');
            Route::post('search', [ControllerSeguimientoFab::class, 'infoGeneral'])->name('fabrica.search');
        });

        Route::group(['prefix' => 'almacen'], function () {
            Route::get('', [ControllerInfoAlmacenes::class, 'procesoData'])->name('info.almacen');
            Route::post('search', [ControllerInfoAlmacenes::class, 'infoGeneral'])->name('search.almacen');
        });

        Route::group(['prefix' => 'despachos'], function () {
            Route::get('', [ControllerInfoDespachos::class, 'procesoData'])->name('info.despachos');
        });

        Route::group(['prefix' => 'taller'], function () {
            Route::get('', [ControllerGestionTaller::class, 'getInfoReparacion'])->name('info.taller');
        });

        Route::group(['prefix' => 'pagina-web'], function () {
            Route::get('', [ControllerAdminInfoPw::class, 'infoPaginaWeb'])->name('info.pagweb');
            Route::post('', [ControllerAdminInfoPw::class, 'searchInfo'])->name('search.info.pw');
            Route::post('/delete', [ControllerAdminInfoPw::class, 'deleteSolicitudPw'])->name('delete.info.pw');
        });

        Route::group(['prefix' => 'maestros'], function () {
            Route::get('', [ServiciosControllerAdmin::class, 'home'])->name('admin.info');
            Route::post('', [ServiciosControllerAdmin::class, 'createInfo'])->name('create.admin');
        });

        Route::group(['prefix' => 'st_seguimiento'], function () {
            Route::get('', [ControllerInformes::class, 'getInformes'])->name('info.st.seg');
            Route::post('exportar-seguimientos', [ControllerInformes::class, 'exportInfo'])->name('export.st.seg');
            Route::post('delete-st-admin', [ControllerInformes::class, 'deleteServicioTecnico'])->name('delete.st.seg');
        });

        Route::group(['prefix' => 'usuarios'], function () {
            Route::get('', [ControllerUsuarios::class, 'index'])->name('users.admin');
            Route::post('search', [ControllerUsuarios::class, 'searchInfo'])->name('search.users.admin');
            Route::post('', [ControllerUsuarios::class, 'createUser'])->name('create.users.admin');
            Route::post('/update-foto', [ControllerUsuarios::class, 'updateFoto'])->name('update.photo');
        });
    });
});

Route::group(['prefix' => 'tareas', 'middleware' => 'auth'], function () {
});
