@extends ('apps.nexus.plantilla.app')

@section('body')
<div class="container">
    <h2>Agregar Nuevo Departamento</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('formulario.areas.empresa') }}" method="POST" enctype="multipart/form-data">                
        <div class="mb-3">
            <label for="nombre_dpto" class="form-label">Nombre del Departamento</label>
            <input type="text" class="form-control" id="nombre_dpto" name="nombre_dpto" required>
        </div>

        <div class="mb-3">
            <label for="descripcion_dpto" class="form-label">Descripción del Departamento</label>
            <textarea class="form-control" id="descripcion_dpto" name="descripcion_dpto" rows="3" required></textarea>
        </div>

        <div class="mb-3">
            <label for="url_Imagen" class="form-label">Subir Imagen</label>
            <input type="file" class="form-control" id="url_Imagen" name="url_Imagen" accept="image/*" required>
        </div>

        <button type="submit" class="btn btn-primary">Guardar Departamento</button>
    </form>
</div>
@endsection
