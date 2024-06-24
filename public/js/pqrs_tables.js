document.addEventListener("DOMContentLoaded", function () {
    setupPendientesTable = () => {
        $('#solicitudes-pendientes').DataTable({
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
                [0, "asc"]
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
    setupRealizadasTable = () => {
        $('#solicitudes-realizadas').DataTable({
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
                [0, "asc"]
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
    setupTodasTable = () => {
        $('#solicitudes-todas').DataTable({
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
                [0, "asc"]
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
})
