@extends('adminlte::page')

@section('title', 'Planilla de compras')

@section('content_header')
    <h1>Planilla de compras</h1>
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
@stop
