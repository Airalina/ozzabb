@extends('adminlte::page')

@section('title', 'Orden de Egreso')

@section('content_header')
    <h1>Órdenes de Egreso de materiales</h1>
@stop

@section('content')
    @livewireStyles
    @livewire('orden-de-egreso-de-materiales')
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
    <script>
            window.addEventListener('show-cancel', event => {
                $('#cancel').modal('show');
            })
            window.addEventListener('hide-cancel', event => {
                $('#cancel').modal('hide');
            })
        </script>
        <script>
            window.addEventListener('cancel', event => {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Orden cancelada correctamente',
                    showConfirmButton: false,
                    timer: 1300
                })
            })
    
        </script>
@stop
