<!-- Botón para crear un nuevo cargo sobre las tarjetas -->
<div class="row mb-3">
    <div class="col-md-12 text-end">
        <a href="{{ route('contenido.cargos.areas.empresa', ['id_area' => $id_area])}}" class="btn btn-primary">
            Crear nuevo cargo
        </a>
    </div>
</div>

<!-- Lista de cargos -->
<div class="row">
    @foreach ($info as $item)
        <div class="col-md-3 mb-2 d-flex">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-center">
                        <div class="d-flex flex-column text-center align-items-center justify-content-between">
                            <div class="fs-italic">
                                <h5>{{ $item->nombre_cargo }}</h5>
                            </div>
                            <!-- Estrellas y contenido -->
                            <a href="{{ route('info.modulos.nexus', ['id_cargo' => $item->id_cargo]) }}"
                                class="card-profile-progress">
                                <div id="circle-progress-1{{ $item->id_cargo }}" class="circle-progress-basic circle-progress-primary"
                                    data-min-value="0" data-max-value="100" data-value="80" data-type="percent" role="progressbar" aria-valuemin="0"
                                    aria-valuemax="100" aria-valuenow="80">
                                    <svg version="1.1" width="100" height="100" viewBox="0 0 100 100" class="circle-progress">
                                        <circle class="circle-progress-circle" cx="50" cy="50" r="46" fill="none" stroke="#ddd"
                                            stroke-width="8"></circle>
                                    </svg>
                                </div>
                                <img src="{{ asset('img/profile.png') }}" alt="User-Profile" class="img-fluid rounded-circle card-img">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
