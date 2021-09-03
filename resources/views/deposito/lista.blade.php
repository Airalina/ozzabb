            <div class="card">
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
                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                  @if (auth()->user()->can('storedepo', auth()->user()))
                    <div>
                        <button wire:click="create()" type="button" class="btn btn-info btn-sm">Agregar Deposito</button>
                    </div>
                  @endif
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th style="text-align: center">Nombre</th>
                      <th style="text-align: center">Ubicación</th>
                      <th style="text-align: center">Propósito</th>
                      <th style="text-aling: center">Fecha de Creación</th>
                      <th style="text-align: center">Estado</th>
                      <th></th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($depositos as $deposito)
                    <tr>
                      <td style="text-align: center">{{ $deposito->name }}</td>
                      <td style="text-align: center">{{ $deposito->location }}</td>
                      <td style="text-align: center">{{ $deposito->purpose }}</td>
                      <td >{{ date('d-m-Y', strtotime($deposito->create_date)) }}</td>
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
                        <button type="button" wire:click="explora({{$deposito}})" class="btn btn-primary btn-xs"><i class="fas fa-file-alt"></i> Ver</button>
                        @if (auth()->user()->can('deletedepo', auth()->user()))
                        <button type="button" wire:click="delete({{$deposito}})" class="btn btn-danger btn-xs">Borrar</button>
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
              </div>
              <!-- /.card-body -->
            </div>