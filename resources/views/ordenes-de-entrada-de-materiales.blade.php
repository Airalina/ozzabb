@extends('adminlte::page')

@section('title', 'Orden de Ingreso')

@section('content_header')
    <h1>Ordenes de entrada de materiales</h1>
@stop

@section('content')
    @livewireStyles
        @livewire('orden-de-entrada-de-materiales')
    @livewireScripts
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
