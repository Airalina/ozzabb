<div>
    <button wire:click="volver()" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i>
        Volver</button>
</div>
<br>
<div class="card card-primary">
    <div class="card-header">
        <h6 class="card-title">Detalle de depósito </h6>
    </div>
    <div class="card-body">
        <div class="col-md-6">
            <x-form-create-warehouse :types="$types" showOptions="1" disabled="disabled" />
        </div>
        <div class="row">
            @if (auth()->user()->can('updatedepo', auth()->user()))
                @if ($warehouse['type'] != 4)
                    <div class="col">
                        <button style="margin-right: 5px" wire:click="retiros()" type="button"
                            class="btn btn-primary"><i class="fas fa-file-alt"></i> Ver retiros de este
                            depósito</button>
                    </div>
                @endif
                <div class="card-tools">
                    <div class="col">
                        <button style="margin-right: 5px" wire:click="ingreso()" type="button"
                            class="btn btn-info">Nuevo
                            Ingreso</button>
                        @if ($warehouse['type'] != 4)
                            <button wire:click="egreso()" type="button" class="btn btn-info">Nuevo Egreso</button>
                        @endif
                    </div>
                </div>
            @endif
        </div>
        <div class="card-body table-responsive pl-0">
            <div>
                <label class="float-left mr-2">Registros por página:</label><input style="width: 60px; height: 30px"
                    type="number" wire:model="paginasinternas" min="1" class="form-control">
            </div>
            <table class="table table-hover table-sm">
                @switch($warehouse['type'])
                    @case(1)
                        <x-list-materials-warehouses :elements="$deposited" />
                    @break

                    @case(2)
                        <x-list-materials-warehouses :elements="$deposited" />
                    @break

                    @case(3)
                        <x-list-assembleds-warehouses :elements="$deposited" />
                    @break

                    @case(4)
                        <x-list-installations-warehouses :elements="$deposited" />
                    @break
                @endswitch
            </table>
            {{ $deposited->links() }}
        </div>

    </div>
</div>
</div>
