@extends('apps.intranet.plantilla.app')
@section('title')
    Flayer
@endsection
@section('head')
@endsection
@section('sagrilaft')
    bg-danger active
@endsection
@section('body')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>SAGRILAFT Y PTEE</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item text-blue">Inicio</li>
                        <li class="breadcrumb-item active">Flayer</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            <div class="row mb-4">
                <div class="text-end">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-outline-danger" data-toggle="modal"
                            data-target="#exampleModal">Modificar flayer</button>
                        <button type="button" class="btn btn-outline-success" onclick="ExportInfoExcel()"><i
                                class="far fa-file-excel"></i>
                            Descargar</button>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">

                    <div class="card">
                        <div class="card-body">
                            <label for="">Fecha</label>
                            <input type="month" value="@php echo date('Y-m') @endphp"
                                onchange="searchInfoDate(this.value)" class="form-control" name="monthSearch"
                                id="monthSearch">
                        </div>
                    </div>

                    <div class="small-box bg-white">
                        <div class="inner">
                            <h3 id="cantidadViewsFlayer">{{ $cantidad }}</h3>
                            <p>Visualizaciones</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <div class="small-box-footer text-dark">Mes consultado</div>
                    </div>
                    <div class="card">
                        <div class="card-body" id="imgCreativoPtee">
                                <a href="{{ isset($img->url)?asset($img->url):'#' }}" target="_BLANK">
                                    <img src="{{ isset($img->url)?asset($img->url):'' }}" width="100%" alt="">
                                </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-body" id="infoTableFlayerUsers">
                            @php
                                echo $table;
                            @endphp
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('footer')
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Configurar flayer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img id="preview" style="display: none" width="100%" src="#" alt="">
                        </div>
                        <div class="col-md-8">
                            <form id="form-img-act-flayer" enctype="multipart/form-data" method="post">
                                <label for="">Imagen del flayer</label>
                                <input type="file" class="form-control" name="imgPrevFlayer" id="imgPrevFlayer"
                                    accept="image/*">
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-outline-danger" onclick="UpdateFlayer()">Actualizar
                        Flayer</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(() => {
            dataTablesFormat();
        })
        document.getElementById('imgPrevFlayer').addEventListener('change', previewImage);

        function previewImage() {
            var input = document.getElementById('imgPrevFlayer');
            var preview = document.getElementById('preview');

            if (input.files && input.files[0]) {

                preview.style.display = "block";
                var reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                };

                reader.readAsDataURL(input.files[0]);
            } else {
                preview.style.display = "none";
            }
        }

        dataTablesFormat = () => {
            $('#usuariosInfoFlayerTable').DataTable({
                "oLanguage": {
                    "sSearch": "Buscar:",
                    "sInfo": "Mostrando de _START_ a _END_ de _TOTAL_ registros",
                    "oPaginate": {
                        "sPrevious": "Volver",
                        "sNext": "Siguiente"
                    },
                    "sEmptyTable": "No se encontró ningun registro en la base de datos",
                    "sZeroRecords": "No se encontraron resultados...",
                    "sLengthMenu": "Mostrar _MENU_ registros"
                },
                "order": [
                    [0, "desc"]
                ],
                "buttons": [
                    "excel"
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "responsive": false,
            });
        }

        UpdateFlayer = () => {

            var form = document.getElementById("form-img-act-flayer")
            var fecha = $('#monthSearch').val()
            console.log(fecha);
            var formulario = new FormData(form);
            formulario.append('valor', 'valor');
            formulario.append('fecha', fecha);
            var datos = $.ajax({
                url: window.location.href,
                type: "post",
                dataType: "json",
                data: formulario,
                cache: false,
                contentType: false,
                processData: false
            });

            datos.done((res) => {

                Swal.fire({
                    text: "Información actualizada",
                    icon: "success",
                    showConfirmButton: false,
                    position: "top-end",
                    timer: 2000,
                    toast: true,
                });

                document.getElementById('imgCreativoPtee').innerHTML = res.img;

                form.reset()
                $('#exampleModal').modal('hide')
                document.getElementById('preview').style.display = "none";
            })

            datos.fail(() => {
                Swal.fire({
                    text: "Hubo un problema de conexión, vuelve a intentar",
                    icon: "error",
                    showConfirmButton: false,
                    position: "top-end",
                    timer: 2000,
                    toast: true,
                });
            })
        }

        searchInfoDate = (fecha) => {
            var datos = $.ajax({
                url: window.location.href + "/search",
                type: "post",
                dataType: "json",
                data: {
                    fecha
                }
            });

            datos.done((response) => {
                document.getElementById('imgCreativoPtee').innerHTML = response.img;
                document.getElementById('cantidadViewsFlayer').innerHTML = response.cantidad
                document.getElementById('infoTableFlayerUsers').innerHTML = response.table
                dataTablesFormat();
            });
        }

        ExportInfoExcel = () => {
            var fecha = $('#monthSearch').val()
            location.href = window.location.href + "/download-excel/" + fecha
        }
    </script>
@endsection
