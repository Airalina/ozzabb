 @if ($images)
     Vista previa de la foto:
     <div>
         @foreach ($images as $img)
             <div wire:key="{{ $loop->index }}">
                 <img src="{{ $img->temporaryUrl() }}" class="img-fluid img-thumbnail"
                     style="width:150px;height:150px">
                 <button wire:click="deleteImg({{ $loop->index }})" type="button"
                     class="btn-danger rounded-circle">x</button>
             </div>
         @endforeach
     </div>
 @endif
