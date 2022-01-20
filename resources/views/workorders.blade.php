@extends('adminlte::page')

@section('title', 'Órdenes de trabajo')

@section('content_header')
    <h1>Órdenes de trabajo</h1>
@stop

@section('content')
    @livewireStyles
    @livewire('work-orders')
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
        window.addEventListener('show-form-reservation', event => {
            $('#form-reservation').modal('show');
        })
        window.addEventListener('hide-form-reservation', event => {
            $('#form-reservation').modal('hide');
        })
        window.addEventListener('show-form-material', event => {
            $('#form-material').modal('show');
        })
        window.addEventListener('hide-form-material', event => {
            $('#form-material').modal('hide');
        })
        window.addEventListener('show-form-addmaterial', event => {
            $('#form-addmaterial').modal('show');
        })
        window.addEventListener('hide-form-addmaterial', event => {
            $('#form-addmaterial').modal('hide');
        })
        window.addEventListener('show-form-addproduct', event => {
            $('#form-addproduct').modal('show');
        })
        window.addEventListener('hide-form-addproduct', event => {
            $('#form-addproduct').modal('hide');
        })
        window.addEventListener('show-form-product', event => {
            $('#form-product').modal('show');
        })
        window.addEventListener('hide-form-product', event => {
            $('#form-product').modal('hide');
        })
       
      
    </script>
@stop
