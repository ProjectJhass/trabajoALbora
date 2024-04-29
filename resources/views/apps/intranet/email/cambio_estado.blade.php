@php
    $baseUrl = env('APP_BASE_URL', 'http://localhost');
@endphp
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Notificación</title>
</head>

<body>
    <p><strong>Reciba un cordial saludo</strong></p>
    <p>Por el presente me permito notificar los diferentes avances de la solicitud realizada</p>
    <p><strong>Nombre de solicitud: </strong>{{ $solicitud }}</p>
    <p><strong>Estado: </strong>{{ $estado }}</p>
    <p><strong>Prioridad: </strong>{{ $prioridad }}</p>
    <p>Esta notificación se ha enviado porque se realizó un cambio de estado en la solicitud,
        para visualizar más detalladamente los cambios
        ingresa a la <a href="{{ $baseUrl }}/intranet_albura/public/bitacora/usuario/inicio/progreso">bitacora de solicitudes</a>.</p>
    <p>¡Espero su día sea muy productivo!</p>
    <p>Saludos,</p>
    <p>Dpto de sistemas</p>
</body>

</html>
