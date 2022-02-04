            <div class="card">
            <style>
              nav svg {
                height: 20px;
              }     
            </style>
              <div class="card-header">
                <h3 class="card-title">Depositos</h3>
                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                  <div>
                    <input type="text" name="searchdeposito" wire:model="searchdeposito" class="form-control float-right" placeholder="Buscar">
                  </div>
                  </div>
                </div>
              </div>
              <div class="card-header">
                <div>  
                      <label class="float-left">Registros por pagina:</label><input style="width: 60px; height: 30px" type="number" wire:model="paginas" class="form-control">
                </div>
                <div class="card-tools">             
                  <div class="input-group input-group-sm"> 
                  @if (auth()->user()->can('storedepo', auth()->user()))
                    <div>
                        <button wire:click="create()" type="button" class="btn btn-info btn-sm">Agregar Deposito</button>
                    </div>
                  @endif
                </div>
              </div>
              <br>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover table-sm" >
                <div class="form-group" data-select2-id="45">
                    <label>Ordenar por</label>
                    <select wire:model="order" class="form-control select2bs4 select2-hidden-accessible"
                        style="width: 100%;" tabindex="-1" aria-hidden="true">
                        <option data-select2-id="47" value="type">Tipo</option>
                        <option data-select2-id="48" value="name">Nombre</option>
                        <option data-select2-id="49" value="location">Ubicación</option>
                        <option data-select2-id="50" value="description">Propósito</option>
                    </select>
                </div>
                  <thead>
                    <tr>
                      <th  style="text-align: center">Nombre</th>
                      <th style="text-align: center">Tipo</th> 
                      <th style="text-align: center">Ubicación</th>
                      <th style="text-align: center">Propósito</th>
                      <th style="text-align: center">Fecha de Creación</th>
                      <th style="text-aling: center">Temporal</th>
                      <th style="text-align: center; width:70px">Estado</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($depositos as $deposito)
                    <tr>
                      <td style="text-align: center">{{ $deposito->name }}</td>
                      @switch($deposito->type)
                            @case(1)
                                <td style="text-align: center">Almacén</td>
                                @break
                            @case(2)
                                <td style="text-align: center">Producción</td>
                                @break
                            @case(3)
                                <td style="text-align: center">Ensamblados</td>
                                @break
                            @case(4)
                                <td style="text-align: center">Expedición</td>
                                @break
                      @endswitch
                      <td style="text-align: center">{{ $deposito->location }}</td>
                      <td style="text-align: center">{{ $deposito->description }}</td>
                      <td style="text-align: center">{{ date('d-m-Y', strtotime($deposito->create_date)) }}</td>
                      <td style="text-align: center">{{ ($deposito->temporary == 1) ? 'Sí' : 'No'  }}</td>
                      @switch($deposito->state)
                            @case(1)
                                <td style="text-align: center">Habilitado</td>
                                @break
                            @case(2)
                                <td style="text-align: center">Lleno</td>
                                @break
                            @case(3)
                                <td style="text-align: center">Deshabilidato</td>
                                @break
                      @endswitch
                      <td style="text-align: center">
                        <button type="button" wire:click="explora({{$deposito}})" class="btn btn-primary btn-sm"><i class="fas fa-file-alt"></i> Ver</button>
                        @if (auth()->user()->can('updatedepo', auth()->user()))
                          <button type="button" wire:click="update({{$deposito}})" class="btn btn-success btn-sm">Actualizar</button>
                        @endif
                        @if (auth()->user()->can('deletedepo', auth()->user()))
                          <button type="button" wire:click=" destruirdepo({{$deposito}})" class="btn btn-danger btn-sm">Borrar</button>
                        @endif
                      </td>
                    </tr>
                    @empty
                      <tr class="text-center">
                        <td style="text-align: center" colspan="4" class="py-3 italic">No hay información</td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
                {{ $depositos->links() }}
              </div>
              @include('borrar')
              <!-- /.card-body -->
            </div>