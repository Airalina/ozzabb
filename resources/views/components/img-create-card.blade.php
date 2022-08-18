 @if (count($files['images']) > 0)
     <label for="view" class="mt-4">Vista previa</label>
     <div>
         @foreach ($files['images'] as $index => $img)
             <div class="mb-2">
                 <img src="{{ $img }}" class="img-fluid img-thumbnail" style="width:150px;height:150px">
                 @if ($funcion != 'explorar')
                     <button wire:click="deleteImg({{ $index }})" type="button"
                         class="btn-danger rounded-circle">x</button>
                 @endif
             </div>
         @endforeach
     </div>
 @endif
