<?php

namespace App\Http\Traits;

use Illuminate\Validation\Rule;

trait WarehouseTrait
{
    /**
     * Validaciones para crear depositos
     * @return array $validation
     */
    public function validationWarehouses()
    {

        $validation['rules'] = [
            'warehouse.type' => 'required|' . Rule::in(array_keys($this->types)),
            'warehouse.name' => 'required|string|min:4|max:100',
            'warehouse.location' => 'required|string|min:4|max:300',
            'warehouse.description' => 'required|string|min:4|max:300',
            'warehouse.create_date' => 'required',
            'warehouse.temporary' => 'sometimes',
        ];

        $validation['messages'] =
            [
                'warehouse.type.required' => 'El campo Tipo de depósito es requerido',
                'warehouse.type.in' => 'El campo Tipo de depósito no es válido',
                'warehouse.name.required' => 'El campo Nombre es requerido',
                'warehouse.name.min' => 'El campo Nombre tiene por lo menos 4 caracteres',
                'warehouse.name.max' => 'El campo Nombre tiene como maximo 100 caracteres',
                'warehouse.location.required' => 'El campo Ubicación es requerido',
                'warehouse.location.min' => 'El campo Ubicación tiene como minimo 4 caracteres',
                'warehouse.location.max' => 'El campo Ubicación tiene como maximo 300 caracteres',
                'warehouse.description.required' => "El campo Descripción es requerido",
                'warehouse.description.min' => 'El campo Descripción tiene como minimo 4 caracteres',
                'warehouse.description.max' => 'El campo Descripción tiene como maximo 300 caracteres',
                'warehouse.create_date.required' => 'El campo Fecha es requerido',
            ];

        return $validation;
    }

    /**
     * Validaciones para agregar productos
     * @return array $validation
     */
    public function validationProducts()
    {
        $this->type = $this->productSelected['typeProduct'];
        $amountAvaiable = $this->view == 'egreso' ? '|lte:amount.avaiable' : '';

        $validation['rules'] = [
            'product.amount' => 'required|integer|min:1|max:1000000' . $amountAvaiable,
            'product.packaging' => 'required_if:type,material',
            'product.serial_number' => 'required_if:type,instalacion|string|min:0|max:100',
            'product.client_order_id' => 'required_if:type,instalacion|numeric|min:0|max:1000000',
            'product.number_version' => 'required_if:type,instalacion|numeric|min:0|max:1000000',
        ];

        $validation['messages'] =
            [
                'product.amount.required' => 'El campo Cantidad es requerido',
                'product.amount.integer' => 'El campo Cantidad tiene que ser un número entero mayor a cero (0)',
                'product.amount.min' => 'El campo Cantidad es como mínimo 1(uno)',
                'product.amount.max' => 'El campo Cantidad es como máximo 1000000(un millon)',
                'product.amount.lte' => 'El campo Cantidad debe ser menor o igual a la Cantidad Disponible',
                'product.packaging.required_if' => 'El campo Packaging es requerido',
                'product.serial_number.required_if' => 'El campo Número de serie es requerido',
                'product.serial_number.min' => 'El campo Número de serie tiene como minimo 4 caracteres',
                'product.serial_number.max' => 'El campo Número de serie tiene como maximo 100 caracteres',
                'product.number_version.required_if' => 'El campo N° de version es requerido',
                'product.number_version.numeric' => 'El campo N° de version es numerico',
                'product.number_version.min' => 'El campo N° de version tiene como mínimo 0(cero)',
                'product.number_version.max' => 'El campo N° de version tiene como maximo 10000000(diez millon)',
                'product.client_order_id.required_if' => 'El campo Id orden de cliente es requerido',
                'product.client_order_id.numeric' => 'El campo Id orden de cliente es numerico',
                'product.client_order_id.min' => 'El campo Id orden de cliente tiene como mínimo 0(cero)',
                'product.client_order_id.max' => 'El campo Id orden de cliente tiene como maximo 10000000(diez millon)',
            ]; 
        
        return $validation;
    }

    /**
     * Validaciones para ingresar/egresar
     * @return array $validation
     */
    public function validationMovements()
    {
        $type = ($this->warehouse['type'] == 1 || $this->warehouse['type'] == 2) ?: false;

        $validation['rules'] = [
            'movements.date' => 'required',
            'movements.hour' => 'required',
            'movements.name_receive' => 'required',
            'movements.name_entry' => 'required',
            'selection' => 'required_if:type,true',
            'warehouseDestination' => 'required_if:view,egreso',
        ];

        $validation['messages'] =
            [
                'movements.date.required' => 'El campo Fecha es requerido',
                'movements.hour.required' => 'El campo Hora es requerido',
                'movements.name.max' => 'El campo Nombre tiene como maximo 100 caracteres',
                'movements.name_receive.required' => 'El campo "Responsable de recibir" es requerido',
                'movements.name_entry.required' => 'El campo "Responsable de ingresar" es requerido',
                'selection.required_if' => 'Debe seleccionar una opción del tipo de producto a ingresar',
                'warehouseDestination.required_if' => 'Debe seleccionar un depósito destino'
            ];

        return $validation;
    }
}
