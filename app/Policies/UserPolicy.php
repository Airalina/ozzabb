<?php

namespace App\Policies;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function store(User $user)
    {
        $roles=User::find($user->id)->roles()->where('user_id',$user->id)->get();
        
        foreach($roles as $rol)
        {
            $permisos=$rol->permissions()->where('role_id',$rol->id)->where('name','Administración de Usuarios')->get();
            foreach($permisos as $permiso)
            {
                if($permiso->create==1)
                {
                    return true;
                } 
            }
        }
        return false;
    }

    public function update(User $user)
    {
        $roles=User::find($user->id)->roles()->where('user_id',$user->id)->get();
        
        foreach($roles as $rol)
        {
            $permisos=$rol->permissions()->where('role_id',$rol->id)->where('name','Administración de Usuarios')->get();
            foreach($permisos as $permiso)
            {
                if($permiso->update==1)
                {
                    return true;
                } 
            }
        }
        return false;
    }

    public function delete(User $user)
    {
        $roles=User::find($user->id)->roles()->where('user_id',$user->id)->get();
        
        foreach($roles as $rol)
        {
            $permisos=$rol->permissions()->where('role_id',$rol->id)->where('name','Administración de Usuarios')->get();
            foreach($permisos as $permiso)
            {
                if($permiso->delete==1)
                {
                    return true;
                } 
            }
        }
        return false;
    }

    public function see(User $user)
    {
        $roles=User::find($user->id)->roles()->where('user_id',$user->id)->get();
        
        foreach($roles as $rol)
        {
            $permisos=$rol->permissions()->where('role_id',$rol->id)->where('name','Administración de Usuarios')->get();
            foreach($permisos as $permiso)
            {
                if($permiso->see==1)
                {
                    return true;
                } 
            }
        }
        return false;
    }

    public function seerol(User $user)
    {
        $roles=User::find($user->id)->roles()->where('user_id',$user->id)->get();
        
        foreach($roles as $rol)
        {
            $permisos=$rol->permissions()->where('role_id',$rol->id)->where('name','Administración de Roles')->get();
            foreach($permisos as $permiso)
            {
                if($permiso->see==1)
                {
                    return true;
                } 
            }
        }
        return false;
    }

    public function storerol(User $user)
    {
        $roles=User::find($user->id)->roles()->where('user_id',$user->id)->get();
        
        foreach($roles as $rol)
        {
            $permisos=$rol->permissions()->where('role_id',$rol->id)->where('name','Administración de Roles')->get();
            foreach($permisos as $permiso)
            {
                if($permiso->create==1)
                {
                    return true;
                } 
            }
        }
        return false;
    }

    public function updaterol(User $user)
    {
        $roles=User::find($user->id)->roles()->where('user_id',$user->id)->get();
        
        foreach($roles as $rol)
        {
            $permisos=$rol->permissions()->where('role_id',$rol->id)->where('name','Administración de Roles')->get();
            foreach($permisos as $permiso)
            {
                if($permiso->update==1)
                {
                    return true;
                } 
            }
        }
        return false;
    }

    public function deleterol(User $user)
    {
        $roles=User::find($user->id)->roles()->where('user_id',$user->id)->get();
        
        foreach($roles as $rol)
        {
            $permisos=$rol->permissions()->where('role_id',$rol->id)->where('name','Administración de Roles')->get();
            foreach($permisos as $permiso)
            {
                if($permiso->delete==1)
                {
                    return true;
                } 
            }
        }
        return false;
    }

    public function seecust(User $user)
    {
        $roles=User::find($user->id)->roles()->where('user_id',$user->id)->get();
        
        foreach($roles as $rol)
        {
            $permisos=$rol->permissions()->where('role_id',$rol->id)->where('name','Administración de Clientes')->get();
            foreach($permisos as $permiso)
            {
                if($permiso->see==1)
                {
                    return true;
                } 
            }
        }
        return false;
    }

    public function storecust(User $user)
    {
        $roles=User::find($user->id)->roles()->where('user_id',$user->id)->get();
        
        foreach($roles as $rol)
        {
            $permisos=$rol->permissions()->where('role_id',$rol->id)->where('name','Administración de Clientes')->get();
            foreach($permisos as $permiso)
            {
                if($permiso->create==1)
                {
                    return true;
                } 
            }
        }
        return false;
    }

    public function updatecust(User $user)
    {
        $roles=User::find($user->id)->roles()->where('user_id',$user->id)->get();
        
        foreach($roles as $rol)
        {
            $permisos=$rol->permissions()->where('role_id',$rol->id)->where('name','Administración de Clientes')->get();
            foreach($permisos as $permiso)
            {
                if($permiso->update==1)
                {
                    return true;
                } 
            }
        }
        return false;
    }

    public function deletecust(User $user)
    {
        $roles=User::find($user->id)->roles()->where('user_id',$user->id)->get();
        
        foreach($roles as $rol)
        {
            $permisos=$rol->permissions()->where('role_id',$rol->id)->where('name','Administración de Clientes')->get();
            foreach($permisos as $permiso)
            {
                if($permiso->delete==1)
                {
                    return true;
                } 
            }
        }
        return false;
    }

    public function seepedidos(User $user)
    {
        $roles=User::find($user->id)->roles()->where('user_id',$user->id)->get();
        
        foreach($roles as $rol)
        {
            $permisos=$rol->permissions()->where('role_id',$rol->id)->where('name','Administración de Pedidos De Clientes')->get();
            foreach($permisos as $permiso)
            {
                if($permiso->see==1)
                {
                    return true;
                } 
            }
        }
        return false;
    }

    public function storepedidos(User $user)
    {
        $roles=User::find($user->id)->roles()->where('user_id',$user->id)->get();
        
        foreach($roles as $rol)
        {
            $permisos=$rol->permissions()->where('role_id',$rol->id)->where('name','Administración de Pedidos De Clientes')->get();
            foreach($permisos as $permiso)
            {
                if($permiso->create==1)
                {
                    return true;
                } 
            }
        }
        return false;
    }

    public function updatepedidos(User $user)
    {
        $roles=User::find($user->id)->roles()->where('user_id',$user->id)->get();
        
        foreach($roles as $rol)
        {
            $permisos=$rol->permissions()->where('role_id',$rol->id)->where('name','Administración de Pedidos De Clientes')->get();
            foreach($permisos as $permiso)
            {
                if($permiso->update==1)
                {
                    return true;
                } 
            }
        }
        return false;
    }

    public function deletepedidos(User $user)
    {
        $roles=User::find($user->id)->roles()->where('user_id',$user->id)->get();
        
        foreach($roles as $rol)
        {
            $permisos=$rol->permissions()->where('role_id',$rol->id)->where('name','Administración de Pedidos De Clientes')->get();
            foreach($permisos as $permiso)
            {
                if($permiso->delete==1)
                {
                    return true;
                } 
            }
        }
        return false;
    }

    public function seeinstall(User $user)
    {
        $roles=User::find($user->id)->roles()->where('user_id',$user->id)->get();
        
        foreach($roles as $rol)
        {
            $permisos=$rol->permissions()->where('role_id',$rol->id)->where('name','Administración de Instalaciones')->get();
            foreach($permisos as $permiso)
            {
                if($permiso->see==1)
                {
                    return true;
                } 
            }
        }
        return false;
    }

    public function storeinstall(User $user)
    {
        $roles=User::find($user->id)->roles()->where('user_id',$user->id)->get();
        
        foreach($roles as $rol)
        {
            $permisos=$rol->permissions()->where('role_id',$rol->id)->where('name','Administración de Instalaciones')->get();
            foreach($permisos as $permiso)
            {
                if($permiso->create==1)
                {
                    return true;
                } 
            }
        }
        return false;
    }

    public function updateinstall(User $user)
    {
        $roles=User::find($user->id)->roles()->where('user_id',$user->id)->get();
        
        foreach($roles as $rol)
        {
            $permisos=$rol->permissions()->where('role_id',$rol->id)->where('name','Administración de Instalaciones')->get();
            foreach($permisos as $permiso)
            {
                if($permiso->update==1)
                {
                    return true;
                } 
            }
        }
        return false;
    }

    public function deleteinstall(User $user)
    {
        $roles=User::find($user->id)->roles()->where('user_id',$user->id)->get();
        
        foreach($roles as $rol)
        {
            $permisos=$rol->permissions()->where('role_id',$rol->id)->where('name','Administración de Instalaciones')->get();
            foreach($permisos as $permiso)
            {
                if($permiso->delete==1)
                {
                    return true;
                } 
            }
        }
        return false;
    }
    public function seedepo(User $user)
    {
        $roles=User::find($user->id)->roles()->where('user_id',$user->id)->get();
        
        foreach($roles as $rol)
        {
            $permisos=$rol->permissions()->where('role_id',$rol->id)->where('name','Administración de Depósitos')->get();
            foreach($permisos as $permiso)
            {
                if($permiso->see==1)
                {
                    return true;
                } 
            }
        }
        return false;
    }

    public function storedepo(User $user)
    {
        $roles=User::find($user->id)->roles()->where('user_id',$user->id)->get();
        
        foreach($roles as $rol)
        {
            $permisos=$rol->permissions()->where('role_id',$rol->id)->where('name','Administración de Depósitos')->get();
            foreach($permisos as $permiso)
            {
                if($permiso->create==1)
                {
                    return true;
                } 
            }
        }
        return false;
    }

    public function updatedepo(User $user)
    {
        $roles=User::find($user->id)->roles()->where('user_id',$user->id)->get();
        
        foreach($roles as $rol)
        {
            $permisos=$rol->permissions()->where('role_id',$rol->id)->where('name','Administración de Depósitos')->get();
            foreach($permisos as $permiso)
            {
                if($permiso->update==1)
                {
                    return true;
                } 
            }
        }
        return false;
    }

    public function deletedepo(User $user)
    {
        $roles=User::find($user->id)->roles()->where('user_id',$user->id)->get();
        
        foreach($roles as $rol)
        {
            $permisos=$rol->permissions()->where('role_id',$rol->id)->where('name','Administración de Depósitos')->get();
            foreach($permisos as $permiso)
            {
                if($permiso->delete==1)
                {
                    return true;
                } 
            }
        }
        return false;
    }
}
