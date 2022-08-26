  <div>
      <button wire:click="back()" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i>
          Volver</button>
  </div>
  <br>

  <div class="card card-primary">
      <div class="card-header">
          <h3 class="card-title"> Proveedor código: {{ $provider['id'] }} </h3>
      </div>
      <div class="card-body">
          <form>
              <div class="col-md-12">
                  <div class="card-body">
                      <x-form-create-provider rowClass="row" columnClass="col-sm-4" disabled="disabled" />
                      <div class="row">
                          <div class="col-md-7">
                              <x-list-prices-card type="proveedor" :providerPrices="$providerPrices" permission="storeprovider"  :arPrice="$ar_price" />
                          </div>
                          <div class="col-md-5">
                              <x-list-history-prices-card :prices="$prices" />
                          </div>
                      </div>
                  </div>
              </div>
          </form>
      </div>

  </div>
