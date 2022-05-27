<div>
  <button wire:click="toexplora()" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i>
    Volver</button>
</div>
<br>
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Retiros</h3>

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
          <th></th>
        </tr>
      </thead>
      <tbody>
       
        @forelse($ordenegresodatail as $oregreso)
        <tr>
          <td style="text-align: center">{{ $oregreso->id }}</td>
            @if ($oregreso->is_material == 1)
            <td style="text-align: center">{{ $oregreso->materials->code }}</td>
            <td style="text-align: center">{{ $oregreso->materials->description }}</td>
            <td style="text-align: center">{{  $oregreso->presentation }}</td>
            @else
            <td style="text-align: center">{{ $oregreso->assembleds->id }}</td>
            <td style="text-align: center">{{ $oregreso->assembleds->description }}</td>
            <td style="text-align: center">Ensamblados</td>
            @endif
            <td style="text-align: center">{{ abs($oregreso->amount) }}</td>
            <td style="text-align: center">{{ abs($oregreso->amount*$oregreso->presentation) }}</td>
            <td style="text-align: center">{{ $oregreso->warehouse2->name }}</td>
            <td style="text-align: center">
              @if($oregreso->warehouse2->type==1)
              Almacen
              @elseif($oregreso->warehouse2->type==2)
              Producción
              @elseif($oregreso->warehouse2->type==3)
              Ensamblados
              @elseif($oregreso->warehouse2->type==4)
              Expedición
              @endif
            </td>
          <td style="text-align: center">
            {{  date('d-m-Y', strtotime($oregreso->date_change))  }} - {{ $oregreso->hour }}
          </td>
          <td>
            <button type="button" wire:click="retiro_detail({{ $oregreso->id }})" class="btn btn-primary btn-sm"><i class="fas fa-file-alt"></i> Ver</button>
          </td>
        </tr>
        @empty
        <tr class="text-center">
          <td style="text-align: center" colspan="4" class="py-3 italic">No hay información</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <!-- /.card-body -->
</div>