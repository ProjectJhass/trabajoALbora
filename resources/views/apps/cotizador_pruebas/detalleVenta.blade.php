<div class="col-md-5 mb-3" id="detalleVentaCotizador">
    <div class="card card-outline card-secondary">
        <div class="card-header">
            Detalle de la venta
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="">Neto</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon3">$</span>
                        </div>
                        <input type="text" value="{{ number_format($neto) }}" class="form-control" id="basic-url" disabled
                            aria-describedby="basic-addon3">
                    </div>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="">Descuento normal</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon3">$</span>
                        </div>
                        <input type="text" value="{{ number_format($normal) }}" class="form-control" id="basic-url" disabled
                            aria-describedby="basic-addon3">
                    </div>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="">Descuento adicional</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon3">$</span>
                        </div>
                        <input type="text" value="{{ number_format($adicional) }}" class="form-control" id="basic-url" disabled
                            aria-describedby="basic-addon3">
                    </div>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="">Total a pagar</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon3">$</span>
                        </div>
                        <input type="text" value="{{ number_format($total) }}" class="form-control" id="basic-url" disabled
                            aria-describedby="basic-addon3">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-4">
    <div class="card card-outline card-secondary">
        <div class="card-header">
            Valor a financiar
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 mb-3" hidden>
                    <label for="">Valor</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon3">$</span>
                        </div>
                        <input type="number" class="form-control" value="{{ $total }}" name="total_a_pagar" id="total_a_pagar">
                    </div>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="">Nuevo valor</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon3">$</span>
                        </div>
                        <input type="number" class="form-control" onkeyup="calcularValorCredito(this.value)" name="valor_a_financiar"
                            id="valor_a_financiar">
                    </div>
                </div>
                <div class="col-md-12 mb-3" id="txtValorFinanciar" hidden>
                    <label for="">Valor a financiar</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon3">$</span>
                        </div>
                        <input type="text" class="form-control" name="valor_nuevo_financiar" id="valor_nuevo_financiar" readonly>
                    </div>
                </div>
                <div class="col-md-12 mb-3" id="txtValorRestaCredito" hidden>
                    <label for="">Valor a pagar de contado</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon3">$</span>
                        </div>
                        <input type="text" class="form-control" name="valor_resta_financiar" id="valor_resta_financiar" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-2 mb-3">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card text-center">
                <div class="card-body">
                    <div style="cursor: pointer" data-toggle="modal" data-target="#modalGenerarCotizacion">
                        <i class="fas fa-cart-arrow-down" style="font-size: 45px; color:rgb(197, 197, 197)"></i>
                    </div>
                </div>
                <div class="card-footer">
                    Generar cotización
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card text-center">
                <div class="card-body text-center">
                    <div style="cursor: pointer" data-toggle="modal" data-target="#modalInfoSolicitarCredito">
                        <i class="far fa-credit-card" style="font-size: 45px; color:rgb(197, 197, 197)"></i>
                    </div>
                </div>
                <div class="card-footer">
                    Solicitar crédito
                </div>
            </div>
        </div>
    </div>
</div>
