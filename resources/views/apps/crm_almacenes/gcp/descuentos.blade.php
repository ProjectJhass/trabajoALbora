@extends('apps.crm_almacenes.gcp.plantilla.app')
@section('title')
    Liquidador descuentos
@endsection
@section('header')
@endsection
@section('descuentos')
    active
@endsection
@section('contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Liquidador de descuentos</h4>
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
                            <form id="formulario-valores-descuento" method="post" class="was-validated">
                                @csrf
                                <div class="form-group">
                                    <label for="">Total cuotas cartera</label>
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
                                    <label for="">Fecha facturación</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                                        </div>
                                        <input type="date" name="fecha" class="form-control" id="fecha" placeholder="Username" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Saldo a plazos</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-hand-holding-usd"></i></div>
                                        </div>
                                        <input type="number" name="capital" id="capital" min="0" class="form-control" placeholder="Valor"
                                            required>
                                    </div>
                                </div>
                                <center>
                                    <button type="button" class="btn btn-danger"
                                        onclick="ConsultarValoresLiquidadorDescuento('formulario-valores-descuento')">Calcular</button>
                                </center>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card card-outline card-success">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="info-box mb-3 bg-info">
                                        <span class="info-box-icon"><i class="fas fa-money-check-alt"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Saldo a plazos pendiente</span>
                                            <span class="info-box-number">$ <span id="vlr_capital_descuento">0</span></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="info-box mb-3 bg-warning">
                                        <span class="info-box-icon"><i class="fas fa-coins"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Valor del descuento</span>
                                            <span class="info-box-number">$ <span id="vlr_intereses_descuento">0</span></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="info-box mb-3 bg-success">
                                        <span class="info-box-icon"><i class="fas fa-hand-holding-usd"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Total a pagar</span>
                                            <span class="info-box-number">$ <span id="vlr_total_a_pagar_descuento">0</span></span>
                                        </div>
                                    </div>
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
        ConsultarValoresLiquidadorDescuento = (form) => {
            loandingPanel()
            var formData = new FormData(document.getElementById(form));
            formData.append('dato', 'valor');
            var datos = $.ajax({
                url: "{{ route('calcular.dsto.liq') }}",
                type: "POST",
                dataType: "json",
                data: formData,
                cache: false,
                contentType: false,
                processData: false
            });
            datos.done((res) => {
                loadedPanel()
                if (res.status == true) {
                    document.getElementById('vlr_capital_descuento').innerHTML = new Intl.NumberFormat("es-CO").format(res.capital);
                    document.getElementById('vlr_intereses_descuento').innerHTML = new Intl.NumberFormat("es-CO").format(res.intereses);
                    document.getElementById('vlr_total_a_pagar_descuento').innerHTML = new Intl.NumberFormat("es-CO").format((res.capital -
                        res.intereses));
                }
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
    </script>
@endsection
