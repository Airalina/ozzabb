@extends('adminlte::page')

@section('title', 'Pedidos')

@section('content_header')
    <h1>Pedidos</h1>
@stop

@section('content')
    @livewireStyles
    @if (auth()->user()->can('seepedidos', auth()->user()))
        <div>
            @livewire('ordenesclientes')
        </div>
    @endif
    @livewireScripts
@stop

@section('footer')
    <strong>Setecel s.r.l V1.0 - &#169 Codigitar {{ date('Y') }} - <a href="https://codigitar.com/" target="_blank"
            target="_blank">www.codigitar.com</a></strong>
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
        window.addEventListener('show-form-installation', event => {
            $('#form-installation').modal('show');
        })
        window.addEventListener('hide-form-installation', event => {
            $('#form-installation').modal('hide');
        })
        window.addEventListener('show-form-address', event => {
            $('#form-address').modal('show');
        })
        window.addEventListener('hide-form-address', event => {
            $('#form-address').modal('hide');
        })
    </script>
    <script>
        window.addEventListener('show-borrar', event => {
            $('#borrar').modal('show');
        })
        window.addEventListener('hide-borrar', event => {
            $('#borrar').modal('hide');
        })
    </script>
    <script>
        window.addEventListener('deleted', event => {
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Registro eliminado correctamente',
                showConfirmButton: false,
                timer: 1300
            })
        })
    </script>
    <script>
        window.addEventListener('errorResponse', message => {
            console.log(message.detail.error);
        })
    </script>
@stop
