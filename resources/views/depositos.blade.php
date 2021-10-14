@extends('adminlte::page')

@section('title', 'Depósitos')

@section('content_header')
    <h1>Administración de Depósitos</h1>
@stop

@section('content')
    @livewireStyles
        @livewire('depositos')
    @livewireScripts
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop