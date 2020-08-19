<?php

namespace App\Models\Painel\Certidao;

use Illuminate\Database\Eloquent\Model;

class CertidaoBatismo extends Model
{
    //
    protected $table = 'certidao_batismo';
    protected $fillable = [
        'crianca',
        'pai',
        'mae',
        'padrinho',
        'madrinha',
        'data_batizado',
        'local_batizado',
        'duvidoso',
        'livro',
        'folha',
        'celebrante'
    ];
    
}
