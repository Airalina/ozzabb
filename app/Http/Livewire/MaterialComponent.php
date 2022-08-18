<?php

namespace App\Http\Livewire;


use App\Models\Accessory;
use App\Models\Cable;
use App\Models\Clip;
use App\Models\Connector;
use App\Models\Dollar;
use App\Models\Material;
use App\Models\Provider;
use App\Models\Terminal;
use App\Models\Tube;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Http\Traits\ValidationTrait;
use App\Http\Traits\ProviderTrait;
use App\services\StoreImagesService;

class MaterialComponent extends Component
{
    use ProviderTrait, ValidationTrait, WithPagination, WithFileUploads;

    protected $paginationTheme = 'bootstrap';
    protected $materials;
    //Constantes 
    public $funcion = "", $paginas = 25,  $search = "", $searchSeal = "", $searchTerminal = "", $searchproviders = "", $order = "code";
    //Variables
    public $dolar, $ar_price, $showPrice, $addProvider, $providerSelected, $provider, $familySelected, $providerPrice;
    //Arrays
    public $price = [], $material = [], $terminal = [], $connector = [], $cable = [], $seal = [], $tube = [], $clip = [], $accesory = [],
        $files = [], $validation = [], $explora = [], $providerPrices = [], $upload  = [], $providers = [], $materialContent = [],
        $information = [];

    public function __construct()
    {
        //Inicializa array para deshabilitar campos 
        $this->explorar = [
            'disabled' => "",
            'readonly' => "",
            'familyDisabled' => "",
        ];
        //Inicializa array para almacenar imagenes 
        $this->files = [
            'paths' => [],
            'images' => [],
        ];
    }

    public function render()
    {
        //Precio del dolar al dia
        $this->dolar = Dollar::findOrfail(1);
        $this->ar_price = !empty($this->dolar) ? $this->dolar->arp_price : 0;

        //Buscador de materiales
        $this->materials  = Material::search($this->search, $this->order)->paginate($this->paginas);

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

        //Buscador de proveedores
        $this->providers = Provider::search($this->searchproviders)->get();

        return view('livewire.material-component', [
            'materials' => $this->materials,
        ]);
    }

    //Inicializando variables
    public function mount()
    {
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
        $this->addProvider = false;
        $this->providerPrice = [];
    }

    /**
     * Accion de cambiar la vista a crear en "Agregar Material"
     * 
     * @return string $funcion
     */
    public function create()
    {
        $this->funcion = "crear";
        $this->showPrice = "no";
        $this->addProvider = true;
        return $this->funcion;
    }

    /**
     * Rellena un array con los datos requeridos para la familia de materiales escogida
     * $key index del array que corresponde a materialFamily
     * addFields para añadir los campos si la familia "Tubos" es de tipo "Termocontraible" 
     * 
     * @param string $family, string|integer $key,bool $addFields, int $materialId = ''
     */
    public function updatedMaterialFamily($family, $key, $addFields = false, $materialId = '')
    {
        $this->familySelected = $family;

        switch ($this->familySelected) {
            case 'Conectores':
                $this->materialContent[$this->familySelected] = [
                    'connectors' => Connector::selection(),
                    'terminals' => [],
                    'seals' => [],
                ];
                break;
            case 'Cables':
                $this->materialContent[$this->familySelected] = [
                    'colors' => Material::COLORS,
                    'configurations' => Cable::CONFIGURATIONS,
                    'norms' => Cable::NORMS,
                ];
                break;
            case 'Terminales':
                $this->materialContent[$this->familySelected] = [
                    'materials' => Terminal::MATERIALS,
                    'types' => Terminal::TYPES
                ];
                break;
            case 'Tubos':
                $this->materialContent[$this->familySelected] = [
                    'types' => Tube::TYPES,
                    'addFields' => $addFields
                ];
                break;
            case 'Accesorios':
                $this->materialContent[$this->familySelected]['types'] = Accessory::TYPES;
                break;
            case 'Clips':
                $this->materialContent[$this->familySelected]['types'] = Clip::TYPES;
                break;
        }
        $this->fillInformation($this->familySelected, $materialId);
        //Inicializar el array de las validaciones segun el tipo de familia
        $type = $this->information['families'][$this->familySelected];
        $this->validation[$type] = [];

        return;
    }

    /**
     * Rellena un array para mostrar campos dependiendo de la familia de materiales escogida
     * 
     * @param string $family, int $materialId
     * @return array $information
     */
    public function fillInformation($family, $materialId = '')
    {
        $this->information['showColors'] = ($family == 'Cables' || $family == 'Terminales') ? false : true;
        $this->information['showLines'] = ($family == 'Cables' || $family == 'Tubos' || $family == 'Accesorios') ? false : true;
        $this->information['showReplace'] = ($family == 'Cables' || $family == 'Tubos') ? false : true;
        $materialReplaces = Material::familyMaterials($family)->whereNotIn('id', [$materialId]);
        $this->information['replaces'] = $materialReplaces ? $materialReplaces->get()->toArray() : [];

        return $this->information;
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
     * Rellena un array para almacenar imagenes
     * 
     * @return array $files
     */
    public function updatedUploadImages()
    {
        $validationProperties = $this->validationImages();
        $this->validate($validationProperties['rules'], $validationProperties['messages']);

        foreach ($this->upload['images'] as $image) {
            $this->files['images'][] = $image->temporaryUrl();
            $this->files['paths'][] = $image;
        }
        return $this->files['images'];
    }

    /**
     * Elimina una imagen y su path
     * @param int $index
     * @return array $files
     */
    public function deleteImg(int $index)
    {
        unset($this->files['images'][$index]);
        unset($this->files['paths'][$index]);
        return $this->files;
    }

    /**
     * Registro de un material
     * 
     * @param $type, $id
     * @return Material $material|null
     */
    public function store()
    {
        //validacion para materiales
        $validationProperties = $this->validationMaterials($this->familySelected, $this->showPrice);
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
            //Asociar precio de proveedor al material
            if ($this->showPrice == 'yes') {
                $this->addPrice($material, $this->providerSelected, $this->validation);
            }

            //almacenar imagenes
            if (!empty($this->files['images'])) {
                $storeImages = new StoreImagesService;
                $material->image = $storeImages->uploadManyFiles($this->upload['images'], 'materials/' . $material->id);
                $material->save();
            }

            DB::commit();
            $this->resetValidation();
            $this->resetExcept(['information']);

            return $material;
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
     * accion de cambiar la vista a editar en "Actualizar"
     * 
     * @param int $materialId
     * @return string $funcion
     */
    public function edit($materialId)
    {
        $this->funcion = "actualizar";
        $this->explorar['familyDisabled'] = 'disabled';
        $this->material = $this->fillMaterial($materialId);
        return $this->funcion;
    }

    /**
     * Actualizar un material
     * 
     * @param Material $material
     * @return Material $material|null
     */
    public function update(Material $material)
    {
        //validacion para materiales
        $validationProperties = $this->validationMaterials($this->familySelected, $this->showPrice);
        $this->validation = $this->validate($validationProperties['rules'], $validationProperties['messages']);

        try {
            DB::beginTransaction();

            //actualizar el material
            $material->update($this->validation['material']);
            //obteniendo la relacion de la familia escogida dinamicamente
            $model = $this->information['families'][$this->familySelected];
            //actualizando las caracteristicas del material y su familia
            $familyColumns = $this->validation[$model] ?? [];
            $material->$model()->update($familyColumns);

            //guardando sellos y terminales para materiales familia conectores
            if ($this->validation['material']['family'] == 'Conectores') {
                $familyMaterial = $material->connector;
                $terminals = array_keys($this->materialContent['Conectores']['terminals']) ?? false;
                $seals = array_keys($this->materialContent['Conectores']['seals']) ?? false;
                $familyMaterial->terminals()->sync($terminals);
                $familyMaterial->seals()->sync($seals);
            }
            //almacenar imagenes si los paths son diferentes a los de base de datos
            if ($this->files['paths'] != $this->material['image']) {
                $storeImages = new StoreImagesService;
                //Compara las imagenes de base de datos con las que se envian 
                $materialImages = collect($this->material['image'])->diffKeys($this->files['images'])->all();
                //Se eliminan las imagenes que ya no van a estar en base de datos
                $storeImages->deleteManyFiles($materialImages);
                //guarda las imagenes enviadas, retorna un string con una matriz de paths para guardar en base de datos 
                $material->image = $storeImages->uploadManyFiles($this->files['paths'], 'materials/' . $material->id);
                $material->save();
            }
            DB::commit();
            $this->resetValidation();
            $this->resetExcept(['information']);

            return $material;
        } catch (\Exception $e) {
            DB::rollBack();

            // Respuesta en consola del error
            $this->dispatchBrowserEvent('errorResponse', ['error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Detalle de un material
     * 
     * @param int $materialId
     * @return string $funcion
     */
    public function explorar($materialId)
    {
        $this->funcion = "explorar";
        $this->material = $this->fillMaterial($materialId);

        //deshabilitar campos
        $this->explorar = [
            'disabled' => "disabled",
            'readonly' => "readonly",
            'familyDisabled' => "disabled",
        ];

        return $this->funcion;
    }

    /**
     * Rellena un array con la informacion de un material
     * 
     * @param int $materialId
     * @return array $materialArray|null
     */
    public function fillMaterial($materialId)
    {
        $material = Material::findOrFail($materialId);
        if ($material) {
            $materialArray = [
                'id' => $material->id,
                'code' => $material->code,
                'name' => $material->name,
                'family' => $material->family,
                'color' => $material->color,
                'description' => $material->description,
                'replace_id' => $material->replace_id,
                'stock_min' => $material->stock_min,
                'stock_max' => $material->stock_max,
                'stock' => $material->stock,
                'usage' => $material->usage,
                'line' => $material->line,
                'image' => json_decode($material->image)
            ];

            if (!empty($materialArray['image'])) {
                $this->files['paths'] = $materialArray['image'];
                foreach ($materialArray['image'] as $image) {
                    $this->files['images'][] = $material->getUrl($image);
                }
            }

            $addFields = ($material->family == 'Tubos') ? ($material->tube->type == 'Termocontraible' ? true : false) : false;
            $this->updatedMaterialFamily($material->family, $material->id, $addFields, $materialId);
            $this->fillFamilyData($material);
            $this->providerPrices = $material->providerprices;
            return $materialArray;
        }
        return null;
    }

    /**
     * Rellena un array con la informacion dependiendo de la familia de un material
     * 
     * @param Material $material
     * @return 
     */
    public function fillFamilyData($material)
    {

        switch ($material->family) {
            case 'Conectores':
                $this->connector['number_of_ways'] = $material->connector->number_of_ways;
                $this->connector['type'] = $material->connector->type;
                $this->connector['connector_id'] = $material->connector->connector_id;
                $this->connector['watertight'] = $material->connector->watertight;
                $this->connector['lock'] = $material->connector->lock;
                $this->connector['cover'] = $material->connector->cover;

                $terminals = $material->connector->terminals;
                $terminals->map(function ($item, $key) {
                    return $this->addTerminalsToConnector($item->materialId);
                });
                $seals = $material->connector->seals;
                $seals->map(function ($item, $key) {
                    return $this->addSealsToConnector($item->material);
                });
                break;
            case 'Cables':
                $this->cable['section'] = $material->cable->section;
                $this->cable['base_color'] = $material->cable->base_color;
                $this->cable['line_color'] = $material->cable->line_color;
                $this->cable['braid_configuration'] = $material->cable->braid_configuration;
                $this->cable['norm'] = $material->cable->norm;
                $this->cable['number_of_unipolar'] = $material->cable->number_of_unipolar;
                $this->cable['mesh_type'] = $material->cable->mesh_type;
                $this->cable['operating_temperature'] = $material->cable->operating_temperature;
                break;
            case 'Terminales':
                $this->terminal['size'] = $material->terminal->size;
                $this->terminal['minimum_section'] = $material->terminal->minimum_section;
                $this->terminal['maximum_section'] = $material->terminal->maximum_section;
                $this->terminal['material'] = $material->terminal->material;
                $this->terminal['type'] = $material->terminal->type;
                break;
            case 'Tubos':
                $this->tube['type'] = $material->tube->type;
                $this->tube['diameter'] = $material->tube->diameter;
                $this->tube['wall_thickness'] = $material->tube->wall_thickness;
                $this->tube['contracted_diameter'] = $material->tube->contracted_diameter;
                $this->tube['minimum_temperature'] = $material->tube->minimum_temperature;
                $this->tube['maximum_temperature'] = $material->tube->maximum_temperature;
                break;
            case 'Accesorios':
                $this->accesory['type'] = $material->accesory->type;
                break;
            case 'Sellos':
                $this->seal['minimum_diameter'] = $material->seal->minimum_diameter;
                $this->seal['maximum_diameter'] = $material->seal->maximum_diameter;
                $this->seal['type'] = $material->seal->type;
                break;
            case 'Clips':
                $this->clip['type'] = $material->clip->type;
                $this->clip['long'] = $material->clip->long;
                $this->clip['width'] = $material->clip->width;
                $this->clip['hole_diameter'] = $material->clip->hole_diameter;
                break;
        }

        return;
    }

    /**
     * Genera el modal para eliminar un material
     * 
     * @param Material $material
     * @return 
     */
    public function destruir(Material $material)
    {
        $this->material = $material->toArray();
        return $this->dispatchBrowserEvent('show-borrar');
    }

    /**
     * Accion de eliminar logicamente un material
     * 
     * @return string funcion|null
     */
    public function delete()
    {
        if (auth()->user()->cannot('delete', auth()->user())) {
            abort(403);
        } else {
            try {
                DB::beginTransaction();

                $material = Material::findOrFail($this->material['id']);
                $material->providers->each(function ($provider, $key) use ($material) {
                    $providerPrice = $material->providerprices()->whereId($provider->pivot->id)->first();
                    if ($providerPrice) {
                        //Elimina logicamente el registro de precios
                        $providerPrice->prices()->delete();
                        //Elimina logicamente registros de precios por proveedor del material
                        $providerPrice->delete();
                    }
                    return $providerPrice;
                });
                if ($material->family == 'Conectores') {
                    //Elimina relacion entre conector y terminales
                    $terminals = $material->connector->terminals()->select('terminal_id')->get();
                    $terminalsId = $terminals->pluck('terminal_id');
                    $material->connector->terminals()->detach($terminalsId);

                    //Elimina relacion entre conector y sellos
                    $seals = $material->connector->seals()->select('seal_id')->get();
                    $sealsId = $seals->pluck('seal_id');
                    $material->connector->seals()->detach($sealsId);
                }

                //Elimina logicamente el familiar del material
                $model = $this->information['families'][$material->family];
        
                $material->$model->delete();
                //Elimina logicamente el material
                $material->delete();
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
     * @return string $funcion
     */
    public function createPrice()
    {
        $this->providers = Provider::all();
        $this->addProvider = true;
        $this->funcion = "crearPrecio";
        $this->showPrice = 'yes';
        return $this->funcion;
    }

    /**
     * Accion de asociar material y proveedor a un precio ingresado
     * @param Material $material, Provider $providerSelected, array $validation  
     * @return ProviderPrice $providerPrice
     */
    public function addPrice(Material $material, $providerSelected, $validation)
    {
        //asociar los precios de materiales con proveedores
        $material->providers()->syncWithPivotValues([$providerSelected->id], $validation['price'], false);
        $providerPrice = $material->providerprices->last();

        //guardando historial de precios
        $providerPrice->prices()->updateOrCreate([
            'date' => date("d-m-Y"),
            'provider_id' => $providerSelected->id,
            'price' => $validation['price']['usd_price'],
        ]);

        return $providerPrice;
    }

    /**
     * Registro de precio
     * @param Material $material 
     * @return ProviderPrice $providerPrice
     */
    public function storePrice(Material $material)
    {
        //validacion para precios
        $validationProperties = $this->validationPrice();
        $this->validation = $this->validate($validationProperties['rules'], $validationProperties['messages']);
        $providerPrice = $this->addPrice($material, $this->providerSelected, $this->validation);

        $this->backToExplorar();
        return $providerPrice;
    }

    /**
     * Accion para la vista de actualizar precios
     * @param Material $material, integer $priceId 
     * @return array $price
     */
    public function editPrice(Material $material, $priceId)
    {
        $this->providers = Provider::all();
        $this->addProvider = true;
        $this->funcion = "actualizarPrecio";
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
            $this->providerSelected = $this->providerPrice->provider;
        }
        

        return $this->price;
    }

    /**
     * Accion actualizar precios existentes, si cambia el precio lo almacena en el historial de precios
     * @param Material $material, Provider $provider, array $validation, float $usd_price = 0
     * @return ProviderPrice $providerPrice
     */
    public function updateProviderPrice(Material $material, Provider $provider, $validation, $usd_price = 0)
    {
        $material->providers()->updateExistingPivot($provider->id, $validation['price']);
        $providerPrice = $material->providerprices->last();

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
     * Actualizar un precio
     * @param Material $material 
     * @return ProviderPrice $providerPrice
     */
    public function updatePrice(Material $material)
    {
        //validacion para precios
        $validationProperties = $this->validationPrice();
        $this->validation = $this->validate($validationProperties['rules'], $validationProperties['messages']);

        //Si cambia el proveedor, elimina el anterior
        if ($this->providerSelected->id === $this->providerPrice->provider_id) {
            //actualiza los datos del precio del proveedor si no se cambia el proveedor
            $providerPrice = $this->updateProviderPrice($material, $this->providerSelected, $this->validation, $this->providerPrice->usd_price);
        } else {
            //actualiza los datos del precio del proveedor si se cambia el proveedor, elimina logicamente el registro del proveedor anterior
            $material->providers()->updateExistingPivot($this->providerPrice->provider_id, [
                'deleted_at' => Carbon::now()
            ]);
            $this->providerPrice->prices()->delete();

            $providerPrice = $this->addPrice($material, $this->providerSelected, $this->validation);
        }
        $this->backToExplorar();

        return $providerPrice;
    }

    /**
     * Accion que ejecuta el modal para crear un proveedor  
     * @return event show-form
     */
    public function addProvider()
    {
        return $this->dispatchBrowserEvent('show-form');
    }

    /**
     * Registra un proveedor por medio del trait ProviderTrait
     * @return event hide-form
     */
    public function storeProvider()
    {
        $provider = $this->storeProviders();

        $this->selectprovider($provider);
        return $this->dispatchBrowserEvent('hide-form');
    }

    /**
     * Selecciona un proveedor
     * @return Provider $providerSelected
     */
    public function selectprovider(Provider $provider)
    {
        $this->providerSelected = $provider;
        $this->reset(['addProvider', 'searchproviders', 'provider']);
        return $this->providerSelected;
    }

    /**
     * Elimina al proveedor seleccionado 
     * @return boolean $addProvider
     */
    public function downprovider()
    {
        unset($this->providerSelected);
        $this->addProvider = true;
        return $this->addProvider;
    }

    /**
     * Accion que genera la vista del listado de materiales
     * 
     * @return string funcion
     */
    public function back()
    {
        $this->funcion = "";
        $this->resetExcept(['information']);
        return $this->funcion;
    }

    /**
     * Accion para regresar al detalle del material seleccionado
     * @return function explorar
     */
    public function backToExplorar()
    {
        $this->resetExcept(['information', 'material']);
        $this->resetValidation();
        return $this->explorar($this->material['id']);
    }

    /**
     * Accion para cerrar el modal 
     * 
     * @return function reset
     */
    public function backModal()
    {
        $this->resetValidation();
        return $this->reset(['provider']);
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

}
