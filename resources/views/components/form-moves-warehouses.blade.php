<div class="form-group">
    <label for="name_entry">Responsable de ingreso:</label>
    <div class="row">
        <div class="col-4">
            <input type="text" name="name_entry" id="name_entry" wire:model="movements.name_entry" class="form-control form-control-sm"
                style="width: auto" placeholder="Responsable de ingreso">
        </div>
    </div>
</div>
<div class="form-group">
    <label for="name_receive">Responsable de recibir:</label>
    <div class="row">
        <div class="col-4">
            <input type="text" name="name_receive" id="name_receive" wire:model="movements.name_receive" class="form-control form-control-sm"
                style="width: auto" placeholder="Responsable de recibir">
        </div>
    </div>
</div>
<div class="form-group">
    <label for="date">Fecha</label>
    <div class="row">
        <div class="col-4">
            <input type="date" name="date" id="date" wire:model="movements.date" class="form-control form-control-sm"
                style="width: auto" placeholder="dd/mm/AAAA">
        </div>
    </div>
</div>
<div class="form-group">
    <label for="hour">Hora</label>
    <div class="row">
        <div class="col-4">
            <input type="time" name="hour" id="hour" wire:model="movements.hour" style="width: auto"
                class="form-control form-control-sm" placeholder="">
        </div>
    </div>
</div>