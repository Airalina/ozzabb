<div class="{{$rowClass}}">
    <div class="{{ $columnClass }}">
        <div class="form-group">
            <label for="name">Nombre de la empresa</label>
            <input type="text" class="form-control" id="name" wire:model="provider.name"
                placeholder="Nombre de la empresa" required {{ $disabled }}>
        </div>
    </div>
    <div class="{{ $columnClass }}">
        <div class="form-group">
            <label for="address">Domicilio</label>
            <input type="text" class="form-control" id="address" wire:model="provider.address"
                placeholder="Domicilio" required {{ $disabled }}>
        </div>
    </div>
    <div class="{{ $columnClass }}">
        <div class="form-group">
            <label for="email">Correo electrónico para ventas</label>
            <input type="email" class="form-control" id="email" wire:model="provider.email"
                placeholder="Correo electrónico para ventas" required {{ $disabled }}>
        </div>
    </div>
</div>

@if (!$modal)
    <div class="{{$rowClass}}">
        <div class="{{ $columnClass }}">
            <div class="form-group">
                <label for="phone">Teléfono</label>
                <input type="text" class="form-control" id="phone" wire:model="provider.phone"
                    placeholder="Teléfono" {{ $disabled }}>
            </div>
        </div>
        <div class="{{ $columnClass }}">
            <div class="form-group">
                <label for="contact_name">Nombre de contacto</label>
                <input type="text" class="form-control" id="contact_name" pattern="[A-Za-z]"
                    wire:model="provider.contact_name" placeholder="Nombre de contacto" {{ $disabled }}>
            </div>
        </div>
        <div class="{{ $columnClass }}">
            <div class="form-group">
                <label for="point_contact">Puesto de contacto</label>
                <input type="text" class="form-control" id="point_contact" wire:model="provider.point_contact"
                    placeholder="Puesto de contaco" {{ $disabled }}>
            </div>
        </div>
    </div>
    <div class="{{$rowClass}}">
        <div class="{{ $columnClass }}">
            <div class="form-group">
                <label for="site_url">Página web</label>
                <input type="text" class="form-control" id="site_url" wire:model="provider.site_url"
                    placeholder="www.paginaweb.com" {{ $disabled }}>
            </div>
        </div>
        <div class="{{ $columnClass }}">
            <div class="form-group">
                <label for="cuit">CUIT</label>
                <input type="text" class="form-control" id="cuit" wire:model="provider.cuit" placeholder="CUIT" {{ $disabled }}>
            </div>
        </div>
        <div class="{{ $columnClass }}">
            <div class="form-check">
                <label for="exampleCheck1" class="form-check-label">
                    <input type="checkbox" wire:model="provider.status" class="form-check-input"
                        id="exampleCheck1" {{ $disabled }}>Activo</label>
            </div>
        </div>
    </div>
@endif
