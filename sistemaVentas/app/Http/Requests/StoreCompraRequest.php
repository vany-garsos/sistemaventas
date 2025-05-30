<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompraRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        //inspeccionar
    // dd($this->all());
        return [
            'proveedore_id'=>'required|exists:proveedores,id',
            'comprobante_id'=>'required|exists:comprobantes,id',
            'numero_comprobante' => 'required|unique:compras,numero_comprobante|max:255',
            'impuesto'=>'required',
            'fecha_hora'=>'required',
            'total' => 'required'
        ];
    }
}
