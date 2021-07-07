<?php

namespace App\Http\Livewire;
use App\Models\User;
use App\Models\Rol;
use Livewire\Component;

class Usuarios extends Component
{
    public  $idu, $name, $email, $nombre_y_apellido, $telefono, $dni, $activo, $domicilio, $users, $userup,$roles, $search;
    public $funcion, $funcionru;
    public function render()
    {
        $this->roles = Rol::where('nombre','LIKE','%' . $this->search . '%')
        ->get();
        $this->users = User::where('name','LIKE','%' . $this->search . '%')
        ->orWhere('dni','LIKE','%'.$this->search.'%')
        ->orWhere('nombre_y_apellido','LIKE','%'.$this->search.'%')
        ->orWhere('telefono','LIKE','%'.$this->search.'%')
        ->orWhere('domicilio','LIKE','%'.$this->search.'%')
        ->orWhere('email','LIKE','%'.$this->search.'%')->get();

        return view('livewire.usuarios', [
            'users' => $this->users,
        ]);
    }
   
    public function store()
    {
        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'nombre_y_apellido'=>$this->nombre_y_apellido,
            'domicilio'=>$this->domicilio,
            'telefono'=>$this->telefono,
            'dni'=>$this->dni,
        ]);
    }

    public function destruir(User $user)
    {
        $user->delete();
    }

    public function funcion()
    {
        $this->funcion="crear";
    }

    public function update(User $user)
    { 
        $this->idu=$user->id;
        $this->name=$user->name;
        $this->nombre_y_apellido=$user->nombre_y_apellido;
        $this->domicilio=$user->domicilio;
        $this->telefono=$user->telefono;
        $this->email=$user->email;
        $this->dni=$user->dni;
        $this->funcion="adaptar";
    }

    public function editar()
    {
        $userup =User::find($this->idu);
        
        $userup->nombre_y_apellido=$this->nombre_y_apellido;
        $userup->dni=$this->dni;
        $userup->domicilio=$this->domicilio;
        $userup->telefono=$this->telefono;
        $userup->email=$this->email;
        $userup->save();
    }

    public function rolusuario(User $user)
    {
        $this->nombre_y_apellido=$user->nombre_y_apellido;
        $this->funcionru="asigna";
    }


}
