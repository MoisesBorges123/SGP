<?php

namespace App\Models\Painel\Livros;

use Illuminate\Database\Eloquent\Model;

class Livro extends Model
{
    //
    protected $fillable=['numero','data_inicio','data_fim','sacramento','observacao'];
}
