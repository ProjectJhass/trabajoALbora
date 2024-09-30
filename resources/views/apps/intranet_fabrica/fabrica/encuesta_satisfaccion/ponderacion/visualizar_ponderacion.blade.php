<table class="table table-hover">
    <thead class="bg-danger text-center">
        <tr>
            <th>Categoria Preguntas</th>
            @foreach (array_values($result_ponderacion)[1] as $key_pon => $value_pon)
                <th>{{ $key_pon }} <br> N:
                    {{ $value_pon['ÁREA DE TRABAJO']['resultados']['cantidad_personas_respondieron_encuesta'] }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody class="text-center">
        @foreach ($preguntas_ponderacion as $key_pre_ponderacion => $value_pre_ponderacion)
            <tr>
                <td>{{ $value_pre_ponderacion }} (<b class="text-danger">16.6%</b>)</td>
                @foreach (array_values($result_ponderacion)[1] as $key_seccion => $value_seccion)
                    @if (isset($value_seccion[$value_pre_ponderacion]))
                        <td class="result_section_{{ $key_seccion }}"
                            data-porcentajeSectionPegSumado="{{ round($value_seccion[$value_pre_ponderacion]['resultados']['porcentaje_seccion_pregunta_sumado'], 1) > 16.6 ? 16.6 : round($value_seccion[$value_pre_ponderacion]['resultados']['porcentaje_seccion_pregunta_sumado'], 1) }}">
                            (CL: <b
                                class="text-danger">{{ round($value_seccion[$value_pre_ponderacion]['resultados']['porcentaje_respuestas_sumado'], 2) }}</b>)
                            (PD:<b
                                class="text-danger">{{ round($value_seccion[$value_pre_ponderacion]['resultados']['porcentaje_seccion_pregunta_sumado'], 1) > 16.6 ? 16.6 : round($value_seccion[$value_pre_ponderacion]['resultados']['porcentaje_seccion_pregunta_sumado'], 1) }}</b>%)
                        </td>
                    @endif
                @endforeach
            </tr>
        @endforeach
    </tbody>
    <tfoot class="text-center">
        <tr>
            <th>Resultados</th>
            @foreach (array_values($result_ponderacion)[1] as $key_pon => $value_pon)
                <th>
                    <strong id="load_value_result_pon_{{ $key_pon }}"></strong>
                </th>
            @endforeach
        </tr>
        <tr>
            <th></th>
            @foreach (array_values($result_ponderacion)[1] as $key_pon => $value_pon)
                <th id="content_words_result_pon_{{ $key_pon }}">
                    <strong id="load_words_result_pon_{{ $key_pon }}"></strong>
                </th>
            @endforeach
        </tr>
    </tfoot>
</table>

<br>
<hr>
<div class="d-flex justify-content-center">
    <button onclick="download_excel_data_export_ponderacion()" class="btn btn-outline-danger w-50"><i
            class="fas fa-file-excel"></i> - Descargar Ponderación</button>
</div>
<br>

<script>
    $(document).ready(function() {
        let sections = @json(array_values($result_ponderacion)[1]);

        Object.keys(sections).forEach(function(key) {
            let className = '.result_section_' + key;
            let totalSum = 0;

            $(className).each(function() {
                let percentage = parseFloat($(this).attr('data-porcentajeSectionPegSumado'));
                if (!isNaN(percentage)) {
                    totalSum += percentage;
                }
            });
            $(`#load_value_result_pon_${key}`).text(Math.round(totalSum) + '%')
            percentage_words_in_table(key, totalSum);
        });
    });

    function percentage_words_in_table(key, totalSum) {
        if (totalSum >= 95) {
            $(`#content_words_result_pon_${key}`).css('background-color', '');
            $(`#content_words_result_pon_${key}`).addClass('bg-success');
            $(`#load_words_result_pon_${key}`).text('Supera lo esperado');
        } else if (totalSum < 95 && totalSum >= 80) {
            $(`#content_words_result_pon_${key}`).css('background-color', '');
            $(`#content_words_result_pon_${key}`).addClass('bg-warning');
            $(`#load_words_result_pon_${key}`).text('Cumple lo esperado');
        } else if (totalSum < 80 && totalSum >= 70) {
            $(`#content_words_result_pon_${key}`).css('background-color', '');
            $(`#content_words_result_pon_${key}`).css('background-color', '#FFA500');
            $(`#load_words_result_pon_${key}`).text('No cumple lo esperado');
        } else if (totalSum < 70) {
            $(`#content_words_result_pon_${key}`).css('background-color', '');
            $(`#content_words_result_pon_${key}`).addClass('bg-danger');
            $(`#load_words_result_pon_${key}`).text('No cumple lo esperado');
        }
    }

    function download_excel_data_export_ponderacion() {
        let proceso_seleccionado = '{{ $proceso_seleccionados }}';

        $.ajax({
            beforeSend: function() {
                beforeSendFunction();
            },
            type: "POST",
            url: "{{ route('intranet_fabrica.encuestas_satisfaccion_ponderacion.get_excel_export') }}",
            data: {
                "data_exception": @json(array_values($result_ponderacion)),
                "proceso": proceso_seleccionado
            },
            xhrFields: {
                responseType: 'blob'
            },
            success: function(response, status, xhr) {
                Swal.close();
                let today = new Date();
                let today_form = `${today.getFullYear()}-${String(today.getMonth() + 1).padStart(2, '0')}-${String(today.getDate()).padStart(2, '0')}`;
                // Obtener el nombre de archivo desde los headers de la respuesta
                var filename = "";
                var disposition = xhr.getResponseHeader('Content-Disposition');
                if (disposition && disposition.indexOf('attachment') !== -1) {
                    var filenameRegex = /filename[^;=\n]=((['"]).?\2|[^;\n]*)/;
                    var matches = filenameRegex.exec(disposition);
                    if (matches != null && matches[1]) {
                        filename = matches[1].replace(/['"]/g, '');
                    }
                }

                // Crear un enlace para descargar el archivo Blob
                var link = document.createElement('a');
                var url = window.URL.createObjectURL(response);
                link.href = url;
                link.download = filename || `ponderacion_${today_form}.xlsx`;
                document.body.appendChild(link);
                link.click();

                // Limpiar el enlace temporal
                window.URL.revokeObjectURL(url);
                document.body.removeChild(link);
            }
        });
    }
</script>
