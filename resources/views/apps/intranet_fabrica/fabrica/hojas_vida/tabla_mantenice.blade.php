<div class="table-responsive-sm">
    <table class="table shadow rounded" id="history_tables">
        <thead class="bg-danger" id="tablita">
            <tr>
                <th scope="col">Referencia</th>
                <th scope="col">Nombre</th>
                <th scope="col">Observación</th>
                @php
                    $nombre = $rol == 1 ? 'Responsable' : 'Creador';
                @endphp

                <th scope="col">{{ $nombre }}</th>
                <th scope="col">Fecha</th>
                <th scope="col">Editar</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($mantenimientos as $item)
                @php

                    if ($rol === 1) {
                        $fecha = $item['fecha_mantenimiento'];
                        if ($fecha >= $hoy && $item['estado'] == 'programado') {
                            $info = 'btn btn-success';
                            $icono = '<i class="fas fa-edit"></i>';
                        }
                        if ($fecha < $hoy && $item['estado'] != 'programado') {
                            $info = 'btn btn-danger';
                            $icono = '<i class="fas fa-ban"></i>';
                        }

                        if ($fecha < $hoy && $item['estado'] == 'programado') {
                            $info = 'btn btn-warning';
                            $icono = '<i class="fas fa-exclamation-triangle"></i>';
                        }

                        $modal = $info === 'btn btn-danger' ? 'false' : 'modal';
                    } else {
                        $modali = 'modalAceptacion';
                    }

                @endphp

                @if ($rol === 1)
                    <tr>


                        <td>{{ $item['referencia'] }}</td>
                        <td>{{ $item['nombre_maquina'] }}</td>
                        <td>{{ $item['observacion'] }}</td>
                        <td>{{ $item['responsable'] }}</td>
                        <td>{{ $item['fecha_mantenimiento'] }}</td>

                        {{-- BOTON DE EDICIÓN o DE ACEPTACION DE MANTENIMIENTO --}}

                        <td>

                            @if ($rol === 1)
                                <a type="button" class="{{ $info }}" data-toggle="{{ $modal }}"
                                    id="boton_{{ $item['id_mantenimiento'] }}"
                                    onclick="chargeMantenice('{{ route('charge.mantenice') }}','{{ $item['id_mantenimiento'] }}'),validacion('{{ $modal }}')"
                                    data-target="#modal" data-button="{{ $info }}">{!! $icono !!}</a>
                            @else
                                @if ($hoy <= $item['fecha_mantenimiento'])
                                    <button class="btn btn-success"data-toggle="modal"
                                        data-target="#{{ $modali }}"
                                        onclick="chargeInfo('{{ route('user.mantenice') }}', '{{ $item['id_mantenimiento'] }}')"><i
                                            class="fas fa-user-check"></i></button>
                                @elseif($hoy > $item['fecha_mantenimiento'] && $hoy <= $item['extemporaneo'])
                                    <button class="btn btn-warning"data-toggle="modal"
                                        data-target="#{{ $modali }}"
                                        onclick="chargeInfo('{{ route('user.mantenice') }}', '{{ $item['id_mantenimiento'] }}')"><i
                                            class="fas fa-exclamation-triangle"></i></button>
                                @endif
                            @endif


                        </td>
                    </tr>
                @else
                    @if ($hoy <= $item['extemporaneo'])
                        <tr>


                            <td>{{ $item['referencia'] }}</td>
                            <td>{{ $item['nombre_maquina'] }}</td>
                            <td>{{ $item['observacion'] }}</td>
                            <td>{{ $item['responsable'] }}</td>
                            <td>{{ $item['fecha_mantenimiento'] }}</td>

                            {{-- BOTON DE EDICIÓN o DE ACEPTACION DE MANTENIMIENTO --}}

                            <td>

                                @if ($rol === 1)
                                    <a type="button" class="{{ $info }}" data-toggle="{{ $modal }}"
                                        id="boton_{{ $item['id_mantenimiento'] }}"
                                        onclick="chargeMantenice('{{ route('charge.mantenice') }}','{{ $item['id_mantenimiento'] }}'),validacion('{{ $modal }}')"
                                        data-target="#modal"
                                        data-button="{{ $info }}">{!! $icono !!}</a>
                                @else
                                    @if ($hoy <= $item['fecha_mantenimiento'])
                                        <button class="btn btn-success"data-toggle="modal"
                                            data-target="#{{ $modali }}"
                                            onclick="chargeInfo('{{ route('user.mantenice') }}', '{{ $item['id_mantenimiento'] }}')"><i
                                                class="fas fa-user-check"></i></button>
                                    @elseif($hoy > $item['fecha_mantenimiento'] && $hoy <= $item['extemporaneo'])
                                        <button class="btn btn-warning"data-toggle="modal"
                                            data-target="#{{ $modali }}"
                                            onclick="chargeInfo('{{ route('user.mantenice') }}', '{{ $item['id_mantenimiento'] }}')"><i
                                                class="fas fa-exclamation-triangle"></i></button>
                                    @endif
                                @endif


                            </td>
                        </tr>
                    @endif
                @endif
            @endforeach
        </tbody>

    </table>
</div>
