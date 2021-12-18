<div>
  <button wire:click="toexplora()" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i>
    Volver</button>
</div>
<br>
<div class="card card-primary">
  <div class="card-header">
    <h3 class="card-title">Registro de Instalación</h3>
  </div>
  <div>
    @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    <div class="card-body">
      <form>
        <h5>Datos de Ensamblado</h5>
        <br>
        <div class="form-group">
          <label>Descripción</label>
          <textarea class="form-control form-control-sm" rows="3" wire:model="description" style="width: 300px"
            placeholder="Descripción ..."></textarea>
        </div>
        <div class="form-group">
          <label>Fecha de Ingreso</label>
          <input type="date" wire:model="date" class="form-control form-control-sm" style="width: auto"
            placeholder="dd/mm/AAAA">
        </div>
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Seleccione material a ser agregado:</h3>
            <br>
            <div class="input-group input-group-sm" style="width: 150px;">
              <input wire:model="searchmateriales" type="text" class="form-control form-control-xs float-right"
                placeholder="Buscar material...">
            </div>
          </div>
          <!-- /.card-header -->
          @if($searchmateriales!="")
          <div class="card-body table-responsive p-0">
            <table class="table table-hover table-sm">
              <thead>
                <tr>
                  <th style="text-align: center">Codigo</th>
                  <th style="text-align: center">Descripción</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @forelse($materiales as $material)
                <tr>
                  <td style="text-align: center">{{ $material->code }}</td>
                  <td style="text-align: center">{{ $material->description }}</td>
                  <td><button type="button" wire:click="selectmaterial({{ $material->id }})"
                      class="btn btn-success btn-sm">Seleccionar</button></td>
                </tr>
                @empty
                <tr class="text-center">
                  <td colspan="4" class="py-3 italic">No hay información</td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
          @endif
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Materiales agregados:</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover table-sm">
              <thead>
                <tr>
                  <th style="text-align: center">Codigo</th>
                  <th style="text-align: center">Descripción</th>
                  <th style="text-align: center">Cantidad</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach($details as $detail)
                <tr>
                  <td style="text-align: center">{{ $detail[0] }}</td>
                  <td style="text-align: center">{{ $detail[1] }}</td>
                  <td style="text-align: center">{{ $detail[2] }}</td>
                  <td style="text-align: center"><button type="button" wire:click="downmateriall({{ $detail[3] }})"
                      class="btn btn-danger btn-sm">Quitar</button></td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </form>
    </div>
  </div>
  <div class="card-footer">
    <td><button wire:click="store()" type="button" class="btn btn-primary">Guardar </button></td>
    <td><button wire:click="volver()" type="button" class="btn btn-primary">Cancelar</button></td>
  </div>
</div>
<div wire:ignore.self class="modal" id="form" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form wire.submit.prevent="addmaterial">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Material</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <p><label>Codigo: </label> {{$codem}}</p>
          </div>
          <div class="form-group">
            <p><label>Descripción: </label> {{$descriptionm}}</p>
          </div>
          <div class="form-group">
            <label>Cantidad:</label>
            <input wire:model.defer="amount" type="number">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" wire:click.prevent="addmateriall()" class="btn btn-primary btn-sm">Agregar</button>
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </form>
  </div>
</div>
</div>