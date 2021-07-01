@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Administración de Usuarios</h1>
@stop

@section('content')
  
        <p>Welcome to this beautiful admin panel.</p>
        @livewire('abmusuarios')
    
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
