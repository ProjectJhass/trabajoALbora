@extends('apps.control_madera.plantilla.app')
@section('body')
    <div class="">
        <div class="clearfix"></div>
        <div class="page-title">
            <div class="title_left">
                <h4>Cortes planificados - {{ $estado }}</h4>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-12">
            <div>
                <div class="x_title">
                    <h2></h2>
                    <div class="clearfix"></div>
                </div>
                <div>
                    <ul class="list-unstyled top_profiles scroll-view">
                        @foreach ($cortes as $item)
                            <li class="media event mb-3">
                                <a href="{{ route('info.piezas.c.planner', ['id_corte' => $item->id]) }}" class="pull-left border-red profile_thumb">
                                    <i class="fab fa-steam-symbol red"></i>
                                </a>
                                <div class="media-body">
                                    <a class="title"
                                        href="{{ route('info.piezas.c.planner', ['id_corte' => $item->id]) }}">{{ $item->mueble . ' ' . $item->serie . ' ' . strtoupper($item->madera) }}</a>
                                    <p class="red"><strong>X {{ $item->cantidad }} UNIDADES</strong></p>
                                    <p> <small>{{ $item->created_at }}</small>
                                    </p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
