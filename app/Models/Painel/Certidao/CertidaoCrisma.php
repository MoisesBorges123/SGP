<?php

namespace App\Models\Painel\Certidao;

use Illuminate\Database\Eloquent\Model;

class CertidaoCrisma extends Model
{
    //
    protected $table="certidao_crisma";
    protected $fillable = ['crismando','pai','mae','padrinho','data_crisma','livro','folha','duvidoso'];
}
