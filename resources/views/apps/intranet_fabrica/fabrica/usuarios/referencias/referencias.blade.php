@extends('apps.intranet_fabrica.layout_fabrica.app')
@section('title')
    Referencias
@endsection
@section('active-usuarios')
    bg-danger active
@endsection
@section('active-sub-referencias')
    active
@endsection
@section('fabrica-body')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5 class="m-0">Referencias - Documentación técnica</h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home.intranet.fabrica') }}">Fábrica</a></li>
                        <li class="breadcrumb-item active">Referencias</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-outline card-danger">
                <div class="card-header">
                    <h5>Nueva referencia</h5>
                </div>
                <div class="card-body">
                    <form id="formulario-nueva-referencia" method="post" class="was-validated" autocomplete="off" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="">Nombre de la referencia</label>
                            <input type="text" class="form-control" name="nombre_nueva_referencia" id="nombre_nueva_referencia"
                                placeholder="Registrar referencia">
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-danger"
                                onclick="AgregarNuevaReferenciaFab('{{ route('agregar.referencia.fab') }}','formulario-nueva-referencia')">Agregar nueva
                                referencia</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script>
        AgregarNuevaReferenciaFab = (url, form) => {
            Swal.fire({
                title: 'Seguro de crear esta referencia?',
                text: "No podrás reversar esta operación!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, crear',
                cancelButtonText: 'No, cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    var response = RegistrarNuevaInformacionFab(url, form);
                    response.done((res) => {
                        if (res.status == true) {
                            document.getElementById(form).reset();
                            Swal.fire(
                                'EXCELENTE!',
                                'La referencia fue creada exitosamente',
                                'success'
                            )
                        }
                    });
                    response.fail(() => {
                        Swal.fire(
                            'ERROR!',
                            'Hubo un problema al procesar la solicitud',
                            'error'
                        )
                    });
                }
            })
        }

        RegistrarNuevaInformacionFab = (url, form) => {
            var info = new FormData(document.getElementById(form));
            info.append('valor', 'valor');
            var datos = $.ajax({
                url: url,
                type: "post",
                dataType: "json",
                data: info,
                cache: false,
                contentType: false,
                processData: false
            });
            return datos;
        }
    </script>
@endsection
