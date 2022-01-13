<div class="card">
              <div class="card-header">
                <h3 class="card-title">Instalaciones</h3>
                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                  <div>
                    <input type="text" name="search" wire:model="searchinstallation" class="form-control float-right" placeholder="Buscar">
                  </div>
                  </div>
                </div>
              </div>
              <div class="card-header">
                <div>  
                  <label class="float-left">Registros por pagina:</label><input style="width: 60px; height: 30px" type="number" min="1" wire:model="paginas" class="form-control">
                </div>
                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <div>
                      @if (auth()->user()->can('storeinstall', auth()->user()))
                        <button wire:click="create()" type="button" class="btn btn-info btn-sm">Agregar Instalaciones</button>
    	                @endif
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap table-sm">
                  <div class="form-group" data-select2-id="45">
                      <label>Ordenar por</label>
                      <select wire:model="order" class="form-control select2bs4 select2-hidden-accessible"
                          style="width: 100%;" tabindex="-1" aria-hidden="true">
                          <option data-select2-id="47" value="code">Codigo</option>
                          <option data-select2-id="48" value="description">Descripción</option>
                          <option data-select2-id="49" value="usd_price">Precio U$D</option>
                      </select>
                  </div>
                  <thead>
                    <tr>
                      <th style="text-align: center">Codigo</th>
                      <th style="text-align: center">Descripcion</th>
                      <th style="text-align: center">Precio U$D</th>
                      <th style="text-align: center">Fecha de Ingreso</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($instalaciones as $instalacion)
                    <tr>
                      <td style="text-align: center">{{ $instalacion->code }}</td>
                      <td style="text-align: center">{{ $instalacion->description }}</td>
                      <td style="text-align: center">{{ $instalacion->usd_price }}</td>
                      <td style="text-align: center">{{ date('d-m-Y', strtotime($instalacion->date_admission)) }}</td>
                      <td style="text-align: center">
                        <button type="button" wire:click="explora({{ $instalacion->id }})" class="btn btn-primary btn-sm"><i class="fas fa-file-alt"></i> Ver</button>
                        @if (auth()->user()->can('updateinstall', auth()->user()))
                          <button type="button" wire:click="updateinstallation({{ $instalacion->id }})" class="btn btn-success btn-sm">Actualizar</button>
                        @endif
                        @if (auth()->user()->can('deleteinstall', auth()->user()))
                          <button type="button" wire:click="destruir({{ $instalacion->id }})" class="btn btn-danger btn-sm">Borrar</button>
                        @endif
                      </td>
                    </tr>
                    @empty
                      <tr class="text-center">
                        <td colspan="4" class="py-3 italic">No hay información</td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
                {{ $instalaciones->links() }}
              </div>
              @include('borrar')
              <!-- /.card-body -->
            </div>