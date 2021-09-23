<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Clientorder;
use App\Models\Orderdetail;
use App\Models\Installation;
use App\Models\Revisiondetail;
use App\Models\PucharsingSheet;
use App\Models\PucharsingSheetDetail;
use App\Models\PucharsingSheetOrder;

class PurchasingSheet extends Component
{
 
    public $orders, $ottPlatform = '', $search, $clientOrders = [], $clientorders = [], $order = [], $order_detail = [], $installations, $installation_code = [[]], $revision_detail, $total_amount = [], $buys = [], $div = false, $select = false;
    protected $listeners = ['clientOrdersSelected'];

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
                            }
                        }
                    }
            }
      
          
        }
        
        
   }

}
