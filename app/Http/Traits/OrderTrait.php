<?php

namespace App\Http\Traits;

use App\Models\Material;

trait OrderTrait
{
    /**
     * Validaciones para seleccionar instalaciones
     * @return array $validation
     */
    public function validationSelectInstallations()
    {
        $validation['rules'] =  [
            'installation.amount' => 'required|integer|min:1|max:1000000',
            'installation.revisionSelected' => 'required',
        ];

        $validation['messages'] = [
            'installation.amount.required' => 'El campo Cantidad es requerido',
            'installation.amount.integer' => 'El campo Cantidad tiene que ser un número entero mayor a cero (0)',
            'installation.amount.min' => 'El campo Cantidad es como mínimo 1(uno)',
            'installation.amount.max' => 'El campo Cantidad es como máximo 1000000(un millon)',
            'installation.revisionSelected.required' => 'Debe seleccionar una revisión',
        ];

        return $validation;
    }
        
    /**
     * Validaciones para almacenar pedido
     * @return array $validation
     */
    public function validationOrders()
    {
        $validation['rules'] =  [
            'installationsSelected' => 'required|array|min:2',
            'customer' => 'required',
            'domicileDelivery' => 'required|array',
            'order.deadline' => 'required|date|after:today',
        ];

        $validation['messages'] = [
            'installationsSelected.required' => 'Debe seleccionar por lo menos una (1) instalación',
            'installationsSelected.array' => 'Debe seleccionar por lo menos una (1) instalación',
            'installationsSelected.min' => 'Debe seleccionar por lo menos una (1) instalación',
            'customer.required' => 'Debe seleccionar un (1) Cliente',
            'domicileDelivery.required' => 'Debe seleccionar un (1) Domicilio de entrega',
            'domicileDelivery.array' => 'Debe seleccionar un (1) Domicilio de entrega',           
            'order.deadline.required' => 'El campo "Fecha estimada de entrega" es requerido',
            'order.deadline.date' => 'El campo "Fecha estimada de entrega" debe ser una fecha',
            'order.deadline.after' => 'El campo "Fecha estimada de entrega" debe ser una fecha después de hoy',
        ];

        return $validation;
    }
    
}
