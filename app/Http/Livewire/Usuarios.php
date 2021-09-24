<?php

namespace App\Http\Livewire;
use App\Models\User;
use App\Models\Role;
use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class Usuarios extends Component
{
    
    public $idus, $usuarios, $idu,$password,$password1, $name, $email, $nombre_y_apellido, $telefono, $dni, $activo, $domicilio, $users, $userup,$roles,$roless, $search;
    public $funcion="", $order='id', $funcionru, $userlog;
    
    public function render()
    {
        $this->roles = Role::all();
        $this->users = User::where('name','LIKE','%' . $this->search . '%')
        ->orWhere('dni','LIKE','%'.$this->search.'%')
        ->orWhere('nombre_y_apellido','LIKE','%'.$this->search.'%')
        ->orWhere('telefono','LIKE','%'.$this->search.'%')
        ->orWhere('domicilio','LIKE','%'.$this->search.'%')
        ->orWhere('email','LIKE','%'.$this->search.'%')->orderBy($this->order)->get();

        return view('livewire.usuarios', [
            'users' => $this->users,
        ]);
    }
   
    public function store()
    {
        $this->validate([
            'name' => 'required|string|min:5',
            'email' => 'required|email',
            'nombre_y_apellido' => 'required|string|min:10',
            'domicilio' => 'required|string|min:6',
            'dni' => 'required|numeric|min:1000000|max:100000000',
            'telefono' => 'required|numeric|min:1000000000',
            'password' => 'required|min:8'
        ],[
            'name.required' => 'El campo "Nombre" es requerido',
            'name.min' => 'El campo "Nombre" debe tener como mínimo 5(cinco) caracteres',
            'email.required' => 'El campo "Email" es requerido ',
            'email.email' => 'El email no es válido',
            'nombre_y_apellido.required' => 'El campo "Nombre y Apellido" es requerido',
            'nombre_y_apellido.min' => 'El campo "Nombre y Apellido" debe tener como mínimo 10(diez) caracteres',
            'domicilio.required' => 'El campo "Domicilio" es requerido',
            'domicilio.min' => 'El campo "Domicilio" debe tener como mínimo 6(seis) caracteres',
            'dni.required' => 'El campo "D.N.I" es requerido',
            'dni.min' => 'El campo "D.N.I" está incompleto, verifique',
            'dni.max' => 'El campo "D.N.I" tiene numeros de más, verifique',
            'telefono.required' => 'El campo "Teléfono" es requerido',
            'telefono.min' => 'El campo "Teléfono" está incompleto, verifique',
            'password.required' => 'El campo "Contraseña" es requerido',
            'password.min' => 'El campo "Contraseña" debe tener como mínimo 8(ocho) caracteres',
        ]);
        if (auth()->user()->cannot('store', auth()->user()))
        {
            abort(403);
        }else{
            if($this->password==$this->password1){
                User::create([
                    'name' => $this->name,
                    'email' => $this->email,
                    'nombre_y_apellido'=>$this->nombre_y_apellido,
                    'domicilio'=>$this->domicilio,
                    'telefono'=>$this->telefono,
                    'dni'=>$this->dni,
                    'password'=>Hash::make($this->password)
                ]);
                $this->funcion="";
            }
           
        }
    }

    public function destruir(User $user)
    {
        if (auth()->user()->cannot('delete', auth()->user())) {
            abort(403);
        }else
        {
            $user->delete();
        }
    }

    public function funcion()
    {
        $this->funcion="crear";
        $this->funcionru="";
        $this->idu=null;
        $this->name=null;
        $this->nombre_y_apellido=null;
        $this->domicilio=null;
        $this->telefono=null;
        $this->email=null;
        $this->dni=null;
        $this->password=null;
        $this->password1=null;
    }
    
    public function endfunctions()
    {
        $this->funcion="";
        $this->resetValidation();
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
        $this->funcionru="";
    }

    public function editar(){
        $this->validate([
            'name' => 'required|string|min:5',
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$this->idu.''],
            'nombre_y_apellido' => 'required|string|min:10',
            'domicilio' => 'required|min:6',
            'dni' => 'required|numeric|min:1000000|max:100000000',
            'telefono' => 'required|numeric|min:1000000000',
        ],[
            'name.required' => 'El campo "Nombre" es requerido',
            'name.min' => 'El campo "Nombre" debe tener como mínimo 5(cinco) caracteres',
            'email.required' => 'El campo "Email" es requerido ',
            'email.email' => 'El email no es válido',
            'nombre_y_apellido.required' => 'El campo "Nombre y Apellido" es requerido',
            'nombre_y_apellido.min' => 'El campo "Nombre y Apellido" debe tener como mínimo 10(diez) caracteres',
            'domicilio.required' => 'El campo "Domicilio" es requerido',
            'domicilio.min' => 'El campo "Domicilio" debe tener como mínimo 6(seis) caracteres',
            'dni.required' => 'El campo "D.N.I" es requerido',
            'dni.min' => 'El campo "D.N.I" está incompleto, verifique',
            'dni.max' => 'El campo "D.N.I" tiene numeros de más, verifique',
            'telefono.required' => 'El campo "Teléfono" es requerido',
            'telefono.min' => 'El campo "Teléfono" está incompleto, verifique',
        ]);
        
        $userup =User::find($this->idu);
        $userup->nombre_y_apellido=$this->nombre_y_apellido;
        $userup->dni=$this->dni;
        $userup->domicilio=$this->domicilio;
        $userup->telefono=$this->telefono;
        $userup->email=$this->email;
        $userup->save();
        $this->funcion="";
        $this->resetValidation();
    }

    public function volver(){
        $this->funcion="";
        $this->funcionru="";
        $this->resetValidation();
    }

    public function rolusuario(User $user)
    {   
        $this->idus=$user->id;
        $this->name=$user->name;
        $this->nombre_y_apellido=$user->nombre_y_apellido;
        $this->domicilio=$user->domicilio;
        $this->telefono=$user->telefono;
        $this->email=$user->email;
        $this->dni=$user->dni;
        $this->funcionru="asigna";
        $this->funcion="0";   
    }

    public function asignarols(Role $rol)
    {      
        $this->roless= User::find($this->idus)->roles()->where('role_id',$rol->id)->get();
        if(sizeof($this->roless)==0)
        {
            $rol->users()->attach($this->idus);
        }            
    }

    public function quitarol(Role $rol)
    {   
        $rol->users()->detach($this->idus);                      
    }
}
