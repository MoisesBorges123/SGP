<?php

namespace App\Models\Painel\Livros;

use Illuminate\Database\Eloquent\Model;

class Pagina extends Model
{
    //
    protected $table = 'paginas';
    protected $fillable = ['numero','livro'];
}
