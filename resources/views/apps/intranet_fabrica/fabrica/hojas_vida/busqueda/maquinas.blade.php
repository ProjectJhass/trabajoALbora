@foreach ($maquinas as $maquina)
    <div class="col-md-2 col-sm-3 mb-3">
        <div class="card">
            <div class="card-header">
                <div class="card-image">
                    @if (!empty($maquina->imagen))
                        <img src="{{ asset('img/imgMaquinas/' . $maquina->imagen) }}" alt="" id="imgMaquina{{ $maquina->id_maquina }}"
                            style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <img src="{{ asset('img/imgMaquinas/defecto.png') }}" alt="" id="imgMaquina{{ $maquina->id_maquina }}"
                            style="width: 100%; height: 100%; object-fit: cover;">
                    @endif
                </div>
                <div class="card-tools">
                    <a type="button" onclick="abrirModalEditarImagen('{{ $maquina->id_maquina }}')"><i class="fas fa-cog"></i></a>
                </div>
            </div>
            <div class="card-body">
                <div class="category">{{ $maquina->referencia }}</div>
                <div class="heading">{{ $maquina->nombre_maquina }}</div>                
            </div>
            <div class="card-footer text-center">
                <a href="{{ route('historial.maquina', ['referencia' => trim($maquina->referencia)]) }}" class="btn btn-danger btn-sm"><i
                    class="fas fa-eye"></i> Ver</a>
            </div>
        </div>
    </div>
@endforeach
