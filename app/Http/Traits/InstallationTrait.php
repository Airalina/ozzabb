<?php

namespace App\Http\Traits;

trait InstallationTrait
{
    /**
     * Validaciones para crear instalaciones
     * @return array $validation
     */
    public function validationInstallations()
    {
        $installationId = $this->installation['id'] ?? '';

        $validation['rules'] = [
            'installation.code' => 'required|integer|min:1|max:100000000|unique:installations,code,' . $installationId,
            'installation.description' => 'required|string|min:5|max:300',
            'installation.date_admission' => 'required|date',
            'installation.usd_price' => 'required|numeric|min:0|max:1000000',
            'materialsSelected' => 'required_if:view,create|array',
            'materialsSelected.*.id' => 'required_if:view,create|exists:materials,id',
            'materialsSelected.*.id' => 'required_if:view,create|exists:materials,id',
            'customer' => 'required',
        ];
        
        $validation['messages'] =  [
            'installation.date_admission.required' => 'El campo Fecha es requerido',
            'installation.code.required' => 'El campo Código es requerido',
            'installation.code.unique' => 'El campo código que inteta ingresar se encuentra en uso, debe ser único',
            'installation.code.integer' => 'El campo Código debe ser un número entero',
            'installation.code.min' => 'El campo Código debe ser igual o mayor a 1(uno)',
            'installation.code.max' => 'El campo Código debe ser menor o igual a 10000000(diez millones)',
            'installation.description.required' => 'El campo Descripción es requerido',
            'installation.description.min' => 'El campo Descripción tiene al menos 5 caracteres',
            'installation.description.max' => 'El campo Descripción tiene como máximo 300 caracteres',
            'installation.date_admission.requred' => 'El campo Fecha es requerido',
            'installation.usd_price.required' => 'El campo Precio U$D es requerido',
            'installation.usd_price.numeric' => 'El campo Precio U$D es numérico',
            'installation.usd_price.min' => 'El campo precio U$D debe ser un número mayor a 0(cero)',
            'installation.usd_price.max' => 'El campo precio U$D tiene como maximo 1000000(un millon)',
            'materialsSelected.required_if' => 'Debe seleccionar por lo menos un (1) material',
            'materialsSelected.*.id.exists' => 'Error al cargar el material',
            'customer.required' => 'Debe seleccionar un cliente',
        ];
        return $validation;
    }

    /**
     * Validaciones para seleccionar materiales
     * @return array $validation
     */
    public function validationSelectMaterials()
    {
        $validation['rules'] =  [
            'material.amount' => 'required|integer|min:1|max:1000000',
        ];

        $validation['messages'] = [
            'material.amount.required' => 'El campo Cantidad es requerido',
            'material.amount.integer' => 'El campo Cantidad tiene que ser un número entero mayor a cero (0)',
            'material.amount.min' => 'El campo Cantidad es como mínimo 1(uno)',
            'material.amount.max' => 'El campo Cantidad es como máximo 1000000(un millon)',
        ];

        return $validation;
    }

    /**
     * Validaciones para subir plano de instalacion
     * @return array $validation
     */
    public function validationImages()
    {
        $validation['rules'] = [
            'installation.image' => 'image|mimes:jpg,png|max:5120',
        ];

        $validation['messages'] = [
            'installation.image' => 'El campo Imagen debe contener archivos de tipo imagen',
            'installation.image.mimes' => 'El campo Imagen debe contener archivos con la extension png o jpg',
            'installation.image.max' => 'El campo Imagen no debe ser un archivo mayor a 20MB',
        ];

        return $validation;
    }

    /**
     * Validaciones para una nueva revision
     * @return array $validation
     */
    public function validationRevisions()
    {
        $validation['rules'] = [
            'revision.reason' => 'required',
            'revision.create_date' => 'required|date',
            'materialsSelected' => 'required|array',
            'materialsSelected.*.id' => 'required|exists:materials,id',
        ];

        $validation['messages'] = [
            'revision.reason.required' => 'El campo Razón es requerido',
            'revision.create_date.required' => 'El campo Fecha de Ingreso es requerido',
            'revision.create_date.date' => 'El campo Fecha de Ingreso debe ser una fecha',
            'materialsSelected.required' => 'Debe seleccionar por lo menos un (1) material',
            'materialsSelected.*.id.exists' => 'Error al cargar el material',
        ];

        return $validation;
    }
}
