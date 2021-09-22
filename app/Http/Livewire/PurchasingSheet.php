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
 
    public $orders, $ottPlatform = '', $search, $order, $order_detail, $installations, $installation_code = [], $revision_detail, $total_amount, $buys, $div = false, $select = false;
    
    public function render()
    {    
        $this->orders = Clientorder::where('id','LIKE','%'.$this->search.'%')
        ->orWhere('customer_name','LIKE','%'.$this->search.'%')
        ->get();

        return view('livewire.purchasing-sheet');
    }
    public function order_change(){
        $this->div=true;
        $this->select=true;
        $this->order = Clientorder::find($this->search);
        $this->order_detail = Orderdetail::where('clientorder_id', $this->search)->get();      
        $this->total_amount = $this->order_detail->sum('cantidad');

        foreach($this->order_detail as $key => $detail){
            $this->installation_code[$key] = $detail->material_id;
        }
        foreach($this->installation_code as $key => $code){
            $this->installations[$key] = Installation::where('code', $code)->first();
        }
        
        foreach ($this->installations as $key => $installation) {
                $this->revision_detail[$key] = Revisiondetail::where('installation_id', $installation->id)->get();
    }

       # dd($this->revision_detail);
        $this->buys = PucharsingSheetOrder::where('clientorder_id', $this->search)->get();
   }

   public function backspace(){
    $this->div=false;
    $this->select=false;
   }
}
