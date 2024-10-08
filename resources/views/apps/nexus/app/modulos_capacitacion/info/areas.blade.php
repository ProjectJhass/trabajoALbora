<div class="row" style="padding-top: 60px;">
    <form method="GET" action="{{ route('modulos.nexus') }}" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Buscar por nombre de departamento" value="{{ request('search') }}">
            <button class="btn btn-primary" type="submit">Buscar</button>
        </div>
    </form>
    <a href="{{route('contenido.areas.empresa')}}"><button class="btn btn-outline-primary">Crear área</button></a>
</div>

<div class="row mt-2">
    @foreach ($info as $item)
    <div class="col-12 col-md-6 col-lg-3 mb-4"> <!-- Ajuste para grilla responsive -->
        <div class="card h-100" style="border-radius: 15px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); transition: box-shadow 0.3s ease;">
            <img src="{{ asset('assets/img/ImageAreas/'.$item->name_image) }}" class="card-img-top img-fluid" style="border-top-left-radius: 15px; border-top-right-radius: 15px; height: 220px; object-fit: contain; padding-top:10px;" alt="Imagen de ejemplo">
            <div class="card-body text-center d-flex flex-column justify-content-between" style="height: auto;"> <!-- Ajuste para alturas dinámicas -->
                <h5 class="card-title fw-bold text-primary">{{ $item->nombre_dpto }}</h5>
                <p class="card-text text-muted" style="display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 3; overflow: hidden; text-overflow: ellipsis; font-size: 14px;">
                    {{$item->descripcion_dpto}}
            </p>
                <a href="{{ route('cargos.modulos.nexus', ['id_area' => $item->id_dpto]) }}" class="btn-custom">
                    <span id="circle-progress-1{{ $item->id_dpto }}">Ver más</span>
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<style>
    .card {
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .card:hover {
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    .btn-custom {
        border: 1px solid #db5363;
        color: #db5363;
        border-radius: 50px;
        padding: 10px 24px;
        margin-top: 1rem;
        text-decoration: none;
        display: inline-block;
        transition: background-color 0.3s ease;
    }

    .btn-custom:hover {
        background-color: #db5363;
        color: white;
    }

    /* Ajustes para responsividad */
    @media (max-width: 768px) {
        .card-img-top {
            height: 180px; /* Reducir altura en pantallas más pequeñas */
        }
    }

    @media (max-width: 576px) {
        .card-img-top {
            height: 150px; /* Reducir altura en pantallas aún más pequeñas */
        }
    }
</style>
