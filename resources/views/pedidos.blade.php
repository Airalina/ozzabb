@extends('adminlte::page')

@section('title', 'Pedidos')

@section('content_header')
    <h1>Pedidos</h1>
@stop

@section('content')
    @livewireStyles
        @if (auth()->user()->can('seepedidos', auth()->user()))
            @livewire('ordenesclientes')
        @endif
    @livewireScripts
@stop

@section('footer')
  <strong>Setecel s.r.l V1.0 - &#169 Codigitar {{ date('Y') }} - <a href="https://codigitar.com/" target="_blank" target="_blank">www.codigitar.com</a></strong>
@stop  

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
    <script>
        window.addEventListener('show-form', event => {
            $('#form').modal('show');
        })
        window.addEventListener('hide-form', event => {
            $('#form').modal('hide');
        })
    </script>
 @stop