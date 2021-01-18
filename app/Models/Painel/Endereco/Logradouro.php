<?php

namespace App\Models\Painel\Endereco;

use Illuminate\Database\Eloquent\Model;

class Logradouro extends Model
{
    //
    public $fillable = ['estado','rua','bairro','cep','cidade','dd_local','complemento','ibge'];
}
