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
                <table class="table table-hover text-nowrap">
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
                        <button type="button" wire:click="explora({{ $instalacion->id }})" class="btn btn-primary btn-xs"><i class="fas fa-file-alt"></i> Ver</button>
                        @if (auth()->user()->can('deleteinstall', auth()->user()))
                          <button type="button" wire:click="delete({{ $instalacion->id }})" class="btn btn-danger btn-xs">Borrar</button>
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
              </div>
              <!-- /.card-body -->
            </div>