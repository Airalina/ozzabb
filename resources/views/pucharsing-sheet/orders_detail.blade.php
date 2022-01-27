<div>
    <button wire:click="go_to_orders({{$to_order}})" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i>
        Volver</button>
</div><br>
<div>
    <div class="card card-tabs">                    
        <div class="card-body table-responsive">
            <form>
                <div class="card-body table-responsive p-0">
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th style="text-align: center">Nombre Material</th>
                                    <th style="text-align: center">Presentación</th>
                                    <th style="text-align: center">Cantidad</th>
                                    <th style="text-align: center">Precio por presentación</th>
                                    <th style="text-align: center">Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($buy_order_details as $detail)
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
            </form>
        </div>
    </div>
</div>