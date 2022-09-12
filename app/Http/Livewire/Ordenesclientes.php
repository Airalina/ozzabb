<?php

namespace App\Http\Livewire;

use App\Http\Traits\OrderTrait;
use App\Models\Installation;
use App\Models\Clientorder;
use App\Models\Customer;
use App\Models\Dollar;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use PDF;

class Ordenesclientes extends Component
{
    use WithPagination, OrderTrait;
    protected $paginationTheme = 'bootstrap';
    protected $orders;
    //Variables no definidas
    public  $order, $customer, $installationSelected, $domicileDelivery, $validation, $ar_price, $dolar, $installations, $customers;
    //Variables definidas 
    public $view = "", $searchInstallations = '', $searchCustomer = '', $searchOrder = '', $dateSearch = '', $stateSearch = '',
        $searchRevisions = '', $component = '', $showSelectionRevisions = false, $showPdf = true, $paginas = 25;
    //Arrays
    public $states = [], $statesPosition = [], $customerSelected = [], $customersData = [], $installationsSelected = [],
        $installation = [], $revisions = [];

    protected $listeners = [
        'newOrder',
        'newAddress',
        'backModal'
    ];

    public function newOrder(Customer $client)
    {
        $this->customer = $client;
        $this->view = "ordernew";
        $this->namecust = $client->name;
        $this->customer_id = $client->id;
        $this->selectaddress($client);
    }

    public function __construct()
    {
        //Inicializa array con estados de orden 
        $this->states = Clientorder::STATES;
        $this->statesPosition = array_flip($this->states);
        //Inicializa array para relacionar con clientes
        $this->customersData = [
            'customers' => [],
            'searchCustomers' => '',
            'customerSelected' => [],
        ];
        $this->installationsSelected['total'] = [
            'id' => 0,
            'code' => ' ',
            'usd_price' => ' ',
            'amount' => 'Total',
            'revisionSelected' => [['number_version' => ' ']],
            'subtotal' => 0
        ];
    }

    public function render()
    {
        //Precio del dolar al dia
        $this->dolar = Dollar::findOrfail(1);
        $this->ar_price = !empty($this->dolar) ? $this->dolar->arp_price : 0;

        $this->customersData['customers'] = Customer::searchList($this->customersData['searchCustomers'])->get();
        $this->installations = !empty($this->customer) ?  $this->customer->searchInstallations($this->searchInstallations)->get() : [];
        $this->orders = Clientorder::search($this->searchOrder, $this->dateSearch, $this->stateSearch)->paginate($this->paginas);

        $this->revisions = !empty($this->installation['id']) ?
            $this->installationSelected->searchRevisions($this->searchRevisions)->get() : [];

        return view('livewire.ordenesclientes', [
            'orders' => $this->orders,
        ]);
    }

    /**
     * Accion de resetear paginacion
     * 
     * @return function resetPage()
     */
    public function updatingSearch()
    {
        return $this->resetPage();
    }

    /**
     * Filtrar resultados segun fecha o estado
     * 
     * @return
     */
    public function updatedSearchOrder()
    {
        $this->dateSearch = $this->formatDate();
        $this->stateSearch = $this->statesPosition[$this->searchOrder] ?? $this->searchOrder;
        return;
    }

    /**
     * Formatear fecha para la busqueda en base de datos
     * 
     * @return string $date
     */
    public function formatDate()
    {
        $array = explode('/', $this->searchOrder);
        $year = (!empty($array[2])) ? $array[2] : '';
        $month =  (!empty($array[1])) ? $array[1] : '';
        $day =  (!empty($array[0])) ? $array[0] : '';
        $date = $year . '-' . $month . '-' . $day;
        return $date;
    }

    /**
     * Accion de cambiar la vista a crear en "Agregar Pedido"
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
                'addresses' => $this->customer->domiciledeliveries->toArray(),
            ];
            $this->reset('installationsSelected');
            $this->domicileDelivery = [];
            return $this->customersData['searchCustomers'] = '';
        }
        return null;
    }
    /**
     * Accion de crear un nuevo domicilio
     * 
     * @param string $type
     * @return event show-form-address
     */
    public function createAddress()
    {
        $this->resetValidation();
        return $this->dispatchBrowserEvent('show-form-address');
    }

    /**
     * Accion de seleccionar un domicilio 
     * 
     * @return event hide-form-address
     */
    public function newAddress($id)
    {
        $this->selectAddress($id);
        $this->resetValidation();
        return $this->dispatchBrowserEvent('hide-form-address');
    }

    /**
     * Accion de seleccionar un domicilio 
     * 
     * @return string $domicileDelivery|null
     */
    public function selectAddress($addressId)
    {
        $domicileDelivery = $this->customer ? $this->customer->domiciledeliveries()->whereId($addressId)->first() : false;
        if ($domicileDelivery) {
            $this->domicileDelivery = [
                'id' => $domicileDelivery->id,
                'street' => $domicileDelivery->street,
                'number' => $domicileDelivery->number,
                'location' => $domicileDelivery->location,
                'province' => $domicileDelivery->province,
                'country' => $domicileDelivery->country,
                'postcode' => $domicileDelivery->postcode,
            ];
            $this->resetValidation();
            return $this->domicileDelivery;
        }
        return null;
    }

    /**
     * Quitar direccion seleccionada
     * 
     * @return array $domicileDelivery
     */
    public function downAddress()
    {
        $this->customersData['customerSelected']['addresses'] = $this->customer->domiciledeliveries->toArray();
        return $this->domicileDelivery = [];
    }

    /**
     * Accion de seleccionar una instalacion 
     * 
     * @param int $installationId
     * @return array $installation|null
     */
    public function selectInstallation($installationId)
    {
        $this->installationSelected = Installation::findOrfail($installationId);

        if ($this->installationSelected) {
            $this->installation  = [
                'id' => $this->installationSelected->id,
                'code' => $this->installationSelected->code,
                'description' => $this->installationSelected->description,
                'usd_price' => $this->installationSelected->usd_price,
                'revisionSelected' => [$this->installationSelected->revisions->last()->toArray()],
                'subtotal' => 0
            ];
            $revisionDetails = $this->installationSelected->findRevisionsDetail($this->installation['revisionSelected'][0]['number_version']);
            $this->installation['materials'] = $this->fillMaterial($revisionDetails);
            $this->dispatchBrowserEvent('show-form-installation');
            $this->resetValidation();
            return $this->installation;
        }
        return null;
    }

    /**
     * Rellenar materiales correspondiente a las revisiones
     * 
     * @param array $details
     * @return array $materials|array []
     */
    public function fillMaterial($revisionDetails)
    {
        foreach ($revisionDetails as $detail) {
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
     * Agrega al array de instalaciones una instalacion seleccionada
     * 
     * @return function backModal()
     */
    public function addInstallation()
    {
        $validationProperties = $this->validationSelectInstallations();
        $this->validation = $this->validate($validationProperties['rules'], $validationProperties['messages']);

        $this->installation['amount'] =  $this->validation['installation']['amount'];
        $this->installation['subtotal'] = $this->installation['usd_price'] *  $this->installation['amount'];
        $this->installationsSelected[$this->installation['id']] = $this->installation;
        //Transforma el array de las instalaciones seleccionadas y calcula su subtotal
        $collection = collect(Arr::except($this->installationsSelected, ['total']));
        $this->installationsSelected['total']['subtotal'] = $collection->sum('subtotal');

        // dd($this->installation);
        $this->dispatchBrowserEvent('hide-form-installation');
        return $this->backModal();
    }

    /**
     * Elimina del array de instalaciones una instalacion seleccionada
     * 
     * @return array $installationsSelected
     */
    public function downInstallation($installationId)
    {
        $this->installationsSelected['total']['subtotal'] -= $this->installationsSelected[$installationId]['subtotal'];
        unset($this->installationsSelected[$installationId]);
        return $this->installationsSelected;
    }

    /**
     * Elimina del array de revisiones una revision seleccionada
     * 
     * @return bool $showSelectionRevisions
     */
    public function downRevision()
    {

        $this->showSelectionRevisions = true;
        $this->installation['revisionSelected'] = [];
        $this->installation['materials'] = [];
        return $this->showSelectionRevisions;
    }

    /**
     * Seleccionar revision para la instalacion
     * 
     * @param int $revisionId
     * @return bool $showSelectionRevisions|null
     */
    public function selectRevision($revisionId)
    {
        if ($this->installationSelected) {
            $this->showSelectionRevisions = false;
            $this->installation['revisionSelected'] = $this->installationSelected->revisions()->whereId($revisionId)->get()->toArray();
            $revisionDetails =  $this->installationSelected->findRevisionsDetail($this->installation['revisionSelected'][0]['number_version']);
            $this->installation['materials'] = $this->fillMaterial($revisionDetails);
            $this->reset('searchRevisions');
            return $this->showSelectionRevisions;
        }
        return null;
    }

    /**
     * Accion para cerrar el modal 
     * 
     * @return function reset
     */
    public function backModal()
    {
        $this->resetValidation();
        $this->dispatchBrowserEvent('hide-form-address');
        return $this->reset(['installation', 'searchInstallations']);
    }

    /**
     * Registro de un pedido
     * 
     * @return Clientorder $clientorder|null
     */
    public function store()
    {
        //validacion para pedidos
        $validationProperties = $this->validationOrders();
        $this->validation = $this->validate($validationProperties['rules'], $validationProperties['messages']);

        try {
            DB::beginTransaction();
            //creando el pedido
            $order = [
                'customer_name' => $this->validation['customer']['name'],
                'deliverydomicile_id' => $this->validation['domicileDelivery']['id'],
                'date' =>  Carbon::now(),
                'deadline' => $this->validation['order']['deadline'],
                'buys' => 1,
                'order_state' => 1,
                'usd_price' => $this->validation['installationsSelected']['total']['subtotal'],
                'arp_price' => $this->validation['installationsSelected']['total']['subtotal'] * $this->ar_price,
            ];

            $clientOrder = $this->customer->clientorders()->firstOrCreate($order);

            foreach ($this->installationsSelected as $key => $installation) {
                $installations[$key] = [
                    'cantidad' => $installation['amount'],
                    'unit_price_usd' => $installation['usd_price'],
                    'revision_id' => $installation['revisionSelected'][0]['id'] ?? '',
                ];
            }
            unset($installations['total']);
            $clientOrder->installations()->sync($installations);

            DB::commit();
            $this->resetValidation();

            $this->reset();
            return $clientOrder;
        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($clientOrder->installations)) {
                // en caso de error, borra detalle de la orden 
                foreach ($clientOrder->installations as $installation) {
                    $clientOrder->installations()->detach([$installation->id]);
                }
            }
            if (isset($clientOrder)) {
                // en caso de error, borra orden
                $clientOrder->delete();
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
     * accion de cambiar la vista a editar en "Actualizar"
     * 
     * @param int $orderId
     * @return string $view
     */
    public function edit($orderId)
    {
        $this->view = "update";
        $this->order = $this->fillOrder($orderId);
        return $this->view;
    }

    /**
     * Rellena un array con la informacion de una orden
     * 
     * @param int $materialId
     * @return array $materialArray|null
     */
    public function fillOrder($orderId)
    {
        $order = Clientorder::findOrFail($orderId);
        if ($order) {
            $deadline = Carbon::parse($order->deadline);
            $orderArray = [
                'id' => $order->id,
                'deadline' => $deadline->format('Y-m-d'),
                'deliveryDomicile' => $order->domicile_deliveries ? $order->domicile_deliveries->toArray() : [],
                'customer' => $order->customer ?  $order->customer->toArray() : [],
                'customer_name' => $order->customer_name,
                'date_year' =>  date('Y', strtotime($order->date)),
                'date' => date('d-m-Y H:i', strtotime($order->date)),
                'deadline_date' => date('d-m-Y', strtotime($order->deadline)),
            ];
            //Seleccionar el cliente
            $this->selectCustomer($order->customer_id);
            //Seleccionar la direccion
            $this->selectAddress($order->deliverydomicile_id);
            //Seleccionar las instalaciones
            $this->addInstallations($order->installations);

            return $orderArray;
        }
        return null;
    }

    /**
     * Rellena array de instalaciones seleccionadas
     * 
     * @param array $installations
     * @return array $installationsSelected
     */
    public function addInstallations($installations)
    {
        foreach ($installations as $installation) {
            $this->installation  = [
                'id' => $installation->id,
                'code' => $installation->code,
                'description' => $installation->description,
                'usd_price' => $installation->usd_price,
                'revisionSelected' => $installation->revisions()->whereId($installation->pivot->revision_id)->get()->toArray(),
                'amount' => $installation->pivot->cantidad,
                'subtotal' => $installation->pivot->cantidad * $installation->usd_price
            ];
            $revisionDetails = $installation->findRevisionsDetail($this->installation['revisionSelected'][0]['number_version']);
            $this->installation['materials'] = $this->fillMaterial($revisionDetails);
            $this->installationSelected = $installation;
            $this->installationsSelected[$this->installation['id']] = $this->installation;
            $this->installationsSelected['total']['subtotal'] += $this->installation['subtotal'];
        }

        return $this->installationsSelected;
    }

    /**
     * Actualizar un pedido
     * 
     * @param Clientorder $clientorder
     * @return Clientorder $clientorder|null
     */
    public function update(Clientorder $clientOrder)
    {
        //validacion para ordenes
        $validationProperties = $this->validationOrders();
        $this->validation = $this->validate($validationProperties['rules'], $validationProperties['messages']);

        try {
            DB::beginTransaction();

            //actualizar el pedido
            $order = [
                'customer_id' => $this->validation['customer']['id'],
                'customer_name' => $this->validation['customer']['name'],
                'deliverydomicile_id' => $this->validation['domicileDelivery']['id'],
                'deadline' => $this->validation['order']['deadline'],
                'usd_price' => $this->validation['installationsSelected']['total']['subtotal'],
                'arp_price' => $this->validation['installationsSelected']['total']['subtotal'] * $this->ar_price,
            ];
            $clientOrder->update($order);

            //actualizar la relacion entre instalaciones y pedidos
            foreach ($this->installationsSelected as $key => $installation) {
                $installations[$key] = [
                    'cantidad' => $installation['amount'],
                    'unit_price_usd' => $installation['usd_price'],
                    'revision_id' => $installation['revisionSelected'][0]['id'] ?? '',
                ];
            }
            unset($installations['total']);
            $clientOrder->installations()->sync($installations);

            DB::commit();
            $this->resetValidation();
            $this->reset();
            return $clientOrder;
        } catch (\Exception $e) {
            DB::rollBack();
            // Respuesta en consola del error
            $this->dispatchBrowserEvent('errorResponse', ['error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Genera el modal para eliminar un pedido
     * 
     * @param Clientorder $clientorder
     * @return 
     */
    public function destroy(Clientorder $clientorder)
    {
        $this->order = $clientorder->toArray();
        return $this->dispatchBrowserEvent('show-borrar');
    }

    /**
     * Accion de eliminar logicamente un pedido
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
                $clientOrder = Clientorder::findOrFail($this->order['id']);
                $clientOrder->orderdetails->each(function ($orderDetail, $key) {
                    //Elimina logicamente el detalle del pedido
                    $orderDetail->delete();
                    return null;
                });
                //Elimina logicamente el pedido
                $clientOrder->delete();
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
     * Detalle de un pedido
     * 
     * @param int $orderId
     * @return string $view
     */
    public function explorar($orderId)
    {
        $this->view = "explorar";
        $this->order = $this->fillOrder($orderId);

        return $this->view;
    }

    /**
     * Generador de PDF
     * 
     * @return \Illuminate\Http\Response
     */
    public function createPDF()
    {
        if ($this->order) {
            $order = $this->order;
            $installationsSelected = $this->installationsSelected;
            $ar_price = $this->ar_price;
            $showPdf = false;
            $pdf = PDF::loadView('pedidos.listadodetail', compact('order', 'installationsSelected', 'ar_price', 'showPdf'));
            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->stream();
            }, 'pedido-' . $this->order['date'] . '.pdf');
        }
    }
}
