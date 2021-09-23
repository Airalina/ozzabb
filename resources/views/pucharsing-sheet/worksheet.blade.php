
 <div>
     <div class="card card-tabs">
         <div class="card-header">
             <h3 class="card-title">Solicitud de pedidos</h3>
         </div>
         <!-- /.card-header -->
         <div class="card-body table-responsive">
             <div class="form-group">
                 <label>Fecha pedido</label>
                 <div class="input-group input-group-sm">
                     <div>
                         <input wire:model="date" type="date" class="form-control" value="{{ date('Y-m-d') }}">
                     </div>
                 </div>
             </div>
             <div wire:ignore>
                 <label>Número de pedido</label>
                 <select class="form-control" id="select2-dropdown" multiple="multiple">
                     <option>Seleccione una opción</option>
                     @foreach ($orders as $order)
                         <option value="{{ $order->id }}">{{ $order->id }}/2021</option>
                     @endforeach
                 </select>
                 <div class="form-group">
                     <button type="button" wire:click="order_change()"
                         class="btn btn-success btn-xs">Seleccionar</button>
                 </div>
             </div>
             @if ($select)
                 <table class="table table-head text-nowrap">
                     <thead>
                         <tr>
                             <th>Código Pedido</th>
                             <th>Fecha entrega</th>
                             <th>Cantidad total</th>
                             <th>Estado</th>
                             <th>Compras</th>
                             <th>Fecha de inicio</th>
                         </tr>
                     </thead>
                     <tbody>

                         @forelse($clientorders as $key => $clientorder)
                             @if (isset($clientorder->id))
                                 <tr class="registros">
                                     <td>{{ $clientorder->id }} </td>
                                     <td>{{ $clientorder->deadline->format('d-m-Y') }} </td>
                                     <td>{{ $total_amount[$key] }} </td>
                                     <td>{{ $clientorder->order_state }} </td>
                                     <td>
                                         @if (!empty($buys))
                                             No
                                         @else
                                             Sí
                                         @endif
                                     </td>
                                     <td> {{ isset($clientorder->created_at) ? $clientorder->created_at->format('d-m-Y') : '' }}
                                     </td>
                                 </tr>
                             @endif
                         @empty
                             <div> No hay registros</div>
                         @endforelse
                     </tbody>
                 </table>
                 <!-- <div class="form-group">
                    <button wire:click="save()" type="button" class="btn btn-primary">Guardar Cambios</button>
                </div> 
                -->
             @endif

         </div>
         <!-- /.card-body -->
     </div>
 </div>


 @section('js')
     <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

     <script>
         $(document).ready(function() {
             $('#select2-dropdown').select2();
             $('#select2-dropdown').on('change', function(e) {
                 var data = $('#select2-dropdown').select2("val");
                 var data2 = $('select2-selection__choice__remove').select2("val");

                 @this.emit('clientOrdersSelected', data);
             });
         });
     </script>
 @stop
