@extends ('apps.nexus.plantilla.app')

@section('body')
<div class="container">
    <h2>Agregar Nueva Area</h2>

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
            <label for="nombre_dpto" class="form-label">Nombre del Area</label>
            <input type="text" class="form-control" id="nombre_dpto" name="nombre_dpto" required>
        </div>

        <div class="mb-3">
            <label for="descripcion_dpto" class="form-label">Descripción del Area</label>
            <textarea class="form-control" id="descripcion_dpto" name="descripcion_dpto" rows="3" required></textarea>
        </div>

        <div class="mb-3">
            <label for="name_image" class="form-label">Subir Imagen</label>
            <input type="file" class="form-control" id="name_image" name="name_image" accept="image/*" required>
        </div>

        <!-- Sección para seleccionar usuarios -->
        <div class="mb-3">
            <label class="form-label">Asignar Usuarios al Área</label>
            <div id="usuarios-container">
                <!-- Aquí se cargarán los checkboxes con AJAX -->
            </div>
            <small class="form-text text-muted">Selecciona uno o más usuarios.</small>
        </div>

        <button type="submit" class="btn btn-primary">Guardar Area</button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Hacer la petición AJAX con fetch
    fetch("{{ route('get.usuarios') }}")
    .then(function(response) {
        return response.json(); // Convertir la respuesta a JSON
    })
    .then(function(usuarios) {
        let container = document.getElementById('usuarios-container');
        container.innerHTML = ''; // Vaciar el contenedor

        // Recorrer los usuarios y añadir checkboxes al contenedor
        usuarios.forEach(function(usuario) {
            let checkbox = document.createElement('div');
            checkbox.classList.add('form-check');

            let input = document.createElement('input');
            input.type = 'checkbox';
            input.classList.add('form-check-input');
            input.id = usuario.id;  // Asignar ID único al checkbox
            input.name = usuario.id;          // Nombre del array para la solicitud
            input.value = 'usuario_'+usuario.id;              // ID del usuario

            let label = document.createElement('label');
            label.classList.add('form-check-label');
            label.setAttribute('for', 'usuario_' + usuario.id);
            label.textContent = usuario.nombre;    // Nombre del usuario

            checkbox.appendChild(input);
            checkbox.appendChild(label);
            container.appendChild(checkbox);
        });
    })
    .catch(function(error) {
        console.error('Error al cargar los usuarios:', error);
    });
});
</script>

@endsection
