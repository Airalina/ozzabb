<?php

namespace App\Http\Livewire;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Livewire\Component;

class Roles extends Component
{
    public $search, $rol, $idrol,$funcion="", $nombre, $permisos, $funcionpr;
    public function render()
    {
        $this->permisos=Permission::where('role_id',$this->idrol)->get();
        $this->roles = Role::where('nombre','LIKE','%' . $this->search . '%')
        ->get();

        return view('livewire.roles', [
            'roles' => $this->roles,
        ]);
    }

    public function store()
    {
        $this->validate([
            'nombre'=>'required|string|min:3',
        ],[
            'nombre.required' => 'El campo "Nombre" es requerido',
            'nombre.min' => 'El campo "Nombre" tiene como mínimo 3(tres) caracteres'
        ]);
        Role::create([
            'nombre' => $this->nombre,
            'activo' => 1,
        ]);
        $rol=Role::where('nombre', $this->nombre)->get();
        foreach($rol as $ro){
            Permission::Create([
                'name' => "Administracion de Usuarios",
                'see' => 0,
                'create' => 0,
                'update' => 0,
                'delete' => 0,
                'role_id' => $ro->id,     
            ]);
            Permission::Create([
                'name' => "Administracion de Roles",
                'see' => 0,
                'create' => 0,
                'update' => 0,
                'delete' => 0,
                'role_id' => $ro->id,  
            ]);
            Permission::Create([
                'name' => "Administracion de Clientes",
                'see' => 0,
                'create' => 0,
                'update' => 0,
                'delete' => 0,
                'role_id' => $ro->id,   
            ]);
            Permission::Create([
                'name' => "Administracion de Pedidos De Clientes",
                'see' => 0,
                'create' => 0,
                'update' => 0,
                'delete' => 0,
                'role_id' => $ro->id,
            ]);
        }
        
        $this->funcion="";
        $this->resetValidation();
    }

    public function volver(){
        $this->funcion="";
        $this->funcionpr="";
        $this->resetValidation();
    }

    public function destruir(Role $rol)
    {
          $this->rol=$rol;
          $this->dispatchBrowserEvent('show-borrar');
    }
    public function delete()
    {
        if($this->rol->nombre!="Gerente" && $this->rol->nombre!="Administrador"){
            $this->rol->delete();
        }   
        $this->dispatchBrowserEvent('hide-borrar');
    }

    public function funcion()
    {
        $this->idrol=null;
        $this->nombre=null;
        $this->funcion="crear";
        $this->funcionpr="";
    }

    public function update(Role $rol){   
        $this->idrol=$rol->id;
        $this->nombre=$rol->nombre;
        $this->funcion="adaptar";
        $this->funcionpr="";
    }

    public function editar()
    {
        $this->validate();
        $rolup =Role::find($this->idrol);
        $rolup->nombre=$this->nombre;
        $rolup->save();
        $this->funcion="";
    }


    public function verpermisos(Role $rol)
    {
        $this->idrol=$rol->id;
        $this->permisos=Permission::where('role_id', $rol->id)->get();
        $this->nombre=$rol->nombre;
        $this->funcionpr="asigna";
        $this->funcion="0";
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
        $this->resetValidation();
    }
}
