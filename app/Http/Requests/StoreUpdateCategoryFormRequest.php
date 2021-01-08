<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateCategoryFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        /*
        Necessário passar os seguintes parâmetros no campo headers do Postman
        para que o conteúdo seja compreendido como uma requisição ajax.

        Key: Content-Type
        Value: application/json

        Key: X-Requested-With
        Value: XMLHttpRequest

        */
        return [
            'name' => "required|min:3|max:50|unique:categories,name,{$this->id},id"
        ];
    }
}
