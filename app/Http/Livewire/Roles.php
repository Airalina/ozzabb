<?php

namespace App\Http\Livewire;
use App\Models\User;
use App\Models\Rol;
use App\Models\Permission;
use Livewire\Component;

class Roles extends Component
{
    public $search, $rol, $idrol,$funcion="", $nombre, $permisos, $funcionpr;
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
        $this->funcion="";
    }

    public function destruir(Rol $rol)
    {
        $rol->delete();
    }

    public function funcion()
    {
        $this->idrol=null;
        $this->nombre=null;
        $this->funcion="crear";
        $this->funcionpr="";
    }

    public function update(Rol $rol)
    {   
        $this->idrol=$rol->id;
        $this->nombre=$rol->nombre;
        $this->funcion="adaptar";
        $this->funcionpr="";
    }

    public function editar()
    {
        $rolup =Rol::find($this->idrol);
        $rolup->nombre=$this->nombre;
        $rolup->save();
        $this->funcion="";
    }


    public function verpermisos(Rol $rol)
    {
        $this->permisos=Permission::where('rol_id', $rol->id)->get();
        $this->nombre=$rol->name;
        $this->funcionpr="asigna";
        $this->funcion="";
    }

    public function permisosrolsee(Permission $permiso)
    {
        $permisoup =Permission::find($permiso->id);
        $permisoup->see=1;
        $permisoup->save();
    }

    public function quitarpermisosee(Permission $permiso)
    {
        $permisoup =Permission::find($permiso->id);
        $permisoup->see=0;
        $permisoup->save();
    }
    
    public function permisosrolcreate(Permission $permiso)
    {
        $permisoup =Permission::find($permiso->id);
        $permisoup->create=1;
        $permisoup->save();
    }

    public function quitarpermisocreate(Permission $permiso)
    {
        $permisoup =Permission::find($permiso->id);
        $permisoup->create=0;
        $permisoup->save();
    }
    
    public function permisosrolupdate(Permission $permiso)
    {
        $permisoup =Permission::find($permiso->id);
        $permisoup->update=1;
        $permisoup->save();
    }

    public function quitarpermisoupdate(Permission $permiso)
    {
        $permisoup =Permission::find($permiso->id);
        $permisoup->update=0;
        $permisoup->save();
    }
    
    public function permisosroldelete(Permission $permiso)
    {
        $permisoup =Permission::find($permiso->id);
        $permisoup->delete=1;
        $permisoup->save();
    }

    public function quitarpermisodelete(Permission $permiso)
    {
        $permisoup =Permission::find($permiso->id);
        $permisoup->delete=0;
        $permisoup->save();
    }

    public function endfunctions()
    {
        $this->funcion="";
    }
}
