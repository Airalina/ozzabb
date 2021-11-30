  <div>
      <button wire:click="back()" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i>
          Volver</button>
  </div>
  <br>

  <div class="card card-primary">
      <div class="card-header">
          <h3 class="card-title"> Proveedor código: {{ $idexplora }} </h3>
      </div>
      <div class="card-body">
          <form>
              <div class="col-md-12">
                  <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="name">Nombre de la empresa</label>
                                    <input type="text" class="form-control" id="name" wire:model="name"
                                        placeholder="Nombre de la empresa" required readonly>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="address">Domicilio</label>
                                    <input type="text" class="form-control" id="address" wire:model="address"
                                        placeholder="Domicilio" required readonly>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="phone">Teléfono</label>
                                    <input type="text" class="form-control" id="phone" wire:model="phone" placeholder="Teléfono"
                                        readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="email">Correo electrónico para ventas</label>
                                    <input type="email" class="form-control" id="email" wire:model="email"
                                        placeholder="Correo electrónico para ventas" required readonly>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="contact_name">Nombre de contacto</label>
                                    <input type="text" class="form-control" id="contact_name" pattern="[A-Za-z]"
                                        wire:model="contact_name" placeholder="Nombre de contacto" readonly>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="point_contact">Puesto de contacto</label>
                                    <input type="text" class="form-control" id="point_contact" wire:model="point_contact"
                                        placeholder="Puesto de contaco" readonly>
                                </div>
                            </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="site_url">Página web</label>
                                <input type="text" class="form-control" id="site_url" wire:model="site_url"
                                    placeholder="www.paginaweb.com" readonly>
                            </div>
                        </div>
                     </div>
                </div>
              </div>
          </form>
      </div>
      <div class="row">
          <div class="col-md-7">
              <div class="card">
                  <div class="card-header">
                      <h3 class="card-title">Lista de precios del proveedor</h3>
                      <div class="card-tools">
                          @if (auth()->user()->can('storeprovider', auth()->user()))
                              <div>
                                  <button wire:click="agregamat({{ $provider->id }})" type="button"
                                      class="btn btn-info btn-sm">Agregar Material</button>
                              </div>
                          @endif
                      </div>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body table-responsive">
                      <table class="table table-sm">
                          <thead>
                              <tr>
                                  <th>Material</th>
                                  <th>Nombre</th>
                                  <th>Cantidad</th>
                                  <th>Presentación</th>
                                  <th>Precio U$D</th>
                                  <th>Precio AR$</th>
                                  <th></th>
                              </tr>
                          </thead>
                          <tbody>

                              @forelse($provider_prices as $provider_price)
                                  <tr>
                                      <td>{{ $provider_price->material->code }}</td>
                                      <td>{{ $provider_price->material->name }}</td>
                                      <td>{{ $provider_price->amount }}</td>
                                      <td>{{ $provider_price->unit }} {{ $provider_price->presentation }}</td>
                                      <td>{{ $provider_price->usd_price }}</td>
                                      <td>{{ $provider_price->ars_price }}</td>
                                      @if (auth()->user()->can('deleteprovider', auth()->user()))
                                          <td><button wire:click="updatemat({{ $provider_price->id }})" type="button"
                                                  class="btn btn-success btn-sm">Actualizar</button></td>
                                      @endif
                                  </tr>
                              @empty
                                  <tr class="text-center">
                                      <td colspan="4" class="py-3 italic">No hay información</td>
                                  </tr>
                              @endforelse
                          </tbody>
                      </table>
                  </div>
                  <!-- /.card-body -->
              </div>
          </div>
          <!-- /.card -->

          <div class="col-md-5">
              <div class="card">
                  <div class="card-header">
                      <h3 class="card-title">Historial de precios del Proveedor</h3>
                  </div>
                  <!-- /.card-header -->

                  <div class="card-body table-responsive">
                      <table class="table table-sm">
                          <thead>
                              <tr>
                                  <th>Fecha</th>
                                  <th>Material </th>
                                  <th>Nombre</th>
                                  <th>Precio en U$D</th>
                              </tr>
                          </thead>
                          <tbody>

                              @forelse($prices as $price)

                                  <tr>
                                      <td>{{ $price->date }}</td>
                                      <td>{{ $price->provider_price->material->code }}</td>
                                      <td>{{ $price->provider_price->material->name }}</td>
                                      <td>{{ $price->price }}</td>
                                  </tr>
                              @empty
                                  <tr class="text-center">
                                      <td colspan="4" class="py-3 italic">No hay información</td>
                                  </tr>
                              @endforelse
                          </tbody>
                      </table>
                  </div>
                  <!-- /.card-body -->
              </div>
              <!-- /.card -->
          </div>
      </div>
  </div>
