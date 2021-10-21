@extends('adminlte::page')

@section('title', 'Instalaciones')

@section('content_header')
    <h1>Administracion de Instalaciones</h1>
@stop

@section('content')
    @livewireStyles
        @livewire('instalaciones')
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
