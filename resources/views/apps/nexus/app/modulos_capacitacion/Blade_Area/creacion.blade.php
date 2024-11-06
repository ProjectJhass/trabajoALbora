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

        <button type="button" onclick="crearArea()" class="btn btn-primary">Guardar Area</button>
    </form>
</div>

<script>
    const crearArea = () => {

        let formData = new FormData(document.getElementById('frmCreateArea'));
        
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
</script>

@endsection
