<?php

namespace App\Http\Requests\Painel\Certidoes;

use Illuminate\Foundation\Http\FormRequest;

class StoreCertidaoCrisma extends FormRequest
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
        return [
            'crismando'=>'required|min:3',
            'data_crisma'=>'required|date',
            'pai'=>'min:3',
            'mae'=>'min:3',
            'padrinho'=>'min:3',
            'livro'=>'required',
            'folha'=>'required'
        ];
    }
}
