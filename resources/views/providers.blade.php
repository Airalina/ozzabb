@extends('adminlte::page')

@section('title', 'Proveedores')

@section('content_header')
    <h1>Proveedores</h1>
@stop

@section('content')
    @livewireStyles
        @livewire('providers')
    @livewireScripts
@stop

@section('footer')
  <strong>Setecel s.r.l V1.0 - &#169 Codigitar {{ date('Y') }} - <a href="https://codigitar.com/" target="_blank">www.codigitar.com</a></strong>
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
    <script>
        window.addEventListener('show-borrar', event => {
            $('#borrar').modal('show');
        })
        window.addEventListener('hide-borrar', event => {
            $('#borrar').modal('hide');
        })
    </script>
@stop
