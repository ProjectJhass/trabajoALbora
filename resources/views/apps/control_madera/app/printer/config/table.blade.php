<div class="x_panel">
    <div class="x_title">
        <h2>Impresoras registradas</h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <div class="row">
            <div class="col-sm-12">
                <div class="card-box table-responsive">
                    <p class="text-muted font-13 m-b-30">
                        Las siguientes son impresoras registras, unicamente debe estar activa una, para su correcto funcionamiento
                    </p>
                    <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>IP</th>
                                <th>Puerto</th>
                                <th>Estado</th>
                                <th>Conexión</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($info as $item)
                                <tr style="cursor: pointer" onclick="searchInfoPrinter('{{ $item->id }}')">
                                    <td>{{ $item->id }}</td>
                                    <td class="text-left">{{ $item->nombre }} <br><small>Impresora: {{ $item->impresora }}</small></td>
                                    <td>{{ $item->ip }}</td>
                                    <td>{{ $item->puerto }}</td>
                                    <td>{{ $item->estado == 0 ? 'Inactivo' : 'En uso' }}</td>
                                    <td>{{ $item->conexion }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
