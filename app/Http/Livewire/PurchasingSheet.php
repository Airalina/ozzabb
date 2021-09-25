<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Clientorder;
use App\Models\Orderdetail;
use App\Models\Installation;
use App\Models\Revisiondetail;
use App\Models\Material;
use App\Models\DepositMaterial;
use App\Models\PucharsingSheet;
use App\Models\PucharsingSheetDetail;
use App\Models\PucharsingSheetOrder;

class PurchasingSheet extends Component
{
 
    public $x, $mat = [], $orders, $ottPlatform = '', $search, $clientOrders = [], $clientorders = [], $order = [], $order_detail = [], $installations, $installation_code = [[]], $revision_detail, $total_amount = [], $buys = [], $deposit_material = [], $total_material = [], $div = false, $select = false, $presentation = [], $present = [], $suma = [];
    protected $listeners = ['clientOrdersSelected'];
    private $select_presentation = [];

    public function render()
    {    
        $this->orders = Clientorder::where('id','LIKE','%'.$this->search.'%')
        ->orWhere('customer_name','LIKE','%'.$this->search.'%')
        ->get();

        return view('livewire.purchasing-sheet');
    }
    public function clientOrdersSelected($clientOrdersValues){ 
        $this->clientOrders = $clientOrdersValues;
    }

    public function order_change(){
        $this->div=true;
        $this->select=true;
        foreach ($this->clientOrders as $key => $order) {
            $this->clientorders[$key] = Clientorder::find((int)$order);
            $this->order_detail[$key] = Orderdetail::where('clientorder_id', $this->clientorders[$key]->id)->get();      
            $this->total_amount[$key] = $this->order_detail[$key]->sum('cantidad');
            $this->buys[$key] = PucharsingSheetOrder::where('clientorder_id', $this->clientorders[$key]->id)->first();
            
            foreach($this->order_detail[$key] as $indice => $detail){ 
                    $this->installations[$key][$indice] = Installation::where('code',$detail->material_id)->first(); 
                    foreach ($this->installations as $ind => $installation) {
                        foreach ($installation as $llave => $revision) {
                            if(isset($revision->id)){
                                 $this->revision_detail[$ind] = Revisiondetail::where('installation_id', $revision->id)->get();
                              #   dd($this->revision_detail);
                                 foreach($this->revision_detail[$ind] as $j => $lol){
                                     $this->deposit_material[$j]=DepositMaterial::where('material_id', $lol->material_id)->groupBy('material_id', 'presentation')->selectRaw('material_id, presentation, sum(amount) as sum')->get();
                                 #dd($this->deposit_material[$key][$j]);
                                  #  $this->mat[$j] = $this->x->get();
                                    
                                        # $this->deposit_material[$key][$j] = DepositMaterial::where('material_id', $lol->material_id)->groupBy('presentation')->selectRaw('material_id, presentation, sum(amount) as sum')->get();
                                 #  $this-> = DepositMaterial::where('material_id', $lol->material_id)->groupBy('presentation');
                                  
                                }
                             
                                }
                        }
                    }
            }
           
          
        }
        
        if(!empty($this->presentation)){
            $this->select_presentation = json_decode($this->presentation);
            $this->material_id = $this->select_presentation->material_id; 
            $this->suma[$this->material_id] = $this->select_presentation->sum;
         #   $this->presentation =  $this->select_presentation->presentation;
            $this->present[$this->material_id] =$this->select_presentation->presentation;
       #     dd($this->presentation); 
           
    }
        }
       # dd($this->mat);
      #   dd($this->deposit_material);       
   }
   
  
