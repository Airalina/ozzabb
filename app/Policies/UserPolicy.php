<?php

namespace App\Policies;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function store(User $user)
    {
        $roles=User::find($user->id)->rols()->where('rol_id',$user->id)->get();
        
        foreach($roles as $rol)
        {
            $permisos=$rol->permissions()->where('rol_id',$rol->id)->get();
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
        $roles=User::find($user->id)->rols()->where('rol_id',$user->id)->get();
        
        foreach($roles as $rol)
        {
            $permisos=$rol->permissions()->where('rol_id',$rol->id)->get();
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
        $roles=User::find($user->id)->rols()->where('rol_id',$user->id)->get();
        
        foreach($roles as $rol)
        {
            $permisos=$rol->permissions()->where('rol_id',$rol->id)->get();
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
        $roles=User::find($user->id)->rols()->where('rol_id',$user->id)->get();
        
        foreach($roles as $rol)
        {
            $permisos=$rol->permissions()->where('rol_id',$rol->id)->get();
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

}
