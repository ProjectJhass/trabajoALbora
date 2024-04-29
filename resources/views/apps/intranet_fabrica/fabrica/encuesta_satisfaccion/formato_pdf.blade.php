<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <table width="100%">
        <tbody width="100%">
            <tr>
                <td>
                    <table width="100%">
                        <tr>
                            <td width="50%">
                                <img src="https://img.mailinblue.com/2547420/images/rnb/original/63c95df80e1a1a40c40097d0.png" width="60%" alt="">
                            </td>
                            <td width="50%" style="text-align: center; font-size: 19px">
                                ENCUESTA DE SATISFACCIÓN DEL CLIENTE INTERNO
                            </td>
                        </tr>
                    </table>
                    <table width="100%">
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                    </table>
                    <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="520">
                        <tr>
                            <td style="height: 1px;">
                                <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                    <tr>
                                        <td>
                                            <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" valign="" class="r14-i" height="1"
                                                style="border-top-style: solid; background-clip: border-box; border-top-color: #4A4A4A; border-top-width: 1px; font-size: 1px; line-height: 1px;">
                                                <tr>
                                                    <td height="0" style="font-size: 0px; line-height: 0px;">­</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table cellspacing="0" cellpadding="0" style="margin-top: 2%; margin-bottom: 2%" border="0" width="100%">
                        <tr>
                            <td style="width: 33.33%; text-align: center">CÓDIGO: RG-TH-07</td>
                            <td style="width: 33.33%; text-align: center">VERSIÓN: 05</td>
                            <td style="width: 33.33%; text-align: center">PÁGINA: 1</td>
                        </tr>
                    </table>
                    <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="520">
                        <tr>
                            <td style="height: 1px;">
                                <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                    <tr>
                                        <td>
                                            <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" valign="" class="r14-i" height="1"
                                                style="border-top-style: solid; background-clip: border-box; border-top-color: #4A4A4A; border-top-width: 1px; font-size: 1px; line-height: 1px;">
                                                <tr>
                                                    <td height="0" style="font-size: 0px; line-height: 0px;">­</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table cellspacing="0" cellpadding="0" style="margin-top: 2%; margin-bottom: 2%; font-size: 13px" border="0" width="100%">
                        @foreach ($info as $key => $value)
                            <tr style="margin-top: 50px">
                                <td width="130px"><strong>NOMBRE:</strong></td>
                                <td>{{ $value->nombre_usuario }}</td>
                            </tr>
                            <tr>
                                <td width="130px"><strong>PROCESO:</strong></td>
                                <td>{{ $value->proceso }}</td>
                            </tr>
                            <tr>
                                <td width="130px"><strong>SECCIÓN:</strong></td>
                                <td>{{ $value->seccion }}</td>
                            </tr>
                            <tr>
                                <td width="130px"><strong>FECHA:</strong></td>
                                <td>{{ date('Y-m-d') }}</td>
                            </tr>
                        @endforeach
                    </table>
                    <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="520">
                        <tr>
                            <td style="height: 1px;">
                                <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                    <tr>
                                        <td>
                                            <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" valign="" class="r14-i" height="1"
                                                style="border-top-style: solid; background-clip: border-box; border-top-color: #4A4A4A; border-top-width: 1px; font-size: 1px; line-height: 1px;">
                                                <tr>
                                                    <td height="0" style="font-size: 0px; line-height: 0px;">­</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table cellspacing="0" cellpadding="0" style="margin-top: 2%; margin-bottom: 2%" border="0" width="100%">
                        <tr>
                            <td width="40%"><strong>OBJETIVO:</strong><br>
                                <p style="text-align: justify">Medir el nivel de satisfacción del personal interno a fin de identificar
                                    y determinar fortalezas y debilidades de la empresa con sus colaboradores
                                    de manera que ayude a generar estratégias para incrementar su satisfacción y
                                    por ende la productividad general.</p>
                            </td>
                            <td width="10%"></td>
                            <td width="40%"><strong>INSTRUCCIONES:</strong><br>
                                <p style="text-align: justify">Lea atentamente cada uno de los puntos y califique el factor mencionado de 1 a 5, donde 1
                                    es la calificación más baja y 5 es la calificación más alta, conforme a su percepción general de la empresa.
                                </p>
                            </td>
                        </tr>
                    </table>
                    <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="520">
                        <tr>
                            <td style="height: 1px;">
                                <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                    <tr>
                                        <td>
                                            <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" valign="" class="r14-i" height="1"
                                                style="border-top-style: solid; background-clip: border-box; border-top-color: #4A4A4A; border-top-width: 1px; font-size: 1px; line-height: 1px;">
                                                <tr>
                                                    <td height="0" style="font-size: 0px; line-height: 0px;">­</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table cellspacing="0" cellpadding="0" style="margin-top: 2%; margin-bottom: 2%" border="0" width="100%">
                        <tr>
                            <p><u>PREGUNTAS Y PUNTUACIÓN</u></p>
                        </tr>
                        <tr>
                            <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="520" style="margin-top: 3%; margin-bottom: 3%;">
                                <tr>
                                    <td style="height: 1px;">
                                        <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                            <tr>
                                                <td>
                                                    <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" valign="" class="r14-i" height="1"
                                                        style="border-top-style: solid; background-clip: border-box; border-top-color: #4A4A4A; border-top-width: 1px; font-size: 1px; line-height: 1px;">
                                                        <tr>
                                                            <td height="0" style="font-size: 0px; line-height: 0px;">­</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </tr>
                        <tr>
                            <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                <tbody>
                                    <tr>
                                        <td style="width: 2%">#</td>
                                        <td style="width: 2%"></td>
                                        <td style="width: 76%">PREGUNTA</td>
                                        <td style="width: 10%"></td>
                                        <td style="width: 10%">CALIFICACIÓN</td>
                                    </tr>
                                </tbody>
                            </table>
                        </tr>
                        <tr>
                            <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="520" style="margin-top: 3%; margin-bottom: 3%;">
                                <tr>
                                    <td style="height: 1px;">
                                        <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                            <tr>
                                                <td>
                                                    <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" valign="" class="r14-i" height="1"
                                                        style="border-top-style: solid; background-clip: border-box; border-top-color: #4A4A4A; border-top-width: 1px; font-size: 1px; line-height: 1px;">
                                                        <tr>
                                                            <td height="0" style="font-size: 0px; line-height: 0px;">­</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </tr>
                        <tr>
                            <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                <tbody>
                                    @foreach ($preguntas as $key => $val)
                                        <tr>
                                            <td style="width: 2%">{{ $val->id_pregunta }}-</td>
                                            <td style="width: 2%"></td>
                                            <td style="width: 76%">
                                                <p style="font-size: 12px">{{ $val->pregunta }}</p>
                                            </td>
                                            <td style="width: 10%"></td>
                                            <td style="width: 10%; text-align: center">{{ $val->respuesta }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </tr>
                        <tr>
                            <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="520" style="margin-top: 3%; margin-bottom: 3%;">
                                <tr>
                                    <td style="height: 1px;">
                                        <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                            <tr>
                                                <td>
                                                    <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" valign="" class="r14-i" height="1"
                                                        style="border-top-style: solid; background-clip: border-box; border-top-color: #4A4A4A; border-top-width: 1px; font-size: 1px; line-height: 1px;">
                                                        <tr>
                                                            <td height="0" style="font-size: 0px; line-height: 0px;">­</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </tr>
                        @foreach ($info as $key => $value)
                            <tr>
                                <table>
                                    <tr>
                                        <td>
                                            ¿Qué actividad de integración sugiere?
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{ $value->comentario1 }}
                                        </td>
                                    </tr>
                                </table>
                            </tr>
                            <tr>
                                <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="520" style="margin-top: 3%; margin-bottom: 3%;">
                                    <tr>
                                        <td style="height: 1px;">
                                            <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                                <tr>
                                                    <td>
                                                        <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" valign="" class="r14-i" height="1"
                                                            style="border-top-style: solid; background-clip: border-box; border-top-color: #4A4A4A; border-top-width: 1px; font-size: 1px; line-height: 1px;">
                                                            <tr>
                                                                <td height="0" style="font-size: 0px; line-height: 0px;">­</td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </tr>
                            <tr>
                                <table>
                                    <tr>
                                        <td>
                                            ¿Qué habilidad posee (Cantar, Bailar, Jugar... etc)?
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{ $value->comentario2 }}
                                        </td>
                                    </tr>
                                </table>
                            </tr>
                            <tr>
                                <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="520" style="margin-top: 3%; margin-bottom: 3%;">
                                    <tr>
                                        <td style="height: 1px;">
                                            <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                                <tr>
                                                    <td>
                                                        <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" valign="" class="r14-i" height="1"
                                                            style="border-top-style: solid; background-clip: border-box; border-top-color: #4A4A4A; border-top-width: 1px; font-size: 1px; line-height: 1px;">
                                                            <tr>
                                                                <td height="0" style="font-size: 0px; line-height: 0px;">­</td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </tr>
                            <tr>
                                <table>
                                    <tr>
                                        <td>
                                            ¿Qué mejoras sugiere en la empresa?
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{ $value->comentario3 }}
                                        </td>
                                    </tr>
                                </table>
                            </tr>
                        @endforeach
                    </table>
                </td>
            </tr>
        </tbody>
    </table>


</body>

</html>
