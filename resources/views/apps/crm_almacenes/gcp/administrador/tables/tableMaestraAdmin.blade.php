@php
    $date_d = date('d'); // Día actual
    $date_m = date('m'); // Mes actual

    // Array de nombres de meses en español
    $meses = [
        '01' => 'Enero',
        '02' => 'Febrero',
        '03' => 'Marzo',
        '04' => 'Abril',
        '05' => 'Mayo',
        '06' => 'Junio',
        '07' => 'Julio',
        '08' => 'Agosto',
        '09' => 'Septiembre',
        '10' => 'Octubre',
        '11' => 'Noviembre',
        '12' => 'Diciembre',
    ];
@endphp

<style>
    /*Oportunidad*/
    .start11 {
        color: red
    }

    .start21 {
        color: gray
    }

    .start31 {
        color: gray
    }

    /*Prospecto*/
    .start12 {
        color: red
    }

    .start22 {
        color: red
    }

    .start32 {
        color: gray
    }

    /*Efectivo*/
    .start13 {
        color: red
    }

    .start23 {
        color: red
    }

    .start33 {
        color: red
    }
</style>
<form id="formDeleteClientsMaestra">
    @csrf
    <table class="table table-bordered table-sm" id="clientes-maestra-general-admin">
        <thead>
            <tr class="text-center" style="font-size: 14px; background-color: #c22121; color: white;">
                <th><input type="checkbox" onchange="ActualizarValoresCheck()" id="checkSelectTodos"> <i
                        class="fas fa-mouse-pointer"></i></th>
                <th hidden>Eliminar</th>
                <th>#</th>
                <th>Tipo</th>
                <th>Cédula</th>
                <th>Cliente</th>
                <th>Fecha creación</th>
                <th>Próxima llamada</th>
                <th>Fecha Cumpleaños</th>
                <th>Ciudad</th>
                <th>Celular</th>
                <th>Productos</th>
                <th>Comentarios</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody style="font-size: 15px">
            <?php $data = ['1', '2', '3']; ?>
            @foreach ($clientes as $key => $value)
                <?php $nombre_c = trim($value->nombre_1 . ' ' . $value->nombre_2 . ' ' . $value->apellido_1 . ' ' . $value->apellido_2); ?>
                <tr>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="declinarCliente[]"
                                id="declinar{{ $value->id_cliente }}" value="{{ $value->id_cliente }}">
                        </div>
                    </td>
                    <td hidden>{{ in_array($value->tipo_cliente, $data) ? '' : 'Declinar' }}</td>
                    <td>{{ $value->id_cliente }} <?php echo $value->estado == 2 ? '<span class="badge badge-pill badge-info">Preferencial</span>' : ''; ?></td>
                    <td style="cursor: pointer">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <i class="fas fa-star start1{{ $value->tipo_cliente }} star{{ $value->id_cliente }}"
                                id="cl{{ $value->id_cliente }}1"
                                onclick="validarEstella('1', '{{ $value->id_cliente }}')" title="Oportunidad"></i>
                            <i class="fas fa-star start2{{ $value->tipo_cliente }} star{{ $value->id_cliente }}"
                                id="cl{{ $value->id_cliente }}2"
                                onclick="validarEstella('2', '{{ $value->id_cliente }}')" title="Prospecto"></i>
                            <i class="fas fa-star start3{{ $value->tipo_cliente }} star{{ $value->id_cliente }}"
                                id="cl{{ $value->id_cliente }}3"
                                onclick="validarEstella('3', '{{ $value->id_cliente }}')" title="Efectivo"></i>
                        </div>
                    </td>
                    <td id="cedula{{ $value->id_cliente }}">{{ $value->cedula_cliente }}</td>
                    <td id="cliente{{ $value->id_cliente }}" data-nombre="{{ $nombre_c }}">{{ $nombre_c }}
                    </td>
                    <td class="text-center">{{ $value->fecha_registro }}</td>
                    <td class="text-center" id="llamar{{ $value->id_cliente }}">
                        @foreach ($value->llamadasPendientes as $item)
                            {{ $item->fecha_a_llamar }}
                        @endforeach
                    </td>
                    <td class="text-center" id="llamar{{ $value->id_cliente }}">
                        @if ($value->fecha_cumple)
                            @if ($value->fecha_cumple != '1990-01-01')
                                @php
                                    // Lógica para dividir la fecha
                                    $fecha = explode('-', $value->fecha_cumple);

                                    // Día y mes del cumpleaños
                                    $cumple_d = $fecha[2];
                                    $cumple_m = $fecha[1];

                                    // Obtener el nombre del mes
                                    $mes_nombre = $meses[$cumple_m] ?? 'Desconocido';

                                    // Verificamos si el cumpleaños aún no ha pasado este año
                                    $validate = !($cumple_m > $date_m || ($cumple_m == $date_m && $cumple_d > $date_d));
                                @endphp

                                @if (!$validate)
                                    {{ $mes_nombre . ' - ' . $cumple_d }}
                                @else
                                    {{ $mes_nombre . ' - ' . $cumple_d }}
                                    <br>
                                    @if ($value->cumpleanosEnviados->isNotEmpty())
                                        <span class="badge badge-danger">Gestionado</span>
                                    @else
                                        <span class="badge badge-secondary">No gestionado</span>
                                    @endif
                                @endif
                            @else
                                {{ 'N/A' }}
                            @endif
                        @else
                            {{ 'N/A' }}
                        @endif
                    </td>
                    <td id="ciudad{{ $value->id_cliente }}">{{ $value->ciudad }}</td>
                    <td id="celular{{ $value->id_cliente }}">{{ $value->celular_1 }}</td>
                    <td class="text-center">
                        <div class="nav-item dropdown">
                            <a class="nav-link text-danger" data-toggle="dropdown" href="#">
                                <i class="fas fa-shopping-cart"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-xl dropdown-menu-right">
                                <span class="dropdown-item dropdown-header">Productos</span>
                                <div id="products{{ $value->id_cliente }}">
                                    <div class="dropdown-divider"></div>
                                    @foreach ($value->itemsCotizados as $prod)
                                        <div class="dropdown-item">{{ $prod->producto }}</div>
                                        <div class="dropdown-divider"></div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="text-center">
                        <a class="btn btn-app bg-danger" style="min-width: 30px; height: 45px;"
                            onclick="MostrarComentariosCliente('{{ $value->id_cliente }}')">
                            <span class="badge bg-teal">{{ $value->coment }}</span>
                            <i class="fas fa-comments"></i>
                        </a>
                    <td class="text-center" id="opcionesCliente{{ $value->id_cliente }}">
                        @if ($value->tipo_cliente != '0')
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-sm btn-info" title="Ver información cliente"
                                    onclick="ObtenerInformacionCliente('{{ $value->id_cliente }}')"><i
                                        class="fas fa-eye" style="font-size: 15px"></i></button>
                                <button type="button" class="btn btn-sm btn-primary" title="Programar una llamada"
                                    onclick="AgendarLlamadaCliente('{{ $value->id_cliente }}')"><i
                                        class="fas fa-phone-alt" style="font-size: 15px"></i></button>
                                <a href="{{ route('asesor.whatsapp', ['celular' => empty($value->celular_1) ? 1 : $value->celular_1]) }}"
                                    target="_BLANK" type="button" class="btn btn-sm btn-success"
                                    title="Enviar mensaje al WhatsApp"><i class="fab fa-whatsapp"
                                        style="font-size: 15px"></i></a>
                            </div>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                @if ($value->tipo_cliente == '3')
                                    <button type="button" class="btn btn-sm btn-warning"
                                        id="ventaEfectiva{{ $value->id_cliente }}"
                                        onclick="MarcarVentaEfectivaCliente('{{ $value->id_cliente }}', '{{ $value->cedula_cliente }}')"
                                        title="Marcar venta efectiva"><i class="far fa-money-bill-alt"
                                            style="font-size: 15px"></i></button>
                                @else
                                    <button type="button" class="btn btn-sm btn-warning"
                                        id="ventaEfectiva{{ $value->id_cliente }}"
                                        onclick="VentaEfectivaClienteCrm('{{ $value->id_cliente }}', '{{ $value->cedula_cliente }}')"
                                        title="Marcar venta efectiva"><i class="far fa-money-bill-alt"
                                            style="font-size: 15px"></i></button>
                                @endif
                                <a href="{{ route('send.encuesta.asesor', ['celular' => empty($value->celular_1) ? 1 : $value->celular_1, 'nombre' => empty($nombre_c) ? 'Albura' : $nombre_c]) }}"
                                    target="_BLANK" type="button" class="btn btn-sm btn-secondary"
                                    title="Enviar encuesta de satisfacción"><i class="fas fa-paper-plane"
                                        style="font-size: 15px"></i></a>
                                <button type="button" class="btn btn-sm btn-danger"
                                    onclick="NotificarEliminacionClienteCrmAdmin('{{ $value->id_cliente }}')"
                                    title="Eliminar contacto"><i class="fas fa-trash-alt"
                                        style="font-size: 15px"></i></button>
                            </div>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</form>
