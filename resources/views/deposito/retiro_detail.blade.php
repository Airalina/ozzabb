<div>
  <button wire:click="toretiros()" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i>
    Volver</button>
</div>
<br>
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Detalle de retiro N°: {{ $retiro->id }}</h3>

  </div>
  <!-- /.card-header -->
  <div class="card-body table-responsive p-0">
    <table class="table table-hover table-sm">
      <thead>
        <tr>
          <th style="text-align: center">Orden N°</th>
          <th style="text-align: center">Código</th>
          <th style="text-align: center">Descripción</th>
          <th style="text-align: center">Packaging</th>
          <th style="text-align: center">Cantidad Retirada</th>
          <th style="text-align: center">Total</th>
          <th style="text-align: center">Destino</th>
          <th style="text-align: center">Tipo</th>
          <th style="text-align: center">Fecha</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td style="text-align: center">{{ $retiro->id }}</td>
          @if ($retiro->is_material == 1)
          <td style="text-align: center">{{ $retiro->materials->code }}</td>
          <td style="text-align: center">{{ $retiro->materials->description }}</td>
          <td style="text-align: center">{{ $retiro->presentation}}</td>
          @else
          <td style="text-align: center">{{ $retiro->assembleds->id }}</td>
          <td style="text-align: center">{{ $retiro->assembleds->description }}</td>
          <td style="text-align: center">Ensamblados</td>
          @endif
          <td style="text-align: center">{{ abs($retiro->amount) }}</td>
          <td style="text-align: center">{{ abs($retiro->amount*$retiro->presentation) }}</td>
          <td style="text-align: center">{{ $retiro->warehouse2->name }}</td>
          <td style="text-align: center">
            @if($retiro->warehouse2->type==1)
            Almacen
            @elseif($retiro->warehouse2->type==2)
            Producción
            @elseif($retiro->warehouse2->type==3)
            Ensamblados
            @elseif($retiro->warehouse2->type==4)
            Expedición
            @endif
          </td>
          <td style="text-align: center">
            {{ date('d-m-Y', strtotime($retiro->date_change)) }} - {{ $retiro->hour }}
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <!-- /.card-body -->
</div>
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Detalle de ingreso en el depósito: {{ $retiro->warehouse2->name }} </h3>

  </div>
  <!-- /.card-header -->
  <div class="card-body table-responsive p-0">
    <table class="table table-hover table-sm">
      <thead>
        <tr>
          <th style="text-align: center">Orden N°</th>
          <th style="text-align: center">Código</th>
          <th style="text-align: center">Descripción</th>
          <th style="text-align: center">Packaging</th>
          <th style="text-align: center">Cantidad Retirada</th>
          <th style="text-align: center">Total</th>
          <th style="text-align: center">Origen</th>
          <th style="text-align: center">Tipo</th>
          <th style="text-align: center">Fecha</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          @forelse ($ingresos as $ingreso)
          <td style="text-align: center">{{ $ingreso->id }}</td>
          @if ($ingreso->is_material == 1)
          <td style="text-align: center">{{ $ingreso->materials->code }}</td>
          <td style="text-align: center">{{ $ingreso->materials->description }}</td>
          <td style="text-align: center">{{ $ingreso->presentation}}</td>
          @else
          <td style="text-align: center">{{ $ingreso->assembleds->id }}</td>
          <td style="text-align: center">{{ $ingreso->assembleds->description }}</td>
          <td style="text-align: center">Ensamblados</td>
          @endif
          <td style="text-align: center">{{ abs($ingreso->amount) }}</td>
          <td style="text-align: center">{{ abs($ingreso->amount*$ingreso->presentation) }}</td>
          <td style="text-align: center">{{ $ingreso->warehouse2->name }}</td>
          <td style="text-align: center">
            @if($ingreso->warehouse2->type==1)
            Almacen
            @elseif($ingreso->warehouse2->type==2)
            Producción
            @elseif($ingreso->warehouse2->type==3)
            Ensamblados
            @elseif($ingreso->warehouse2->type==4)
            Expedición
            @endif
          </td>
          <td style="text-align: center">
            {{ date('d-m-Y', strtotime($ingreso->date_change)) }} - {{ $ingreso->hour }}
          </td>
          @empty
          <td>No se han registrado ingresos</td>
          @endforelse
        </tr>
      </tbody>
    </table>
  </div>
  <!-- /.card-body -->
</div>