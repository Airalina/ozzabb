<?php

namespace App\Http\Traits;

use App\Models\Material;

trait AssembledTrait
{
    /**
     * Validaciones para crear ensamblados
     * @return array $validation
     */
    public function validationAssembleds()
    {
        $validation['rules'] =  [
            'assembled.description' => 'required|max:500',
            'assembled.create_date' => 'required|date',
            'materialsSelected' => 'required|array',
            'materialsSelected.*.id' => 'required|exists:materials,id',
        ];

        $validation['messages'] = [
            'assembled.description.required' => 'El campo Descripción es requerido',
            'assembled.description.max' => 'El campo Descripción no debe superar 500 carácteres',
            'assembled.create_date.required' => 'El campo Fecha de ingreso es requerido',
            'assembled.create_date.date' => 'El campo Fecha de ingreso debe ser una fecha',
            'materialsSelected.required' => 'Debe seleccionar por lo menos un (1) material',
            'materialsSelected.exists' => 'Error al cargar el material',
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
}
