<div class="col-md-4 mb-3" id="detalleVentaCotizador">
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
@if ($cuotas != 1 || $cc == 1)
    <div class="col-md-4 mb-3">
        <div class="card card-outline card-secondary">
            <div class="card-header">
                Cuotas
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="">Cuota inicial</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon3">$</span>
                            </div>
                            <input type="text" value="{{ number_format($inicial) }}" class="form-control" id="basic-url" disabled
                                aria-describedby="basic-addon3">
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Garantía</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon3">$</span>
                            </div>
                            <input type="text" value="{{ number_format($garantia) }}" class="form-control" id="basic-url" disabled
                                aria-describedby="basic-addon3">
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="">Cuota mensual</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon3">$</span>
                            </div>
                            <input type="text" value="{{ number_format($mensual) }}" class="form-control" id="basic-url" disabled
                                aria-describedby="basic-addon3">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="">Número de cuotas</label>
                            <div class="input-group mb-3">
                                <input type="text" value="{{ number_format($cuotas) }}" class="form-control" id="basic-url" disabled
                                    aria-describedby="basic-addon3">
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="">Venta total</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon3">$</span>
                                </div>
                                <input type="text" value="{{ number_format($venta_total) }}" class="form-control" id="basic-url" disabled
                                    aria-describedby="basic-addon3">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
<div class="col-md-4 mb-3">
    <div class="card card-outline card-secondary">
        <div class="card-header">
            Modificar cotización
        </div>
        <div class="card-body">
            <form action="">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="">Plan de venta</label>
                        <select name="plan_venta" id="plan_venta" class="form-control">
                            <option value="{{ $cuotas }}">{{ $cuotas + $cc == '1' ? 'CO' : $cuotas + $cc . 'F' }}</option>
                            @foreach ($planes as $item)
                                <option value="{{ $item->id_tasa }}">{{ $item->plan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="">Valor inicial</label>
                        <input type="number" class="form-control" name="valor_inicial_cot" id="valor_inicial_cot">
                    </div>
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-success"
                        onclick="ActulizarPlanVentaCotizador()">Modificar</button>
                </div>
            </form>
        </div>
    </div>
</div>
