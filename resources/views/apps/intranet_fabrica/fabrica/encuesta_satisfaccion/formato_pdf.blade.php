{{-- <!DOCTYPE html>
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
                                <img src="https://img.mailinblue.com/2547420/images/rnb/original/63c95df80e1a1a40c40097d0.png"
                                    width="60%" alt="">
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
                    <table width="100%" cellpadding="0" border="0" style="margin-top: 3%; margin-bottom: 3%;">
                        <tr>
                            <td style="height: 1px; font-size: 0px; line-height: 0px; border-top: 1px solid #4A4A4A">
                            </td>
                        </tr>
                    </table>
                    <table cellspacing="0" cellpadding="0" style="margin-top: 2%; margin-bottom: 2%" border="0"
                        width="100%">
                        <tr>
                            <td style="width: 33.33%; text-align: center">CÓDIGO: RG-TH-07</td>
                            <td style="width: 33.33%; text-align: center">VERSIÓN: 05</td>
                            <td style="width: 33.33%; text-align: center">PÁGINA: 1</td>
                        </tr>
                    </table>
                    <table width="100%" cellpadding="0" border="0" style="margin-top: 3%; margin-bottom: 3%;">
                        <tr>
                            <td style="height: 1px; font-size: 0px; line-height: 0px; border-top: 1px solid #4A4A4A">
                            </td>
                        </tr>
                    </table>
                    <table cellspacing="0" cellpadding="0" style="margin-top: 2%; margin-bottom: 2%; font-size: 13px"
                        border="0" width="100%">
                        @foreach ($info as $key => $value)
                            <tr>
                                <td width="130px"><strong>PROCESO:</strong></td>
                                <td>{{ $value->proceso }}</td>
                            </tr>
                            <tr>
                                <td width="130px"><strong>SECCIÓN:</strong></td>
                                <td>{{ $value->seccion }}</td>
                            </tr>
                            <tr>
                                <td width="130px"><strong>TIEMPO EN LA EMPRESA:</strong></td>
                                <td>{{ $value->tiem_empresa }}</td>
                            </tr>
                            <tr>
                                <td width="130px"><strong>FECHA:</strong></td>
                                <td>{{ date('Y-m-d') }}</td>
                            </tr>
                        @endforeach
                    </table>
                    <table width="100%" cellpadding="0" border="0" style="margin-top: 3%; margin-bottom: 3%;">
                        <tr>
                            <td style="height: 1px; font-size: 0px; line-height: 0px; border-top: 1px solid #4A4A4A">
                            </td>
                        </tr>
                    </table>
                    <table cellspacing="0" cellpadding="0" style="margin-top: 2%; margin-bottom: 2%" border="0"
                        width="100%">
                        <tr>
                            <td width="40%"><strong>OBJETIVO:</strong><br>
                                <p style="text-align: justify">Medir el nivel de satisfacción del personal interno a
                                    fin de identificar
                                    y determinar fortalezas y debilidades de la empresa con sus colaboradores
                                    de manera que ayude a generar estratégias para incrementar su satisfacción y
                                    por ende la productividad general.</p>
                            </td>
                            <td width="10%"></td>
                            <td width="40%"><strong>INSTRUCCIONES:</strong><br>
                                <p style="text-align: justify">Lea atentamente cada uno de los puntos y califique el
                                    factor mencionado de 1 a 5, donde 1
                                    es la calificación más baja y 5 es la calificación más alta, conforme a su
                                    percepción general de la empresa.
                                </p>
                            </td>
                        </tr>
                    </table>
                    <table width="100%" cellpadding="0" border="0" style="margin-top: 3%; margin-bottom: 3%;">
                        <tr>
                            <td style="height: 1px; font-size: 0px; line-height: 0px; border-top: 1px solid #4A4A4A">
                            </td>
                        </tr>
                    </table>
                    <table cellspacing="0" cellpadding="0" style="margin-top: 2%; margin-bottom: 2%" border="0"
                        width="100%">
                        <tr>
                            <p><u>PREGUNTAS Y PUNTUACIÓN</u></p>
                        </tr>
                        <tr>
                            <table width="100%" cellpadding="0" border="0"
                                style="margin-top: 3%; margin-bottom: 3%;">
                                <tr>
                                    <td
                                        style="height: 1px; font-size: 0px; line-height: 0px; border-top: 1px solid #4A4A4A">
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
                            <table width="100%" cellpadding="0" border="0"
                                style="margin-top: 3%; margin-bottom: 3%;">
                                <tr>
                                    <td
                                        style="height: 1px; font-size: 0px; line-height: 0px; border-top: 1px solid #4A4A4A">
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
                            <table width="100%" cellpadding="0" border="0"
                                style="margin-top: 3%; margin-bottom: 3%;">
                                <tr>
                                    <td
                                        style="height: 1px; font-size: 0px; line-height: 0px; border-top: 1px solid #4A4A4A">
                                    </td>
                                </tr>
                            </table>
                        </tr>
                        @foreach ($info as $key => $value)
                            <tr>
                                <table>
                                    <tr>
                                        <td>
                                            ¿Esta dispuesto a participar en actividades de integración en horarios
                                            adicionales?
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
                                <table width="100%" cellpadding="0" border="0"
                                    style="margin-top: 3%; margin-bottom: 3%;">
                                    <tr>
                                        <td
                                            style="height: 1px; font-size: 0px; line-height: 0px; border-top: 1px solid #4A4A4A">
                                        </td>
                                    </tr>
                                </table>
                            </tr>
                            <tr>
                                <table>
                                    <tr>
                                        <td>
                                            ¿Que actividades de integración sugiere?
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
                                <table width="100%" cellpadding="0" border="0"
                                    style="margin-top: 3%; margin-bottom: 3%;">
                                    <tr>
                                        <td
                                            style="height: 1px; font-size: 0px; line-height: 0px; border-top: 1px solid #4A4A4A">
                                        </td>
                                    </tr>
                                </table>
                            </tr>
                            <tr>
                                <table>
                                    <tr>
                                        <td>
                                            ¿Que habilidades posee (cantar, bailar, juegar, etc.)?
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{ $value->comentario3 }}
                                        </td>
                                    </tr>
                                </table>
                            </tr>
                            <tr>
                                <table width="100%" cellpadding="0" border="0"
                                    style="margin-top: 3%; margin-bottom: 3%;">
                                    <tr>
                                        <td
                                            style="height: 1px; font-size: 0px; line-height: 0px; border-top: 1px solid #4A4A4A">
                                        </td>
                                    </tr>
                                </table>
                            </tr>
                            <tr>
                                <table>
                                    <tr>
                                        <td>
                                            ¿Qué mejoras sugiere para la empresa?
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{ $value->comentario4 }}
                                        </td>
                                    </tr>
                                </table>
                            </tr>
                            <tr>
                                <table width="100%" cellpadding="0" border="0"
                                    style="margin-top: 3%; margin-bottom: 3%;">
                                    <tr>
                                        <td
                                            style="height: 1px; font-size: 0px; line-height: 0px; border-top: 1px solid #4A4A4A">
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

</html> --}}

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body {
            font-size: 12px;
        }

        .page-break {
            page-break-after: always;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 5px;
        }

        .divider {
            height: 1px;
            font-size: 0px;
            line-height: 0px;
            border-top: 1px solid #4A4A4A;
            margin-top: 3%;
            margin-bottom: 3%;
        }

        .centered {
            text-align: center;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <td width="50%">
                <img src="https://img.mailinblue.com/2547420/images/rnb/original/63c95df80e1a1a40c40097d0.png"
                    width="60%" alt="Logo">
            </td>
            <td width="50%" class="centered" style="font-size: 19px;">
                ENCUESTA DE SATISFACCIÓN DEL CLIENTE INTERNO
            </td>
        </tr>
    </table>

    <div class="divider"></div>

    <table>
        <tr>
            <td class="centered"><b>CÓDIGO: RG-TH-07</b></td>
            <td class="centered"><b>VERSIÓN: 06</b></td>
            <td class="centered"><b>PÁGINA: 1</b></td>
        </tr>
    </table>

    <div class="divider"></div>

    <table>
        @foreach ($info as $key => $value)
            <tr>
                <td width="130px"><strong>PROCESO:</strong></td>
                <td>{{ $value->proceso }}</td>
            </tr>
            <tr>
                <td><strong>SECCIÓN:</strong></td>
                <td>{{ $value->seccion }}</td>
            </tr>
            <tr>
                <td><strong>TIEMPO EN LA EMPRESA:</strong></td>
                <td>{{ $value->tiem_empresa }}</td>
            </tr>
            <tr>
                <td><strong>FECHA:</strong></td>
                <td>{{ date('Y-m-d') }}</td>
            </tr>
        @endforeach
    </table>

    <div class="divider"></div>

    <table>
        <tr>
            <td width="40%"><strong>OBJETIVO:</strong><br>
                <p style="text-align: justify;">Medir el nivel de satisfacción del personal interno a
                    fin de identificar
                    y determinar fortalezas y debilidades de la empresa con sus colaboradores
                    de manera que ayude a generar estratégias para incrementar su satisfacción y
                    por ende la productividad general.</p>
            </td>
            <td width="10%"></td>
            <td width="40%"><strong>INSTRUCCIONES:</strong><br>
                <p style="text-align: justify;">Lea atentamente cada uno de los puntos y califique el
                    factor mencionado de 1 a 5, donde 1
                    es la calificación más baja y 5 es la calificación más alta, conforme a su
                    percepción general de la empresa.</p>
            </td>
        </tr>
    </table>

    <div class="divider"></div>

    <p class="centered"><u><b>PREGUNTAS Y PUNTUACIÓN</b></u></p>

    <table>
        <tr>
            <td width="2%"><b>#</b></td>
            <td class="centered" width="76%"><b>PREGUNTA</b></td>
            <td class="centered" width="10%"><b>CALIFICACIÓN</b></td>
        </tr>
        @foreach ($preguntas as $val)
            <tr>
                <td>{{ $val->id_pregunta }}-</td>
                <td>{{ $val->pregunta }}</td>
                <td class="centered">{{ $val->respuesta }}</td>
            </tr>
        @endforeach
    </table>

    <div class="divider"></div>

    <table>
        @foreach ($info as $value)
            <tr>
                <td class="centered"><b>¿Esta dispuesto a participar en actividades...?</b></td>
            </tr>
            <tr>
                <td>{{ $value->comentario1 ?? "N/A" }}</td>
            </tr>
            <tr>
                <td class="centered"><b>¿Qué actividades de integración sugiere?</b></td>
            </tr>
            <tr>
                <td>{{ $value->comentario2 ?? "N/A" }}</td>
            </tr>
            <tr>
                <td class="centered"><b>¿Qué habilidades posee?</b></td>
            </tr>
            <tr>
                <td>{{ $value->comentario3 ?? "N/A" }}</td>
            </tr>
            <tr>
                <td class="centered"><b>¿Qué mejoras sugiere para la empresa?</b></td>
            </tr>
            <tr>
                <td>{{ $value->comentario4 ?? "N/A" }}</td>
            </tr>
        @endforeach
    </table>

</body>

</html>
