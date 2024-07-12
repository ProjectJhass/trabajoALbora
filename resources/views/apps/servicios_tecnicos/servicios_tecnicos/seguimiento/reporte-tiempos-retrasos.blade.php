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
                <div>
                    @php
                        $dias = $data->dias;
                        $diferencia = $data->transcurrido;
                        $retraso = $data->retraso;
                    @endphp
                    <p>Feliz dia</p>
                    <p>Queremos informarle que la solicitud <b>Número #{{ $data->id_st }}</b> ha excedido el tiempo
                        límite de
                        respuesta
                        establecido para la etapa <b> {{ $data->etapa }}</b>. A continuación, encontrará los detalles:
                    </p>
                </div>
                <div class=" my-4 text-center"
                    style="width: 100%;position: relative;display: flex;flex-direction: row;justify-content: space-between;align-items:center;">
                    <p class="m-0">
                        {{ $data->id_st }}
                    </p>
                    <div class="id_etapa d-none" style="box-sizing: border-box;width: 5%; display: none">
                        {{ $data->id_st }}</div>
                    <div class="etapas"
                        style="width: 95%;position: relative;display: flex;align-items: center;justify-content: space-between;">
                        <progress id="bar" class="progressbar bg-info" value=0 max=100></progress>
                        @for ($i = 1; $i <= 7; $i++)
                            <div class="etapa"
                                style="display: flex;flex-direction: column;align-items: center;justify-content: center;width: 132px;z-index: 10;">
                                <button data-days="{{ $data->dias ?? '' }}" data-id="{{ $data->id_etapa ?? '' }}"
                                    data-diff="{{ $data->diferencia ?? '' }}" data-stage="{{ $data->etapa ?? '' }}"
                                    id="btn_{{ "$i" }}" class="step-btn text-center" type="button"
                                    data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                                    aria-controls="collapseOne">
                                    {{ "$i" }}
                                </button>
                            </div>
                        @endfor
                    </div>
                </div>
                <div>
                    <ul>
                        <li><b>Número de Solicitud:</b> {{ $data->id_st }}.</li>
                        <li><b>Etapa:</b> {{ $data->etapa }}.</li>
                        <li><b>Fecha Inicio Etapa:</b> {{ $data->fecha_inicial }}.</li>
                        <li><b>Tiempo limite respuesta:</b> {{ $dias }} dias.</li>
                        <li><b>Tiempo transcurrido:</b> {{ $diferencia }} dias.</li>
                        <li><b>Tiempo de retraso:</b> {{ $retraso }} dias.</li>
                    </ul>
                </div>
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

    #btn_{{$data->id_etapa}} {
        background-color: #ff3e1d;
        border : 2px solid #a7a7ba;
        color : white;
    }
</style>

{{-- <script>
    addEventListener("DOMContentLoaded", (event) => {
        formatODT = (element, id_st) => {
            const odt = [];
            Array.from(element.childNodes).filter(node => node.nodeType === 1)
                .forEach((el) => {
                    if (el.firstElementChild && el.firstElementChild.id) {
                        let dataHolder = el.firstElementChild.dataset;
                        if (dataHolder.id !== "" && dataHolder.stage !== "" && dataHolder.days !== "" &&
                            dataHolder
                            .diff !== "") {
                            odt.push({
                                id_st: id_st,
                                id: parseInt(dataHolder.id),
                                etapa: dataHolder.stage,
                                dias: parseInt(dataHolder.days),
                                diferencia: parseInt(dataHolder.diff),
                            });
                        }
                    } else {
                        // console.log("Do nothing.");
                    }
                });
            return odt;
        };
        const steps = document.querySelectorAll('.etapas');
        Array.from(steps).forEach(async (step) => {
            const id_st = step.previousElementSibling.innerText;
            const odt = formatODT(step, id_st);
            const bar = document.getElementById(`bar`);
            const maxID = (odt.reduce((maxId, etapa) => Math.max(etapa.id, maxId), -Infinity));
            const progress = (maxID - 1) * 100 / (7 - 1);
            bar.setAttribute('value', progress);
            const btns = step.querySelectorAll('.etapa');
            btns.forEach((button, index) => {
                button = button.firstElementChild;
                if (index + 1 <= maxID) {
                    const etapa = odt.find(etapa => etapa.id === index + 1);
                    if (etapa) {
                        const dias = parseInt(etapa.dias);
                        const transcurrido = etapa.diferencia;
                        button.style.border = "2px solid #a7a7ba";
                        button.style.color = "white";
                        button.style.background = "#ff3e1d";
                    } else {
                        button.style.background = "#a7a7ba";
                    }
                } else {
                    button.style.color = "#666666";
                }
            });
        });
    });
</script> --}}
