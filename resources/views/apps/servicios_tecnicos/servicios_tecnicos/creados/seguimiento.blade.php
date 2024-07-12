 @extends('apps.servicios_tecnicos.plantilla.app')
 @section('head')
     <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
     <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
 @endsection
 @section('st')
     active
 @endsection
 @section('body')
     <div class="card mb-4">
         <div class="card-body">
             <div class="filtrosContainer w-100 d-flex  pr-0">
                 <div class='fechasContainer d-flex align-items-center justify-content-betweeen' style="width: 46%">
                     <input onchange="filtrar()" type='month' class='form-control' name='fecha_inicial' id='fecha_inicial'>
                     <label class="mx-2" for=''>Hasta:</label>
                     <input onchange="filtrar()" type='month' class='form-control' name='fecha_final' id='fecha_final'>
                 </div>
                 <select onchange="filtrar()" class="form-control" name="proveedor" id="proveedor" required>
                     <option value="">Seleccionar Proveedor</option>
                     <option value="MUEBLES ALBURA">MUEBLES ALBURA</option>
                     <option value="HAPPY SLEEP">HAPPY SLEEP</option>
                 </select>
                 <select onchange="filtrar()" class="form-control" name="almacen" id="almacen" required>
                     <option value="">Seleccionar Almacen</option>
                     @foreach ($almacenes as $item)
                         <option value="{{ $item->almacen }}">{{ $item->almacen }}</option>
                     @endforeach
                 </select>
                 <select onchange="filtrar()" class="form-control" name="servicio" id="servicio" required>
                     <option value="">Seleccionar Servicio</option>
                     <option value="CLIENTE">CLIENTE</option>
                     <option value="ALMACEN">ALMACEN</option>
                     <option value="BODEGA">BODEGA</option>
                 </select>
             </div>
         </div>
     </div>
     <div class="nav-align-top mb-4">
         @foreach ($valores as $item)
             <ul class="nav nav-tabs nav-fill" role="tablist">
                 <li class="nav-item">
                     <button type="button" class="nav-link active" role="tab"
                         onclick="buscarInformacionSolicitudes('st_en_proceso','all')" data-bs-toggle="tab"
                         data-bs-target="#st_en_proceso" aria-controls="st_en_proceso" aria-selected="true">
                         <i class="tf-icons bx bx-home me-1"></i><span class="d-none d-sm-block">En proceso</span>
                         @if ($item['proceso'] > 0)
                             <span
                                 class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger ms-1">{{ $item['proceso'] }}</span>
                         @endif

                     </button>
                 </li>
                 <li class="nav-item">
                     <button type="button" class="nav-link" role="tab"
                         onclick="buscarInformacionSolicitudes('st_no_gar_def', 'No garantia')" data-bs-toggle="tab"
                         data-bs-target="#st_no_gar_def" aria-controls="st_no_gar_def" aria-selected="false">
                         <i class="tf-icons bx bx-user me-1"></i><span class="d-none d-sm-block">Por definir - No
                             garantía</span>
                         @if ($item['garantia'] > 0)
                             <span
                                 class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger ms-1">{{ $item['garantia'] }}</span>
                         @endif
                     </button>
                 </li>
                 <li class="nav-item">
                     <button type="button" class="nav-link" role="tab"
                         onclick="buscarInformacionSolicitudes('st_recoger', 'Recoger')" data-bs-toggle="tab"
                         data-bs-target="#st_recoger" aria-controls="st_recoger" aria-selected="false">
                         <i class="tf-icons bx bx-message-square me-1"></i><span class="d-none d-sm-block"> Recoger</span>
                         @if ($item['recoger'] > 0)
                             <span
                                 class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger ms-1">{{ $item['recoger'] }}</span>
                         @endif
                     </button>
                 </li>
                 <li class="nav-item">
                     <button type="button" class="nav-link" role="tab"
                         onclick="buscarInformacionSolicitudes('st_definir','En devolucion')" data-bs-toggle="tab"
                         data-bs-target="#st_definir" aria-controls="st_definir" aria-selected="false">
                         <i class="tf-icons bx bx-message-square me-1"></i><span class="d-none d-sm-block"> Por
                             definir</span>
                         @if ($item['definir'] > 0)
                             <span
                                 class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger ms-1">{{ $item['definir'] }}</span>
                         @endif
                     </button>
                 </li>
                 <li class="nav-item">
                     <button type="button" class="nav-link" role="tab"
                         onclick="buscarInformacionSolicitudes('st_historial', 'Definido')" data-bs-toggle="tab"
                         data-bs-target="#st_historial" aria-controls="st_historial" aria-selected="false">
                         <i class="tf-icons bx bx-message-square me-1"></i><span class="d-none d-sm-block"> historial</span>
                         @if ($item['historial'] > 0)
                             <span
                                 class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger ms-1">{{ $item['historial'] }}</span>
                         @endif
                     </button>
                 </li>
                 {{--
                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" onclick="buscarInformacionSolicitudes('st_definidos', 'Definido')"
                        data-bs-toggle="tab" data-bs-target="#st_definidos" aria-controls="st_definidos" aria-selected="false">
                        <i class="tf-icons bx bx-message-square me-1"></i><span class="d-none d-sm-block"> Definidos</span>
                    </button>
                </li> --}}
             </ul>
         @endforeach
         <div id="tablesContainer" class="tab-content">
             <div class="tab-pane fade show active" id="st_en_proceso" role="tabpanel">
                 @php
                     echo $table;
                 @endphp
             </div>
             <div class="tab-pane fade" id="st_no_gar_def" role="tabpanel"></div>
             <div class="tab-pane fade" id="st_recoger" role="tabpanel"></div>
             <div class="tab-pane fade" id="st_definir" role="tabpanel"></div>
             <div class="tab-pane fade" id="st_historial" role="tabpanel"></div>
             {{-- <div class="tab-pane fade" id="st_definidos" role="tabpanel"></div> --}}
         </div>
     </div>
 @endsection
 @section('footer')
     <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
     <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
     <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
     <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
     <script>
         $(document).ready(function() {
             setupTable();
         })
         deleteHtmlTables = () => {
             document.getElementById('st_en_proceso').innerHTML = ''
             document.getElementById('st_no_gar_def').innerHTML = ''
             document.getElementById('st_recoger').innerHTML = ''
             document.getElementById('st_definir').innerHTML = ''
             document.getElementById('st_historial').innerHTML = ''
             // document.getElementById('st_definidos').innerHTML = ''
         }
         setupTable = () => {
             $('#tableStSolicitados').DataTable({
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
                     [0, "desc"]
                 ],
                 "paging": true,
                 "lengthChange": true,
                 "searching": true,
                 "ordering": true,
                 "info": false,
                 "autoWidth": false,
                 "responsive": false,
             });
         }

         buscarInformacionSolicitudes = (seccion, estado) => {
             var fecha_i = $('#fecha_inicial').val();
             var fecha_f = $('#fecha_final').val();
             var proveedor = $('#proveedor').val();
             var almacen = $('#almacen').val();
             var servicio = $('#servicio').val();
             fecha_i ? fecha_i += "-01" : null;
             fecha_f ? fecha_f = getLastDayOfMonth(fecha_f) : null;
             deleteHtmlTables()
             var data = $.ajax({
                 url: "{{ route('info.estado.ost') }}",
                 type: 'POST',
                 dataType: 'json',
                 data: {
                     estado_solicitud: estado,
                     fecha_inicial: fecha_i,
                     fecha_final: fecha_f,
                     proveedor,
                     almacen,
                     servicio
                 },
             })
             data.done((res) => {
                 document.getElementById(seccion).innerHTML = res.info
                 setupTable()
             })
         }

         function getLastDayOfMonth(dateString) {
             let [year, month] = dateString.split('-').map(Number);
             let date = new Date(year, month, 0); // El día 0 del mes siguiente es el último día del mes actual
             let lastDay = date.getDate();
             let formattedMonth = month.toString().padStart(2, '0');
             let formattedDay = lastDay.toString().padStart(2, '0');
             return `${year}-${formattedMonth}-${formattedDay}`;
         }
         filtrar = () => {
             const tabs = document.querySelectorAll('.tab-pane');
             tabs.forEach(element => {
                 if (element.hasChildNodes()) {
                     let seccion = element.id;
                     let estado = null;
                     switch (seccion) {
                         case 'st_en_proceso':
                             estado = 'all';
                             break;
                         case 'st_no_gar_def':
                             estado = 'No garantia';
                             break;
                         case 'st_recoger':
                             estado = 'Recoger';
                             break;
                         case 'st_definir':
                             estado = 'En devolucion';
                             break;
                         case 'st_historial':
                             estado = 'Definido';
                             break;
                         default:
                             break;
                     }
                     console.log(seccion, estado);
                     buscarInformacionSolicitudes(seccion, estado);
                 }
             });
         }
     </script>
 @endsection
