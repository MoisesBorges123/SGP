<?php

namespace App\Http\Requests\Painel\Estacionamento;

use Illuminate\Foundation\Http\FormRequest;

class StoreTablePriceRequest extends FormRequest
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
            'car_60min'=>'required',
            'car_30min'=>'required',
            'car_15min'=>'required',
            'car_diaria'=>'required',
            'car_pernoite'=>'required',
            'car_mensalidade'=>'required',
            'mot_60min'=>'required',
            'mot_30min'=>'required',
            'mot_15min'=>'required',
            'mot_diaria'=>'required',
            'mot_pernoite'=>'required',
            'mot_mensalidade'=>'required',
            
        ];
    }
}
