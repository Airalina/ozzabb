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

@section('footer')
  <strong>Setecel s.r.l V1.0 - &#169 Codigitar {{ date('Y') }} - <a href="https://codigitar.com/" target="_blank">www.codigitar.com</a></strong>
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
