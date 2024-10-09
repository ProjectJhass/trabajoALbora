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

    <form id="frmCreateArea">
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
            <select class="form-control js-example-basic-multiple" multiple="multiple" name="select_usuario_seleccionado[]" id="usuarios-select"></select>
            <small class="form-text text-muted">Selecciona uno o más usuarios.</small>
        </div>



        <button type="button" onclick="crearArea()" class="btn btn-primary">Guardar Area</button>
    </form>
</div>

<script>
    const crearArea = () => {
        // const ContentIdUsers=document.getElementById("usuarios-select").selectedOptions;
        // const selectedArray = Array.from(ContentIdUsers);
        // const arregloIdUsers=[]
        // selectedArray.forEach(element => {
        //     arregloIdUsers.push({
        //         name:element.textContent,
        //         value:element.value
        //     });
        // });
        let formData = new FormData(document.getElementById('frmCreateArea'));
        // formData.append("IdUsers", JSON.parse(arregloIdUsers));
        
        $.ajax({
            url: "{{ route('formulario.areas.empresa') }}",
            type: "POST",
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: (response) => {
                notificacion(response.mensaje, 'success', 4000)
                console.log(response);
            },
            error: (errror) => {

                if (errror.status == 500) {
                    // notification(response.mensaje, 'success', 4000)

                }

                let err_json = errror.responseJSON;
                console.error(err_json);
            }

        })

    }

    document.addEventListener('DOMContentLoaded', function() {
        // Selecciona el elemento del select
        const selectElement = $('.js-example-basic-multiple');

        // Asegurarse de que Select2 esté disponible y luego inicializarlo
        if (selectElement) {
            $(selectElement).select2(); // Usamos el método select2
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