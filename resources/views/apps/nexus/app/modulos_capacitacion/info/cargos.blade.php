<div class="row">
    @foreach ($info as $item)
        <div class="col-md-3 mb-2 d-flex">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-center">
                        <div class="d-flex flex-column text-center align-items-center justify-content-between ">
                            <div class="fs-italic">
                                <h5>{{ $item->nombre_cargo }}</h5>
                            </div>
                            <div class="text-black-50 text-warning">
                                <svg class="icon-20" xmlns="http://www.w3.org/2000/svg" width="20px" viewBox="0 0 20 20" fill="orange">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                    </path>
                                </svg>
                                <svg class="icon-20" xmlns="http://www.w3.org/2000/svg" width="20px" viewBox="0 0 20 20" fill="orange">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                    </path>
                                </svg>
                                <svg class="icon-20" xmlns="http://www.w3.org/2000/svg" width="20px" viewBox="0 0 20 20" fill="orange">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                    </path>
                                </svg>
                                <svg class="icon-20" xmlns="http://www.w3.org/2000/svg" width="20px" viewBox="0 0 20 20" fill="orange">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                    </path>
                                </svg>
                                <svg class="icon-20" xmlns="http://www.w3.org/2000/svg" width="20px" viewBox="0 0 20 20" fill="orange">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                    </path>
                                </svg>
                            </div>
                            <a href="{{ route('info.modulos.nexus', ['id_cargo' => $item->id_cargo]) }}"
                                class="card-profile-progress">
                                <div id="circle-progress-1{{ $item->id_cargo }}" class="circle-progress-basic circle-progress-primary"
                                    data-min-value="0" data-max-value="100" data-value="80" data-type="percent" role="progressbar" aria-valuemin="0"
                                    aria-valuemax="100" aria-valuenow="80">
                                    <svg version="1.1" width="100" height="100" viewBox="0 0 100 100" class="circle-progress">
                                        <circle class="circle-progress-circle" cx="50" cy="50" r="46" fill="none" stroke="#ddd"
                                            stroke-width="8">
                                        </circle>
                                    </svg>
                                </div>
                                <img src="{{ asset('img/profile.png') }}" alt="User-Profile" class="img-fluid rounded-circle card-img">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
