<div>
        <button wire:click="volver()" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Volver</button>
</div>
<br>
<div class="col-md-6">
<div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Registro de depósito</h3>
              </div>  
            <form>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <h5>Datos de depósito</h5>
                        <br>    
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nombre</label>
                            <input class="form-control form-control-sm" type="text" wire:model="name" placeholder="Ingrese nombre del deposito">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Ubicación</label>
                            <input class="form-control form-control-sm" type="email" wire:model="location" placeholder="Ingrese ubicación del depósito">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Descripción</label>
                            <textarea class="form-control form-control-sm" rows="3" wire:model="descriptionw" placeholder="Descripción ..."></textarea>
                        </div>
                        @if(!$temporary)
                            <div class="form-check">
                                <input type="checkbox" wire:model="permanent" class="form-check-input" id="exampleCheck2"  checked="">
                                <label for="exampleInputEmail1">Permanente ( Indica si el depósito es permanente "tildado" )</label>
                            </div>
                        @endif
                        @if(!$permanent)
                            <div class="form-check">
                                <input type="checkbox" wire:model="temporary" class="form-check-input" id="exampleCheck1"  checked="">
                                <label for="exampleInputEmail1">Temporal ( Indica si el depósito es temporal "tildado" )</label>
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tipo de depósito</label>
                            <select class="form-control form-control-sm select2 select2-hidden-accessible" wire:model="type" style="width: auto">
                                <option selected="selected" ></option>
                                <option >Almacén</option>
                                <option >Producción</option>
                                <option >Ensamblados</option>
                                <option >Expedición</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Fecha de creación</label>
                            <div class="row">
                                <div class="col-4">
                                    <input type="date" wire:model="create_date" class="form-control form-control-sm" placeholder="dd/mm/AAAA" >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <td><button wire:click="store()" type="button" class="btn btn-primary">Guardar </button></td>
                        <td><button wire:click="volver()" type="button" class="btn btn-primary">Cancelar</button></td>
                    </div>
            </form>
</div>
</div>
