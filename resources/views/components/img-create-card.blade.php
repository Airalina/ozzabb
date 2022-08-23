@if (count($files['images']) > 0)
    <label for="view" class="mt-4">Vista previa</label>
    <div class="mb-2 d-flex flex-wrap">
        @foreach ($files['images'] as $index => $img)
            <div class="p-1">
                <a href="{{ $img }}" data-lightbox="photos">
                    <img src="{{ $img }}" class="img-fluid" style="width:150px;height:150px">
                </a>
                @if ($funcion != 'explorar')
                    <button wire:click="deleteImg({{ $index }})" type="button"
                        class="btn-danger rounded-circle">x</button>
                @endif
            </div>
        @endforeach
    </div>
@endif
