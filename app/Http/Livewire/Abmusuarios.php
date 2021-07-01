<?php

namespace App\Http\Livewire;
use App\Models\User;

use Livewire\Component;

class Abmusuarios extends Component
{
    public $search = '';
    public function render()
    {
        $users = User::all();
        return view('livewire.abmusuarios', 
            ['users' => $users]
        );
    }


    public function edit($id){
		      $userupd=User::findOrFail($id);
		      $this->editid=$id;
		      $this->name=$userupd->name;
		      $this->nombre_y_apellido=$userupd->nombre_y_apellido;
		      $this->telefono=$userupd->telefono;
		      $this->dni=$userupd->dni;
		      $this->domicilio=$userupd->domicilio;
		      $this->email=$userupd->email;
		      
		      $this->updatemode=true;
    }

    public function store(){
        
            User::create([
                'name' => $this->name,
                'email' => $this->email,
                'nombre_y_apellido'=>$this->nombre_y_apellido,
                'domicilio'=>$this->domicilio,
                'telefono'=>$this->telefono,
                'dni'=>$this->dni,
        ]);

        }
}

/*

User::where('name','LIKE','%' . $this->search . '%')
            ->orWhere('dni','LIKE','%'.$this->search.'%')
            ->orWhere('nombre_y_apellido','LIKE','%'.$this->search.'%')
            ->orWhere('telefono','LIKE','%'.$this->search.'%')
            ->orWhere('domicilio','LIKE','%'.$this->search.'%')
            ->orWhere('email','LIKE','%'.$this->search.'%')
            ->get(),
*/
