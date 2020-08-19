<?php

namespace App\Http\Requests\Painel\Certidoes;

use Illuminate\Foundation\Http\FormRequest;

class CertidaoBatismoValidation extends FormRequest
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
            //
            'crianca'=>'required|min:3',
            'data_batizado'=>'required|date',
            'livro'=>'required',
            'folha'=>'required'
        ];
    }

    public function smartValidation($dados){
        if($dados['data_nascimento'] > date('Y-m-d',time())){
            return false;
        }
        if($dados['data_batizado'] > date('Y-m-d',time())){            
            return false;
        }
        if($dados['data_batizado'] < $dados['data_nascimento']){
           // $dados['data_batizado'] . " > " .$dados['data_nascimento'];
            return false;

        }
        
        
        return true;
    }
}
