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
        window.addEventListener('cancel', event => {
            Swal.fire({
            title: '¿Está seguro de cancelar la orden?',
            text: "No podrás revertir esto.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '¡Sí, cancelar!'
            }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                '¡Cancelada!',
                'Su orden ha sido cancelada.',
                'success'
                )
            }
            })
        })

    </script>
@stop
