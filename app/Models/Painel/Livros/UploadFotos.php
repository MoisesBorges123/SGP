<?php

namespace App\Models\Painel\Livros;

use Illuminate\Database\Eloquent\Model;

class UploadFotos extends Model
{
    protected $table = "fotos_livro";
    protected $fillable = [
        'foto','tamanho','pagina','caminho'
    ];
    public $timestamps = true;
}
