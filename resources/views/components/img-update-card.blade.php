@if ($images)
    @foreach ($images as $img)
        <div wire:key="{{ $loop->index }}">
            @if (is_string($img))
                <img src="{{ $material->getUrl($img) }}" class="img-fluid img-thumbnail"
                    style="width:150px;height:150px">
            @else
                <img src="{{ $img->temporaryUrl() }}" class="img-fluid img-thumbnail" style="width:150px;height:150px">
                <button wire:click="deleteImg({{ $loop->index }})" type="button"
                    class="btn-danger rounded-circle">x</button>
            @endif
        </div>
    @endforeach
@endif
