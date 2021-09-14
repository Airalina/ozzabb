            @switch($div)
                @case("Conectores")
                    <div class="form-group">
                        <label for="terminal">Terminal Asociado</label>

                        <select wire:model="terminal" id="terminal" class="form-control form-control-sm">

                            @if ($terminalId != null)
                                <option value="{{ $termi->id }}" selected>{{ $termi->material->name }}</option>
                            @else
                                <option selected>Seleccione un terminal</option>
                            @endif
                            @foreach ($infoTerm as $term)
                                @if ($terminalId != null)
                                    @if ($terminalId === $term->id)
                                        @php continue;  @endphp
                                    @endif
                                @endif
                                <option value="{{ $term->id }}"> {{ $term->material->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="seal">Sello Asociado</label>

                        <select wire:model="seal" id="seal" class="form-control form-control-sm">
                            @if ($sealId != null)
                                <option value="{{ $seli->id }}" selected>{{ $seli->material->name }}</option>
                            @else
                                <option selected>Seleccione un sello</option>
                            @endif
                            @foreach ($infoSell as $sell)
                                @if ($sealId != null)
                                    @if ($sealId === $sell->id)
                                        @php continue;  @endphp
                                    @endif
                                @endif
                                <option value="{{ $sell->id }}"> {{ $sell->material->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="number_of_ways">Cantidad de vías</label>
                        <input type="text" class="form-control" id="number_of_ways" wire:model="number_of_ways"
                            placeholder="Cantidad de vías">
                    </div>
                    <div class="form-group">
                        <label for="type">Tipo</label>
                        <select class="form-control form-control-sm" wire:model="type" id="type">
                            <option selected value="">Selecciona un tipo</option>
                            <option value="Porta macho">Porta macho</option>
                            <option value="Porta hembra">Porta hembra</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="connector">Contraparte</label>
                        <select wire:model="connector" id="connector" class="form-control form-control-sm">

                            @if ($connectorId != null)
                                <option value="{{ $connect->id }}" selected>{{ $connect->material->name }}</option>
                            @else
                                <option selected>Seleccione una contraparte</option>
                            @endif
                            @foreach ($infoCon as $con)
                                @if ($connectorId != null)
                                    @if ($connectorId === $con->id)
                                        @php continue;  @endphp
                                    @endif
                                @endif
                                <option value="{{ $con->id }}"> {{ $con->material->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @break
                @case("Cables")
                    <div class="form-group">
                        <label for="size">Tamaño</label>
                        <input type="text" class="form-control" id="size" wire:model="size" placeholder="Tamaño en mm">
                    </div>
                    <div class="form-group">
                        <label for="minimum_section">Sección mínima</label>
                        <input type="text" class="form-control" id="minimum_section" wire:model="minimum_section"
                            placeholder="Sección mínima">
                    </div>
                    <div class="form-group">
                        <label for="maximum_section">Sección máxima</label>
                        <input type="text" class="form-control" id="maximum_section" wire:model="maximum_section"
                            placeholder="Sección máxima">
                    </div>

                @break
                @case("Terminales")
                    <div class="form-group">
                        <label for="size">Tamaño</label>
                        <input type="text" class="form-control" id="size" wire:model="size" placeholder="Tamaño en mm">
                    </div>
                    <div class="form-group">
                        <label for="minimum_section">Sección mínima</label>
                        <input type="text" class="form-control" id="minimum_section" wire:model="minimum_section"
                            placeholder="Sección mínima">
                    </div>
                    <div class="form-group">
                        <label for="maximum_section">Sección máxima</label>
                        <input type="text" class="form-control" id="maximum_section" wire:model="maximum_section"
                            placeholder="Sección máxima">
                    </div>
                @break
                @default
            @endswitch
            @if ($materialFamily)
                <div class="form-group">
                    <label for="replace">Reemplazo</label>
                    <select class="form-control form-control-sm" wire:model="replace" id="replace">
                        @if ($rplce != null)
                            <option value="{{ $rplce->id }}" selected>{{ $rplce->name }}</option>
                        @else
                            <option selected>Seleccione un reemplazo</option>
                        @endif
                        @foreach ($materialFamily as $rep)
                            @if ($rplce != null)
                                @if ($rplce->id === $rep->id)
                                    @php continue;  @endphp
                                @endif
                            @endif
                            <option value="{{ $rep->id }}"> {{ $rep->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
