@extends('adminlte::page')

@section('title', 'Planillas de compra')

@section('content_header')
    <h1>Planillas de compra</h1>
@stop

@section('content')
    @livewireStyles
    @livewire('purchasing-sheet')
    @livewireScripts
@stop

@section('css')

    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        console.log('Hi!');
    </script>
    <script>
        window.addEventListener('show-form', event => {
            $('#form').modal('show');
        })
        window.addEventListener('hide-form', event => {
            $('#form').modal('hide');
        })
        window.addEventListener('show-formmaterial', event => {
            $('#formmaterial').modal('show');
        })
        window.addEventListener('hide-formmaterial', event => {
            $('#formmaterial').modal('hide');
        })
    </script>
@stop
