<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Dollar;

class Dolar extends Component
{
    public $ars_price,$dolar, $new_price, $new_ars_price;
    public function render()
    {
        $this->dolar=Dollar::where('id',1)->first();
        $this->ars_price=$this->dolar->arp_price;
        return view('livewire.dolar');
    }
    public function modifica()
    {   
        $this->new_ars_price=$this->ars_price;
        $this->dispatchBrowserEvent('show-form');
    }
    public function update()
    {
        $this->validate([
            'new_ars_price'=>'required|numeric|min:0|max:100000'
        ],[
            'new_ars_price.required'=>'La cotización en pesos argentinos, es requerida.',
            'new_ars_price.numeric'=>'La cotización en pesos argentinos, debe ser numérica.',
            'new_ars_price.min'=>'La cotización en pesos argentinos, debe ser un número real positivo.',
            'new_ars_price.max'=>'El valor de la cotización en pesos argentinos, esta por encima del máximo.',
        ]);
        $this->new_price=Dollar::find(1);
        $this->new_price->arp_price=$this->new_ars_price;
        $this->new_price->save();
        $this->resetValidation();
        $this->dispatchBrowserEvent('hide-form');
    }
    public function cancel(){
        $this->dispatchBrowserEvent('hide-form');
        $this->resetValidation();
    }
}
