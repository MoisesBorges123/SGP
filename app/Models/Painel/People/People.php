<?php

namespace App\Models\Painel\People;

use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    //
    protected $table = "pessoas";

    protected $fillable=[
        'nome',
        'identidade',
        'data_nascimento',
        'cpf',
        'ctps',
        'titulo_eleitoral',
        'email'
    ];

}
