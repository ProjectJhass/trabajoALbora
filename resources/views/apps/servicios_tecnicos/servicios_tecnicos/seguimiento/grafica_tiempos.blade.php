<div class="accordion" id="tiemposGrafica">
    <div id="step-title">
        <p>Creación</p>
        <p>Visita</p>
        <p>Valoración</p>
        <p>Recogida</p>
        <p>Ingreso Taller</p>
        <p>Salida Taller</p>
        <p>Entrega Mercancia</p>
    </div>
    <div class="steps-container">
        @isset($data)
        @php
            krsort($data);
        @endphp
        @foreach ($data as $etapas)
            <div class="step-wrapper">
                @php
                    $id_st = $etapas[0]['id_st'];
                @endphp
                <div class="step-id"> {{ json_encode($id_st) }}</div>
                <div class="steps">
                    <progress id="bar_{{ $id_st }}" class="progress bg-info" value=0 max=100></progress>
                    @for ($i = 1; $i <= 7; $i++)
                        <div class="step-item">
                            <button data-days="{{ $etapas[$i - 1]['dias'] ?? '' }}"
                                data-id="{{ $etapas[$i - 1]['id'] ?? '' }}"
                                data-diff="{{ $etapas[$i - 1]['diferencia'] ?? '' }}"
                                data-stage="{{ $etapas[$i - 1]['etapa'] ?? '' }}"
                                id="btn_{{ $id_st }}_{{ $i }}" class="step-button text-center"
                                type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                                aria-controls="collapseOne">
                                {{ $i }}
                            </button>
                        </div>
                    @endfor
                </div>
            </div>
        @endforeach
        @else
        <div>hola</div>
        @endisset
    </div>
</div>
