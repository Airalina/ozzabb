<?php

namespace App\Http\Traits;

use App\Models\Accessory;
use App\Models\Cable;
use App\Models\Clip;
use App\Models\Connector;
use App\Models\Material;
use App\Models\Terminal;
use App\Models\Tube;

trait MaterialTrait
{
    /**
     * Validaciones para crear materiales y sus familias
     * string $family, string $showPrice
     * @return array $validation
     */
    public function validationMaterials($family, $showPrice)
    {
        $regex = "/^[\d]{0,4}(\.[\d]{1,2})?$/";
        $materialId = $this->material['id'] ?? '';

        $validation['rules'] =  [
            'material.code' => 'required|max:20|unique:materials,code,' . $materialId,
            'material.name' => 'nullable',
            'material.family' => 'required',
            'material.description' => 'nullable|max:500',
            'material.line' => 'nullable',
            'material.usage' => 'nullable',
            'material.replace_id' => 'nullable',
            'material.stock_min' => 'nullable|numeric|min:0|max:999999',
            'material.stock_max' => 'nullable|numeric|min:0|max:999999',
            'material.color' => 'nullable',
            'upload.images' => 'sometimes',
            'connector' => 'sometimes',
            'connector.number_of_ways' => 'required_if:family,Conectores|nullable|numeric|integer|min:0|max:999',
            'connector.type' => 'required_if:family,Conectores|nullable',
            'connector.connector_id' => 'nullable',
            'connector.watertight' => 'required_if:family,Conectores|nullable|boolean',
            'connector.lock' => 'required_if:family,Conectores|nullable|boolean',
            'connector.cover' => 'required_if:family,Conectores|nullable|boolean',
            'cable.section' => 'numeric|required_if:family,Cables|nullable|regex: ' . $regex,
            'cable' => 'sometimes',
            'cable.base_color' => 'required_if:family,Cables|nullable',
            'cable.line_color' => 'sometimes|nullable',
            'cable.braid_configuration' => 'required_if:family,Cables|nullable',
            'cable.norm' =>  'required_if:family,Cables|nullable',
            'cable.number_of_unipolar' => 'nullable|numeric|min:0',
            'cable.mesh_type' => 'nullable|string',
            'cable.operating_temperature' => 'numeric|required_if:family,Cables|nullable|regex: ' . $regex,
            'terminal' => 'sometimes',
            'terminal.size' => 'numeric|required_if:family,Terminales|min:0|max:99999|nullable',
            'terminal.minimum_section' => 'nullable|numeric|regex: ' . $regex,
            'terminal.maximum_section' => 'nullable|numeric|regex: ' . $regex,
            'terminal.material' => 'required_if:family,Terminales|nullable',
            'terminal.type' => 'required_if:family,Terminales|nullable',
            'seal' => 'sometimes',
            'seal.minimum_diameter' => 'numeric|required_if:family,Sellos|nullable|regex: ' . $regex,
            'seal.maximum_diameter' => 'numeric|required_if:family,Sellos|nullable|regex: ' . $regex,
            'seal.type' => 'nullable|max:30',
            'tube' => 'sometimes',
            'tube.diameter' => 'numeric|required_if:family,Tubos|nullable|regex: ' . $regex,
            'tube.type' => 'required_if:family,Tubos|nullable',
            'tube.wall_thickness' => 'numeric|required_if:family,Tubos|nullable|regex: ' . $regex,
            'tube.contracted_diameter' => 'numeric|nullable|regex: ' . $regex,
            'tube.minimum_temperature' => 'numeric|nullable|min:0|max:9999',
            'tube.maximum_temperature' => 'numeric|nullable|min:0|max:9999',
            'accessory' => 'sometimes',
            'accessory.type' => 'required_if:family,Accesorios',
            'clip' => 'sometimes',
            'clip.long' => 'numeric|required_if:family,Clips|nullable|regex: ' . $regex,
            'clip.width' => 'numeric|required_if:family,Clips|nullable|regex: ' . $regex,
            'clip.hole_diameter' => 'numeric|required_if:family,Clips|nullable|regex: ' . $regex,
            'clip.type' => 'required_if:family,Clips|nullable'
        ];

        $validation['messages'] = [
            'material.code.required' => 'El campo C??digo es requerido',
            'material.code.unique' => 'El campo c??digo que inteta ingresar se encuentra en uso, debe ser ??nico',
            'material.code.max' => 'El campo c??digo tiene como m??ximo 20 caracteres',
            'material.name.required' => 'El campo Nombre es requerido',
            'material.family.required' => 'El campo Familia es requerido',
            'material.description.max' => 'El campo Descripci??n no debe superar 500 car??cteres',
            'material.usage.required' => 'Seleccione una opci??n para el campo de Uso',
            'material.stock_min.required' => 'El campo Stock m??nimo es requerido',
            'material.stock_min.numeric' => 'El campo Stock m??nimo es num??rico (decimales separados por punto)',
            'material.stock_min.min' => 'El campo Stock m??nimo debe ser un n??mero mayor a 0(cero).',
            'material.stock_min.max' => 'El campo Stock m??nimo es inferior a 6 digitos.',
            'material.stock_max.numeric' => 'El campo Stock m??ximo es num??rico (decimales separados por punto)',
            'material.stock_max.min' => 'El campo Stock m??ximo debe ser un n??mero mayor a 0(cero).',
            'material.stock_max.max' => 'El campo Stock m??ximo es inferior a 6 digitos.',
            'material.color.required' => 'El campo Color es requerido',
            'connector.number_of_ways.numeric' => 'El campo Cantidad de v??as es num??rico (decimales separados por punto)',
            'connector.number_of_ways.integer' => 'El campo Cantidad de v??as es un n??mero natural',
            'connector.number_of_ways.min' => 'El campo Cantidad de v??as debe ser un n??mero entero de 1 a 999',
            'connector.number_of_ways.max' => 'El campo Cantidad de v??as debe ser un n??mero entero de 1 a 999',
            'connector.number_of_ways.required_if' => 'El campo Cantidad de v??as es requerido si la familia es ' . $family,
            'type.required_if' => 'El campo Tipo es requerido',
            'connector.watertight.required_if' => 'Seleccione una opci??n para el campo Estanco',
            'connector.lock.required_if' => 'Seleccione una opci??n para el campo Traba secundaria',
            'connector.cover.required_if' => 'Seleccione una opci??n para el campo Tapa',
            'connector.watertight.boolean' => 'El campo Estanco debe ser s?? o no',
            'connector.lock.boolean' => 'El campo Traba secundaria debe ser s?? o no',
            'connector.cover.boolean' => 'El campo Tapa debe ser s?? o no',
            'cable.section.numeric' => 'El campo Secci??n es num??rico (decimales separados por punto)',
            'cable.section.required_if' => 'El campo Secci??n es requerido si la familia es ' . $family,
            'cable.section.regex' => 'El campo Secci??n es un n??mero de m??ximo 4 cifras con 2 posiciones decimales',
            'cable.base_color.required_if' => 'Seleccione una opci??n del campo Color base',
            'cable.braid_configuration.required_if' => 'Seleccione una opci??n del campo Configuraci??n de Trenza',
            'cable.norm.required_if' => 'Seleccione una opci??n del campo Norma',
            'cable.number_of_unipolar.numeric' => 'El campo Cantidad de unipolares es num??rico (decimales separados por punto)',
            'cable.number_of_unipolar.min' => 'El campo Cantidad de unipolares debe ser un n??mero mayor a cero (0) ',
            'cable.operating_temperature.numeric' => 'El campo Temperatura de Servicio es num??rico (decimales separados por punto)',
            'cable.operating_temperature.required_if' => 'El campo Temperatura de Servicio es requerido si la familia es ' . $family,
            'cable.operating_temperature.regex' => 'El campo Temperatura de Servicio es un n??mero de m??ximo 4 cifras con 2 posiciones decimales',
            'terminal.size.numeric' => 'El campo Tama??o es num??rico(decimales separados por p??nto)',
            'terminal.size.required_if' => 'El campo Tama??o es requerido si la familia es ' . $family,
            'terminal.size.min' => 'El campo Tama??o debe ser un n??mero mayor a 0(cero)',
            'terminal.size.max' => 'El campo Tama??o debe ser un n??mero de 5 cifras como m??ximo',
            'terminal.minimum_section.numeric' => 'El campo Secci??n m??nima es num??rico (decimales separados por punto)',
            'terminal.maximum_section.numeric' => 'El campo Secci??n m??xima es num??rico (decimales separados por punto)',
            'terminal.minimum_section.regex' => 'El campo Secci??n m??nima es un n??mero de m??ximo 4 cifras con 2 posiciones decimales',
            'terminal.maximum_section.regex' => 'El campo Secci??n m??xima es un n??mero de m??ximo 4 cifras con 2 posiciones decimal',
            'terminal.material.required_if' => 'Seleccione una opci??n para el campo Material',
            'terminal.type.required_if' => 'Seleccione una opci??n para el campo Tipo',
            'seal.minimum_diameter.numeric' => 'El campo Di??metro m??nimo de Cable es num??rico (decimales separados por punto)',
            'seal.minimum_diameter.required_if' => 'El campo Di??metro m??nimo de Cable es requerido si la familia es ' . $family,
            'seal.minimum_diameter.regex' => 'El campo Di??metro m??nimo de Cable es un n??mero de m??ximo 4 cifras con 2 posiciones decimales',
            'seal.maximum_diameter.numeric' => 'El campo Di??metro m??ximo de Cable es num??rico (decimales separados por punto)',
            'seal.maximum_diameter.required_if' => 'El campo Di??metro m??ximo de Cable es requerido si la familia es ' . $family,
            'seal.maximum_diameter.regex' => 'El campo Di??metro m??ximo de Cable es un n??mero de m??ximo 4 cifras con 2 posiciones decimales',
            'seal.type.max' => 'El campo Tipo de sello debe ser inferior a 30 car??cteres',
            'seal.type.max' => 'El campo Tipo de sello debe ser inferior a 30 car??cteres',
            'tube.diameter.numeric' => 'El campo Di??metro es num??rico (decimales separados por punto)',
            'tube.diameter.required_if' => 'El campo Di??metro es requerido si la familia es ' . $family,
            'tube.diameter.regex' => 'El campo Di??metro es un n??mero de m??ximo 4 cifras con 2 posiciones decimal',
            'tube.wall_thickness.numeric' => 'El campo Espesor de Pared es num??rico (decimales separados por punto)',
            'tube.wall_thickness.required_if' => 'El campo Espesor de Pared es requerido si la familia es ' . $family,
            'tube.wall_thickness.regex' => 'El campo Espesor de Pared es un n??mero de m??ximo 4 cifras con 2 posiciones decimal',
            'tube.contracted_diameter.numeric' => 'El campo Di??metro Contra??do es num??rico (decimales separados por punto)',
            'tube.contracted_diameter.required_if' => 'El campo Di??metro Contra??do es requerido si la familia es ' . $family,
            'tube.contracted_diameter.regex' => 'El campo Di??metro Contra??do es un n??mero de m??ximo 4 cifras con 2 posiciones decimal',
            'tube.minimum_temperature.numeric' => 'El campo Temperatura m??nima de Servicio es num??rico (decimales separados por punto)',
            'tube.minimum_temperature.required_if' => 'El campo Temperatura m??nima de Servicio es requerido si la familia es ' . $family,
            'tube.minimum_temperature.min' => 'El campo Temperatura m??nima de Servicio es como m??nimo 0??C',
            'tube.minimum_temperature.max' => 'El campo Temperatura m??nima de Servicio es un n??mero de m??ximo 4 cifras con 2 posiciones decimal',
            'tube.maximum_temperature.numeric' => 'El campo Temperatura m??xima de Servicio es num??rico (decimales separados por punto)',
            'tube.maximum_temperature.required_if' => 'El campo Temperatura m??xima de Servicio es requerido si la familia es ' . $family,
            'tube.maximum_temperature.min' => 'El campo Temperatura m??xima de Servicio es como m??nimo 0??C',
            'tube.maximum_temperature.max' => 'El campo Temperatura m??xima de Servicio es un n??mero de m??ximo 4 cifras con 2 posiciones decimal',
            'tube.type.required_if' => 'Seleccione una opci??n del campo Tipo de Tubo',
            'clip.long.numeric' => 'El campo Largo es num??rico (decimales separados por punto)',
            'clip.long.required_if' => 'El campo Largo es requerido si la familia es ' . $family,
            'clip.long.regex' => 'El campo Largo es un n??mero de m??ximo 4 cifras con 2 posiciones decimales',
            'clip.width.numeric' => 'El campo Ancho es num??rico (decimales separados por punto)',
            'clip.width.required_if' => 'El campo Ancho es requerido si la familia es ' . $family,
            'clip.width.regex' => 'El campo Ancho es un n??mero de m??ximo 4 cifras con 2 posiciones decimales',
            'clip.hole_diameter.numeric' => 'El campo Di??metro del Orificio es num??rico (decimales separados por punto)',
            'clip.hole_diameter.required_if' => 'El campo Di??metro del Orificio es requerido si la familia es ' . $family,
            'clip.hole_diameter.regex' => 'El campo Di??metro del Orificio es un n??mero de m??ximo 4 cifras con 2 posiciones decimales',
            'clip.type.required_if' => 'Seleccione una opci??n del campo tipo de Clip',
            'accessory.type.required_if' => 'Seleccione una opci??n del campo tipo de Accesorio',
        ];
        if ($showPrice === 'yes' || $this->component == 'depositos') {
            $validationPrice = $this->validationPrice();
            $validation['rules'] = array_merge($validation['rules'], $validationPrice['rules']);
            $validation['messages'] = array_merge($validation['messages'], $validationPrice['messages']);
        }

        if ($this->upload) {
            $validationImages = $this->validationImages();
            $validation['rules'] = array_merge($validation['rules'], $validationImages['rules']);
            $validation['messages'] = array_merge($validation['messages'], $validationImages['messages']);
        }

        return $validation;
    }

    /**
     * Validaciones para crear precio del material
     * @return array $validation
     */
    public function validationPrice($module = 'material')
    {
        
        $validation['rules'] = [
            'price.amount' => 'required_if:showPrice,yes|nullable|numeric|min:0',
            'price.unit' => 'required_if:showPrice,yes|nullable|numeric|min:0',
            'price.presentation' => 'required_if:showPrice,yes',
            'price.provider_code' => 'required_if:showPrice,yes|nullable|string|min:0|max:50',
            'price.usd_price' => 'required_if:showPrice,yes|nullable|numeric|min:0',
            'price.ars_price' => 'required_if:showPrice,yes|nullable|numeric|min:0',
        ];

        $validation['messages'] = [
            'price.amount.required_if' => 'El campo cantidad es requerido',
            'price.amount.numeric' => 'El campo cantidad debe ser num??rico (decimales separados por punto)',
            'price.amount.min' => 'El campo cantidad debe ser mayor a cero (0)',
            'price.unit.required_if' => 'El campo packaging es requerido',
            'price.unit.numeric' => 'El campo packaging debe ser num??rico (decimales separados por punto)',
            'price.unit.min' => 'El campo packaging debe ser mayor a cero (0)',
            'price.presentation.required_if' => 'Seleccione una opci??n para el campo de la presentaci??n del packaging',
            'price.provider_code.required_if' => 'El c??digo de material interno del proveedor es requerido',
            'price.provider_code.string' => 'El c??digo de material interno del proveedor es requerido',
            'price.provider_code.min' => 'El c??digo de material interno del proveedor tiene como m??nimo un caracter',
            'price.provider_code.max' => 'El c??digo de material interno del proveedor tiene como m??ximo cincuenta caracteres',
            'price.usd_price.required_if' => 'El campo precio U$D es requerido',
            'price.usd_price.numeric' => 'El campo precio U$D debe ser num??rico (decimales separados por punto)',
            'price.usd_price.min' => 'El campo  U$D  debe ser mayor a cero (0)',
            'price.ars_price.required_if' => 'El campo precio AR$ es requerido',
            'price.ars_price.numeric' => 'El campo precio AR$ es num??rico (decimales separados por punto)',
            'price.ars_price.min' => 'El campo  AR$  debe ser mayor a cero (0)',
        ];
        if ($this->component == 'depositos') {
            $validation['rules']['showPrice'] = 'in:yes';
            $validation['messages']['showPrice.in'] = 'Debe ingresar una presentaci??n para el material';
        }
        if ($module == 'material') {
            $validation['rules']['providerSelected'] = 'required_if:showPrice,yes';
            $validation['messages']['providerSelected.required_if'] = 'Seleccione una opci??n para el campo Proveedor';
        } else {
            $validation['rules']['materialSelected'] = 'required';
            $validation['messages']['materialSelected.required'] = 'Seleccione una opci??n para el campo Material';
        }

        return $validation;
    }

    /**
     * Validaciones para subir imagenes al material
     * @return array $validation
     */
    public function validationImages()
    {
        $validation['rules'] = [
            'upload.images.*' => 'image|mimes:jpg,png|max:5120',
        ];

        $validation['messages'] = [
            'upload.images.*.image' => 'El campo Imagen debe contener archivos de tipo imagen',
            'upload.images.*.mimes' => 'El campo Imagen debe contener archivos con la extension png o jpg',
            'upload.images.*.max' => 'El campo Imagen no debe ser un archivo mayor a 20MB',
        ];

        return $validation;
    }

    public function familyMaterial($family, $addFields = false, $materialId = '')
    {
        $this->familySelected = $family;

        switch ($this->familySelected) {
            case 'Conectores':
                $this->materialContent[$this->familySelected] = [
                    'connectors' => Connector::selection(),
                    'terminals' => [],
                    'seals' => [],
                ];
                break;
            case 'Cables':
                $this->materialContent[$this->familySelected] = [
                    'colors' => Material::COLORS,
                    'configurations' => Cable::CONFIGURATIONS,
                    'norms' => Cable::NORMS,
                ];
                break;
            case 'Terminales':
                $this->materialContent[$this->familySelected] = [
                    'materials' => Terminal::MATERIALS,
                    'types' => Terminal::TYPES
                ];
                break;
            case 'Tubos':
                $this->materialContent[$this->familySelected] = [
                    'types' => Tube::TYPES,
                    'addFields' => $addFields
                ];
                break;
            case 'Accesorios':
                $this->materialContent[$this->familySelected]['types'] = Accessory::TYPES;
                break;
            case 'Clips':
                $this->materialContent[$this->familySelected]['types'] = Clip::TYPES;
                break;
        }
        $this->fillInformation($this->familySelected, $materialId);
        //Inicializar el array de las validaciones segun el tipo de familia
        $type = $this->information['families'][$this->familySelected];
        $this->validation[$type] = [];
        return $this->familySelected;
    }

    /**
     * Rellena un array para mostrar campos dependiendo de la familia de materiales escogida
     * 
     * @param string $family, int $materialId
     * @return array $information
     */
    public function fillInformation($family, $materialId = '')
    {
        $this->information['showColors'] = ($family == 'Cables' || $family == 'Terminales') ? false : true;
        $this->information['showLines'] = true;
        $this->information['showReplace'] = ($family == 'Cables' || $family == 'Tubos') ? false : true;
        $materialReplaces = Material::familyMaterials($family)->whereNotIn('id', [$materialId]);
        $this->information['replaces'] = $materialReplaces ? $materialReplaces->get()->toArray() : [];
        $color = $this->material['color'] ?? null;
        $this->material['color'] = $this->information['showColors'] ? $color : null;
        $this->material['replace_id'] = null;

        return $this->information;
    }
}
