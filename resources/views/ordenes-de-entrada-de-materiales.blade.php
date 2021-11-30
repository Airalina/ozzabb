@extends('adminlte::page')

@section('title', 'Orden de Ingreso')

@section('content_header')
    <h1>Ordenes de ingreso de materiales</h1>
@stop

@section('content')
    @livewireStyles
    @livewire('orden-de-entrada-de-materiales')
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
    </script>
    <script type="text/javascript">
        window.onload = function() {
            Livewire.on('alertClose', () => {
                $("#alert").html('<div class="alert alert-danger alert-dismissible">Orden de ingreso cerrada</div>');
            })
        }
    </script>
@stop
