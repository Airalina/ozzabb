<div>
    <button wire:click="back()" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Volver</button>
</div>
<br>
<div class="col-md-6">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Detalle de instalación</h3>
        </div>
        <form>
            <div class="card-body">
                <x-form-validation-errors :errors="$errors" />
                <x-form-create-installation disabled='disabled' :customersData="$customersData" />
                <div class="card-tools">
                    <div>
                        <button wire:click="newRevision()" type="button" class="btn btn-info btn-sm">Nueva
                            Revisión</button>
                    </div>
                </div>
               <x-list-revisions-card :revisions="$installation['revisions']" />
            </div>
            @include('borrar')
    </div>
</div>
