<?php

namespace App\Http\Livewire;
use App\Models\Rol;
use Livewire\Component;

class Roles extends Component
{
    public $search, $rol, $idrol,$funcion, $nombre;
    public function render()
    {
        $this->roles = Rol::where('nombre','LIKE','%' . $this->search . '%')
        ->get();

        return view('livewire.roles', [
            'roles' => $this->roles,
        ]);
    }

    public function store()
    {
        Rol::create([
            'nombre' => $this->nombre,
        ]);
    }

    public function destruir(Rol $rol)
    {
        $rol->delete();
    }

    public function funcion()
    {
        $this->funcion="crear";
    }

    public function update(Rol $rol)
    { 
        $this->idrol=$rol->id;
        $this->nombre=$rol->nombre;
        $this->funcion="adaptar";
    }

    public function editar()
    {
        $rolup =rol::find($this->idrol);
        $rolup->nombre=$this->nombre;
        $rolup->save();
    }
}
