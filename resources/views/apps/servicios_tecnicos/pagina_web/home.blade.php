<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Servicios Tecnicos Albura</title>
    <meta name="description" content="En Muebles Albura SAS, ofrecemos un servicio técnico especializado para resolver cualquier inconveniente que puedas tener con tus compras. Nuestro equipo está aquí para garantizar que tus muebles funcionen perfectamente. ¡Confía en nosotros para brindarte una experiencia sin preocupaciones y disfruta de tus muebles con total tranquilidad!">
    <meta name="keywords" content="servicio tecnico albura, servicio albura, tecnico albura, servicios tecnicos, servicios tecnicos albura, reparacion albura">
    <link rel="stylesheet" href="{{ asset('css/Bootstrap_5.3_css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style_home.css') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('resource/images/alburac.png') }}" sizes="30">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets_plugin/vendor/css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets_plugin/vendor/css/theme-default.css') }}" />
</head>

<body>
    <div class="d-flex justify-content-center mt-2 alig-items-center">
        <nav id="header" class="shadow">
            <a href="{{ route('info.pagweb') }}" title="Inicio Albura">
                <div class="logo_Albura "></div>
            </a>
        </nav>
    </div>

    <div class="d-flex justify-content-center">
        <div class="card shadow " id="tarjeta">
            <div class="card-header " id="header_prob">
                <h3 class="titulo ">Opciones</h3>
            </div>
            <div class="card-body row ">
                <div class="col-sm d-flex justify-content-end">
                    <div class="shadow rounded p-3  " id="caja" onclick="openModal()">
                        <div class="d-flex justify-content-center ">
                            <div class="option1 shadow p-1"></div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <h4>Contactar asesor de servicio técnico</h4>
                        </div>
                        <div class="texto d-flex justify-content-center" id="text">
                            <p>Contacte de manera fácil y rápida con uno de nuestros asesores, para brindarle toda
                                la ayuda posible.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-sm  d-flex justify-content-center ">
                    <a href="{{ route('enviar-data') }}" class="ancla">
                        <div class="shadow rounded p-3  mt-2" id="caja">
                            <div class="d-flex justify-content-center ">
                                <div class="option2 shadow p-1"></div>
                            </div>
                            <div class="d-flex justify-content-center">
                                <h4>Solicite su servicio técnico</h4>
                            </div>
                            <div class="texto d-flex justify-content-center" id="text">
                                <p>Gestione usted mismo su servicio técnico especializado,
                                    será evaluado por nuestro personal lo más pronto posible para darle solución.
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <!-- Button trigger modal -->
        <!-- Modal texto terminos y condiciones -->
        <div class="modal fade" id="tyc" data-bs-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel"><b>Términos y Condiciones</b></h5>
                        </button>
                    </div>
                    <div class="modal-body">
                        Bienvenido a la plataforma de servicios técnicos de Muebles Albura, en adelante (“Plataforma”),
                        cuya actividad principal es atender todas las solicitudes de garantía de muebles, colchones y
                        accesorios para el hogar de los consumidores ubicados en la República de Colombia, en adelante
                        (“los Usuarios” / “Clientes”). Al ingresar al Sitio el Usuario admite haber leído y entendido
                        los Términos y Condiciones de Uso, en adelante (“Términos y Condiciones”), y por consiguiente
                        asumen la obligación de respetar su contenido, política de privacidad, notificaciones legales y
                        todas las cláusulas de exención de responsabilidad que figuran en el mismo.
                        Los presentes Términos y Condiciones están sujetos a cambios sin previo aviso, en cualquier
                        momento, y a partir de la fecha de modificación de estos Términos y Condiciones, todas las
                        operaciones que se celebren entre Luis Darío Botero Gómez, persona natural identificado con NIT
                        7.504.725-0 en representación de la marca Muebles Albura y el sitio web www.mueblesalbura.com.co
                        y el Usuario se regirán por el documento modificado.
                        <br><br>
                        <b>Inscripción del Usuario en Plataforma</b><br><br>


                        En el proceso de solicitud de la garantía, el Cliente deberá ingresar la siguiente información
                        personal:
                        <br><b>1.</b> Contactar a nuestro asesor de servicio al cliente, quien durante la conversación
                        puede solicitarle información necesaria para brindarte una asesoría personalizada. Al continuar
                        aceptas el tratamiento de tus datos personales, de acuerdo con la Ley 1581 de 2012 de Protección
                        de Datos y con el Decreto 1377 de 2013.
                        <br><b>2.</b>Ingresar a la plataforma directamente, los datos a ingresar serían: Información de
                        contacto, incluyendo nombre, número de identificación, fecha de nacimiento, dirección, número de
                        teléfono y correo electrónico.
                        <br><b>3.</b> Además, envío de evidencias como fotografías y videos del producto informando el
                        daño presentado para un mejor diagnóstico de la garantía.
                        <br><br>
                        <b>Verificación del Usuario – Impedimento de uso</b><br><br>


                        Al ingresar a este sitio el Usuario adquiere el compromiso de suministrar información personal
                        correcta y verdadera para la entrega efectiva de los productos adquiridos. mueblesalbura.com.co
                        examinará la solicitud presentada por el Usuario y se reservará la facultad de verificar los
                        datos comunicados por cada uno de los Usuarios. De constatarse una inconsistencia en la
                        información del Usuario al momento de la inscripción un funcionario se comunicará con usted para
                        validar los datos.
                        <br><br>
                        <b>Responsabilidad del Usuario</b> <br><br>
                        A continuación, damos a conocer información importante en el momento de tramitar un servicio
                        técnico por la plataforma de la empresa Muebles Albura, el usuario acepta haber leído y
                        entendido los siguientes numerales: <br>
                        <b>*</b> He sido informado sobre el envío de evidencias (fotos, videos), con el fin de que la
                        empresa pueda valorar y de esta manera se pueda hacer efectiva la garantía a la cual tengo
                        derecho como lo dice el Estatuto del Consumidor Ley 1480 de 2011. Para más información y
                        detalles de garantía ingresar a: <a
                            href="https://mueblesalbura.com.co/home/garantia-de-productos/.">https://mueblesalbura.com.co/home/garantia-de-productos/.</a><br>
                        <b>*</b> Después de revisar profundamente las evidencias enviadas, la empresa Muebles Albura
                        decide recoger el producto en tu domicilio, para esto solicitamos empacar cuidadosamente con
                        cartón y cinta; adicionalmente proveer una fotografía de evidencia, para así programar la
                        recolección dentro de los próximos días. <br>
                        <b>*</b> Es de aclarar que el producto será recogido donde fue entregado, en caso contrario,
                        nuestro equipo de Logística se comunicará contigo. <br>
                        <b>*</b> Es liberalidad de la empresa recoger el producto y contrastar la evidencia enviada por
                        el cliente versus el estado del producto. La recogida del producto no implica que estemos dando
                        la garantía, simplemente es un diagnostico adicional que requiere fabrica. La garantía o no
                        garantía se expedirá por fabrica mediante un documento. <br>
                        <b>*</b> Entiendo que la empresa Muebles Albura, una vez recogido el producto en su domicilio,
                        estará dando respuesta en un tiempo no mayor a 15 días hábiles, para retornarlo a su destino
                        inicial (domicilio reportado por nuestro cliente). Todo esto de acuerdo al diagnóstico emitido
                        por la fábrica y teniendo en cuenta la Ley 1480 de 2011 “Estatuto al Consumidor”. Una vez
                        diagnosticado el servicio técnico los tiempos varían según el daño y complejidad de la
                        reparación. <br>
                        <b>*</b> He sido informado que, si el producto ha sido reparado y fue enviado por la
                        transportadora, en el momento de recibirlo, solicitamos el favor de firmar y colocar en la guía
                        la siguiente frase “SIN REVISAR CONTENIDO” en caso de que reciba una persona diferente al
                        titular, dar la instrucción de colocar la frase “SIN REVISAR CONTENIDO”. Esto con el fin de
                        realizar reclamaciones a la empresa transportadora en caso de que tu producto no llegue en buen
                        estado. <br>
                        <b>4.</b> Es responsabilidad del usuario leer y dar por aceptado el entender y manejar las
                        políticas del tratamiento de sus datos personales, de acuerdo con la Ley 1581 de 2012 de
                        Protección de Datos y con el Decreto 1377 de 2013, el uso de la plataforma de servicios técnicos
                        y términos y condiciones del sitio.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-dismiss="modal"
                            onclick="closeModal()">Cerrar</button>

                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header" style="border-top: solid red 3px">
                        <center>
                            <p>Para iniciar su trámite de Servicios Técnicos, por favor lee y acepta los <b>términos y
                                    condiciones plataforma, Términos y condiciones comerciales y Política de
                                    Privacidad.</b></p>
                        </center>
                        {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                    </div>
                    <div class="modal-body">
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" value="true" id="terminos1"
                                onclick="checkex()">
                            <label class="form-check-label" for="terminos1" id="lt1">
                                <b>Acepto haber leido los presentes términos. </b><a href="#" type="button"
                                    onclick="desplegarTyc()">Ver Términos y Condiciones.</a>
                            </label>
                        </div>
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" value="true" id="terminos2"
                                onclick="checkex()">
                            <label class="form-check-label" for="terminos2" id="lt2" onclick="checkex()">
                                <b>Términos y Condiciones Comerciales. </b><a
                                    href="https://mueblesalbura.com.co/home/condiciones-y-restricciones/"
                                    target="_blank">Ver Aquí</a>
                            </label>
                        </div>
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" value="true" id="terminos3"
                                onclick="checkex()">
                            <label class="form-check-label" for="terminos3" id="lt3">
                                <b>Politicas de Privacidad. </b><a
                                    href="https://mueblesalbura.com.co/home/condiciones-y-restricciones/"
                                    target="_blank">Ver Aquí</a>
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="https://mueblesalbura.com.co/" type="button" class="btn btn-danger">Rechazar los
                            TyC</a>
                        <button type="button" class="btn btn-success" onclick="validarCheckboxes()">Aceptar los
                            TyC</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal " id="contacto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" id="header-modal">
                        <h1 class="modal-title fs-5" id="exampleModalLabel" style="color: white;"><i
                                class="fas fa-info-circle"></i>
                            Información</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex justify-content-center" id="menu_informacion">
                            <div>
                                <a id="ancla" href="https://api.whatsapp.com/send/?phone=573217998744"
                                    target="_blank" class="d-block mt-3">
                                    <img src="{{ asset('resource/images/whatsapp.webp') }}" class="ml-1"
                                        width="30" height="30"> Whatsapp: 3217998744</a>
                                <div>
                                    <input type="text" value="serviciostecnicos@mueblesalbura.com.co" disabled
                                        class="form-control mb-2 mt-2" id="input">


                                    <button class="btn rounded-pill btn-outline-info mt-2" type="button"
                                        id="botones_info" onclick="copiar()"><img
                                            src="{{ asset('resource/images/email.png') }}"
                                            style="border: solid 2px white;border-radius: 50%" width="30"
                                            height="30">&nbsp;&#160; Copiar Enlace.</button>

                                    <a type="button" href="tel:+573217998744" id="botones_info1"
                                        class="btn rounded-pill btn-outline-info  mt-2">
                                        <img src="{{ asset('resource/images/llamada.png') }}"
                                            style="border: solid 2px white;border-radius: 50%" width="30"
                                            height="30">&nbsp;&#160; Realizar Llamada.
                                    </a>
                                </div>
                                <div id="copiado" class="alert alert-success mt-3" role="alert">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer id="footer" class="shadow row">
        <script src="{{ asset('js/Jquery/jquery-3.7.1.js') }}"></script>
        <script src="{{ asset('js/script.js') }}"></script>
        <script src="{{ asset('js/Bootstrap_5.3_js/bootstrap.min.js') }}"></script>
    </footer>
</body>

</html>
