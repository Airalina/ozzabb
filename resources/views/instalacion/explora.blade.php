<div class="card-tools">
              <div>
                    <button wire:click="volver()" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Volver</button>
    	        </div>
              <br>
              <div class="card-header">
                <h6 class="card-title">Usted a seleccionado la instalacion con código: {{ $code }} </h6><br>
                <h6 class="card-title">Descripción: {{ $description }} </h6><br>
                <h6 class="card-title">Precio Unitario: {{ $usd_price }} </h6><br>
                <h6 class="card-title">Fecha de creación: {{ $date_admission }} </h6><br>
                <div class="card-tools">
                  @if (auth()->user()->can('updateinstall', auth()->user()))
                    <button wire:click="newrevision()" type="button" class="btn btn-info">Nueva Revision</button>
                  @endif
                </div>
              </div>
<div class="row">
    <table class="table table-hover text-nowrap">
          <thead>        
            
                    <tr>
                      <th>N° de revisión</th>
                      <th>Razón</th>
                      <th>Fecha de creación</th>
                      <th></th>
                    </tr>
                  </thead>
                  
                  <tbody>
                  @foreach($revisiones as $rev)
                        <tr>
                            <td>{{ $rev->number_version }}</td>
                            <td>{{ $rev->reason }}</td>
                            <td>{{ $rev->create_date }}</td>                 
                            <td>
                              <button type="button" wire:click="seedetail({{$rev->number_version}})" class="btn btn-primary btn-xs"><i class="fas fa-file-alt"></i> Ver</button>
                              @if (auth()->user()->can('updateinstall', auth()->user()))
                                <button type="button" wire:click="exploradetail({{$rev->number_version}})" class="btn btn-primary btn-xs"> Actualizar</button>
                              @endif
                              @if (auth()->user()->can('deleteinstall', auth()->user()))
                                <button type="button" wire:click="borrarevision({{ $rev }})" class="btn btn-danger btn-xs">Borrar</button>
                              @endif
                            </td>
                        </tr>
                    @endforeach
                   
                  </tbody>
                </table>
                {{$revision}}
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
</div>