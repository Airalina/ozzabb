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
        $regex = '/^((?:www\.)(?:[-a-z0-9]+\.)*[-a-z0-9]+.*)$/';
        $providerId = isset($this->provider['id']) ? $this->provider['id'] : '';

        $rules = [
            'provider.name' => 'required',
            'provider.address' => 'required',
            'provider.email' => 'required|email|unique:providers,email,'. $providerId,
            'provider.phone' => 'numeric|nullable',
            'provider.contact_name' => 'string|nullable',
            'provider.point_contact' => 'string|nullable',
            'provider.site_url' => 'nullable|regex: ' . $regex,
            'provider.cuit' => 'nullable',
            'provider.status' => 'boolean',
        ];

        $messages = [
            'provider.name.required' => 'El campo nombre es requerido',
            'provider.address.required' => 'El campo domicilio es requerido',
            'provider.email.required' => 'El campo correo electrónico para ventas es requerido',
            'provider.email.unique' => 'El correo electrónico para ventas ya se encuentra registrado',
            'provider.email.email' => 'El campo correo electrónico para ventas debe ser un email',
            'provider.phone.numeric' => 'El campo teléfono debe ser numérico',
            'provider.contact_name' => 'El campo nombre de contacto no debe tener números ni carácteres',
            'provider.site_url.regex' => 'El formato correcto para la url es: www.tupagina.com',
        ];

        $validation = $this->validate($rules, $messages);

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
