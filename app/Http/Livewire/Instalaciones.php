<?php

namespace App\Http\Livewire;

use App\Http\Traits\InstallationTrait;
use App\Models\Customer;
use Livewire\Component;
use App\Models\Installation;
use App\Models\Material;
use App\Models\Revision;
use App\Models\Revisiondetail;
use App\services\StoreImagesService;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Instalaciones extends Component
{
    use WithFileUploads, WithPagination, InstallationTrait;
    protected $installations;
    protected $paginationTheme = 'bootstrap';
    //Variables no definidas
    public $materials, $revisions, $validation, $customer, $number_version;
    //Variables definidas 
    public $searchMaterials = '', $searchInstallations = '', $pages = 25, $component = '', $searchCustomers = '',  $view = '',
        $order = "code";
    //Arrays
    public $files = [], $installation = [], $materialsSelected = [], $material = [], $revisionDetails = [], $revision = [],
        $customersData = [];

    public function __construct()
    {
        //Inicializa array para almacenar imagenes 
        $this->files = [
            'images' => [],
        ];
        //Inicializa array para relacionar con clientes
        $this->customersData = [
            'customers' => [],
            'searchCustomers' => '',
            'customerSelected' => [],
        ];
    }

    public function render()
    {
        $this->materials = Material::search($this->searchMaterials)->get();
        $this->installations = Installation::search($this->searchInstallations, $this->order)->paginate($this->pages);
        //Busqueda de clientes
        $this->customersData['customers'] = Customer::search($this->customersData['searchCustomers'])->get()->toArray();

        return view('livewire.instalaciones', [
            'installations' => $this->installations,
        ]);
    }

    /**
     * Accion de cambiar la vista a crear en "Agregar Instalacion"
     * 
     * @return string $view
     */
    public function create()
    {
        $this->view = "create";
        return $this->view;
    }

    /**
     * Accion de seleccionar un cliente
     * 
     * @return string $customersData['searchCustomers']|null
     */
    public function selectCustomer($customerId)
    {
        $this->customer = Customer::find($customerId);
        if ($this->customer) {
            $this->customersData['customerSelected'] = [
                'name' => $this->customer->name,
                'phone' => $this->customer->phone,
                'email' => $this->customer->email,
                'domicile_admin' => $this->customer->domicile_admin,
                'estado' => $this->customer->estado,
            ];
            return $this->customersData['searchCustomers'] = '';
        }
        return null;
    }

    /**
     * Rellena un array para almacenar imagenes
     * 
     * @return array $files
     */
    public function updatedInstallationImage()
    {
        $validationProperties = $this->validationImages();
        $this->validate($validationProperties['rules'], $validationProperties['messages']);

        $this->files['images'][0] = $this->installation['image']->temporaryUrl();
        $this->files['paths'][0] = $this->installation['image'];

        return $this->files['images'];
    }

    /**
     * Elimina una imagen y su path
     * 
     * @param int $index
     * @return array $files
     */
    public function deleteImg(int $index)
    {
        unset($this->files['images'][$index]);
        unset($this->files['paths'][$index]);
        unset($this->installation['image']);

        return $this->files;
    }
    /**
     * Seleccionar material para la instalacion
     * 
     * @param int $materialId
     * @return array $material|null
     */
    public function selectMaterial($materialId)
    {
        $material = Material::findOrfail($materialId);

        if ($material) {
            $this->material  = [
                'id' => $material->id,
                'code' => $material->code,
                'description' => $material->description
            ];
            $this->dispatchBrowserEvent('show-form-material');
            $this->resetValidation();
            return $this->material;
        }
        return null;
    }

    /**
     * Agrega al array de materiales un material seleccionado
     * 
     * @return function backModal()
     */
    public function addMaterial()
    {
        $validationProperties = $this->validationSelectMaterials();
        $this->validation = $this->validate($validationProperties['rules'], $validationProperties['messages']);

        $this->material['amount'] =  $this->validation['material']['amount'];
        $this->materialsSelected[$this->material['id']] = $this->material;

        $this->dispatchBrowserEvent('hide-form-material');
        return $this->backModal();
    }

    /**
     * Elimina del array de materiales un material seleccionado
     * 
     * @return null
     */
    public function downMaterial($materialId)
    {
        unset($this->materialsSelected[$materialId]);
        return null;
    }

    /**
     * Accion al cancelar el modal
     * 
     * @return null
     */
    public function backModal()
    {
        $this->resetValidation();
        $this->reset('material');
        return null;
    }

    /**
     * Registro de una instalacion
     * 
     * @return Installation $installation|null
     */
    public function store()
    {
        $validationProperties = $this->validationInstallations();
        $this->validation = $this->validate($validationProperties['rules'], $validationProperties['messages']);

        try {
            DB::beginTransaction();
            //creando la instalacion
            $installation = $this->customer->installations()->updateOrCreate($this->validation['installation']);
            //asociando la revision base
            $revisionBase = [
                'number_version' => 0,
                'create_date' => $this->validation['installation']['date_admission'],
                'reason' => 'Modelo base'
            ];
            if (!empty($this->installation['image'])) {
                $storeImages = new StoreImagesService;
                //almacenar imagenes
                $revisionBase['image'] = $storeImages->uploadFile($this->installation['image'], 'installations/' . $installation->id);
            }
            $revision = $installation->revisions()->firstOrCreate($revisionBase);

            //asociando instalaciones con revisiones y materiales
            foreach ($this->materialsSelected as $material) {
                $revisionDetail = [
                    'number_version' => $revision->number_version,
                    'material_id' => $material['id'],
                    'amount' => $material['amount'],
                ];
                $installation->revisiondetails()->firstOrCreate($revisionDetail);
            }

            DB::commit();
            if ($this->component == 'depositos') {
                return $this->emit('newInstallation', $this->instalacion->id);
            }
            $this->resetValidation();
            $this->reset();
            return $installation;
        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($installation->revisiondetails)) {
                // en caso de error, borra detalles de revision base de la instalacion 
                foreach ($installation->revisiondetails as $revisiondetail) {
                    $revisiondetail->delete();
                }
            }
            if (isset($revision)) {
                // en caso de error, borra revision de la instalacion 
                $revision->delete();
            }
            if (isset($installation)) {
                // en caso de error, borra instalacion
                $installation->delete();
            }
            // Respuesta en consola del error
            $this->dispatchBrowserEvent('errorResponse', ['error' => $e->getMessage()]);

            return null;
        }
    }

    /**
     * Accion para ir al inicio
     * 
     * @return function emit(backToEntry')|null
     */
    public function back()
    {
        if ($this->component == 'depositos') {
            //En caso de estar en el modulo Depositos, volver al ingreso
            return $this->emit('backToEntry');
        }
        $this->reset();
        $this->resetValidation();
        return null;
    }

    /**
     * Accion de cambiar la vista a editar en "Actualizar"
     * 
     * @param int $installationId
     * @return string $view
     */
    public function edit($installationId)
    {
        $this->view = "update";
        $this->installation = $this->fillInstallation($installationId);
        return $this->view;
    }

    /**
     * Actualizar una instalacion
     * 
     * @param Installation $installation
     * @return Installation $installation|null
     */
    public function update(Installation $installation)
    {
        //validacion para instalaciones
        $validationProperties = $this->validationInstallations();
        $this->validation = $this->validate($validationProperties['rules'], $validationProperties['messages']);

        try {
            DB::beginTransaction();
            //actualizar la instalacion 
            $this->validation['installation']['customer_id'] = $this->customer->id;
            $installation->update($this->validation['installation']);

            DB::commit();
            $this->resetValidation();
            $this->reset();
            return $installation;
        } catch (\Exception $e) {
            DB::rollBack();
            // Respuesta en consola del error
            $this->dispatchBrowserEvent('errorResponse', ['error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Genera el modal para eliminar una instalacion
     * 
     * @param Installation $installation
     * @return array $installation
     */
    public function destroy(Installation $installation)
    {
        $this->dispatchBrowserEvent('show-borrar');
        $this->installation = $installation->toArray();
        return $this->installation;
    }

    /**
     * Accion de eliminar logicamente una instalacion
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

                $installation = Installation::findOrFail($this->installation['id']);
                //Accion para borrar logicamente solo revisiones
                $revisions = $this->view == 'explora' ?  $installation->revisions()->whereId($this->revision['id'])->get()
                    : $installation->revisions;

                $revisions->each(function ($revision, $key) use ($installation) {
                    $revisionsDetail = $installation->revisiondetails()->where('number_version', $revision->number_version)->get();
                    if ($revisionsDetail) {
                        //Elimina logicamente el detalle de las revisiones
                        foreach ($revisionsDetail as $detail) {
                            $detail->delete();
                        }
                    }
                    $revision->delete();
                    return $revisionsDetail;
                });

                $this->dispatchBrowserEvent('deleted');
                //Elimina logicamente la instalacion
                if ($this->view === 'explora') {
                    $this->dispatchBrowserEvent('hide-borrar-revision');
                    return $this->backToExplorar();
                }

                $installation->delete();
                $this->dispatchBrowserEvent('hide-borrar');
                DB::commit();
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
     * Detalle de una instalacion
     * 
     * @param int $installationId
     * @return string $view
     */
    public function explorar($installationId)
    {
        $this->view = "explora";
        $this->installation = $this->fillInstallation($installationId);
        return $this->view;
    }

    /**
     * Rellena un array con la informacion de una instalacion
     * 
     * @param int $installationId
     * @return array $installationArray|null
     */
    public function fillInstallation($installationId)
    {
        $installation = Installation::findOrFail($installationId);
        if ($installation) {
            $date_admission = Carbon::parse($installation->date_admission);
            $installationArray = [
                'id' => $installation->id,
                'code' => $installation->code,
                'description' => $installation->description,
                'date_admission' => $date_admission->format('Y-m-d'),
                'usd_price' => $installation->usd_price,
                'revisions' => $installation->revisions()->get()->toArray(),
            ];
            $this->selectCustomer($installation->customer_id);
            return $installationArray;
        }
        return null;
    }

    /**
     * Vista para agregar una nueva revision
     * 
     * @return array $materialsSelected
     */
    public function newRevision()
    {
        $this->view = "newrevision";
        $installation = Installation::findOrFail($this->installation['id']);
        $this->number_version = $installation->revisions->last()->number_version;
        $revisionDetails = $installation->revisiondetails()->where('number_version', $this->number_version)->get();
        $this->revision['number_version'] = $this->number_version + 1;

        $this->materialsSelected = $this->fillMaterial($revisionDetails);
        return $this->materialsSelected;
    }

    /**
     * Rellenar materiales seleccionados para las instalaciones
     * 
     * @param array $details
     * @return array $materials|array []
     */
    public function fillMaterial($details)
    {
        foreach ($details as $detail) {
            $material = [
                'id' => $detail->material->id,
                'code' => $detail->material->code,
                'description' => $detail->material->description,
                'amount' => $detail->amount
            ];
            $materials[$material['id']] = $material;
        }
        return $materials ?? [];
    }

    /**
     * Almacenar nuevas revisiones para instalaciones
     * 
     * @param Installation $installation
     * @return Installation $installation|null
     */
    public function storeRevision(Installation $installation)
    {
        $validationProperties = $this->validationRevisions();
        $this->validation = $this->validate($validationProperties['rules'], $validationProperties['messages']);

        try {
            DB::beginTransaction();

            $this->validation['revision']['number_version'] = $this->revision['number_version'];
            $revision = $installation->revisions()->firstOrCreate($this->validation['revision']);

            //asociando instalaciones con revisiones y materiales
            foreach ($this->materialsSelected as $material) {
                $revisionDetail = [
                    'number_version' => $revision->number_version,
                    'material_id' => $material['id'],
                    'amount' => $material['amount'],
                ];
                $installation->revisiondetails()->firstOrCreate($revisionDetail);
            }
            DB::commit();
            $this->backToExplorar();
            return $installation;
        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($installation->revisiondetails)) {
                $revisionDetails = $installation->revisiondetails()->where('number_version', $this->number_version)->get();
                // en caso de error, borra detalles de revision de la instalacion 
                foreach ($revisionDetails as $revisiondetail) {
                    $revisiondetail->delete();
                }
            }
            if (isset($revision)) {
                // en caso de error, borra revision de la instalacion 
                $revision->delete();
            }
            // Respuesta en consola del error
            $this->dispatchBrowserEvent('errorResponse', ['error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Vista para actualizar una revision
     * 
     * @param int $revisionId
     * @return array $revision
     */
    public function editRevision($revisionId)
    {
        $this->view = 'updateRevision';
        $installation = Installation::findOrFail($this->installation['id']);
        $this->revision = $installation->revisions()->whereId($revisionId)->first()->toArray();
        $revisionDetails = $installation->findRevisionsDetail($this->revision['number_version']);
        $this->materialsSelected = $this->fillMaterial($revisionDetails);
        return $this->revision;
    }

    /**
     * Actualizar una revision
     * 
     * @param Installation $installation, Revision $revision
     * @return Revision $revision|null
     */
    public function updateRevision(Installation $installation, Revision $revision)
    {
        //validacion para revisiones
        $validationProperties = $this->validationRevisions();
        $this->validation = $this->validate($validationProperties['rules'], $validationProperties['messages']);

        try {
            DB::beginTransaction();
            //actualizar la revision 
            $revision->update($this->validation['revision']);

            $revisionsDetails = $installation->findRevisionsDetail($revision->number_version);
            //si el material en base de datos no existe en el array de materiales seleccionados, lo elimina
            $revisionsDetails->each(function ($revisionsDetail, $key) {
                if (!isset($this->materialsSelected[$revisionsDetail->material_id])) {
                    return $revisionsDetail->delete();
                }
            });
            //actualizar el detalle de la revision si existe el material para el numero de version, sino, la crea
            foreach ($this->materialsSelected as $material) {
                $installation->revisiondetails()->updateOrCreate(
                    ['material_id' => $material['id'], 'number_version' => $revision->number_version],
                    ['amount' => $material['amount']]
                );
            }
            DB::commit();
            $this->backToExplorar();
            return $revision;
        } catch (\Exception $e) {
            DB::rollBack();
            // Respuesta en consola del error
            $this->dispatchBrowserEvent('errorResponse', ['error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Accion para ejecutar el modal y eliminar una revision
     * 
     * @param Revision $revision
     * @return array $revision
     */
    public function destroyRevision(Revision $revision)
    {
        $this->dispatchBrowserEvent('show-borrar-revision');
        $this->revision = $revision->toArray();
        return $this->revision;
    }

    /**
     * Rellena un array con la informacion de una revision
     * 
     * @param int $revisionId
     * @return array $revision|null
     */
    public function explorarRevision($revisionId)
    {
        $installation = Installation::findOrFail($this->installation['id']);

        if ($installation) {
            $this->view = "listadoDetail";
            $revision = $installation->revisions()->whereId($revisionId)->first();
            $this->files['images'][0] = $revision->image ? $revision->getUrl() : false;
            $revisionDetails = $installation->findRevisionsDetail($revision->number_version);
            $this->revisionDetails['materials'] = $this->fillMaterial($revisionDetails);
            $this->revision = $revision->toArray();
            return $this->revision;
        }
        return null;
    }

    /**
     * Accion para regresar al detalle de la instalacion seleccionada
     * @return function explorar
     */
    public function backToExplorar()
    {
        $this->resetValidation();
        $this->reset(['validation', 'revision', 'searchMaterials', 'materialsSelected']);
        return $this->explorar($this->installation['id']);
    }
}
