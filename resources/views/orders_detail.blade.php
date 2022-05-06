<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-4">
        <div class="card-header">
            <div class="row">
                <h6 class="card-title">Proveedor: {{$order->provider->name}} </h6>
            </div>
            <div class="row">
                <h6 class="card-title">Número de orden: {{ $order->order_number }} </h6>
            </div>
            <div class="row">
                <h6 class="card-title">Cantidad de materiales pedidos: {{ count($order->buyorderdetails) }} </h6>
            </div>
            <div class="row">
                <h6 class="card-title">Total U$D: {{ $order->total_price }}</h6>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <h2>Lista de productos</h2>
            </div>
            <div class="row">
            <div class="col-md-12">
                <table class="table table-hover table-sm">
                    <thead>
                        <tr>
                            <th style="text-align: center">Nombre Material</th>
                            <th style="text-align: center">Presentación</th>
                            <th style="text-align: center">Cantidad</th>
                            <th style="text-align: center">Precio U$D por presentación</th>
                            <th style="text-align: center">Total U$D</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($order->buyorderdetails()->get() as $detail)
                            <tr>
                                <td style="text-align: center">{{ $detail->material->name }}</td>
                                <td style="text-align: center">{{ $detail->presentation }}</td>
                                <td style="text-align: center">{{ $detail->amount }}</td>
                                <td style="text-align: center">{{ $detail->presentation_price }}</td>
                                <td style="text-align: center">{{ $detail->total_price }}</td>
                            </tr>
                        @empty
                            <tr class="text-center">
                               <td colspan="100%" class="py-3 italic">No hay ordenes agregadas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        </div>
        
    </div>
    <div class="row no-print">
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
    
</div>