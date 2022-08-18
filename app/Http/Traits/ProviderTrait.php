<?php

namespace App\Http\Traits;

use App\Models\Provider;

trait ProviderTrait
{
    /**
     * Validaciones para crear proveedor 
     * @return array $validation
     */
    public function validationProviders()
    {
        $rules = [
            'provider.name' => 'required',
            'provider.address' => 'required',
            'provider.email' => 'required|unique:providers,email|email',
        ];

        $messages = [
            'provider.name.required' => 'El campo nombre es requerido',
            'provider.address.required' => 'El campo domicilio es requerido',
            'provider.email.required' => 'El campo correo electrónico para ventas es requerido',
            'provider.email.unique' => 'El correo electrónico para ventas ya se encuentra registrado',
            'provider.email.email' => 'El campo correo electrónico para ventas debe ser un email',
        ];

        $validation = $this->validate($rules, $messages);
        $validation['status'] = 1;

        return $validation;
    }

    /**
     * Registro de un proveedor
     * @return Provider $provider
     */
    public function storeProviders()
    {

        $validation = $this->validationProviders();
        $provider = Provider::create($validation['provider']);

        return $provider;
    }
}
