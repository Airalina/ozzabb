<div>
    <button wire:click="backToExplorar()" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i>
        Volver</button>
</div>
<br>
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Retiros</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive">
        <div>
            <label class="float-left mr-2">Registros por página:</label><input style="width: 60px; height: 30px"
                type="number" wire:model="paginasInternasRetiros" min="1" class="form-control">
        </div>
        <x-list-withdraws-details :withdraws="$withdrawsList" />
        {{ $withdrawsList->links() }}
    </div>
    <!-- /.card-body -->
</div>
