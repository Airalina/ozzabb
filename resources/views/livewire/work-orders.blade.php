<div>
  
    @switch($funcion)
      @case("")
          @if (auth()->user()->can('seeproviders', auth()->user()))
            @include("workorder.listado")
          @endif
          @break
  
      @case("crear")
          @include("workorder.create")
          @break
  
      @case("actualizar")
          @include("workorder.create")
          @break
  
      @case("explora")
          @include("workorder.explora")
          @break

      @case("sheet")
          @include("workorder.worksheet")
          @break

      @case("cancelar")
          @include("workorder.cancelar")
          @break
    
      @case("createproduct")
          @include("workorder.createproduct")
          @break
    
      @case("reserva_materiales")
          @include("workorder.reservar")
          @break

    @endswitch
  
    
  </div>
  @push('js')
   <script>
   
        Livewire.on('refreshState', workorder => {
          @this.workorder = workorder
        })
    </script>

@endpush