<div class="row">
    <div class="col-12">
        <h4>Mantenimientos o Procedimientos Realizados</h4>
        @foreach ($historialMaquina as $historial)
            <div class="post">
                <div class="user-block">
                    <img class="img-circle img-bordered-sm" src="{{ asset('img/mantenimiento.png') }}" alt="user image">
                    <span class="username">
                        <a class="text-primary">{{ $historial->solicitud }}</a>
                    </span>
                    <span class="description">
                        <b>Fecha de Solicitud</b> - {{ $historial->fecha_solicitud }} /
                        <b>Quien Realiza la Solicitud</b> - {{ $historial->responsable_s }} <br>
                        <b>Fecha de Solución</b> - {{ $historial->fecha_respuesta }} /
                        <b>Quien Realiza la Solución</b> - {{ $historial->responsable_respuesta }}
                    </span>
                </div>
                <div class="pl-5">
                    <p>
                        <b>Solución</b> <br>
                        {{ $historial->respuesta_solicitud }}
                    </p>
                </div>
            </div>
        @endforeach
    </div>
</div>
