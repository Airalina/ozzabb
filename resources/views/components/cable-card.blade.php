<div class="form-group">
    <label for="section">Sección</label>
    <input type="text" class="form-control" id="section" wire:model="cable.section"
        placeholder="Grosor del cable en mm (para decimales usar 'punto(.)')" {{ $explorar['readonly'] }}>
</div>
<div class="form-group">
    <label for="base_color">Color base</label>
    <select class="form-control form-control-sm" wire:model="cable.base_color" id="base_color"
        {{ $explorar['disabled'] }}>
        <option selected value="" hidden>Selecciona un color</option>
        @foreach ($content['colors'] as $color)
            <option value="{{ $color['name'] }}" style="color:{{ $color['value'] }}">{{ $color['name'] }}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="line_color">Color Línea</label>
    <select class="form-control form-control-sm" wire:model="cable.line_color" id="line_color"
        {{ $explorar['disabled'] }}>
        <option selected value="" hidden>Selecciona un color</option>
        @foreach ($content['colors'] as $color)
            <option value="{{ $color['name'] }}" style="color:{{ $color['value'] }}">{{ $color['name'] }}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="braid_configuration">Configuración de Trenza</label>
    <select class="form-control form-control-sm" wire:model="cable.braid_configuration" id="braid_configuration"
        {{ $explorar['disabled'] }}>
        <option selected value="" hidden>Selecciona una configuración</option>
        @foreach ($content['configurations'] as $configuration)
            <option value="{{ $configuration }}">{{ $configuration }}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="norm">Norma</label>
    <select class="form-control form-control-sm" wire:model="cable.norm" id="norm"
        {{ $explorar['disabled'] }}>
        <option selected value="" hidden>Selecciona una norma</option>
        @foreach ($content['norms'] as $norm)
            <option value="{{ $norm }}">{{ $norm }}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="number_of_unipolar">Cantidad de unipolares</label>
    <input type="text" class="form-control" id="number_of_unipolar" wire:model="cable.number_of_unipolar"
        placeholder="Cantidad de unipolares" {{ $explorar['readonly'] }}>
</div>
<div class="form-group">
    <label for="mesh_type">Tipo de malla</label>
    <input type="text" class="form-control" id="mesh_type" wire:model="cable.mesh_type" placeholder="Tipo de malla"
        {{ $explorar['readonly'] }}>
</div>
<div class="form-group">
    <label for="operating_temperature">Temperatura de Servicio</label>
    <input type="text" class="form-control" id="operating_temperature" wire:model="cable.operating_temperature"
        placeholder="Temperatura en grados Celsius (para decimales usar 'punto(.)')"
        {{ $explorar['readonly'] }}>
</div>
