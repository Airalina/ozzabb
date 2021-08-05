<div>
<div class="card">
            <div class="card-header">
                <h3 class="card-title">Clientes Registrados</h3>
                <div class="card-tools">
                  @if (auth()->user()->can('storecust', auth()->user()))
                    <div>
                      <button wire:click="funcion()" type="button" class="btn btn-info">Agregar Cliente</button>
    	              </div>
                  @endif
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input wire:model="search" type="text" class="form-control float-right" placeholder="Buscar Cliente...">
                    </div>
                </div>
            </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-sm">
                  <thead>
                    <tr>
                      <th>Nombre</th>
                      <th>Teléfono</th>
                      <th>Email</th>
                      <th>Domicilio Administración</th>
                      <th>Estado</th>
                    </tr>
                  </thead>
                  
            <tbody>
              @forelse($clientes as $cliente)
                <tr class="registros">
                      <td>{{ $cliente->name }}</td>
                      <td>{{ $cliente->phone }}</td>
                      <td>{{ $cliente->email}}</td>
                      <td>{{ $cliente->domicile_admin}}</td>
                      @if($cliente->estado==true)
                        <td>Activo</td>
                      @else
                        <td>Inactivo</td>
                      @endif
                      <td >
                        <button type="button" wire:click="explorar({{ $cliente->id }})" class="btn btn-primary btn-xs"><i class="fas fa-file-alt"></i>    Ver</button>
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
</div>
