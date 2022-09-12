
<div class="card-body">
    <h5>Datos del domicilio de entrega</h5>
    <br>
    <x-form-validation-errors :errors="$errors" />
    <div class="form-group">
        <label for="exampleInputEmail1">Calle</label>
        <input class="form-control form-control-sm" type="text" wire:model="street" placeholder="Ingrese calle">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Número</label>
        <input class="form-control form-control-sm" type="text" wire:model="number" placeholder="Ingrese numero">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Localidad</label>
        <input class="form-control form-control-sm" type="text" wire:model="location"
            placeholder="Ingrese localidad">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Provincia</label>
        <input class="form-control form-control-sm" type="text" wire:model="province"
            placeholder="Ingrese provincia">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">País</label>
        <input class="form-control form-control-sm" type="text" wire:model="country" placeholder="Ingrese pais">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Código Postal</label>
        <input class="form-control form-control-sm" type="text" wire:model="postcode"
            placeholder="Ingrese codigo postal">
    </div>
</div> 
<div class="card-footer">
    <td><button wire:click="storedir( {{ $cliente }})" type="button" class="btn btn-primary">Guardar</button></td>
    <td><button wire:click="cancelarup()" type="button" class="btn btn-primary">Cancelar</button></td>
</div>
