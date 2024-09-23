@foreach ($historialMaquina as $historial)
    <div class="post">
        <div class="user-block">
            <img class="img-circle img-bordered-sm" src="{{ asset('img/mantenimiento.png') }}" alt="user image">
            <span class="username">
                <div><b>Descripción del requerimiento: </b> <b class="text-primary">{{ $historial->solicitud }}</b></div>
            </span>
            <span class="description">
                <b>Responsable: </b>{{ $historial->responsable_s }} <br>
                <b>Fecha: </b>{{ $historial->fecha_solicitud }}
            </span>
        </div>
        <div class="pl-5">
            <p style="margin-bottom: 0">
                <b>Solución</b> <br>
                {{ $historial->respuesta_solicitud }}
            </p>
            <span class="description mt-3" style="font-size: 13px;">
                Responsable: {{ $historial->responsable_respuesta }} <br>
                Fecha: {{ $historial->fecha_respuesta }}
            </span>
        </div>
    </div>
@endforeach
