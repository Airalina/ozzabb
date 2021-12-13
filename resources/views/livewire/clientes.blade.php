<div id="create">
  @if($funcion=="neworder")
    <div>
        <button wire:click="volverexplora()" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Volver</button>
    </div>
    <br>
  @endif
  @switch($funcion)
    @case("")
        @if (auth()->user()->can('seecust', auth()->user()))
          @include("cliente.listado")
        @endif
        @break

    @case("crear")
        @include("cliente.registro")
        @break

    @case("creardom")
        @include("cliente.registrodom")      
        @break

    @case("adaptar")
        @include("cliente.adaptar")
        @break

    @case("neworder")
        @livewire('ordenesclientes')
        @break
  
  @endswitch

  @switch($explora)
      @case("activo")
          @include("cliente.explorar")
          @break
  @endswitch
  
</div>
