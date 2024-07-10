<style>
    thead {
        text-align: center;
    }
</style>
<div class="row">
    <div class="col-md-12">
        @foreach ($manual as $manual_i)
            <div class="card">
                <div class="card-header">
                    <div class="row text-center">
                        <div class="col-md-6 mb-3" style="border: 1px solid; border-radius: 12px;">
                            <img class="mt-2 mb-2" src="{{ asset('img/BLANCO.png') }}" width="50%" alt="">
                        </div>
                        <div class="col-md-6 mb-3" style="border: 1px solid; border-radius: 12px;">
                            <h2 class="mt-4"><strong>Manual de funciones</strong></h2>
                        </div>
                        <div class="col-md-4" style="border: 1px solid; border-radius: 12px;">
                            <strong>CODIGO: MF-TH-01</strong>
                        </div>
                        <div class="col-md-4" style="border: 1px solid; border-radius: 12px;">
                            <strong>VERSIÓN: 17</strong>
                        </div>
                        <div class="col-md-4" style="border: 1px solid; border-radius: 12px;">
                            <strong>PÁGINA: 1</strong>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 2%;">
                        <div class="col-md-12 mb-5">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-md-4"><strong>CARGO</strong></div>
                                        <div class="col-md-8">{{ $manual_i->cargo }}</div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-md-4"><strong>ÁREA/DEPENDENCIA</strong></div>
                                        <div class="col-md-8">{{ $manual_i->area }}</div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-md-4"><strong>OPERACIÓN ASIGNADA</strong></div>
                                        <div class="col-md-8">{{ $manual_i->operacion_asignada }}</div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-md-4"><strong>JEFE INMEDIATO</strong></div>
                                        <div class="col-md-8">{{ $manual_i->jefe_inmediato }}</div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-md-4"><strong>AUTORIDAD FORMAL</strong></div>
                                        <div class="col-md-8">{{ $manual_i->autoridad_formal }}</div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="list-group mb-5">
                        <li class="list-group-item">
                            <h5>Objetivo general</h5>
                            <p class="mt-4 mb-4">{{ $manual_i->objetivo_general }}</p>
                        </li>
                    </ul>
                    @foreach ($secciones as $item)
                        @switch($item->id_seccion)
                            @case(2)
                                <table class="table table-sm table-bordered mb-5">
                                    <thead>
                                        <tr>
                                            <th colspan="2"><strong>{{ $item->seccion }}</strong></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($manual_i->funcionesGenerales as $respuesta)
                                            @if ($respuesta->id_seccion == 2)
                                                <tr>
                                                    <td>
                                                        <p class="mt-3">{{ $respuesta->descripcion }}</p>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            @break

                            @case(3)
                                <table class="table table-sm table-bordered mb-5">
                                    <thead>
                                        <tr>
                                            <th colspan="3"><strong>{{ $item->seccion }}</strong></th>
                                        </tr>
                                        <tr>
                                            <th><strong>Descripción</strong></th>
                                            <th><strong>Relevancia</strong></th>
                                            <th><strong>Frecuencia</strong></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($manual_i->funcionesGenerales as $respuesta)
                                            @if ($respuesta->id_seccion == 3)
                                                <tr>
                                                    <td>
                                                        <p class="mt-3">{{ $respuesta->descripcion }}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p class="mt-3">{{ $respuesta->relevancia }}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p class="mt-3">{{ $respuesta->frecuencia }}</p>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            @break

                            @default
                                <table class="table table-sm table-bordered mb-5">
                                    <thead>
                                        <tr>
                                            <th colspan="2"><strong>{{ $item->seccion }}</strong></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($item->subSecciones as $value)
                                            <tr>
                                                <td><p class="mt-3">{{ $value->seccion_m }}</p></td>
                                                <td>
                                                    @foreach ($manual_i->funcionesGenerales as $respuesta)
                                                        @if ($respuesta->id_seccion == $item->id_seccion && $respuesta->id_subseccion == $value->id_seccion_m)
                                                            <p class="mt-3">- {{ $respuesta->descripcion }}</p>
                                                        @endif
                                                    @endforeach
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                        @endswitch
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>
