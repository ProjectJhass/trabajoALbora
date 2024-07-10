@php
    $bandera = 1;
@endphp
<div class="bd-example mt-4">
    <div class="accordion" id="accordionExample">
        @foreach ($info as $item)
            <div class="accordion-item{{ $item->id_evaluacion }} mb-2">
                <h4 class="accordion-header" id="heading{{ $item->id_evaluacion }}">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapse{{ $item->id_evaluacion }}" aria-expanded="true" aria-controls="collapse{{ $item->id_evaluacion }}">
                        Evaluación {{ $bandera }} - {{ $item->nombre_evaluacion }}
                    </button>
                </h4>
                <div id="collapse{{ $item->id_evaluacion }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $item->id_evaluacion }}"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="iq-timeline0 m-0 d-flex align-items-center justify-content-between position-relative">
                            <ul class="list-inline p-0 m-0">
                                @foreach ($item->getPreguntasEvaluacion as $value)
                                    <li class="mt-4">
                                        <div class="timeline-dots1 border-warning text-warning">
                                            <i class="fas fa-book-open"></i>
                                        </div>
                                        <h6 class="float-left mb-3">¿{{ $value->pregunta_ev }}?</h6>
                                        <div class="d-inline-block w-100">
                                            R/: <br>
                                            @switch($value->tipo_respuesta)
                                                @case('multiple')
                                                    <div class="list-group">
                                                        <label class="list-group-item">
                                                            <input class="form-check-input me-1" type="checkbox" value="">
                                                            A. {{ $value->respuesta1 }}
                                                        </label>
                                                        <label class="list-group-item">
                                                            <input class="form-check-input me-1" type="checkbox" value="">
                                                            B. {{ $value->respuesta2 }}
                                                        </label>
                                                        <label class="list-group-item">
                                                            <input class="form-check-input me-1" type="checkbox" value="">
                                                            C. {{ $value->respuesta3 }}
                                                        </label>
                                                        <label class="list-group-item">
                                                            <input class="form-check-input me-1" type="checkbox" value="">
                                                            D. {{ $value->respuesta4 }}
                                                        </label>
                                                    </div>
                                                @break

                                                @case('file')
                                                    <input type="file" class="form-control" readonly name="" id="">
                                                @break

                                                @case('text')
                                                    <textarea readonly class="form-control" name="" id="" cols="30" rows="3"></textarea>
                                                @break

                                                @case('vf')
                                                    <div class="list-group">
                                                        <label class="list-group-item">
                                                            <input class="form-check-input me-1" type="checkbox" value="">
                                                            A. {{ $value->respuesta1 }}
                                                        </label>
                                                        <label class="list-group-item">
                                                            <input class="form-check-input me-1" type="checkbox" value="">
                                                            B. {{ $value->respuesta2 }}
                                                        </label>
                                                    </div>
                                                @break

                                                @default
                                            @endswitch
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
            @php
                $bandera++;
            @endphp
        @endforeach
    </div>
</div>
