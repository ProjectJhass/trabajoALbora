<div class="row">
    @foreach ($data as $value)
    <div class="col-sm-6">
        <div div class="card card-danger shadow ml-1 tarjeta_ p-0 rounded">
            <div class="card-header bg-gradient-danger">
                <h3 class="card-title"><i class="fas fa-tools"></i>&nbsp;&nbsp;<b>Información Mantenimiento&nbsp;</b>
                </h3>


            </div>
            <div class="card-body" style="color: #697a8d">
                <div class="row">
                    <div class="col">
                        <label class="mb-1">Máquina:&nbsp;<small>{{$value->referencia. " - ". $value->nombre_maquina }}</small></label>
                    </div>
                </div>
                <hr style="color: #0056b2;" />
                <label class="mb-1">Observación:&nbsp;<small>{{ $value->observacion }}</small><br>
                    <small>{{$value->fecha_creacion." - ". $value->nombre_creador }}</small></label>
                <hr style="color: #0056b2;" />
                <label class="mb-1">Solución:&nbsp;<small>{{ $value->observacion2 }}</small></label>
                <br>
                    <small>{{$value->fecha_realizacion." - ". $value->responsable }}</small></label>
            </div>
        </div>
    </div>
    @endforeach
</div>
