<?php

namespace App\Models\Painel\Endereco;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    //
    public $fillable = [
        'logradouro',
        'pessoa',
        'numero',
        'apartamento',
        'complemento'
    ];
}
