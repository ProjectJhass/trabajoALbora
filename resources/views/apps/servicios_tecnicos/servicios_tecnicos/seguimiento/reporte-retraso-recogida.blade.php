<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <div class="card mx-auto" style="width: 600px; margin: 0 auto">
        <div class="card-header">
            <div>
                <div><img ng-if="col.img.source" border="0" hspace="0" vspace="0" width="100%"
                        class="rnb-header-img" alt="" style="display:block; float:left; border-radius: 5px; "
                        src="https://img.mailinblue.com/2547420/images/rnb/original/5fb70984c0559c6eb5592fc1.jpg"></div>
                <div style="clear:both;"></div>
            </div>
        </div>
        <div class="card-body">
            <div class="d-flex flex-column">
                <br>
                <hr>
                <div>
                    <p><b>Buen dia</b></p>
                    <p>Queremos informarle que tiene <b>{{ count($data) }} solicitudes de servicio tecnico</b> sin
                        novedad (Actualizaciones) en la recogida. </b>. <br>A continuación, encontrará detalles de las
                        mismas:
                    </p>
                </div>
                <br>
                <hr>
                @foreach ($data as $valSt)
                    <div class="d-flex justify-content-center">
                        <p class="text-center"><b>ST° {{ $valSt->id_st }}</b></p>
                    </div>
                    <p><b>Cliente:</b> {{ $valSt->nuevaSolicitud->nombre }}</p>
                    <p><b>Producto:</b> {{ $valSt->nuevaSolicitud->articulo }}</p>
                    <p><b>Direccion:</b> {{ $valSt->nuevaSolicitud->direccion }}, {{ $valSt->nuevaSolicitud->ciudad }}
                    </p>
                    <p><b>Dias trancurridos en recogida:</b> {{ $valSt->dias_transcurridos }}</p>
                    <hr>
                @endforeach
            </div>
        </div>
        <table class="rnb-del-min-width" width="100%" cellpadding="0" border="0" cellspacing="0"
            style="min-width:100%;" name="Layout_12">
            <tbody>
                <tr>
                    <td class="rnb-del-min-width" align="center" valign="top">
                        <a href="#" name="Layout_12"></a>
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="rnb-container"
                            bgcolor="#ffffff"
                            style="background-color: rgb(255, 255, 255); padding-left: 20px; padding-right: 20px; border-collapse: separate; border-radius: 0px; border-bottom: 0px none rgb(200, 200, 200);">
                            <tbody>
                                <tr>
                                    <td height="20" style="font-size:1px; line-height:20px; mso-hide: all;">
                                        &nbsp;</td>
                                </tr>
                                <tr>
                                    <td valign="top" class="rnb-container-padding" align="left">
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0"
                                            class="rnb-columns-container">
                                            <tbody>
                                                <tr>
                                                    <th class="rnb-force-col"
                                                        style="text-align: left; font-weight: normal; padding-right: 0px;"
                                                        valign="top">

                                                        <table border="0" valign="top" cellspacing="0"
                                                            cellpadding="0" width="100%" align="left"
                                                            class="rnb-col-1">
                                                            <tbody>
                                                                <tr>
                                                                    <td
                                                                        style="font-size:14px; font-family:Arial,Helvetica,sans-serif, sans-serif; color:#3c4858;">
                                                                        <div style="text-align: center;">
                                                                            <span style="font-size:12px;">Email enviado
                                                                                desde mensajer&iacute;a Muebles Albura
                                                                                SAS,<br> por favor no responder a este
                                                                                correo.</span><br> &nbsp;
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>

                                                    </th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="rnb-del-min-width rnb-tmpl-width" width="100%" cellpadding="0" border="0" cellspacing="0"
            style="min-width:590px;" name="Layout_7" id="Layout_7">
            <tbody>
                <tr>
                    <td class="rnb-del-min-width" align="center" valign="top" style="min-width:590px;">
                        <a href="#" name="Layout_7"></a>
                        <table width="100%" cellpadding="0" border="0" align="center" cellspacing="0"
                            bgcolor="#ff2c00"
                            style="padding-right: 20px; padding-left: 20px; background-color: rgb(255, 44, 0);">
                            <tbody>
                                <tr>
                                    <td height="20" style="font-size:1px; line-height:20px; mso-hide: all;">
                                        &nbsp;</td>
                                </tr>
                                <tr>
                                    <td
                                        style="font-size:14px; color:#ffffff; font-weight:normal; text-align:center; font-family:Arial,Helvetica,sans-serif;">
                                        <div>
                                            <div>&copy; {{ date('Y') }} Muebles
                                                Albura SAS</div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td height="20" style="font-size:1px; line-height:20px; mso-hide: all;">
                                        &nbsp;</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</body>

</html>
<style>
    .step-btn {
        transition: transform 300ms;
        width: 32px;
        height: 32px;
        border-radius: 100%;
        background-color: #e6e6ff;
        border: 2px solid #e6e6ff;
        color: #666666;
    }

    .step-btn:hover {
        transform: scale(1.5);
        transition: all 300ms ease-out;
        /* transition-duration: 300ms; */
    }

    progress::-webkit-progress-bar {
        background-color: #e6e6ff;
        width: 100%;
    }

    .progressbar::-moz-progress-bar {
        background: #a7a7ba;
    }

    .progressbar::-webkit-progress-value {
        background: #a7a7ba;
        transition-duration: 300ms;
    }

    progress {
        color: blue;
    }

    .progressbar {
        position: absolute;
        width: calc(100% - 100px);
        box-sizing: border-box;
        transform: translate(-50%, -50%);
        left: 50%;
        z-index: 5;
        height: 6px;
        top: 50%;
    }
</style>
