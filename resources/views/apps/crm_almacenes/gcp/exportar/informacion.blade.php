<div class="card card-outline card-danger w-100">
    <div class="card-header">
        <strong>Clientes</strong>
    </div>
    <div class="card-body d-flex flex-row justify-content-between text-center">
        <div class="" style="max-width: 200px">
            <div class="card shadow">
                <div class="card-header">
                    <strong>Informe General</strong>
                </div>
                <div class="card-body text-center ">
                    <form id="exportarClientesIngresados" class="m-0" name="exportarClientesIngresados" method="POST"
                        action="{{ route('crm.exportar.clientes', ['tipo_cliente' => '', 'fecha_i' => $fecha_i, 'fecha_f' => $fecha_f, 'almacen' => $almacen, 'asesor' => $asesor]) }}">
                        @csrf
                    </form>
                    <button class="border-0 bg-transparent" form="exportarClientesIngresados" type="submit">
                        <img class="excel" src="{{ asset('icons/excel.png') }}" width="20%" alt="">
                    </button>
                </div>
            </div>
        </div>
        <div class="" style="max-width: 200px">
            <div class="card shadow">
                <div class="card-header">
                    <strong>Oportunidad</strong>
                </div>
                <div class="card-body text-center">
                    <form id="exportarClientesOportunidad" class="m-0" name="exportarClientesOportunidad"
                        method="POST"
                        action="{{ route('crm.exportar.clientes', ['tipo_cliente' => 1, 'fecha_i' => $fecha_i, 'fecha_f' => $fecha_f, 'almacen' => $almacen, 'asesor' => $asesor]) }}">
                        @csrf
                    </form>
                    <button class="border-0 bg-transparent" form="exportarClientesOportunidad" type="submit">
                        <img class="excel" src="{{ asset('icons/excel.png') }}" width="20%" alt="">
                    </button>
                </div>
            </div>
        </div>
        <div class="" style="max-width: 200px">
            <div class="card shadow">
                <div class="card-header">
                    <strong>Prospectos</strong>
                </div>
                <div class="card-body text-center">
                    <form id="exportarClientesProspectos" class="m-0" name="exportarClientesProspectos"
                        method="POST"
                        action="{{ route('crm.exportar.clientes', ['tipo_cliente' => 2, 'fecha_i' => $fecha_i, 'fecha_f' => $fecha_f, 'almacen' => $almacen, 'asesor' => $asesor]) }}">
                        @csrf
                    </form>
                    <button class="border-0 bg-transparent" form="exportarClientesProspectos" type="submit">
                        <img class="excel" src="{{ asset('icons/excel.png') }}" width="20%" alt="">
                    </button>
                </div>
            </div>
        </div>
        <div class="" style="max-width: 200px">
            <div class="card shadow">
                <div class="card-header">
                    <strong>Efectivos</strong>
                </div>
                <div class="card-body text-center">
                    <form id="exportarClientesEfectivos" class="m-0" name="exportarClientesEfectivos"
                        method="POST"
                        action="{{ route('crm.exportar.clientes', ['tipo_cliente' => '3', 'fecha_i' => $fecha_i, 'fecha_f' => $fecha_f, 'almacen' => $almacen, 'asesor' => $asesor]) }}">
                        @csrf
                    </form>
                    <button class="border-0 bg-transparent" form="exportarClientesEfectivos" type="submit">
                        <img class="excel" src="{{ asset('icons/excel.png') }}" width="20%" alt="">
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="d-flex justify-content-between w-100">
    <div class="card card-outline card-danger w-100 mr-4">
        <div class="card-header">
            <strong>Llamadas</strong>
        </div>
        <div class="card-body d-flex flex-row justify-content-between text-center">
            <div class="" style="max-width: 200px">
                <div class="card shadow">
                    <div class="card-header">
                        <strong>Realizadas</strong>
                    </div>
                    <div class="card-body text-center">
                        <form id="exportarLlamadasRealizadas" class="m-0" name="exportarLlamadasRealizadas"
                            method="POST"
                            action="{{ route('crm.exportar.llamadas', ['estado' => 'REALIZADA', 'fecha_i' => $fecha_i, 'fecha_f' => $fecha_f, 'almacen' => $almacen, 'asesor' => $asesor]) }}">
                            @csrf
                        </form>
                        <button class="border-0 bg-transparent" class="m-0" form="exportarLlamadasRealizadas"
                            type="submit">
                            <img class="excel" src="{{ asset('icons/excel.png') }}" width="20%" alt="">
                        </button>
                    </div>
                </div>
            </div>
            <div class="" style="max-width: 200px">
                <div class="card shadow">
                    <div class="card-header">
                        <strong>Pendientes</strong>
                    </div>
                    <div class="card-body text-center">
                        <form id="exportarLlamadasPendientes" class="m-0" name="exportarLlamadasPendientes"
                            method="POST"
                            action="{{ route('crm.exportar.llamadas', ['estado' => 'PENDIENTE', 'fecha_i' => $fecha_i, 'fecha_f' => $fecha_f, 'almacen' => $almacen, 'asesor' => $asesor]) }}">
                            @csrf
                        </form>
                        <button class="border-0 bg-transparent" form="exportarLlamadasPendientes" type="submit">
                            <img class="excel" src="{{ asset('icons/excel.png') }}" width="20%" alt="">
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-outline card-danger w-100">
        <div class="card-header">
            <strong>Cotizaciones</strong>
        </div>
        <div class="card-body d-flex flex-row justify-content-center text-center">
            <div class="" style="max-width: 200px">
                <div class="card shadow">
                    <div class="card-header">
                        <strong>Realizadas</strong>
                    </div>
                    <div class="card-body text-center">
                        <form id="exportarCotizaciones" class="m-0" name="exportarCotizaciones" method="POST"
                            action="{{ route('crm.exportar.cotizaciones', ['fecha_i' => $fecha_i, 'fecha_f' => $fecha_f, 'almacen' => $almacen, 'asesor' => $asesor]) }}">
                            @csrf
                        </form>
                        <button class="border-0 bg-transparent" form="exportarCotizaciones" type="submit">
                            <img class="excel" src="{{ asset('icons/excel.png') }}" width="20%" alt="">
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .card-body::after {
        content: none;
    }
</style>
