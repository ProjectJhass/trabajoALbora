@extends('apps.nexus.plantilla.app')
@section('manual')
    active
@endsection
@section('head')
@endsection
@section('body')
    {{--     <div class="row mt-5">
        <div class="col-md-12">
            <div class="flex-wrap d-flex justify-content-between align-items-center">
                <div class="text-white">
                    <h3 class="text-white">Temas de capacitación</h3>
                    <p class="mt-3">Aquí encontrarás los diferentes temas de capacitación, para afianzar tu conocimiento</p>
                </div>
                <div>
                    <a href="#" class="btn btn-gray rounded-pill ">
                        <i class="fas fa-plus"></i>
                        Crear tema de capacitación
                    </a>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="card-title">Manual de funciones</h4>
                    <a href="{{ route('form.manual.nexus') }}" class="btn btn-danger">Crear</a>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Cargo</th>
                                <th>Área</th>
                                <th>Jefe inmediato</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($manuales as $item)
                                <tr>
                                    <td>{{ $item->id_manual }}</td>
                                    <td>{{ $item->cargo }}</td>
                                    <td>{{ $item->area }}</td>
                                    <td>{{ $item->jefe_inmediato }}</td>
                                    <td><a href="{{ route('editar.manual.nexus', ['id_manual' => $item->id_manual]) }}">Ir</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
