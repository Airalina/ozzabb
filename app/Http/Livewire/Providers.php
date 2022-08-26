<?php

namespace App\Http\Livewire;

use App\Models\Provider;
use App\Models\Material;
use App\Models\ProviderPrice;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Dollar;
use App\Http\Traits\ProviderTrait;
use App\Http\Traits\MaterialTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Providers extends Component
{
    use WithPagination, ProviderTrait, MaterialTrait;

    protected $paginationTheme = 'bootstrap';
    protected $providers;
    //Constantes 
    public $view = "",  $paginas = 25, $providerComponent = true, $order = 'name', $addMaterial = false, $searchmaterials = "", $searchTerminal = '',
        $searchSeal = '', $showPrice = 'yes', $addProvider = false;
    //Variables
    public  $providerPrice, $prices, $ar_price, $materialSelected, $familySelected, $upload, $accessory, $search, $material, $dolar,
        $family, $terminal, $connector, $cable, $tube, $clip, $seal;
    //Arrays
    public $explorar = [], $validation = [], $materials = [], $materialContent = [], $information = [], $provider = [], $price = [], $providerPrices = [];

    public function __construct()
    {
        //Inicializa array con informacion de los materiales 
        $this->information = [
            'families' => Material::TYPES,
            'colors' => Material::COLORS,
            'lines' => Material::LINES,
            'usages' => Material::USAGES,
            'showLines' => false,
            'showReplace' => false,
            'showColors' => false,
            'replaces' => [],
        ];
    }

    public function render()
    {
        $this->dolar = Dollar::findOrfail(1);
        $this->ar_price = !empty($this->dolar) ? $this->dolar->arp_price : 0;

        $this->providers = Provider::search($this->search, $this->order)->paginate($this->paginas);

        $this->materials = Material::search($this->searchmaterials)->get();

        if ($this->familySelected === 'Conectores') {
            //Buscador de terminales
            $queryTerminals = Material::FamilyMaterials('Terminales');
            $this->materialContent['Conectores']['listTerminals'] = Material::searchByFamily(
                $queryTerminals,
                $this->searchTerminal
            );

            //Buscador de sellos
            $querySeals = Material::FamilyMaterials('Sellos');
            $this->materialContent['Conectores']['listSeals'] = Material::searchByFamily(
                $querySeals,
                $this->searchSeal
            );
        }

        return view('livewire.providers', [
            'providers' => $this->providers,
        ]);
    }

    /**
     * Accion de cambiar la vista a crear en "Agregar Proveedor"
     * 
     * @return string $view
     */
    public function create()
    {
        $this->provider['status'] = 1;
        $this->view = "crear";

        return $this->view;
    }

    /**
     * Registro de un proveedor
     * 
     * @return Provider $provider|null
     */
    public function store()
    {
        $provider = $this->storeProviders();
        $this->back();

        return $provider;
    }

    /**
     * Accion que genera la vista del listado de proveedores
     * 
     * @return string view
     */
    public function back()
    {
        $this->resetExcept(['information']);
        $this->resetValidation();
        return $this->view;
    }

    /**
     * Detalle de un proveedor
     * 
     * @param int $providerId
     * @return string $view
     */
    public function explorar($providerId)
    {
        $this->view = "explorar";
        $this->provider = $this->fillProvider($providerId);

        return $this->view;
    }

    /**
     * accion de cambiar la vista a editar en "Actualizar"
     * 
     * @param int $providerId
     * @return string $view
     */
    public function edit($providerId)
    {
        $this->view = "actualizar";
        $this->provider = $this->fillProvider($providerId);
        return $this->view;
    }

    /**
     * Rellena un array con la informacion de un proveedor
     * 
     * @param int $providerId
     * @return array $providerArray|null
     */
    public function fillProvider($providerId)
    {
        $provider = Provider::findOrFail($providerId);
        if ($provider) {
            $providerArray = [
                'id' => $provider->id,
                'name' => $provider->name,
                'address' => $provider->address,
                'phone' => $provider->phone,
                'email' => $provider->email,
                'contact_name' => $provider->contact_name,
                'point_contact' => $provider->point_contact,
                'site_url' => $provider->site_url,
                'status' => $provider->status,
                'cuit' => $provider->cuit,
            ];
            $this->providerPrices = $provider->provider_prices;
            $this->prices = $provider->prices;
            return $providerArray;
        }
        return null;
    }

    /**
     * Actualizar un proveedor
     * 
     * @param Provider $provider
     * @return Provider $provider|null
     */
    public function update(Provider $provider)
    {
        $this->validation = $this->validationProviders();
        $provider->update($this->validation['provider']);
        $this->back();

        return $provider;
    }

    /**
     * Genera el modal para eliminar un proveedor
     * 
     * @param Provider $provider
     * @return 
     */
    public function destruir(Provider $provider)
    {
        $this->dispatchBrowserEvent('show-borrar');
        $this->provider = $provider->toArray();
    }

    /**
     * Accion de eliminar logicamente un proveedor
     * 
     * @return function back()|null
     */
    public function delete()
    {
        if (auth()->user()->cannot('delete', auth()->user())) {
            abort(403);
        } else {
            try {
                DB::beginTransaction();

                $provider = Provider::findOrFail($this->provider['id']);
                $provider->materials->each(function ($material, $key) use ($provider) {
                    $providerPrice = $provider->provider_prices()->whereId($material->pivot->id)->first();
                    if ($providerPrice) {
                        //Elimina logicamente el registro de precios
                        $providerPrice->prices()->delete();
                        //Elimina logicamente registros de precios por proveedor del material
                        $providerPrice->delete();
                    }
                    return $providerPrice;
                });

                //Elimina logicamente el proveedor
                $provider->delete();
                DB::commit();

                $this->dispatchBrowserEvent('hide-borrar');
                $this->dispatchBrowserEvent('deleted');
                return $this->back();
            } catch (\Exception $e) {
                DB::rollBack();

                // Respuesta en consola del error
                $this->dispatchBrowserEvent('errorResponse', ['error' => $e->getMessage()]);
                return null;
            }
        }
    }

    /**
     * Accion de cambiar la vista a crear precio en "Agregar Precio"
     * 
     * @return string $view
     */
    public function createPrice()
    {
        $this->materials = Material::all();
        $this->addMaterial = true;
        $this->view = "crearPrecio";
        return $this->view;
    }

    /**
     * Accion que ejecuta el modal para crear un material  
     * @return event show-form
     */
    public function addMaterial()
    {
        return $this->dispatchBrowserEvent('show-form');
    }

    /**
     * Rellena un array con los datos requeridos para la familia de materiales escogida
     * $key index del array que corresponde a materialFamily
     * addFields para añadir los campos si la familia "Tubos" es de tipo "Termocontraible" 
     * 
     * @param string $family
     */
    public function updatedMaterialFamily($family)
    {
        $this->familyMaterial($family);
        return;
    }

    /**
     * Rellena un array que almacena los terminales asociados a un conector
     * 
     * @param Material $material
     * @return array $materialContent
     */
    public function addTerminalsToConnector(Material $material)
    {
        $addTerminal = [
            'id' => $material->terminal->id,
            'name' => $material->name,
            'code' => $material->code,
            'size' => $material->terminal->size,
            'minimum_section' => $material->terminal->minimum_section,
            'maximum_section' => $material->terminal->maximum_section,
        ];

        $this->materialContent['Conectores']['terminals'][$material->terminal->id] = $addTerminal;
        $this->reset('searchTerminal');

        return $this->materialContent;
    }

    /**
     * Rellena un array que almacena los sellos asociados a un conector
     * 
     * @param Material $material
     * @return array $materialContent
     */
    public function addSealsToConnector(Material $material)
    {
        $addSeal = [
            'id' => $material->seal->id,
            'name' => $material->name,
            'code' => $material->code,
            'type' => $material->seal->type,
            'minimum_diameter' => $material->seal->minimum_diameter,
            'maximum_diameter' => $material->seal->maximum_diameter,
        ];

        $this->materialContent['Conectores']['seals'][$material->seal->id] = $addSeal;
        $this->reset('searchSeal');

        return $this->materialContent;
    }

    /**
     * Elimina la posicion indicada para sellos o terminales asociados a un conector
     * 
     * @param $type, $id
     * @return
     */
    public function unsetAssociationToConnector($type, $id)
    {
        unset($this->materialContent['Conectores'][$type][$id]);
        return;
    }

    /**
     * Registro de un material
     * 
     * @param $type, $id
     * @return event hide-form|null
     */
    public function storeMaterial()
    {
        //validacion para materiales
        $validationProperties = $this->validationMaterials($this->familySelected, 'no');
        $this->validation = $this->validate($validationProperties['rules'], $validationProperties['messages']);

        try {
            DB::beginTransaction();
            //creando el material
            $material = Material::updateOrCreate($this->validation['material']);
            //obteniendo la relacion de la familia escogida dinamicamente
            $model = $this->information['families'][$this->familySelected];
            //creando las caracteristicas del material y su familia
            $familyColumns = $this->validation[$model] ?? [];
            $familyMaterial = $material->$model()->firstOrCreate($familyColumns);
            //guardando sellos y terminales para materiales familia conectores
            if ($this->validation['material']['family'] == 'Conectores') {
                $terminals = array_keys($this->materialContent['Conectores']['terminals']) ?? false;
                $seals = array_keys($this->materialContent['Conectores']['seals']) ?? false;

                if ($terminals) {
                    $familyMaterial->terminals()->sync($terminals);
                }
                if ($seals) {
                    $familyMaterial->seals()->sync($seals);
                }
            }

            DB::commit();
            $this->resetValidation();
            $this->selectmaterial($material);
            return $this->dispatchBrowserEvent('hide-form');
        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($familyMaterial)) {
                // en caso de error, borra familia del material 
                $familyMaterial->delete();

                // en caso de error, borra terminales y sellos asociados a conectores
                if ($material->family == 'Conectores') {
                    if ($terminals) {
                        $familyMaterial->terminals()->detach($terminals);
                    }
                    if ($seals) {
                        $familyMaterial->seals()->detach($seals);
                    }
                }
            }
            if (isset($material)) {
                // en caso de error, borra material
                $material->delete();
            }
            // Respuesta en consola del error
            $this->dispatchBrowserEvent('errorResponse', ['error' => $e->getMessage()]);

            return null;
        }
    }


    /**
     * Selecciona un material
     * @return Material $material
     */
    public function selectmaterial(Material $material)
    {
        $this->materialSelected = $material;
        $this->reset([
            'addMaterial', 'searchmaterials', 'material', 'accessory', 'cable', 'connector', 'terminal',
            'seal', 'tube', 'clip', 'familySelected'
        ]);
        return $this->materialSelected;
    }

    /**
     * Elimina al material seleccionado 
     * @return boolean $addProvider
     */
    public function downmaterial()
    {
        unset($this->materialSelected);
        $this->addMaterial = true;
        return $this->addMaterial;
    }

    /**
     * Accion para cambiar el campo "ars_price" dependiendo del campo "usd_price", el precio al dolar actual
     * 
     * @return array $price
     */
    public function changeArsPrice()
    {
        $this->price['ars_price'] = (is_numeric($this->price['usd_price'])) ? $this->price['usd_price'] * $this->ar_price : '';
        return $this->price['ars_price'];
    }

    /**
     * Registro de precio
     * @param Provider $provider
     * @return ProviderPrice $providerPrice
     */
    public function storePrice(Provider $provider)
    {
        //validacion para precios
        $validationProperties = $this->validationPrice('provider');
        $this->validation = $this->validate($validationProperties['rules'], $validationProperties['messages']);
        $providerPrice = $this->addPrice($provider, $this->materialSelected, $this->validation);

        $this->backToExplorar();
        return $providerPrice;
    }


    /**
     * Accion de asociar material y proveedor a un precio ingresado
     * @param Provider $provider, $materialSelected, $validation
     * @return ProviderPrice $providerPrice
     */
    public function addPrice(Provider $provider, $materialSelected, $validation)
    {
        //asociar los precios de materiales con proveedores
        $provider->materials()->syncWithPivotValues([$materialSelected->id], $validation['price'], false);
        $providerPrice = $provider->provider_prices->last();

        //guardando historial de precios
        $providerPrice->prices()->updateOrCreate([
            'date' => date("d-m-Y"),
            'provider_id' => $provider->id,
            'price' => $validation['price']['usd_price'],
        ]);

        return $providerPrice;
    }

    /**
     * Accion para regresar al detalle del proveedor seleccionado
     * @return function explorar
     */
    public function backToExplorar()
    {
        $this->resetExcept(['information', 'provider']);
        $this->resetValidation();
        return $this->explorar($this->provider['id']);
    }

    /**
     * Accion para cerrar el modal 
     * 
     * @return function reset
     */
    public function backModal()
    {
        $this->resetValidation();
        return $this->reset([
            'material', 'accessory', 'cable', 'connector', 'terminal', 'seal', 'tube', 'clip',
            'familySelected'
        ]);
    }

    /**
     * Accion para la vista de actualizar precios
     * @param integer $materialId, integer $priceId 
     * @return array $price|null
     */
    public function editPrice($materialId, $priceId)
    {
        $material = Material::findOrFail($materialId);

        if ($material) {
            $this->materials = Material::all();
            $this->addMaterial = true;
            $this->view = "actualizarPrecio";
            $this->showPrice = 'yes';
            $this->providerPrice = $material->providerprices()->whereId($priceId)->first();

            if ($this->providerPrice) {
                $this->price = [
                    'id' => $this->providerPrice->id,
                    'provider_code' => $this->providerPrice->provider_code,
                    'amount' => $this->providerPrice->amount,
                    'unit' => $this->providerPrice->unit,
                    'presentation' => $this->providerPrice->presentation,
                    'usd_price' => $this->providerPrice->usd_price,
                    'ars_price' => $this->providerPrice->ars_price,
                ];
                $this->materialSelected = $this->providerPrice->material;
            }
            return $this->price;
        }

        return null;
    }

    /**
     * Actualizar un precio
     * @param Provider $provider 
     * @return ProviderPrice $providerPrice
     */
    public function updatePrice(Provider $provider)
    {
        //validacion para precios
        $validationProperties = $this->validationPrice(false);
        $this->validation = $this->validate($validationProperties['rules'], $validationProperties['messages']);

        //Si cambia el material, elimina el anterior
        if ($this->materialSelected->id === $this->providerPrice->material_id) {
            //actualiza los datos del precio del proveedor si no se cambia el material
            $providerPrice = $this->updateProviderPrice($provider, $this->materialSelected, $this->validation, $this->providerPrice->usd_price);
        } else {
            //actualiza los datos del precio del proveedor si se cambia el material, elimina logicamente el registro del material anterior
            $provider->materials()->updateExistingPivot($this->providerPrice->material_id, [
                'deleted_at' => Carbon::now()
            ]);
            $this->providerPrice->prices()->delete();

            $providerPrice = $this->addPrice($provider, $this->materialSelected, $this->validation);
        }
        $this->backToExplorar();

        return $providerPrice;
    }

    /**
     * Accion actualizar precios existentes, si cambia el precio lo almacena en el historial de precios
     * @param Provider $provider, Material $material, $validation, $usd_price = 0
     * @return ProviderPrice $providerPrice
     */
    public function updateProviderPrice(Provider $provider, Material $material, $validation, $usd_price = 0)
    {
        $provider->materials()->updateExistingPivot($material->id, $validation['price']);
        $providerPrice = $provider->provider_prices->last();

        //si se cambia el campo usd_price, guarda registro en historial de precios
        if ($usd_price != $validation['price']['usd_price']) {
            $providerPrice->prices()->updateOrCreate([
                'date' => date("d-m-Y"),
                'provider_id' => $provider->id,
                'price' => $validation['price']['usd_price'],
            ]);
        }
        return $providerPrice;
    }

    /**
     * Accion para habilitar campos si la familia de material es "Tubos" del tipo "Termocontraible"
     * 
     * @return array $materialContent
     */
    public function selectType()
    {
        $this->materialContent[$this->familySelected]['addFields'] = ($this->tube['type'] == 'Termocontraible') ? true : false;
        return $this->materialContent;
    }
}
