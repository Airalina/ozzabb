<div>
  <button wire:click="cancelar()" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Volver</button>
</div>
<br>
<div class="card card-primary">
            <div class="card-body">
                <div class="form-group">
                @if($seeimg==false)
                    <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Materiales registrados en la instalación:</font></font></label>

                          <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                <th style="text-align: center">Codigo Material</th>
                                <th style="text-align: center">Descripción</th>
                                <th style="text-align: center">Cantidad</th>
                                <th></th>
                              </tr>
                            </thead>
                            <tbody>
                           
                              @forelse($detailslist as $detail)
                                <tr>
                                  <td style="text-align: center">{{ $mat[$detail->material_id]['code']}}</td>
                                  <td style="text-align: center">{{ $mat[$detail->material_id]['description']}}</td>
                                  <td style="text-align: center">{{ $detail->amount }}</td>
                                </tr> 
                              @empty
                                  <tr class="text-center">
                                    <td colspan="4" class="py-3 italic">No hay información</td>
                                  </tr>
                              @endforelse

                            </tbody>
                            </table>
                          <button type="button" wire:click="verimagen()" class="btn btn-primary btn-xs"><i class="fas fa-file-alt"></i> Ver Diagrama</button>
                          @else
                          <img src="{{ asset('images/'.$photo.'')}}">
                          <br>
                          <br>
                          <button type="button" wire:click="noverimagen()" class="btn btn-primary btn-xs"> Volver a la descripción</button>
                          @endif
                </div>
            </div>
</div>