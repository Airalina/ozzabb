@extends('adminlte::page')

@section('title', 'Usuarios y Roles')

@section('content_header')
    <h1>Administración de Usuarios y Roles</h1>
@stop

@section('content')
    @livewireStyles
        
    

    <div class="card card-primary card-tabs">
              <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-five-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-five-overlay-tab" data-toggle="pill" href="#custom-tabs-five-overlay" role="tab" aria-controls="custom-tabs-five-overlay" aria-selected="false">Usuarios</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-five-overlay-dark-tab" data-toggle="pill" href="#custom-tabs-five-overlay-dark" role="tab" aria-controls="custom-tabs-five-overlay-dark" aria-selected="false">Roles</a>
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-five-tabContent">
                  <div class="tab-pane fade active show" id="custom-tabs-five-overlay" role="tabpanel" aria-labelledby="custom-tabs-five-overlay-tab">
                    @livewire('usuarios')
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-five-overlay-dark" role="tabpanel" aria-labelledby="custom-tabs-five-overlay-dark-tab">
                    @livewire('roles')  
                  </div>
                </div>
              </div>   
    </div>

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
@stop