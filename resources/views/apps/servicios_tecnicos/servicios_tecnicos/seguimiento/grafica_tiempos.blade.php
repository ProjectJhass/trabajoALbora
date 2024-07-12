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
            @foreach ($data as $index => $etapas)
                <div class="step-wrapper">
                    {{ $etapas[0]->id_st }}
                    <div class="step-id d-none">{{ $index }}</div>
                    <div class="steps">
                        <progress id="bar_{{ $index }}" class="progress bg-info" value=0 max=100></progress>
                        @for ($i = 1; $i <= 7; $i++)
                            <div class="step-item">
                                <button data-days="{{ $etapas[$i - 1]->dias ?? '' }}"
                                    data-id="{{ $etapas[$i - 1]->id ?? '' }}"
                                    data-diff="{{ $etapas[$i - 1]->diferencia ?? '' }}"
                                    data-stage="{{ $etapas[$i - 1]->etapa ?? '' }}"
                                    id="btn_{{ $index }}_{{ "$i" }}" class="step-button text-center"
                                    type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                                    aria-controls="collapseOne">
                                    {{ "$i" }}
                                </button>
                            </div>
                        @endfor
                    </div>
                </div>
            @endforeach
            <br>
            <div class="pagination-wrapper w-100 d-flex justify-content-center">
                <div class="row">
                    {{-- {{ $data->links('pagination::bootstrap-4') }} --}}
                </div>
            </div>
        @endisset
    </div>
</div>
