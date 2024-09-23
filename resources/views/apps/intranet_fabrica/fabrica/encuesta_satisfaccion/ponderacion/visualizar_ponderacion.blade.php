{{-- <pre>
@php
    print_r($data_ponderacion);
@endphp
</pre> --}}


<table class="table table-hover">
    <thead class="bg-danger text-center">
        <tr>
            <th>Categoria Preguntas</th>
            @foreach ($data_ponderacion as $key_seccion => $value_seccion)
                <th>{{ $key_seccion }} <br> N:
                    {{ $value_seccion['ÁREA DE TRABAJO']['cantidad_personas_respondieron'] }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody class="text-center">
        @foreach ($preguntas_ponderacion as $key_pre_ponderacion => $value_pre_ponderacion)
            <tr>
                <td>{{ $value_pre_ponderacion }} (<b class="text-danger">16.6%</b>)</td>
                @foreach ($data_ponderacion as $key_seccion => $value_seccion)
                    @if (isset($value_seccion[$value_pre_ponderacion]))
                        <td>(CL: <b class="text-danger">{{ $value_seccion[$value_pre_ponderacion]['total_media'] }}</b>)(PD:<b class="text-danger">{{ $value_seccion[$value_pre_ponderacion]['total_ponderado'] > 16.6 ? 16.6 : $value_seccion[$value_pre_ponderacion]['total_ponderado'] }}</b>%)
                        </td>
                    @endif
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
