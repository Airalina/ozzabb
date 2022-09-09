<?php

namespace App\Http\Livewire;

use App\Http\Traits\WarehouseTrait;
use App\Models\Assembled;
use App\Models\Material;
use App\Models\DepositMaterial;
use App\Models\Installation;
use App\Models\Warehouse;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Depositos extends Component
{
    use WithPagination, WarehouseTrait;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['newMaterial', 'newAssembled', 'newInstallation', 'backToEntry'];
    //Variables paginadas
    protected $deposited, $deposits, $withdrawsList;
    //Variables definidas 
    public $paginas = 25, $paginasinternas = 10, $paginasInternasRetiros = 10, $search = "", $searchAssembleds = "",
        $searchMaterials = "", $searchInstallations = "", $searchDeposit = "", $view = "", $selection = '', $order = "type";
    //Arrays
    public $amounts = [], $presentations = [], $amount = [], $totals = [], $warehouse = [], $movements = [], $withdraw = [], $withdraws = [],
        $productSelected = [], $productsSelected = [], $product, $productDeposited = [], $installationSelected = [];
    //Variables no definidas
    public $warehouses, $materials, $installations, $assembleds, $productsDeposited, $productDepositedCollect, $types, $validation, $states,
        $dataProduct, $warehouseDestination, $withdrawsCollect, $warehouseWithdraws, $warehouseSelected, $type, $material;

    public function __construct()
    {
        //Inicializa variables con informacion de depositos
        $this->types = Warehouse::TYPES;
        $this->states = Warehouse::STATES;
        $this->warehouse['id'] = '';
        $this->productsSelected['material'] = [];
        $this->amount['avaiable'] = [];
    }

    public function render()
    {
        //Si el ingreso / egreso es sin origen / destino, se buscan todos los materiales que posean una presentacion (relacion providerprices)
        //Si el ingreso / egreso es desde un deposito origen / destino, se buscan todos los materiales almacenados en ese deposito
        $this->materials = (isset($this->warehouseSelected)) ?
            $this->warehouseSelected->searchMaterialsDeposit($this->searchMaterials)->groupBy('id')->get() :
            Material::searchByProviderPrices($this->searchMaterials)->get();
        //Si el ingreso / egreso es sin origen / destino, se buscan todos los ensamblados
        //Si el ingreso / egreso es desde un deposito origen / destino, se buscan todos los ensamblados almacenados en ese deposito
        $this->assembleds = (isset($this->warehouseSelected)) ?
            $this->warehouseSelected->searchAssembledsDeposit($this->searchAssembleds)->get() :
            Assembled::search($this->searchAssembleds)->get();
        //Si el ingreso / egreso es sin origen / destino, se buscan todas las instalaciones
        //Si el ingreso / egreso es desde un deposito origen / destino, se buscan todas las instalaciones almacenados en ese deposito
        $this->installations = (isset($this->warehouseSelected)) ?
            $this->warehouseSelected->searchInstallationsDeposit($this->searchInstallations)->get() :
            Installation::search($this->searchInstallations)->get();
        if (!empty($this->warehouse['id'])) {
            //Almacen - ingreso / egreso con depositos tipo produccion, almacen o ingresar sin deposito
            //Produccion - ingreso / egreso con depositos tipo produccion o ingresar sin deposito 
            //Ensamblados - ingreso / egreso con depositos tipo produccion, ensamblados o ingresar sin deposito 
            //Expedicion - ingreso / egreso con depositos tipo expedicion o sin deposito
            switch ($this->warehouse['type']) {
                case 1:
                    $types = ($this->view == 'ingreso') ? [1] : [1, 2];
                    break;
                case 2:
                    $types = ($this->view == 'ingreso') ? [1, 2, 3] : [2];
                    break;
                case 3:
                    $types = ($this->view == 'ingreso') ? [3] : [2, 3];
                    break;
                case 4:
                    $types = [4];
                    break;
            }
            //Busqueda de depositos elegibles para ingresos / egresos
            $this->warehouses = Warehouse::searchWarehouses($this->searchDeposit, $this->warehouse['id'], $types)->get();
        }
        //Busqueda de depositos en el listado
        $this->deposits = Warehouse::search($this->search, $this->order)->paginate($this->paginas);

        //Paginador de array con los productos almacenados en un deposito  
        $this->deposited = !empty($this->productsDeposited) ? $this->fillPaginator($this->productDepositedCollect, $this->paginasinternas, 'productsDeposited') : collect([]);
        //Paginador de array con los retiros realizados desde el deposito
        $this->withdrawsList = !empty($this->warehouseWithdraws) ? $this->fillPaginator($this->withdrawsCollect, $this->paginasInternasRetiros, 'warehouseWithdraws') : collect([]);

        return view('livewire.depositos', [
            'deposits' => $this->deposits,
            'deposited' => $this->deposited,
            'withdrawsList' => $this->withdrawsList,
        ]);
    }

    /**
     * Accion de cambiar la vista a crear en "Agregar Deposito"
     * 
     * @return string $view
     */
    public function create()
    {
        $this->view = "create";
    }

    /**
     * Registro de un deposito
     * 
     * @return Warehouse $warehouse|null
     */
    public function store()
    {
        //validacion para depositos
        $validationProperties = $this->validationWarehouses();
        $this->validation = $this->validate($validationProperties['rules'], $validationProperties['messages']);
        $this->validation['warehouse']['state'] = 1;

        try {
            DB::beginTransaction();
            //creando el deposito
            $warehouse = Warehouse::updateOrCreate($this->validation['warehouse']);

            DB::commit();
            $this->resetValidation();
            $this->reset();
            return $warehouse;
        } catch (\Exception $e) {
            DB::rollBack();

            if (isset($warehouse)) {
                // en caso de error, borra deposito
                $warehouse->delete();
            }
            // Respuesta en consola del error
            $this->dispatchBrowserEvent('errorResponse', ['error' => $e->getMessage()]);

            return null;
        }
    }

    /**
     * accion de cambiar la vista a editar en "Actualizar"
     * 
     * @param int $warehouseId
     * @return string $view
     */
    public function edit($warehouseId)
    {
        $this->view = "actualizar";
        $this->warehouse = $this->fillWarehouse($warehouseId);
        return $this->view;
    }

    /**
     * Rellena un array con la informacion de un deposito
     * 
     * @param int $warehouseId
     * @return array $warehouseArray|null
     */
    public function fillWarehouse($warehouseId)
    {
        $warehouse = Warehouse::findOrFail($warehouseId);
        if ($warehouse) {
            $warehouseArray = [
                'id' => $warehouse->id,
                'name' => $warehouse->name,
                'description' => $warehouse->description,
                'location' => $warehouse->location,
                'create_date' => $warehouse->create_date,
                'create_date' => $warehouse->create_date,
                'state' => $warehouse->state,
                'type' => $warehouse->type,
                'temporary' => $warehouse->temporary,
            ];

            if ($warehouse->type == 1 || $warehouse->type == 2) {
                //Listado con los productos su la cantidad almacenada en el deposito
                $products = $warehouse->findAmountInWarehouse()->get();

                //Rellena arrays correspondiente con presentaciones, cantidades y totales para el material correspondiente
                $products->each(function ($product) {
                    $this->presentations[$product->is_material][$product->material_id][$product->presentation] = !$product->presentation ? ' ' : $product->presentation;
                    $this->amounts[$product->is_material][$product->material_id][$product->presentation] = $product->total_amount;
                    $this->totals[$product->is_material][$product->material_id][$product->presentation] =  ($product->is_material) ?
                        $product->presentation * $product->total_amount :
                        $product->total_amount;
                });

                $presentations = $this->presentations;
                $amounts = $this->amounts;
                $totals = $this->totals;
                //Rellena array correspondiente con cada producto (material / ensamblado)
                $products->each(function ($product) use ($presentations, $amounts, $totals) {
                    $dataProduct =  $product->is_material ? $product->material :  $product->assembled;

                    $this->productDeposited[$product->is_material][$dataProduct->id] = [
                        'id' => $dataProduct->id,
                        'code' => $dataProduct->code ?? 'Ensamblado - ' . $dataProduct->id,
                        'description' => $dataProduct->description,
                        'packaging' => $presentations[$product->is_material][$product->material_id],
                        'amount' => $amounts[$product->is_material][$product->material_id],
                        'total' =>  $totals[$product->is_material][$product->material_id]
                    ];
                });
                $productCollection = collect($this->productDeposited);
                $this->productDepositedCollect = $productCollection->flatten(1);
            } elseif ($warehouse->type == 3) {
                //Listado con los ensamblados y su cantidad almacenada en el deposito
                $assembleds = $warehouse->assembleds()->get();
                //Rellena array correspondiente con cada ensamblado
                $assembleds->each(function ($assembled) {
                    $assembledDeposited = [
                        'id' => $assembled->id,
                        'description' => $assembled->description,
                        'amount' => $assembled->total_amount,
                    ];
                    $this->productDeposited[$assembled->id] = $assembledDeposited;
                    $this->amounts[$assembled->pivot->is_material][$assembled->pivot->material_id][0] = $assembled->total_amount;
                });
                $this->productDepositedCollect = collect($this->productDeposited);
            } else {
                //Listado con las instalaciones y su cantidad almacenada en el deposito
                $installations = $warehouse->installations()->get();
                //Rellena array correspondiente con cada instalacion
                $installations->each(function ($installation) {
                    $installationDeposited = [
                        'number_version' => $installation->pivot->number_version,
                        'client_order_id' => $installation->pivot->client_order_id,
                        'amount' => $installation->total_amount,
                        'description' => $installation->description,
                        'code' => $installation->code,
                        'serial_number' => $installation->pivot->serial_number
                    ];
                    $this->productDeposited[$installation->id] = $installationDeposited;
                });
                $this->productDepositedCollect = collect($this->productDeposited);
            }
            //Paginador de array con los productos almacenados en un deposito  
            $this->deposited = $this->fillPaginator($this->productDepositedCollect, $this->paginasinternas, 'productsDeposited');

            return $warehouseArray;
        }
        return null;
    }

    /**
     * Paginador para arrays
     * 
     * @param Collection $collect
     * @param int $pages
     * @param string $property
     * @return Illuminate\Pagination\LengthAwarePaginator $pagination
     */
    public function fillPaginator($collect, $pages, $property)
    {
        $options = ['pageName' => $property];
        $this->$property = $collect->forPage($this->page, $pages);
        $pagination = new LengthAwarePaginator($this->$property, $collect->count(), $pages, $this->page, $options);
        return $pagination;
    }

    /**
     * Actualizar un deposito
     * 
     * @param Warehouse $warehouse
     * @return Warehouse $warehouse|null
     */
    public function update(Warehouse $warehouse)
    {
        //validacion para depositos
        $validationProperties = $this->validationWarehouses();
        $this->validation = $this->validate($validationProperties['rules'], $validationProperties['messages']);

        try {
            DB::beginTransaction();

            //actualizar el deposito
            $warehouse->update($this->validation['warehouse']);

            DB::commit();
            $this->resetValidation();
            $this->reset();
            return $warehouse;
        } catch (\Exception $e) {
            DB::rollBack();

            // Respuesta en consola del error
            $this->dispatchBrowserEvent('errorResponse', ['error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Accion que genera la vista del listado de depositos
     * 
     * @return funcion resetValidation()
     */
    public function volver()
    {
        $this->reset();
        return $this->resetValidation();
    }

    /**
     * Detalle de un deposito
     * 
     * @param int $warehouseId
     * @return string $view
     */
    public function explorar($warehouseId)
    {
        $this->view = "explorar";
        $this->warehouse = $this->fillWarehouse($warehouseId);

        return $this->view;
    }

    /**
     * Seleccionar un producto (material, ensamblado, instalacion) a depositar
     * 
     * @param int $id, string $type
     * @return array $productSelected
     */
    public function selectProduct($id, $type = '')
    {
        $this->productSelected = [];

        switch ($type) {
            case 'material':
                $this->dataProduct = Material::findOrFail($id);
                $this->productSelected['is_material'] = 1;
                break;
            case 'ensamblado':
                $this->dataProduct = Assembled::findOrFail($id);
                $this->productSelected['is_material'] = 0;
                break;
            case 'instalacion':
                $this->dataProduct = Installation::findOrFail($id);
                $this->productSelected['revisions'] = $this->dataProduct->revisions->toArray();
                break;
        }
        $this->productSelected['id'] = $this->dataProduct->id;
        $this->productSelected['code'] = $this->dataProduct->code ?? 'Ensamblado - ' . $this->dataProduct->id;
        $this->productSelected['description'] = $this->dataProduct->description;
        $this->productSelected['typeProduct'] = $type;

        //Busqueda de materiales, si existe el warehouse id entonces que posean relacion deposit materials, sino providerprices
        $warehouses =  ($type == 'material') ?  (!empty($this->warehouseSelected->id) ?
            $this->dataProduct->findMaterialsWarehouse($this->warehouseSelected->id)->get()  :
            $this->dataProduct->providers()->get())  : [];

        //Guardado de presentaciones del material    
        foreach ($warehouses as $warehouse) {
            $presentation =  $warehouse->pivot ? (empty($this->warehouseSelected) ?
                $warehouse->pivot->unit :
                $warehouse->pivot->presentation) :
                null;
            $this->productSelected['presentation'][$presentation] = $presentation;
        }

        if ($this->view == 'egreso' && $type == 'ensamblado') {
            $this->product['packaging'] = 0;
            //Calculo de cantidad disponible en ensamblados
            $this->calculateAmountAvaiable();
        }
        $this->resetValidation();
        $this->dispatchBrowserEvent('show-form');

        return $this->productSelected;
    }

    /**
     * Adicionar al array un producto (material, ensamblado, instalacion) a depositar
     * 
     * @return array $productsSelected
     */
    public function addProduct()
    {
        $validationProperties = $this->validationProducts();
        $this->validation = $this->validate($validationProperties['rules'], $validationProperties['messages']);

        $packaging = $this->validation['product']['packaging'] ?? 0;
        //Verifica si el producto seleccionado es un material y ya se encuentra guardado 
        $selectedMaterial = array_key_exists($this->productSelected['id'], $this->productsSelected['material']);
        //Verifica si la presentacion escogida del material es diferente a la presentacion guardada
        $selectedMaterialPresentation = isset($this->productsSelected['material'][$this->productSelected['id']]['packaging']) ?
            (!array_key_exists(
                $packaging,
                $this->productsSelected['material'][$this->productSelected['id']]['packaging']
            )) : false;

        if ($selectedMaterial && $selectedMaterialPresentation) {
            //Guarda presentaciones y cantidad para materiales 
            $this->productsSelected['material'][$this->productSelected['id']]['packaging'][$packaging] = $packaging;
            $this->productsSelected['material'][$this->productSelected['id']]['amount'][$packaging] = ($this->view === "ingreso") ?
                $this->validation['product']['amount']  :
                -$this->validation['product']['amount'];
        } else {
            //Guarda informacion de materiales, ensamblados e instalaciones
            $this->productSelected['amount'][$packaging] = ($this->view === "ingreso") ?  $this->validation['product']['amount'] : -$this->validation['product']['amount'];
            $this->productSelected['packaging'][$packaging] = $packaging;
            $this->productSelected['warehouse_id'] = $this->warehouse['id'];
            $this->productSelected['warehouse2_id'] = ($this->view === "ingreso") ? ($this->warehouseSelected->id ?? '') : $this->warehouseDestination->id ?? '';
            $this->productSelected['type'] = ($this->view === "ingreso") ?: 0;
            if ($this->productSelected['typeProduct'] == 'instalacion') {
                $this->productSelected['serial_number'] = $this->validation['product']['serial_number'] ?? '';
                $this->productSelected['client_order_id'] = $this->validation['product']['client_order_id'] ?? '';
                $this->productSelected['number_version'] = $this->validation['product']['number_version'] ?? '';
            }
            $this->productsSelected[$this->productSelected['typeProduct']][$this->productSelected['id']] = $this->productSelected;
        }
        $this->reset([
            'productSelected', 'product', 'searchMaterials',
            'searchAssembleds', 'searchInstallations', 'amount'
        ]);
        $this->resetValidation();
        $this->dispatchBrowserEvent('hide-form');
        return $this->productsSelected;
    }

    /**
     * Elimina un producto del array de productos seleccionados
     * 
     * @param int $id, string $type
     * @return array $productsSelected
     */
    public function downProduct($id, $type = '')
    {
        unset($this->productsSelected[$type][$id]);
        if (!count($this->productsSelected[$type])) {
            $this->productsSelected[$type] = [];
        }
        $this->reset(['productSelected', 'product', 'amount']);
        return $this->productsSelected;
    }

    /**
     * Salir del modal de seleccion de productos
     * 
     * @return funcion reset(['productSelected', 'product', 'amount'])
     */
    public function backModal()
    {
        return $this->reset(['productSelected', 'product', 'amount']);
    }

    /**
     * Guardado de movimientos (ingresos o egresos) 
     * 
     * @return function backToExplorar()
     */
    public function storeMovements()
    {
        $validationProperties = $this->validationMovements();
        $this->validation = $this->validate($validationProperties['rules'], $validationProperties['messages']);

        foreach ($this->productsSelected as $type => $products) {
            foreach ($products as $product) {
                //En caso de que sea un ingreso, el deposito origen puede ser seleccionado o cero
                $warehouse2_id = $this->view == 'ingreso' ?
                    ($this->warehouseSelected->id ?? 0) :
                    $this->validation['warehouseDestination']['id'];

                switch ($type) {
                    case 'material':
                        $entryProduct = Material::findOrFail($product['id']);
                        foreach ($product['packaging'] as $packaging) {
                            $entryData[] =  [
                                $product['warehouse_id'] => [
                                    'presentation' => $packaging,
                                    'amount' => $product['amount'][$packaging],
                                    'warehouse2_id' => $warehouse2_id,
                                    'type' => $product['type'],
                                    'is_material' => $product['is_material'],
                                    'date_change' => $this->validation['movements']['date'],
                                    'name_receive' => $this->validation['movements']['name_receive'],
                                    'name_entry' => $this->validation['movements']['name_entry'],
                                    'hour' => $this->validation['movements']['hour'],
                                ]
                            ];
                        }
                        break;
                    case 'ensamblado':
                        $entryProduct = Assembled::findOrFail($product['id']);
                        $entryData[] = [
                            $product['warehouse_id'] => [
                                'presentation' => $product['packaging'][0],
                                'amount' => $product['amount'][0],
                                'warehouse2_id' => $warehouse2_id,
                                'type' => $product['type'],
                                'is_material' => $product['is_material'],
                                'date_change' => $this->validation['movements']['date'],
                                'name_receive' => $this->validation['movements']['name_receive'],
                                'name_entry' => $this->validation['movements']['name_entry'],
                                'hour' => $this->validation['movements']['hour'],
                            ]
                        ];
                        break;
                    case 'instalacion':
                        $entryProduct = Installation::findOrFail($product['id']);
                        $entryData[] = [
                            $product['warehouse_id'] =>
                            [
                                'serial_number' => $product['serial_number'],
                                'number_version' => $product['number_version'],
                                'client_order_id' => $product['client_order_id'],
                                'amount' => $product['amount'][0],
                                'warehouse2_id' => $warehouse2_id,
                                'date_admission' => $this->validation['movements']['date'],
                                'name_receive' => $this->validation['movements']['name_receive'],
                                'name_entry' => $this->validation['movements']['name_entry'],
                                'hour' => $this->validation['movements']['hour'],
                            ]
                        ];
                        break;
                }

                if ($entryProduct) {
                    try {
                        DB::beginTransaction();
                        foreach ($entryData as $data) {
                            //Almacena la relacion de productos (materiales, ensamblados e instalaciones) con depositos
                            $entryProduct->warehouses()->attach($data);
                        }
                        $entryData = [];
                        DB::commit();
                    } catch (\Exception $e) {
                        DB::rollBack();
                        // Respuesta en consola del error
                        $this->dispatchBrowserEvent('errorResponse', ['error' => $e->getMessage()]);
                        return null;
                    }
                }
            }
        }
        return $this->backToExplorar();
    }

    /**
     * Seleccion de revisiones en caso de instalaciones 
     * 
     * @param int $revisionId
     * @return array $product|null
     */
    public function selectRevision($revisionId)
    {
        $revision = $this->dataProduct->revisions()->whereId($revisionId)->first();
        if ($revision) {
            $this->product['number_version'] = $revision->number_version;
            return $this->product;
        }
        return null;
    }

    /**
     * Elimina la revision seleccionada
     * 
     * @param int $revisionId
     * @return void
     */
    public function downRevision()
    {
        unset($this->product['number_version']);
        return;
    }

    /**
     *  Accion de cambiar la vista a "Nuevo Ingreso"
     * 
     * @return string $view
     */
    public function ingreso()
    {
        $this->movements['date'] = Carbon::now()->format('Y-m-d');
        $this->movements['hour'] = Carbon::now()->format('H:m');
        $this->view = "ingreso";

        return $this->view;
    }

    /**
     * Seleccionar un deposito
     * 
     * @param int $warehouseId
     * @return Warehouse $warehouse|null
     */
    public function selectDeposit($warehouseId)
    {
        $this->reset('searchDeposit');
        $warehouse = Warehouse::findOrFail($warehouseId);

        if ($warehouse) {
            if ($this->view == 'ingreso') {
                $this->warehouseSelected = $warehouse;
                $this->reset('productsSelected');
            } else {
                $this->warehouseDestination = $warehouse;
            }
            return $warehouse;
        }
        return null;
    }

    /**
     * Deselecciona el deposito seleccionado
     * 
     * @return function resetExcept(['warehouse', 'warehouses', 'view', 'movements'])
     */
    public function downDeposit()
    {
        unset($this->warehouseSelected);
        return $this->resetExcept(['warehouse', 'warehouses', 'view', 'movements']);
    }

    /**
     *  Accion de cambiar la vista a "Nuevo Egreso"
     * 
     * @return string $view
     */
    public function egreso()
    {
        $this->movements['date'] = Carbon::now()->format('Y-m-d');
        $this->movements['hour'] = Carbon::now()->format('H:m');
        $this->warehouseSelected = Warehouse::findOrFail($this->warehouse['id']);
        $this->view = "egreso";

        return $this->view;
    }

    /**
     *  Accion de cambiar la vista a "Ver retiros de este depósito"
     * 
     * @return string $view
     */
    public function retiros()
    {
        $this->view = "retiros";
        $warehouse = Warehouse::findOrFail($this->warehouse['id']);
        $withdraws = $warehouse->depositmaterials()->whereType(0)->get();

        foreach ($withdraws as $withdraw) {
            $withdrawArray = $this->fillWithdraw($withdraw);

            $this->withdraws[$withdraw->id] = $withdrawArray;
        }
        $this->withdrawsCollect = collect($this->withdraws);
        $this->withdrawsList = $this->fillPaginator($this->withdrawsCollect, $this->paginasInternasRetiros, 'warehouseWithdraws');

        return $this->view;
    }

    /**
     * Guarda informacion del movimiento (ingreso / egreso) 
     * 
     * @param DepositMaterial $withdraw
     * @return array $withdrawArray
     */
    public function fillWithdraw($withdraw)
    {
        $withdrawArray = [
            'id' => $withdraw->id,
            'material_id' => $withdraw->material_id,
            'code' => ($withdraw->is_material) ? $withdraw->material->code : 'Ensamblado - ' . $withdraw->assembled->id,
            'description' => ($withdraw->is_material) ? $withdraw->material->description : $withdraw->assembled->description,
            'packaging' => !$withdraw->presentation ? ' '  : $withdraw->presentation,
            'amount' => abs($withdraw->amount),
            'total' => ($withdraw->is_material) ? abs($withdraw->presentation * $withdraw->amount) : abs($withdraw->amount),
            'warehouse_id' => $withdraw->warehouse_id ?? ' ',
            'warehouse2_id' => $withdraw->warehouse2_id ?? ' ',
            'warehouse_name' => $withdraw->warehouse2->name ?? ' ',
            'warehouse_type' => $withdraw->warehouse2 ? $this->types[$withdraw->warehouse2->type] : ' ',
            'date' => date('d-m-Y', strtotime($withdraw->date_change)) . ' - ' .  $withdraw->hour,
            'is_material' => $withdraw->is_material,
        ];

        return $withdrawArray;
    }

    /**
     * Guarda informacion del movimiento (ingreso / egreso) 
     * 
     * @param int depositMaterialId
     * @return string $view
     */
    public function retiroDetail($depositMaterialId)
    {
        $retiro = $this->withdraws[$depositMaterialId];
        $this->withdraw['details']['retiro'] = $retiro;
        $this->withdraw['entry'] = [];
        $warehouseOrigin = Warehouse::findOrFail($this->withdraws[$depositMaterialId]['warehouse2_id']);
        $entry = $warehouseOrigin->searchEntry($retiro['warehouse_id'], $retiro['material_id'], $retiro['packaging'], $retiro['amount']);
        $this->view = "retiroDetail";

        if ($entry) {
            $this->withdraw['entry']['retiro'] = $this->fillWithdraw($entry);
        }
        return $this->view;
    }

    /**
     * Genera el modal para eliminar un depósito
     * 
     * @param Warehouse $warehouse
     * @return
     */
    public function destroy(Warehouse $warehouse)
    {
        $this->warehouse = $warehouse->toArray();
        return $this->dispatchBrowserEvent('show-borrar');
    }

    /**
     * Accion de eliminar logicamente un depósito
     * 
     * @return funcion volver()|null
     */
    public function delete()
    {
        if (auth()->user()->cannot('delete', auth()->user())) {
            abort(403);
        } else {
            try {
                DB::beginTransaction();
                $warehouse = Warehouse::findOrFail($this->warehouse['id']);
                $warehouse->delete();
                DB::commit();

                $this->dispatchBrowserEvent('hide-borrar');
                $this->dispatchBrowserEvent('deleted');
                return $this->volver();
            } catch (\Exception $e) {
                DB::rollBack();

                // Respuesta en consola del error
                $this->dispatchBrowserEvent('errorResponse', ['error' => $e->getMessage()]);
                return null;
            }
        }
    }

    /**
     * Accion de eliminar logicamente un depósito
     * 
     * @param string $type
     * @return string $view
     */
    public function createProduct($type)
    {
        switch ($type) {
            case 'material':
                $view = 'createMaterial';
                break;
            case 'ensamblado':
                $view = 'createAssembled';
                break;
            case 'instalacion':
                $view = 'createInstallation';
                break;
        }
        $this->resetValidation();
        $this->view = $view;
        return $this->view;
    }

    /**
     * Accion para regresar al detalle del deposito
     * 
     * @return function explorar
     */
    public function backToExplorar()
    {
        $this->resetValidation();
        $this->reset([
            'productsSelected', 'warehouseSelected', 'warehouseDestination', 'productSelected', 'product', 'selection',
            'searchMaterials', 'searchAssembleds', 'searchInstallations', 'movements', 'validation', 'amount'
        ]);
        return $this->explorar($this->warehouse['id']);
    }

    /**
     * Accion para calcular la cantidad disponible del producto a egresar
     * 
     * @return int $amount['avaiable']
     */
    public function calculateAmountAvaiable()
    {
        $this->amount['avaiable'] = $this->amounts[$this->productSelected['is_material']][$this->productSelected['id']][$this->product['packaging']];
        return $this->amount['avaiable'];
    }

    /**
     * Accion para seleccionar un material recien creado
     * 
     * @return funcion selectProduct($id, 'material')
     */
    public function newMaterial($id = null)
    {
        $this->view = $this->ingreso();
        return $this->selectProduct($id, 'material');
    }

    /**
     * Accion para seleccionar un ensamblado recien creado
     * 
     * @return funcion selectProduct($id, 'ensamblado')
     */
    public function newAssembled($id = null)
    {
        $this->view = $this->ingreso();
        return $this->selectProduct($id, 'ensamblado');
    }

    /**
     * Accion para seleccionar una instalacion recien creada
     * 
     * @return funcion selectProduct($id, 'instalacion')
     */
    public function newInstallation($id = null)
    {
        $this->view = $this->ingreso();
        return $this->selectProduct($id, 'instalacion');
    }

    /**
     * Accion para volver a la vista de 'Nuevo Ingreso'
     * 
     * @return string $view
     */
    public function backToEntry()
    {
        $this->view = $this->ingreso();
        return $this->view;
    }

    /**
     * Accion para volver a la vista de 'Ver retiros de este depósito'
     * 
     * @return string $view
     */
    public function backToRetiros()
    {
        $this->view = $this->retiros();
        return $this->view;
    }
}
