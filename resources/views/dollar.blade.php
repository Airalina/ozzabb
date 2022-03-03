@extends('adminlte::page')

@section('title', 'Cotización')

@section('content_header')
    <h1>Administración de Dólar</h1>
@stop

@section('content')
    @livewireStyles
        @livewire('dolar')
    @livewireScripts
@stop

@section('footer')
    <strong>Setecel s.r.l V1.0 - &#169 Codigitar {{ date('Y') }} - <a href="https://codigitar.com/" target="_blank">www.codigitar.com</a></strong>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>|
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