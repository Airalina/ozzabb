<div class="form-group">
    @empty($explorar['readonly'])
        <label for="terminal">Terminales Asociados</label>
        <div class="input-group input-group-sm mb-4" style="width: 150px;">
            <input wire:model="searchTerminal" type="text" class="form-control float-right" placeholder="Buscar Material...">
        </div>
    @endempty
    @if ($searchTerminal != null)
        <table class="table table-head table-sm">
            <thead>
                <tr>
                    <th style="text-align: center">Codigo</th>
                    <th style="text-align: center">Tamaño</th>
                    <th style="text-align: center">Sección mínima agrafado</th>
                    <th style="text-align: center">Sección máxima agrafado</th>
                    <th></th>
                </tr>
            </thead>
            @foreach ($content['listTerminals'] as $material)
                <tbody>
                    <td style="text-align: center">{{ $material->code }}</td>
                    <td style="text-align: center">{{ $material->terminal->size }}</td>
                    <td style="text-align: center">{{ $material->terminal->minimum_section }}</td>
                    <td style="text-align: center">{{ $material->terminal->maximum_section }}</td>
                    <td style="text-align: center"><button wire:click="addTerminalsToConnector({{ $material->id }})"
                            type="button" class="btn btn-primary btn-sm">+</button></td>
                </tbody>
            @endforeach
        </table>
    @endif
    @if (count($content['terminals']) > 0)
        <label for="terminal">Terminales Asociados Seleccionados:</label>
        <table class="table table-head table-sm">
            <thead>
                <tr>
                    <th style="text-align: center">Codigo</th>
                    <th style="text-align: center">Tamaño</th>
                    <th style="text-align: center">Sección mínima agrafado</th>
                    <th style="text-align: center">Sección máxima agrafado</th>
                    <th></th>
                </tr>
            </thead>
            @foreach ($content['terminals'] as $terminal)
                <tbody>
                    <td style="text-align: center">{{ $terminal['code'] }}</td>
                    <td style="text-align: center">{{ $terminal['size'] }}</td>
                    <td style="text-align: center">{{ $terminal['minimum_section'] }}</td>
                    <td style="text-align: center">{{ $terminal['maximum_section'] }}</td>
                    <td style="text-align: center">
                        @empty($explorar['readonly'])
                            <button wire:click="unsetAssociationToConnector('terminals',{{ $terminal['id'] }})"
                                type="button" class="btn btn-danger btn-sm">-</button>
                        @endempty
                    </td>
                </tbody>
            @endforeach
        </table>
    @endif
</div>

<div class="form-group">
    @empty($explorar['readonly'])
        <label for="sello">Sellos Asociados</label>
        <div class="input-group input-group-sm mb-4" style="width: 150px;">
            <input wire:model="searchSeal" type="text" class="form-control float-right" placeholder="Buscar Material...">
        </div>
    @endempty
    @if ($searchSeal != null)
        <table class="table table-head table-sm">
            <thead>
                <tr>
                    <th style="text-align: center">Código</th>
                    <th style="text-align: center">Tipo</th>
                    <th style="text-align: center">Diámetro mínimo de cable</th>
                    <th style="text-align: center">Diámetro máximo de cable</th>
                    <th></th>
                </tr>
            </thead>
            @foreach ($content['listSeals'] as $material)
                <tbody>
                    <td style="text-align: center">{{ $material->code }}</td>
                    <td style="text-align: center">{{ $material->seal->type }}</td>
                    <td style="text-align: center">{{ $material->seal->minimum_diameter }}</td>
                    <td style="text-align: center">{{ $material->seal->maximum_diameter }}</td>
                    <td style="text-align: center"><button wire:click="addSealsToConnector({{ $material->id }})"
                            type="button" class="btn btn-primary btn-sm">+</button></td>
                </tbody>
            @endforeach
        </table>
    @endif
    @if (count($content['seals']) > 0)
        <label for="sello">Sellos Asociados Seleccionados:</label>
        <table class="table table-head table-sm">
            <thead>
                <tr>
                    <th style="text-align: center">Código</th>
                    <th style="text-align: center">Tipo</th>
                    <th style="text-align: center">Diámetro mínimo de cable</th>
                    <th style="text-align: center">Diámetro máximo de cable</th>
                    <th></th>
                </tr>
            </thead>
            @foreach ($content['seals'] as $seal)
                <tbody>
                    <td style="text-align: center">{{ $seal['code'] }}</td>
                    <td style="text-align: center">{{ $seal['type'] }}</td>
                    <td style="text-align: center">{{ $seal['minimum_diameter'] }}</td>
                    <td style="text-align: center">{{ $seal['maximum_diameter'] }}</td>
                    <td style="text-align: center">
                        @empty($explorar['readonly'])
                            <button wire:click="unsetAssociationToConnector('seals',{{ $seal['id'] }})" type="button"
                                class="btn btn-danger btn-sm">-</button>
                        @endempty
                    </td>
                </tbody>
            @endforeach
        </table>
    @endif
</div>

<div class="form-group">
    <label for="number_of_ways">Cantidad de vías</label>
    <input type="text" class="form-control" id="number_of_ways" wire:model="connector.number_of_ways"
        placeholder="Cantidad de vías" {{ $explorar['readonly'] }}>
</div>
<div class="form-group">
    <label for="type">Tipo</label>
    <select class="form-control form-control-sm" wire:model="connector.type" id="type"
        {{ $explorar['disabled'] }}>
        <option selected value="" hidden>Selecciona un tipo</option>
        <option value="Porta Macho">Porta Macho</option>
        <option value="Porta Hembra">Porta Hembra</option>
    </select>
</div>
<div class="form-group">
    <label for="connector">Contraparte</label>
    <select wire:model="connector.connector_id" id="connector" class="form-control form-control-sm"
        {{ $explorar['disabled'] }}>
        <option selected value="" hidden>Seleccione una contraparte</option>
        @foreach ($content['connectors'] as $connector)
            <option value="{{ $connector['material']['id'] }}"> {{ $connector['material']['code'] }} -
                {{ $connector['material']['name'] }} </option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="watertight">Estanco</label>
    <select class="form-control form-control-sm" wire:model="connector.watertight" id="watertight"
        {{ $explorar['disabled'] }}>
        <option selected value="" hidden>Selecione una opción</option>
        <option value="1">Sí</option>
        <option value="0">No</option>
    </select>
</div>
<div class="form-group">
    <label for="lock">Traba secundaria</label>
    <select class="form-control form-control-sm" wire:model="connector.lock" id="lock"
        {{ $explorar['disabled'] }}>
        <option selected value="" hidden>Selecciona una opción</option>
        <option value="1">Sí</option>
        <option value="0">No</option>
    </select>
</div>
<div class="form-group">
    <label for="cover">Tapa</label>
    <select class="form-control form-control-sm" wire:model="connector.cover" id="cover"
        {{ $explorar['disabled'] }}>
        <option selected value="" hidden>Selecciona una opción</option>
        <option value="1">Sí</option>
        <option value="0">No</option>
    </select>
</div>

<script>
    $(document).ready(function() {
        $('#selectionTerminals').select2({
            placeholder: "Seleccione terminales a asociar"
        });
        $('#selectionTerminals').on('change', function(e) {
            var terminal = $('#selectionTerminals').select2("val");
            @this.set('connector.terminals', terminal);
        });
        $('#selectionSeals').select2({
            placeholder: "Seleccione sellos a asociar"
        });
        $('#selectionSeals').on('change', function(e) {
            var seal = $('#selectionSeals').select2("val");
            @this.set('connector.seals', seal);
        });
    });
</script>
