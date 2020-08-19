<?php

namespace App\Models\Painel;

use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
    //
    protected $fillable=[
        'nome',
        'identidade',
        'data_nascimento',
        'cpf',
        'ctps',
        'titulo_eleitoral'
    ];
}
