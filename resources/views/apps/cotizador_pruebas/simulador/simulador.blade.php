<div class="row">

    <input hidden value="{{ $total_pagar }}" id="total_pagar_monto" />

    <div class="col-md-4 mb-3">
        <label for="">Monto a financiar</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon3">$</span>
            </div>
            <input type="text" value="{{ number_format($total_pagar, 0, ',', '.') }}" oninput="montosInputValidator()"
                class="form-control" name="monto_credito_simulador" id="monto_credito_simulador">
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <label for="">¿A cuantos meses?</label>
        <select name="cuotas_credito_simulador" onchange="montosInputValidator()" id="cuotas_credito_simulador"
            class="form-control" required>
            <option value="NAN" selected disabled>Seleccione número de cuotas</option>
            <option value="3">3</option>
            <option value="6">6</option>
            <option value="12">12</option>
            <option value="18">18</option>
            <option value="24">24</option>
            <option value="30">30</option>
        </select>
    </div>

    <div class="col-md-4 mt-4">
        <div class="d-flex align-items-center justify-content-center">
            <button class="btn btn-outline-danger" type="button" onclick="calcularValorCredito_()">Simular</button>
        </div>
    </div>


</div>

<div style="display: none" id="hidden_block_simulacion">

    <div class="row">
        <div class="col-12">
            <div class="card m-5">
                <div class="card-header bg-danger">
                    <h5 class="text-center">Resultados</h5>
                </div>
                <div id="cargar_informacion_simulacion">
                    <div class="row">

                        <div class="col m-2">
                            <label for="">Tasa De Interes</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon3">%</span>
                                </div>
                                <input type="text" value="2.17" class="form-control" id="monto_credito_simulador">
                            </div>
                        </div>
                        <div class="col m-2">

                            <label for="">Cuota Mensual</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon3">$</span>
                                </div>
                                <input type="text" value="2.17" class="form-control" id="monto_credito_simulador">
                            </div>

                        </div>
                        <div class="col m-2">

                            <label for="">Tiempo Financiación (Meses)</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon3">Meses</span>
                                </div>
                                <input type="text" value="2.17" class="form-control" id="monto_credito_simulador">
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    montosInputValidator = () => {
        var valor_i = $('#monto_credito_simulador').val();
        valor_i = valor_i.replace(/\./g, '');
        var formatter = new Intl.NumberFormat();

        $("#monto_credito_simulador").val(formatter.format(valor_i))
        $('#hidden_block_simulacion').removeClass("animate__animated animate__flash");
        $('#cargar_informacion_simulacion').html("");
        $('#hidden_block_simulacion').hide();
    }

    calcularValorCredito_simulador = () => {
        var valor_i = $('#monto_credito_simulador').val();
        valor_i = valor_i.replace(/\./g, '');

        let tasa_interes = 2.17;
        let tasa_fogade = 14.3 / 100;
        let valor_financiar = parseFloat(valor_i);
        let plazo_coutas = $('#cuotas_credito_simulador').val();
        /* HACER VALIDACIÓN DEL VALOR A FINANCIAR Y LAS CUOTAS */

        if (plazo_coutas == null || plazo_coutas == NaN) {
            Swal.fire({
                position: "top",
                icon: "error",
                title: " Selecciona un plazo de coutas! ",
                showConfirmButton: false,
                timer: 5000,
                toast: true,
            });
            return;
        } else if (valor_i == "0" || valor_i == 0 || valor_i == "") {
            Swal.fire({
                position: "top",
                icon: "error",
                title: " Digita un monto valido !",
                showConfirmButton: false,
                timer: 5000,
                toast: true,
            });
            return;
        }

        var formatter = new Intl.NumberFormat();

        let divisor_intereses = parseFloat(+tasa_interes / 100);
        let valor_fogade = parseFloat(+(valor_financiar * tasa_fogade) + valor_financiar);

        let PxI = parseFloat(valor_fogade * divisor_intereses);
        let ImasUno = parseFloat(1 + divisor_intereses);
        let UnoMasEleveadoNegativoPeriodo = parseFloat(ImasUno ** parseFloat(-plazo_coutas));
        let UnoMenosUnoPotenciadoPeriodo = parseFloat(1 - UnoMasEleveadoNegativoPeriodo);
        let coutaMensualFija = parseFloat(PxI / UnoMenosUnoPotenciadoPeriodo)


        let domHtml = `
            <div class="row">
                <div class="col m-2">
                    <div class="d-flex justify-content-center">
                    <label for="">Tasa De Interes</label>
                    </div>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon3">%</span>
                        </div>
                        <input type="text" value="2.17" class="form-control" readonly id="monto_credito_simulador">
                    </div>
                </div>
                <div class="col m-2">
                    <div class="d-flex justify-content-center">
                    <label for="">Cuota Mensual</label>
                    </div>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon3">$</span>
                        </div>
                        <input type="text" value="${formatter.format(Math.round(coutaMensualFija))}" readonly class="form-control" id="monto_credito_simulador">
                    </div>
                </div>
                <div class="col m-2">
                    <div class="d-flex justify-content-center">
                        <label for="">Tiempo Financiación</label>
                    </div>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon3">Meses</span>
                        </div>
                        <input type="text" value="${plazo_coutas}" class="form-control" readonly id="monto_credito_simulador">
                    </div>
                </div>
            </div>`;

        Swal.fire({
            position: "top",
            icon: "success",
            title: " Couta calculada!",
            showConfirmButton: false,
            timer: 5000,
            toast: true,
        });

        $('#hidden_block_simulacion').removeClass("animate__animated animate__flash");
        $('#cargar_informacion_simulacion').html(domHtml);
        $('#hidden_block_simulacion').show();
        $('#hidden_block_simulacion').addClass("animate__animated animate__flash");
    }
</script>
