<?php

namespace App\Models\Painel\Celevracoes;

use Illuminate\Database\Eloquent\Model;

class Intencao extends Model
{
    //
    protected $table = "intentions";
    protected $fillable = [
        'person',
        'scope',
        
    ];
}
