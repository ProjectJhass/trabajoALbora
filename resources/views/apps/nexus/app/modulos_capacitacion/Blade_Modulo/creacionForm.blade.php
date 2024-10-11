@extends ('apps.nexus.plantilla.app')

@section('body')
<div class="container mt-4">
    <h2 class="mb-4">Agregar Nuevo Módulo</h2>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form id="frmCreateModulo" enctype="multipart/form-data">
        <!-- Sección Nombre del Módulo -->
        <div class="row mb-4">
            <div class="col-md-6">
                <label for="nombre_modulo" class="form-label">Nombre del Módulo</label>
                <input type="text" class="form-control" id="nombre_modulo" name="nombre_modulo" required>
            </div>
        </div>

        <!-- Sección Descripción del Módulo -->
        <div class="row mb-4">
            <div class="col-md-12">
                <label for="descripcion_modulo" class="form-label">Descripción del Módulo</label>
                <textarea class="form-control" id="descripcion_modulo" name="descripcion_modulo" rows="3" required></textarea>
            </div>
        </div>

        <!-- Sección Subir Imagen y Estado (en la misma fila) -->
        <div class="row mb-4">
            <!-- Subir Imagen -->
            <div class="col-md-6">
                <label for="name_image" class="form-label">Subir Imagen</label>
                <input type="file" class="form-control" id="name_image" name="name_image" accept="image/*" required>
            </div>

            <!-- Estado del Módulo -->
            <div class="col-md-6">
                <label for="estado" class="form-label">Estado del Módulo</label>
                <select class="form-control" id="estado" name="estado" required>
                    <option value="activo">Activo</option>
                    <option value="inactivo">Inactivo</option>
                </select>
            </div>
        </div>

        <!-- Sección Selección de Usuarios -->
        <div class="row mb-4">
            <div class="col-md-12">
                <label class="form-label">Asignar Usuarios al Módulo</label>
                <select class="form-control js-example-basic-multiple" multiple="multiple" name="select_usuario_seleccionado[]" id="usuarios-select"></select>
                <small class="form-text text-muted">Selecciona uno o más usuarios.</small>
            </div>
        </div>

        <!-- Botón de Envío -->
        <div class="row">
            <div class="col-md-12">
                <button type="button" onclick="crearModulo()" class="btn btn-primary w-100">Guardar Módulo</button>
            </div>
        </div>
    </form>
</div>

<script>
    const crearModulo = () => {
        let formData = new FormData(document.getElementById('frmCreateModulo'));
        formData.append('id_cargo', '{{ $id_cargo }}');
        
        $.ajax({
            url: "{{ route('formulario.modulo.cargos.area.empresa') }}", 
            type: "POST",
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: (response) => {
                notificacion(response.mensaje, 'success', 4000);
                console.log(response);
            },
            error: (error) => {
                if (error.status == 500) {
                    // Manejar errores del servidor
                }
                let err_json = error.responseJSON;
                console.error(err_json);
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Seleccionar el elemento de usuarios
        const selectElement = $('.js-example-basic-multiple');

        // Inicializar Select2 si está disponible
        if (selectElement) {
            $(selectElement).select2();
        }

        // Hacer la petición AJAX para obtener los usuarios
        fetch("{{ route('get.usuarios') }}")
            .then(function(response) {
                return response.json(); // Convertir la respuesta a JSON
            })
            .then(function(usuarios) {
                let select = document.getElementById('usuarios-select');
                select.innerHTML = ''; // Vaciar el select

                // Recorrer los usuarios y añadir opciones al select
                usuarios.forEach(function(usuario) {
                    let option = document.createElement('option');
                    option.value = usuario.id; // ID del usuario como valor
                    option.textContent = usuario.nombre; // Nombre del usuario como texto
                    select.appendChild(option);
                });

                // Refrescar Select2 después de cargar las opciones
                const event = new Event('change', {
                    bubbles: true
                });
                select.dispatchEvent(event); // Disparar evento 'change'
            })
            .catch(function(error) {
                console.error('Error al cargar los usuarios:', error);
            });
    });
</script>

@endsection
