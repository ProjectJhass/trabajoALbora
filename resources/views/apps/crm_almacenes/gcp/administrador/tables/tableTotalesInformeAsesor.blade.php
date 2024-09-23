<div class="card card-outline card-danger w-100 animate__animated animate__flash">
    <div class="card-header text-center">
        <strong>Totalidades</strong>
        <div class="card-tools">
            <button class="border-0 bg-transparent" onclick="export_excel_data()">
                <img class="excel" src="{{ asset('icons/excel.png') }}" width="5%" alt="">
            </button>
        </div>
    </div>
    <div class="card-body d-flex flex-row justify-content-between text-center">
        <table class="table table-hover" id="load_tbl_quality_crm">
            <thead class="bg-danger">
                <tr>
                    <th scope="col">Cotizaciones Realizadas</th>
                    <th scope="col">Clientes Oportunidades</th>
                    <th scope="col">Clientes Prospectos</th>
                    <th scope="col">Clientes Efectivos</th>
                    <th scope="col">Llamadas Realizadas</th>
                    <th scope="col">Llamadas Pendientes</th>
                    <th scope="col">Productos cotizados</th>
                </tr>
            </thead>
            <tbody>
                <tr class="text-center">
                    <td><b>{{ $cotizaciones_realizadas }}</b></td>
                    <td><b>{{ $clientes_oportunidad }}</b></td>
                    <td><b>{{ $clientes_prospectos }}</td>
                    <td><b>{{ $clientes_efectivos }}</b></td>
                    <td><b>{{ $llamadas_realizadas }}</b></td>
                    <td><b>{{ $llamadas_pendientes }}</b></td>
                    <td><b>{{ $items_cotizados }}</b></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
    function export_excel_data() {
        // Referencia a la tabla
        var tabla = document.getElementById('load_tbl_quality_crm');

        // Crear la estructura para descargar en Excel
        var html = tabla.outerHTML.replace(/ /g, '%20');

        // Crear enlace temporal para descarga
        var enlace = document.createElement('a');
        enlace.href = 'data:application/vnd.ms-excel;charset=utf-8,' + html;
        enlace.download = 'totalidad_asesor.xls'; // Nombre del archivo que se descarga

        // Ejecutar la descarga
        enlace.click();
    }
</script>
