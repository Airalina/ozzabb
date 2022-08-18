<div class="form-group">
    <div wire:ignore>
        <label for="selectionReplace">Reemplazo</label>
        <select class="custom-select" id="selectionReplace" wire:model="material.replace_id" {{ $explorar['disabled'] }}>
            <option selected value="" hidden>Selecciona un reemplazo</option>
            @foreach ($replaces as $replace)
                <option value="{{ $replace['id'] }}"> {{ $replace['code'] }} - {{ $replace['name'] }}</option>
            @endforeach
        </select>
    </div>

</div>
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#selectionReplace').select2();
            $('#selectionReplace').on('change', function(e) {
                var replace = $('#selectionReplace').select2("val");
                console.log(replace);
                @this.set('replace_id', replace);
            });
        });
    </script>
@endpush
