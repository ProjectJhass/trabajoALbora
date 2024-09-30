@extends('apps.crm_almacenes.gcp.plantilla.app')
@section('title')
    Liquidador intereses
@endsection
@section('header')
@endsection
@section('intereses')
    active
@endsection
@section('contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Liquidador de intereses</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item text-blue">Gcp</li>
                        <li class="breadcrumb-item active">Liquidador</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-outline card-danger">
                        <div class="card-body">
                            <form id="formulario-valores-liquidador" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="">Plan</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-sort-numeric-down"></i></div>
                                        </div>
                                        <select name="plan" id="plan" class="form-control" required>
                                            <option value="">Seleccionar...</option>
                                            @for ($i = 1; $i <= 30; $i++)
                                                <option value="{{ $i }}">{{ $i }}F</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Valor cuota</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-hand-holding-usd"></i></div>
                                        </div>
                                        <input type="number" name="cuota" id="cuota" min="0" class="form-control" placeholder="Valor"
                                            required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Fecha vencimiento</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                                        </div>
                                        <input type="date" name="fecha_v" class="form-control" id="fecha_v" placeholder="Username" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Couta vencida</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-sort-numeric-down"></i></div>
                                        </div>
                                        <select name="cuota_v" id="cuota_v" class="form-control" required>
                                            <option value="">Seleccionar...</option>
                                            @for ($i = 1; $i <= 24; $i++)
                                                <option value="{{ $i }}">{{ $i }}F</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <center>
                                    <button type="button" class="btn btn-danger"
                                        onclick="ConsultarValoresLiquidador('formulario-valores-liquidador')">Calcular</button>
                                </center>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-outline card-secondary">
                        <div class="card-body">
                            <table class="table table-bordered table-sm">
                                <thead>
                                    <tr class="text-center" style="background-color: #c22121; color: white;">
                                        <th>Cuota</th>
                                        <th>Valor Cuota</th>
                                        <th>N° Dias</th>
                                        <th>Cuota Dif</th>
                                        <th>Vlr Intereses</th>
                                        <th>SI/NO</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center" id="informacion-liquidador-tabla"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-outline card-success">
                        <div class="card-body">
                            <div class="info-box mb-3 bg-warning">
                                <span class="info-box-icon"><i class="fas fa-money-check-alt"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Valor Capital</span>
                                    <span class="info-box-number">$ <span id="vlr_capital_liq">0</span></span>
                                </div>
                            </div>
                            <div class="info-box mb-3 bg-danger">
                                <span class="info-box-icon"><i class="fas fa-coins"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Valor intereses</span>
                                    <span class="info-box-number">$ <span id="vlr_intereses_liq">0</span></span>
                                </div>
                            </div>
                            <div class="info-box mb-3 bg-success">
                                <span class="info-box-icon"><i class="fas fa-hand-holding-usd"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Total a pagar</span>
                                    <span class="info-box-number">$ <span id="vlr_total_a_pagar_liq">0</span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('footer')
    <script>
        ConsultarValoresLiquidador = (form) => {
            loandingPanel()
            var formData = new FormData(document.getElementById(form));
            formData.append('dato', 'valor');

            var datos = $.ajax({
                url: "{{ route('calcular.interes.liq') }}",
                type: "POST",
                dataType: "json",
                data: formData,
                cache: false,
                contentType: false,
                processData: false
            });
            datos.done((res) => {
                loadedPanel()
                document.getElementById('informacion-liquidador-tabla').innerHTML = res.tabla;
                ValoresTotalesLiq();
            })
            datos.fail(() => {
                loadedPanel()
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Hubo un problema al procesar la solicitud',
                    showConfirmButton: false,
                    timer: 1500
                })
            })
        }

        ValoresTotalesLiq = () => {
            var total_capital = 0;
            var total_intereses = 0;
            var total_a_pagar = 0;

            $('input[type=checkbox]:checked').each(function() {
                var capital = parseInt($('#valor' + $(this).val()).text().replace('$ ', '').replace('$ ', '').replace(',', '').replace('.',
                    '').replace(',', '').replace('.', ''));
                var intereses = parseInt($('#interes' + $(this).val()).text().replace('$ ', '').replace('$ ', '').replace(',', '').replace(
                    '.', '').replace(',', '').replace('.', ''));
                total_capital += capital;
                total_intereses += intereses;
            });
            total_a_pagar = total_capital + total_intereses;
            document.getElementById('vlr_capital_liq').innerHTML = new Intl.NumberFormat("es-CO").format(total_capital);
            document.getElementById('vlr_intereses_liq').innerHTML = new Intl.NumberFormat("es-CO").format(total_intereses);
            document.getElementById('vlr_total_a_pagar_liq').innerHTML = new Intl.NumberFormat("es-CO").format(total_a_pagar);
        }


        ValidarValorDiferencia = (id_cuota, valor_cuota) => {

            var fecha_v = $('#fecha_v').val();
            var val_cuota = $('#cuota').val();
            if (valor_cuota.length > 0) {
                val_cuota = valor_cuota;
            }

            var datos = $.ajax({
                url: "{{ route('calcular.diferencia.liq') }}",
                type: "POST",
                dataType: "json",
                data: {
                    valor_cuota: val_cuota,
                    fecha_v
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            datos.done((res) => {
                if (res.status == true) {
                    document.getElementById('valor' + id_cuota).innerHTML = "$ " + new Intl.NumberFormat("es-CO").format(res.valor_c)
                    document.getElementById('dias' + id_cuota).innerHTML = res.num_dias
                    document.getElementById('interes' + id_cuota).innerHTML = "$ " + new Intl.NumberFormat("es-CO").format(res.intereses)

                    ValoresTotalesLiq();
                }
            });
            datos.fail(() => {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Hubo un problema al procesar la solicitud',
                    showConfirmButton: false,
                    timer: 1500
                })
            })
        }

        PagarCuotaExtra = (id_cuota, cuota) => {

            if ($('#checkbox' + id_cuota).prop('checked')) {

                var fecha_v = $('#fecha_v').val();
                var valor_cuota = $('#cuota').val();
                var cuota_v = $('#cuota_v').val();

                var datos = $.ajax({
                    url: "{{ route('calcular.nueva.cuota') }}",
                    type: "POST",
                    dataType: "json",
                    data: {
                        valor_cuota,
                        fecha_v,
                        cuota_v,
                        id_cuota,
                        cuota
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                datos.done((res) => {
                    if (res.status == true) {
                        document.getElementById('valor' + id_cuota).innerHTML = "$ " + new Intl.NumberFormat("es-CO").format(res.valor_c)
                        document.getElementById('dias' + id_cuota).innerHTML = res.num_dias
                        document.getElementById('interes' + id_cuota).innerHTML = "$ " + new Intl.NumberFormat("es-CO").format(res.intereses)
                        ValoresTotalesLiq();
                    }
                });
                datos.fail(() => {
                    $('#checkbox' + id_cuota).prop('checked', false);
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Hubo un problema al procesar la solicitud',
                        showConfirmButton: false,
                        timer: 1500
                    })
                })
            } else {
                document.getElementById('dias' + id_cuota).innerHTML = ''
                document.getElementById('interes' + id_cuota).innerHTML = ''
                ValoresTotalesLiq();
            }
        }
    </script>
@endsection
