<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <!-- CSS only -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
</head>

<body>
    <div class="invoice p-3 mb-3">
        <div class="container clearfix">
            <!-- title row -->
            <div class="row">
                <div class="col-12">
                    <h4>
                        <i class="fas fa-globe"></i>{{ config('global.OWN_APP') }}
                    </h4>
                </div>
                <!-- /.col -->
            </div>
            <!-- info row -->
            <div class="row">
                <div class="col-4 float-left">
                    <p class="lead mb-0">De:</p>
                    <address>
                        <p class="mb-0"><strong>{{ config('global.OWN_APP') }}</strong></p>
                        <p class="mb-0">{{ config('global.POSITION_EMAIL') }}</p>
                        <p class="mb-0">{{ config('global.PROVINCE') . ', ' . config('global.PROVINCE_CAPITAL') }}</p>
                        <p class="mb-0">{{ config('global.COUNTRY') }}</p>
                        <p class="mb-0">CP: {{ config('global.CP') }}</p>
                        <p class="mb-0">Teléfono: {{ config('global.PHONE_APP') }}</p>
                        <p class="mb-0">Email: {{ config('global.EMAIL_APP') }}</p>
                    </address>
                </div>
                <!-- /.col -->
                <div class="col-4 float-left">
                    <p class="lead mb-0">Para:</p>
                    <address>
                        <p class="mb-0"><strong>{{ $order['customer_name'] }}</strong></p>
                        @if (!empty($order['deliveryDomicile']))
                            <p class="mb-0">{{ $order['deliveryDomicile']['street'] }},
                                {{ $order['deliveryDomicile']['number'] }}</p>
                            <p class="mb-0">{{ $order['deliveryDomicile']['location'] }},
                                {{ $order['deliveryDomicile']['province'] }}</p>
                            <p class="mb-0">{{ $order['deliveryDomicile']['country'] }}</p>
                            <p class="mb-0">CO: {{ $order['deliveryDomicile']['postcode'] }}</p>
                        @else
                            <p class="mb-0"> La dirección del cliente ha sido borrado del sistema.</p>
                        @endif
                        @if (!empty($order['customer']))
                            <p class="mb-0">Teléfono: {{ $order['customer']['phone'] }}</p>
                            <p class="mb-0">Email: {{ $order['customer']['email'] }}</p>
                        @else
                            <p class="mb-0">El cliente ha sido borrado del sistema.</p>
                        @endif
                    </address>
                </div>
                <!-- /.col -->
                <div class="col-4 float-left">
                    <p class="lead mb-0">Detalles de pedido:</p>
                    <p class="mb-0"><b>Pedido #: </b> {{ $order['id'] }}/{{ $order['date_year'] }}</p>
                    <p class="mb-0"><b>Fecha y hora de pedido: </b> {{ $order['date'] }}</p>
                    <p class="mb-0"><b>Fecha estimada de entrega: </b> {{ $order['deadline_date'] }}</p>
                </div>
                <!-- /.col -->
            </div>
        </div>
        <!-- /.row -->
        <div class="row">
            <x-show-list-installations :installationsSelected="$installationsSelected" viewDetail="listadoDetail" />
            <!-- /.col -->
        </div>
        <!-- /.row -->
        <div class="row">
            <!-- accepted payments column -->
            <div class="col-6">
            </div>
            <!-- /.col -->
            <div class="col-6 float-right">
                <p class="lead">Monto adeudado:</p>

                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th style="width:50%">Total U$D:</th>
                                <td>$ {{ $installationsSelected['total']['subtotal'] }}</td>
                            </tr>
                            <tr>
                                <th>Total AR$:</th>
                                <td>$ {{ $installationsSelected['total']['subtotal'] * $ar_price }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        @if ($showPdf)
            <div class="row no-print">
                <div class="col-12">
                    <button type="button" class="btn btn-primary float-right" wire:click="createPDF()">
                        <i class="fas fa-download"></i> Generar PDF
                    </button>
                </div>
            </div>
        @endif
    </div>
</body>

</html>
