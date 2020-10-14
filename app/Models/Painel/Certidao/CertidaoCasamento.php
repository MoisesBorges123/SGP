<?php

namespace App\Models\Painel\Certidao;

use Illuminate\Database\Eloquent\Model;

class CertidaoCasamento extends Model
{
    //
    protected $table = 'certidao_casamento';
    protected $fillable = [
        'noivo',
        'noiva',
        'data_casamento',
        'celebrante',
        'local_casamento',        
        'duvidoso',
        'livro',
        'folha',  
    ];
}
