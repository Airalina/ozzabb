<div>
    <button wire:click="cancelarup()" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i>
        Volver</button>
</div>
<br>
<div class="col-md-6">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Registro de Domicilio</h3>
        </div>
        <form>
            @include('cliente.createAddress')
        </form>
    </div>
</div>
