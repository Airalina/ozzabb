@extends('adminlte::page')

@section('plugins.Select2', true)

@section('plugins.Lightbox2', true)

@section('title', 'Materiales')

@section('content_header')
    <h1>Administración de Materiales</h1>
@stop

@section('content')
    @livewireStyles
    <div>
        @livewire('material-component')
    </div>
    @livewireScripts
@stop

@section('footer')
    <strong>Setecel s.r.l V1.0 - &#169 Codigitar {{ date('Y') }} - <a href="https://codigitar.com/"
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
        window.addEventListener('show-form', event => {
            $('#form').modal('show');
        })
        window.addEventListener('hide-form', event => {
            $('#form').modal('hide');
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
