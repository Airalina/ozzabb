 <div class="card-body col-12 table-responsive">
     <table class="table table-hover">
         <thead>
             <tr>
                 <th style="text-align: center">Código instalación</th>
                 <th style="text-align: center">N° de revisión</th>
                 <th style="text-align: center">Precio Unitario U$D</th>
                 <th style="text-align: center">Cantidad</th>
                 <th style="text-align: center">Subtotal</th>
                 <th></th>
             </tr>
         </thead>
         <tbody>
             @foreach ($installationsSelected as $index => $installationSelected)
                 <tr>
                     <td style="text-align: center">{{ $installationSelected['code'] }}</td>
                     <td style="text-align: center">
                         {{ $installationSelected['revisionSelected'][0]['number_version'] }}</td>
                     <td style="text-align: center">
                         {{ $index != 'total' ? '$ ' . $installationSelected['usd_price'] : ' ' }}</td>
                     <td style="text-align: center">{{ $installationSelected['amount'] }}</td>
                     <td style="text-align: center">
                         {{ $installationSelected['subtotal'] ? '$' . $installationSelected['subtotal'] : ' ' }}</td>
                     @if ($index != 'total' && $viewDetail == 'listInstallations')
                         <td style="text-align: center"><button type="button"
                                 wire:click="downInstallation({{ $installationSelected['id'] }})"
                                 class="btn btn-danger btn-sm">Quitar</button></td>
                     @endif
                 </tr>
             @endforeach
         </tbody>
     </table>
 </div>
 <!-- /.card-body -->
